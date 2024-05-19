<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kriteria;
use App\Models\PengaduanModel;
use App\Models\PerbandinganKriteria;
use App\Models\PenilaianAlternatif;
use Yajra\DataTables\Facades\DataTables;

class PrioritasController extends Controller
{
    public function calculate()
{
    $breadcrumb = (object) [
        'title' => '',
        'list' => ['Home', 'prioritas']
    ];

    $page = (object) [
        'title' => 'Dashboard admin'
    ];
    $activeMenu = 'prioritas';

    // AHP Calculation

    // Mendapatkan Nilai Perbandingan
    $kriteria = Kriteria::all();
    $perbandinganKriteria = PerbandinganKriteria::all();

    // Membuat Matriks Perbandingan Berpasangan
    $n = count($kriteria);
    $pairwiseMatrix = array_fill(0, $n, array_fill(0, $n, 1.0));

    foreach ($perbandinganKriteria as $perbandingan) {
        $i = $perbandingan->kriteria_1_id - 1;
        $j = $perbandingan->kriteria_2_id - 1;
        $nilai = $perbandingan->nilai_perbandingan;
        $pairwiseMatrix[$i][$j] = $nilai;
        $pairwiseMatrix[$j][$i] = 1 / $nilai;
    }

    // Menghitung Jumlah Kolom
    $columnSums = array_fill(0, $n, 0.0);
    for ($j = 0; $j < $n; $j++) {
        for ($i = 0; $i < $n; $i++) {
            $columnSums[$j] += $pairwiseMatrix[$i][$j];
        }
    }

    // Normalisasi Matriks
    $normalizedMatrix = array_fill(0, $n, array_fill(0, $n, 0.0));
    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $n; $j++) {
            $normalizedMatrix[$i][$j] = $pairwiseMatrix[$i][$j] / $columnSums[$j];
        }
    }

    // Menghitung Rata-rata Baris (Eigenvector)
    $eigenVector = array_fill(0, $n, 0.0);
    for ($i = 0; $i < $n; $i++) {
        $sum = 0.0;
        for ($j = 0; $j < $n; $j++) {
            $sum += $normalizedMatrix[$i][$j];
        }
        $eigenVector[$i] = $sum / $n;
    }

    // Menghitung λ_max
    $lambdaMax = 0.0;
    for ($i = 0; $i < $n; $i++) {
        $sum = 0.0;
        for ($j = 0; $j < $n; $j++) {
            $sum += $pairwiseMatrix[$i][$j] * $eigenVector[$j];
        }
        $lambdaMax += $sum / $eigenVector[$i];
    }
    $lambdaMax /= $n;

    // Menghitung CI
    $ci = ($lambdaMax - $n) / ($n - 1);

    // Menghitung CR
    $ri = [0.0, 0.0, 0.58, 0.90, 1.12, 1.24, 1.32, 1.41, 1.45];
    $cr = $ci / $ri[$n - 1];

    // MABAC Calculation

    $alternatif = DB::table('jenis_pengaduan')->get();
    $penilaianAlternatif = PenilaianAlternatif::all();

    $m = count($alternatif);
    $k = count($kriteria);

    // Membentuk matriks keputusan awal
    $decisionMatrix = [];
    foreach ($penilaianAlternatif as $penilaian) {
        $decisionMatrix[$penilaian->id_jenis_pengaduan][$penilaian->kriteria_id] = $penilaian->nilai;
    }

    // Normalisasi elemen matriks
    $normalizedMatrix = [];
    foreach ($decisionMatrix as $id_jenis_pengaduan => $row) {
        $normalizedRow = [];
        foreach ($row as $key => $value) {
            if ($kriteria->find($key)->tipe == 'benefit') {
                $normalizedRow[$key] = $value / max(array_column($decisionMatrix, $key));
            } else {
                $normalizedRow[$key] = min(array_column($decisionMatrix, $key)) / $value;
            }
        }
        $normalizedMatrix[$id_jenis_pengaduan] = $normalizedRow;
    }

    // Matriks tertimbang
    $weightedMatrix = [];
    foreach ($normalizedMatrix as $id_jenis_pengaduan => $row) {
        $weightedRow = [];
        foreach ($row as $key => $value) {
            $weightedRow[$key] = $value * $eigenVector[$key - 1];
        }
        $weightedMatrix[$id_jenis_pengaduan] = $weightedRow;
    }

    // Matriks area perkiraan perbatasan
    $gMatrix = array_fill(0, $k, 0);
    foreach ($weightedMatrix as $row) {
        foreach ($row as $key => $value) {
            $gMatrix[$key - 1] += $value;
        }
    }
    $gMatrix = array_map(function($val) use ($m) {
        return $val / $m;
    }, $gMatrix);

    // Matriks jarak alternatif
    $qMatrix = [];
    foreach ($weightedMatrix as $id_jenis_pengaduan => $row) {
        $qRow = [];
        foreach ($row as $key => $value) {
            $qRow[$key] = $value - $gMatrix[$key - 1];
        }
        $qMatrix[$id_jenis_pengaduan] = $qRow;
    }

    // Hasil akhir MABAC
    $finalScores = [];
    foreach ($qMatrix as $id_jenis_pengaduan => $row) {
        $finalScores[$id_jenis_pengaduan] = array_sum($row);
    }

    // Dapatkan daftar ID jenis_pengaduan yang valid
    $validJenisPengaduanIds = DB::table('jenis_pengaduan')->pluck('id_jenis_pengaduan')->toArray();

    // Simpan hasil ke database
    foreach ($finalScores as $id_jenis_pengaduan => $score) {
        if (in_array($id_jenis_pengaduan, $validJenisPengaduanIds)) {
            DB::table('hasil_prioritas')->updateOrInsert(
                ['id_jenis_pengaduan' => $id_jenis_pengaduan],
                ['score' => $score]
            );
        }
    }

    return view('admin.prioritas.final', [
        'eigenVector' => $eigenVector,
        'lambdaMax' => $lambdaMax,
        'ci' => $ci,
        'cr' => $cr,
        'finalScores' => $finalScores,
        'breadcrumb' => $breadcrumb, 
        'page' => $page, 
        'activeMenu' => $activeMenu
    ]);
}


    public function tampilKriteria() 
    {
        // Menampilkan halaman awal 
        $breadcrumb = (object) [
            'title' => 'Daftar Kriteria',
            'list' => ['Home', 'Kriteria ']
        ];

        $page = (object) [
            'title' => 'Daftar kriteria yang terdaftar dalam sistem'
        ];

        $activeMenu = 'kriteria'; //set menu yang aktif

        return view('admin.prioritas.kriteria', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    public function listKriteria(Request $request)
    {
        $kriteria = Kriteria::select('id','nama','jenis');

        return DataTables::of($kriteria)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function tampilPrioritas()
{
    $breadcrumb = (object) [
        'title' => '',
        'list' => ['Home', 'pengaduan prioritas']
    ];

    $page = (object) [
        'title' => 'Dashboard admin'
    ];
    $activeMenu = 'hasil';

    return view('admin.prioritas.pengaduan', [
        'breadcrumb' => $breadcrumb, 
        'page' => $page, 
        'activeMenu' => $activeMenu
    ]);
}




public function getPengaduanData()
{
    $query = DB::table('v_pengaduan as vp')
        ->join('jenis_pengaduan as jp', 'vp.id_jenis_pengaduan', '=', 'jp.id_jenis_pengaduan')
        ->join('hasil_prioritas as hp', 'vp.id_jenis_pengaduan', '=', 'hp.id_jenis_pengaduan')
        ->where('vp.id_status_pengaduan', function ($subQuery) {
            $subQuery->select('id_status_pengaduan')
                ->from('status_pengaduan')
                ->where('status_kode', 'ACCEPT')
                ->limit(1);
        })
        ->select('vp.id_pengaduan', 'jp.id_jenis_pengaduan', 'jp.pengaduan_nama', 'vp.id_status_pengaduan', 'hp.score')
        ->orderBy('hp.score', 'DESC');
        
    return DataTables::of($query)
        ->addColumn('action', function ($row) { // menambahkan kolom aksi
            $btn = '<a href="'.url('/jpengaduan/' . $row->id_jenis_pengaduan . '/edit').'" class="btn btn-warning btn-sm"><i class="fas fa-tasks"></i> Tindak</a> ';
            return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
}







}
