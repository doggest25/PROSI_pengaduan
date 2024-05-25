<?php

namespace App\Http\Controllers;

use App\Models\HasilPrioritas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kriteria;
use App\Models\PengaduanModel;
use App\Models\PerbandinganKriteria;
use App\Models\PenilaianAlternatif;
use App\Models\StatusPengaduanModel;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
     $v_pengaduan = PengaduanModel::all();
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
        $eigenVector[$i] = round($sum / $n, 3); // Mengambil 3 angka di belakang koma
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
    $lambdaMax = round($lambdaMax / $n, 3); // Mengambil 3 angka di belakang koma

    // Menghitung CI
    $ci = round(($lambdaMax - $n) / ($n - 1), 3);

    // Menghitung CR
    $ri = [0.0, 0.0, 0.58, 0.90, 1.12, 1.24, 1.32, 1.41, 1.45];
    $cr = round($ci / $ri[$n - 1], 3);

    // MABAC Calculation

    // Mengambil data dari tabel yang relevan
    $alternatif = PengaduanModel::with('jenis_pengaduan')->get();

    $penilaianAlternatif = PenilaianAlternatif::all();

    // Jumlah alternatif dan kriteria
    $m = count($alternatif);
    $k = count($kriteria);

    // Membentuk matriks keputusan awal
     $decisionMatrix = [];
    foreach ($penilaianAlternatif as $penilaian) {
        $decisionMatrix[$penilaian->id_pengaduan][$penilaian->kriteria_id] = $penilaian->nilai;
    }



    // Normalisasi elemen matriks
    $normalizedMatrix = [];
    foreach ($decisionMatrix as $id_pengaduan => $row) {
        $normalizedRow = [];
        foreach ($row as $key => $value) {
            $kriteriaItem = $kriteria->find($key);

            if (!$kriteriaItem) {
                continue; // Lewati jika kriteria tidak ditemukan
            }

            $columnValues = array_column($decisionMatrix, $key);
            $maxValue = max($columnValues);
            $minValue = min($columnValues);

            if ($kriteriaItem->jenis == 'benefit') {
                if ($maxValue != $minValue) {
                    $normalizedRow[$key] = ($value - $minValue) / ($maxValue - $minValue);
                } else {
                    $normalizedRow[$key] = 0;
                }
            } elseif ($kriteriaItem->jenis == 'cost') {
                if ($maxValue != $minValue) {
                    $normalizedRow[$key] = ($maxValue - $value) / ($maxValue - $minValue);
                } else {
                    $normalizedRow[$key] = 0;
                }
            } else {
                // Tambahkan penanganan kesalahan jika jenis kriteria tidak valid
                throw new Exception("Jenis kriteria tidak valid: " . $kriteriaItem->jenis);
            }
        }
        $normalizedMatrix[$id_pengaduan] = $normalizedRow;
    }

    // Matriks tertimbang
    $weightedMatrix = [];
    foreach ($normalizedMatrix as $id_pengaduan => $row) {
        $weightedRow = [];
        foreach ($row as $key => $value) {
            // Menggunakan rumus: ($value * $eigenVector) + $eigenVector
            $weightedRow[$key] = round(($value * $eigenVector[$key - 1]) + $eigenVector[$key - 1], 3); // Mengambil 3 angka di belakang koma
        }
        $weightedMatrix[$id_pengaduan] = $weightedRow;
    }

    // Matriks area perkiraan perbatasan
    $gMatrix = array_fill(0, $k, 1); // Inisialisasi dengan 1 untuk perkalian

    foreach ($weightedMatrix as $row) {
        foreach ($row as $key => $value) {
            $gMatrix[$key - 1] *= $value; // Perkalian nilai elemen dalam kolom
        }
    }

    // Menghitung rata-rata geometris
    $gMatrix = array_map(function($val) use ($m) {
        return round(pow($val, 1 / $m), 3); // Mengambil 3 angka di belakang koma
    }, $gMatrix);

    // Matriks jarak alternatif
    $qMatrix = [];
    foreach ($weightedMatrix as $id_pengaduan => $row) {
        $qRow = [];
        foreach ($row as $key => $value) {
            $qRow[$key] = round($value - $gMatrix[$key - 1], 3); // Mengambil 3 angka di belakang koma
        }
        $qMatrix[$id_pengaduan] = $qRow;
    }

    // Hasil akhir MABAC
    $finalScores = [];
    foreach ($qMatrix as $id_pengaduan => $row) {
        $finalScores[$id_pengaduan] = round(array_sum($row), 3); // Mengambil 3 angka di belakang koma
    }

    // Menyimpan hasil akhir ke database
    foreach ($finalScores as $id_pengaduan => $finalScore) {
        HasilPrioritas::updateOrCreate(
            ['id_pengaduan' => $id_pengaduan],
            ['final_score' => $finalScore]
        );
    }





    return view('admin.prioritas.perhitungan', [
        'alternatif'=>$alternatif,
        'n'=>$n,
        'kriteria' =>$kriteria,
        'eigenVector' => $eigenVector,
        'lambdaMax' => $lambdaMax,
        'ci' => $ci,
        'cr' => $cr,
        'decisionMatrix' => $decisionMatrix,
        'normalizedMatrix' => $normalizedMatrix,
        'weightedMatrix' =>$weightedMatrix,
        'gMatrix' =>$gMatrix,
        'qMatrix' =>$qMatrix,
        'finalScores'=>$finalScores,
        'breadcrumb' => $breadcrumb, 
        'page' => $page, 
        'activeMenu' => $activeMenu,
        
        
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
    
    public function tampilDiterima() 
    {
        // Menampilkan halaman awal 
        $breadcrumb = (object) [
            'title' => ' Pengaduan diterima',
            'list' => ['Home', 'Pengaduan diterima ']
        ];

        $page = (object) [
            'title' => 'Daftar Pengaduan yang diterima dalam sistem'
        ];

        $activeMenu = 'diterima'; //set menu yang aktif

        return view('admin.prioritas.alternatif', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    
    public function listDiterima(Request $request)
{   
    // Filter untuk pengaduan dengan status_kode 'FINISH'
   $finishedPengaduanIds = DB::table('v_pengaduan as vp')
   ->join('status_pengaduan as sp', 'vp.id_status_pengaduan', '=', 'sp.id_status_pengaduan')
   ->where('sp.status_kode', 'FINISH')
   ->orWhere('sp.status_kode', 'ON GOING')
   ->orWhere('sp.status_kode', 'DENIED')
   ->pluck('vp.id_pengaduan')
   ->toArray();


   // Hapus id_pengaduan terkait dari tabel hasil_prioritas dan penilaian_alternatif
   if (!empty($finishedPengaduanIds)) {
       HasilPrioritas::whereIn('id_pengaduan', $finishedPengaduanIds)->delete();
       PenilaianAlternatif::whereIn('id_pengaduan', $finishedPengaduanIds)->delete();
   }
    // Mendapatkan semua ID pengaduan yang sudah memiliki nilai di PenilaianAlternatifModel
    $pengaduanSudahNilai = PenilaianAlternatif::pluck('id_pengaduan')->toArray();

    // Filter data pengaduan yang statusnya 'diterima' dan belum memiliki nilai di PenilaianAlternatifModel
    $detailPengaduan = PengaduanModel::with(['users', 'jenis_pengaduan', 'status_pengaduan'])
        ->whereHas('status_pengaduan', function ($query) {
            $query->where('status_nama', 'diterima');
        })
        ->whereNotIn('id_pengaduan', $pengaduanSudahNilai)
        ->select('id_pengaduan', 'user_id', 'id_jenis_pengaduan', 'id_status_pengaduan')
        ->get();

    return DataTables::of($detailPengaduan)
        ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
        ->addColumn('aksi', function ($detail) { // menambahkan kolom aksi
            $btn = '<a href="'.url('/hasil/detail/' . $detail->id_pengaduan ).'" class="btn btn-info btn-sm">Detail </a> ';
            $btn .= '<a href="' . url('/prioritas/' . $detail->id_pengaduan) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Isi nilai</a>';
            
            return $btn;
        })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);
}
public function showPengaduan($id)
{   
    try {
        $detail = PengaduanModel::findOrFail($id);
    } catch (ModelNotFoundException $e) {
        // Jika data tidak ditemukan, redirect atau tampilkan pesan kesalahan
        return redirect()->back()->with('error', 'Data pengaduan tidak ditemukan.');
    }
    $status_pengaduan = StatusPengaduanModel::all(); // Retrieve all status pengaduan

    $breadcrumb = (object) [
        'title' => 'Detail Pengaduan',
        'list' => ['Home', 'Pengaduan', 'Detail']
    ];

    $page = (object) [
        'title' => 'Detail Pengaduan'
    ];

    $activeMenu = 'diterima'; //set menu yang aktif

    return view('admin.prioritas.alternatif_detail', ['breadcrumb' => $breadcrumb, 'page' => $page, 'detail' => $detail, 'activeMenu' => $activeMenu,'status_pengaduan' => $status_pengaduan]);
}


    public function showFormNilai($id)
    {
        $pengaduan = PengaduanModel::find($id);
        // Menampilkan halaman awal
        $breadcrumb = (object) [
            'title' => ' Pengaduan diterima',
            'list' => ['Home', 'Pengaduan diterima ']
        ];

        $page = (object) [
            'title' => 'Daftar Pengaduan yang diterima dalam sistem'
        ];

        $activeMenu = 'diterima'; //set menu yang aktif

        return view('admin.prioritas.input_nilai', [
            'pengaduan' => $pengaduan,
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    public function simpanNilai(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'biaya' => 'required|integer|between:1,5',
        'sdm' => 'required|integer|between:1,5',
        'efektivitas' => 'required|integer|between:1,5',
        'urgensi' => 'required|integer|between:1,5',
        'dampak' => 'required|integer|between:1,5',
    ]);

    // Ambil jenis pengaduan
    $pengaduan = PengaduanModel::find($id);

    // Mapping kriteria
    $kriteriaMapping = [
        'biaya' => 1, // ID untuk kriteria 'biaya'
        'sdm' => 2, // ID untuk kriteria 'sdm'
        'efektivitas' => 3, // ID untuk kriteria 'efektivitas'
        'urgensi' => 4, // ID untuk kriteria 'urgensi'
        'dampak' => 5, // ID untuk kriteria 'dampak'
    ];

    // Simpan nilai ke tabel penilaian_alternatif
    foreach ($kriteriaMapping as $kriteria => $idKriteria) {
        PenilaianAlternatif::create([
            'id_pengaduan' => $pengaduan->id_pengaduan,
            'kriteria_id' => $idKriteria, // Gunakan ID kriteria dari mapping
            'nilai' => $request->input($kriteria),
        ]);
    }

    // Redirect dengan pesan sukses
    return redirect('prioritas/pengaduanDiterima')->with('success', 'Nilai berhasil disimpan.');
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

public function index() 
    {
        // Menampilkan halaman awal user
        $breadcrumb = (object) [
            'title' => 'Daftar prioritas',
            'list' => ['Home', 'Hasil Prioritas']
        ];

        $page = (object) [
            'title' => 'Daftar  perhitungan prioritas yang terdaftar dalam sistem'
        ];

        $activeMenu = 'hasil'; //set menu yang aktif
         // AHP Calculation
     $v_pengaduan = PengaduanModel::all();
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
         $eigenVector[$i] = round($sum / $n, 3); // Mengambil 3 angka di belakang koma
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
     $lambdaMax = round($lambdaMax / $n, 3); // Mengambil 3 angka di belakang koma
 
     // Menghitung CI
     $ci = round(($lambdaMax - $n) / ($n - 1), 3);
 
     // Menghitung CR
     $ri = [0.0, 0.0, 0.58, 0.90, 1.12, 1.24, 1.32, 1.41, 1.45];
     $cr = round($ci / $ri[$n - 1], 3);
 
     // MABAC Calculation
 
     // Mengambil data dari tabel yang relevan
     $alternatif = PengaduanModel::with('jenis_pengaduan')->get();
 
     $penilaianAlternatif = PenilaianAlternatif::all();
 
     // Jumlah alternatif dan kriteria
     $m = count($alternatif);
     $k = count($kriteria);
 
     // Membentuk matriks keputusan awal
      $decisionMatrix = [];
     foreach ($penilaianAlternatif as $penilaian) {
         $decisionMatrix[$penilaian->id_pengaduan][$penilaian->kriteria_id] = $penilaian->nilai;
     }
 
 
 
     // Normalisasi elemen matriks
     $normalizedMatrix = [];
     foreach ($decisionMatrix as $id_pengaduan => $row) {
         $normalizedRow = [];
         foreach ($row as $key => $value) {
             $kriteriaItem = $kriteria->find($key);
 
             if (!$kriteriaItem) {
                 continue; // Lewati jika kriteria tidak ditemukan
             }
 
             $columnValues = array_column($decisionMatrix, $key);
             $maxValue = max($columnValues);
             $minValue = min($columnValues);
 
             if ($kriteriaItem->jenis == 'benefit') {
                 if ($maxValue != $minValue) {
                     $normalizedRow[$key] = ($value - $minValue) / ($maxValue - $minValue);
                 } else {
                     $normalizedRow[$key] = 0;
                 }
             } elseif ($kriteriaItem->jenis == 'cost') {
                 if ($maxValue != $minValue) {
                     $normalizedRow[$key] = ($maxValue - $value) / ($maxValue - $minValue);
                 } else {
                     $normalizedRow[$key] = 0;
                 }
             } else {
                 // Tambahkan penanganan kesalahan jika jenis kriteria tidak valid
                 throw new Exception("Jenis kriteria tidak valid: " . $kriteriaItem->jenis);
             }
         }
         $normalizedMatrix[$id_pengaduan] = $normalizedRow;
     }
 
     // Matriks tertimbang
     $weightedMatrix = [];
     foreach ($normalizedMatrix as $id_pengaduan => $row) {
         $weightedRow = [];
         foreach ($row as $key => $value) {
             // Menggunakan rumus: ($value * $eigenVector) + $eigenVector
             $weightedRow[$key] = round(($value * $eigenVector[$key - 1]) + $eigenVector[$key - 1], 3); // Mengambil 3 angka di belakang koma
         }
         $weightedMatrix[$id_pengaduan] = $weightedRow;
     }
 
     // Matriks area perkiraan perbatasan
     $gMatrix = array_fill(0, $k, 1); // Inisialisasi dengan 1 untuk perkalian
 
     foreach ($weightedMatrix as $row) {
         foreach ($row as $key => $value) {
             $gMatrix[$key - 1] *= $value; // Perkalian nilai elemen dalam kolom
         }
     }
 
     // Menghitung rata-rata geometris
     $gMatrix = array_map(function($val) use ($m) {
         return round(pow($val, 1 / $m), 3); // Mengambil 3 angka di belakang koma
     }, $gMatrix);
 
     // Matriks jarak alternatif
     $qMatrix = [];
     foreach ($weightedMatrix as $id_pengaduan => $row) {
         $qRow = [];
         foreach ($row as $key => $value) {
             $qRow[$key] = round($value - $gMatrix[$key - 1], 3); // Mengambil 3 angka di belakang koma
         }
         $qMatrix[$id_pengaduan] = $qRow;
     }
 
     // Hasil akhir MABAC
     $finalScores = [];
     foreach ($qMatrix as $id_pengaduan => $row) {
         $finalScores[$id_pengaduan] = round(array_sum($row), 3); // Mengambil 3 angka di belakang koma
     }
 
     // Menyimpan hasil akhir ke database
     foreach ($finalScores as $id_pengaduan => $finalScore) {
         HasilPrioritas::updateOrCreate(
             ['id_pengaduan' => $id_pengaduan],
             ['final_score' => $finalScore]
         );
     }
       

        return view('admin.prioritas.hasil_prioritas', ['breadcrumb' => $breadcrumb, 'page' => $page,'activeMenu' => $activeMenu]);
    }
    public function listAcceptedPengaduan(Request $request)
{
    // Filter untuk pengaduan dengan status_kode 'FINISH'
   $finishedPengaduanIds = DB::table('v_pengaduan as vp')
    ->join('status_pengaduan as sp', 'vp.id_status_pengaduan', '=', 'sp.id_status_pengaduan')
    ->where('sp.status_kode', 'FINISH')
    ->orWhere('sp.status_kode', 'ON GOING')
    ->orWhere('sp.status_kode', 'DENIED')
    ->pluck('vp.id_pengaduan')
    ->toArray();


    // Hapus id_pengaduan terkait dari tabel hasil_prioritas dan penilaian_alternatif
    if (!empty($finishedPengaduanIds)) {
        HasilPrioritas::whereIn('id_pengaduan', $finishedPengaduanIds)->delete();
        PenilaianAlternatif::whereIn('id_pengaduan', $finishedPengaduanIds)->delete();
    }

    // Query untuk pengaduan dengan status_kode 'ACCEPT'
    $query = DB::table('v_pengaduan as vp')
        ->join('hasil_prioritas as hp', 'vp.id_pengaduan', '=', 'hp.id_pengaduan')
        ->join('v_user as us', 'vp.user_id', '=', 'us.user_id')
        ->join('jenis_pengaduan as jp', 'vp.id_jenis_pengaduan', '=', 'jp.id_jenis_pengaduan')
        ->join('status_pengaduan as sp', 'vp.id_status_pengaduan', '=', 'sp.id_status_pengaduan')
        ->select('vp.*', 'us.nama', 'jp.pengaduan_nama', 'hp.final_score')
        ->where('sp.status_kode', 'ACCEPT')
        ->orderBy('hp.final_score', 'DESC');

    return DataTables::of($query)
        ->addColumn('aksi', function ($row) {
            return '<a href="' . url('/hasil/' . $row->id_pengaduan) . '" class="btn btn-info btn-sm">Tindakan</a>';
        })
        ->rawColumns(['aksi'])
        ->make(true);
}
    public function show($id)
{   
    try {
        $detail = PengaduanModel::findOrFail($id);
    } catch (ModelNotFoundException $e) {
        // Jika data tidak ditemukan, redirect atau tampilkan pesan kesalahan
        return redirect()->back()->with('error', 'Data pengaduan tidak ditemukan.');
    }
    $status_pengaduan = StatusPengaduanModel::all(); // Retrieve all status pengaduan

    $breadcrumb = (object) [
        'title' => 'Detail Pengaduan',
        'list' => ['Home', 'Pengaduan', 'Detail']
    ];

    $page = (object) [
        'title' => 'Detail Pengaduan'
    ];

    $activeMenu = 'dpengaduan'; //set menu yang aktif

    return view('admin.prioritas.detail_prioritas', ['breadcrumb' => $breadcrumb, 'page' => $page, 'detail' => $detail, 'activeMenu' => $activeMenu,'status_pengaduan' => $status_pengaduan]);
}

public function updateStatus(Request $request, $id)
{
    $pengaduan = PengaduanModel::findOrFail($id);

    // Cari ID status pengaduan berdasarkan nama
    $idStatus = StatusPengaduanModel::where('status_nama', $request->status_pengaduan)->first()->id_status_pengaduan;
    
    // Simpan ID status pengaduan ke dalam data pengaduan
    $pengaduan->id_status_pengaduan = $idStatus;
    $pengaduan->save();

    // Redirect atau respons lainnya
    return redirect('hasil/accepted')->with('success', 'Status pengaduan berhasil diperbarui.');
}


}
