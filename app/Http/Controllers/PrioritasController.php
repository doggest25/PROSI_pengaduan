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
use App\Models\SubKriteria;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

use function Laravel\Prompts\select;

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

// Mendapatkan dan mengurutkan kriteria berdasarkan id
$kriteria = Kriteria::orderBy('id')->get();
$perbandinganKriteria = PerbandinganKriteria::all();

// Membuat Matriks Perbandingan Berpasangan
$n = count($kriteria);
$pairwiseMatrix = array_fill(0, $n, array_fill(0, $n, 1.0));

// Membuat mapping id kriteria ke indeks matriks
$kriteriaMap = [];
foreach ($kriteria as $index => $k) {
    $kriteriaMap[$k->id] = $index;
}

foreach ($perbandinganKriteria as $perbandingan) {
    $i = $kriteriaMap[$perbandingan->kriteria_1_id];
    $j = $kriteriaMap[$perbandingan->kriteria_2_id];
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
        $normalizedMatrix[$i][$j] = round($pairwiseMatrix[$i][$j] / $columnSums[$j],3);
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

// Mapping eigenvector values to criteria IDs
$eigenVectorMapped = [];
foreach ($kriteria as $index => $k) {
    $eigenVectorMapped[$k->id] = round($eigenVector[$index],3);
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
$pengaduanList = PengaduanModel::with(['users', 'jenis_pengaduan', 'hasil_prioritas'])
->whereHas('status_pengaduan', function ($query) {
    $query->where('status_kode', 'ACCEPT');
})
->whereHas('hasil_prioritas', function ($query) {
    $query->whereNotNull('final_score');
    $query->orderBy('final_score', 'desc');
})
->get();
// Jumlah alternatif dan kriteria
$m = count($pengaduanList);
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
        if (!isset($eigenVectorMapped[$key])) {
            // Handle missing key in eigenVector
            throw new Exception("Missing key in eigenVector: " . $key);
        }
        $weightedRow[$key] = round(($value * $eigenVectorMapped[$key]) + $eigenVectorMapped[$key], 3); // Mengambil 3 angka di belakang koma
    }
    $weightedMatrix[$id_pengaduan] = $weightedRow;
}

/// Matriks area perkiraan perbatasan
$gMatrix = array_fill_keys(array_keys($eigenVectorMapped), 1); // Initialize $gMatrix with the keys from $eigenVectorMapped

foreach ($weightedMatrix as $row) {
    foreach ($row as $key => $value) {
        if (!isset($gMatrix[$key])) {
            // Handle invalid key
            throw new Exception("Invalid key in weightedMatrix: " . $key);
        }
        $gMatrix[$key] *= $value; // Perkalian nilai elemen dalam kolom
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
        if (!isset($gMatrix[$key])) {
            // Handle invalid key
            throw new Exception("Invalid key in gMatrix: " . $key);
        }
        $qRow[$key] = round($value - $gMatrix[$key], 3); // Mengambil 3 angka di belakang koma
    }
    $qMatrix[$id_pengaduan] = $qRow;
}

// Hasil akhir MABAC
$finalScores = [];
foreach ($qMatrix as $id_pengaduan => $row) {
    $finalScores[$id_pengaduan] = round(array_sum($row), 3); // Mengambil 3 angka di belakang koma
}

// Mengurutkan $finalScores dari yang terbesar ke yang terkecil
arsort($finalScores);


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
            ->addColumn('aksi', function ($kriteria) { // menambahkan kolom aksi
                $btn = '<a href="'.url('/prioritas/' . $kriteria->id . '/subkriteria/edit').'" class="btn btn-info btn-sm">Edit Sub kriteria</a> ';
                $btn .= '<a href="'.url('/prioritas/nilaiKriteria').'" class="btn btn-warning btn-sm">Edit Nilai</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/prioritas/'.$kriteria->id).'">'.
                            csrf_field() . method_field('DELETE') .
                            '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    public function createKriteria() 
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Kriteria',
            'list' => ['Home', 'Kriteria', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Kriteria Baru'
        ];

        $activeMenu = 'kriteria'; //set menu yang aktif
        $daftar_kriteria = Kriteria::all();
        return view('admin.prioritas.createKriteria', ['daftar_kriteria'=> $daftar_kriteria,'breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    } 
    

    

    public function storeKriteria(Request $request)
{
    // Validasi input
    $request->validate([
        'nama' => 'required|string',
        'jenis' => 'required|in:cost,benefit',
    ]);

    // Tentukan ID berikutnya secara manual
    $lastInsertedId = Kriteria::max('id') + 1;

    // Simpan kriteria baru dengan ID yang ditentukan
    $kriteria = Kriteria::create([
        'id' => $lastInsertedId,
        'nama' => $request->nama,
        'jenis' => $request->jenis,
    ]);

    // Simpan nilai perbandingan default
    $daftar_kriteria = Kriteria::all();
    foreach ($daftar_kriteria as $k) {
        if ($k->id != $kriteria->id) {
            PerbandinganKriteria::create([
                'kriteria_1_id' => $k->id,
                'kriteria_2_id' => $kriteria->id,
                'nilai_perbandingan' => 1, // Nilai default
            ]);
            PerbandinganKriteria::create([
                'kriteria_1_id' => $kriteria->id,
                'kriteria_2_id' => $k->id,
                'nilai_perbandingan' => 1, // Nilai default
            ]);
        }
    }
 // Buat sub-kriteria default berdasarkan jenis
 $subKriteriaDefault = [
    'benefit' => [
        ['name' => 'Sangat Rendah', 'value' => 1],
        ['name' => 'Rendah', 'value' => 2],
        ['name' => 'Sedang', 'value' => 3],
        ['name' => 'Tinggi', 'value' => 4],
        ['name' => 'Sangat Tinggi', 'value' => 5],
    ],
    'cost' => [
        ['name' => 'Sangat Rendah', 'value' => 5],
        ['name' => 'Rendah', 'value' => 4],
        ['name' => 'Sedang', 'value' => 3],
        ['name' => 'Tinggi', 'value' => 2],
        ['name' => 'Sangat Tinggi', 'value' => 1],
    ],
];

foreach ($subKriteriaDefault[$request->jenis] as $subKriteria) {
    SubKriteria::create([
        'kriteria_id' => $kriteria->id,
        'name' => $subKriteria['name'],
        'value' => $subKriteria['value'],
    ]);
}
    return redirect('prioritas/kriteria')->with('success', "Data berhasil disimpan dengan ID {$lastInsertedId}");
}
public function editNilaiKriteria()
{
    $breadcrumb = (object) [
        'title' => 'Edit Nilai Kriteria',
        'list' => ['Home', 'Kriteria', 'Edit Nilai']
    ];

    $page = (object) [
        'title' => 'Edit Nilai Perbandingan Kriteria'
    ];

    $activeMenu = 'kriteria'; // Set menu yang aktif
    $daftar_kriteria = Kriteria::all();
    
    return view('admin.prioritas.perbandinganKriteria', [
        'daftar_kriteria' => $daftar_kriteria,
        'breadcrumb' => $breadcrumb,
        'page' => $page,
        'activeMenu' => $activeMenu
    ]);
}

public function updateNilaiKriteria(Request $request)
{
    $request->validate([
        'nilai_perbandingan' => 'required|array',
        
    ]);

    foreach ($request->nilai_perbandingan as $kriteria_id => $sub_kriteria) {
        foreach ($sub_kriteria as $sub_kriteria_id => $nilai) {
            // Update nilai perbandingan
            PerbandinganKriteria::updateOrCreate(
                ['kriteria_1_id' => $kriteria_id, 'kriteria_2_id' => $sub_kriteria_id],
                ['nilai_perbandingan' => $nilai]
            );

            // Update nilai perbandingan sebaliknya
            PerbandinganKriteria::updateOrCreate(
                ['kriteria_1_id' => $sub_kriteria_id, 'kriteria_2_id' => $kriteria_id],
                ['nilai_perbandingan' => 1 / $nilai]
            );
        }
    }

    return redirect('prioritas/kriteria')->with('success', "Data berhasil disimpan");
}
public function editSubKriteria($kriteriaId)
{
    $breadcrumb = (object) [
        'title' => 'Edit Sub Kriteria',
        'list' => ['Home', 'Sub Kriteria', 'Tambah']
    ];

    $page = (object) [
        'title' => 'Edit Sub Kriteria Baru'
    ];

    $activeMenu = 'kriteria'; // Set menu yang aktif
    $kriteria = Kriteria::findOrFail($kriteriaId);
    $subKriteria = SubKriteria::where('kriteria_id', $kriteriaId)->get();

    return view('admin.prioritas.edit_sub_kriteria', compact('kriteria', 'subKriteria', 'activeMenu', 'page', 'breadcrumb'));
}


public function updateSubKriteria(Request $request, $kriteriaId)
{
    
    $data = $request->validate([
        'sub_kriteria.*.id' => 'required|exists:sub_kriteria,id',
        'sub_kriteria.*.name' => 'required|string|max:255',
        'sub_kriteria.*.value' => [
            'nullable',
            'integer',
            'min:1',
            'max:5',
            function ($attribute, $value, $fail) use ($request) {
                $values = array_column($request->input('sub_kriteria'), 'value');
                if (count($values) !== count(array_unique($values))) {
                    $fail('Nilai sub kriteria tidak boleh ada yang sama.');
                }
            }
        ],
    ], [
        'sub_kriteria.*.id.required' => 'ID sub kriteria harus diisi.',
        'sub_kriteria.*.id.exists' => 'ID sub kriteria tidak valid.',
        'sub_kriteria.*.name.required' => 'Nama sub kriteria harus diisi.',
        'sub_kriteria.*.value.integer' => 'Nilai sub kriteria harus berupa angka.',
        'sub_kriteria.*.value.min' => 'Nilai sub kriteria harus minimal 1.',
        'sub_kriteria.*.value.max' => 'Nilai sub kriteria harus maksimal 5.',
    ]);

    

    foreach ($request->sub_kriteria as $subKriteriaData) {
        $subKriteria = SubKriteria::findOrFail($subKriteriaData['id']);
        $subKriteria->update([
            'name' => $subKriteriaData['name'],
            'value' => $subKriteriaData['value'],
        ]);
    }

    return redirect()->route('edit-sub-kriteria', $kriteriaId)->with('success', 'Sub-kriteria berhasil diperbarui.');
}


public function destroyKriteria($id)
{
    $check = Kriteria::find($id);
    if (!$check) {
        return redirect('/prioritas/kriteria')->with('error', 'Data level tidak ditemukan');
    }
    
    try {
        Kriteria::destroy($id);

        return redirect('/prioritas/kriteria')->with('success', 'kriteria berhasil dihapus');
    } catch (\Illuminate\Database\QueryException $e) {
        return redirect('/prioritas/kriteria')->with('error', 'Data level gagal dihapus' . $e->getMessage());
    }
}
    
    public function tampilDiterima() 
    {
        // Menampilkan halaman awal 
        $breadcrumb = (object) [
            'title' => 'Mengisi Nilai alternatif',
            'list' => ['Home', 'Pengaduan diterima ']
        ];

        $page = (object) [
            'title' => 'Daftar Pengaduan dengan status "Diterima" yang belum memiliki nilai alternatif'
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
    $pengaduan = PengaduanModel::with('jenis_pengaduan','users')->find($id);

    // Retrieve all criteria with sub-criteria
    $kriteriaList = Kriteria::with('subKriteria')->get();

    // Breadcrumb and page information
    $breadcrumb = (object) [
        'title' => 'Perkiraan Kebutuhan Setiap Pengaduan',
        'list' => ['Home', 'Form Penilaian Kriteria']
    ];

    $page = (object) [
        'title' => 'Form Pemberian Nilai'
    ];

    $activeMenu = 'diterima'; //set menu yang aktif

    return view('admin.prioritas.input_nilai', [
        'pengaduan' => $pengaduan,
        'breadcrumb' => $breadcrumb,
        'page' => $page,
        'activeMenu' => $activeMenu,
        'pengaduan_nama' => $pengaduan->jenis_pengaduan->pengaduan_nama,
        'nama' => $pengaduan->users->nama,
        'deskripsi' => $pengaduan->deskripsi,
        'bukti_foto' => $pengaduan->bukti_foto,
        'kriteriaList' => $kriteriaList,
    ]);
}




public function simpanNilai(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'sub_kriteria' => 'required|array',
    ]);

    // Ambil pengaduan berdasarkan id
    $pengaduan = PengaduanModel::findOrFail($id);

    // Simpan nilai ke tabel penilaian_alternatif
    foreach ($request->input('sub_kriteria') as $kriteriaId => $subKriteriaValue) {
        PenilaianAlternatif::create([
            'id_pengaduan' => $pengaduan->id_pengaduan,
            'kriteria_id' => $kriteriaId,
            'nilai' => $subKriteriaValue,
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
            'title' => 'Hasil Ranking Perhitungan',
            'list' => ['Home', 'Hasil Prioritas']
        ];

        $page = (object) [
            'title' => 'Daftar  ranking berdasarkan final score tertinggi'
        ];

        $activeMenu = 'hasil'; //set menu yang aktif

       // AHP Calculation

// Mendapatkan dan mengurutkan kriteria berdasarkan id
$kriteria = Kriteria::orderBy('id')->get();
$perbandinganKriteria = PerbandinganKriteria::all();

// Membuat Matriks Perbandingan Berpasangan
$n = count($kriteria);
$pairwiseMatrix = array_fill(0, $n, array_fill(0, $n, 1.0));

// Membuat mapping id kriteria ke indeks matriks
$kriteriaMap = [];
foreach ($kriteria as $index => $k) {
    $kriteriaMap[$k->id] = $index;
}

foreach ($perbandinganKriteria as $perbandingan) {
    $i = $kriteriaMap[$perbandingan->kriteria_1_id];
    $j = $kriteriaMap[$perbandingan->kriteria_2_id];
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

// Mapping eigenvector values to criteria IDs
$eigenVectorMapped = [];
foreach ($kriteria as $index => $k) {
    $eigenVectorMapped[$k->id] = $eigenVector[$index];
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
$pengaduanList = PengaduanModel::with(['users', 'jenis_pengaduan', 'hasil_prioritas'])
->whereHas('status_pengaduan', function ($query) {
    $query->where('status_kode', 'ACCEPT');
})
->whereHas('hasil_prioritas', function ($query) {
    $query->whereNotNull('final_score');
    $query->orderBy('final_score', 'desc');
})
->get();
// Jumlah alternatif dan kriteria
$m = count($pengaduanList);
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
        if (!isset($eigenVectorMapped[$key])) {
            // Handle missing key in eigenVector
            throw new Exception("Missing key in eigenVector: " . $key);
        }
        $weightedRow[$key] = round(($value * $eigenVectorMapped[$key]) + $eigenVectorMapped[$key], 3); // Mengambil 3 angka di belakang koma
    }
    $weightedMatrix[$id_pengaduan] = $weightedRow;
}

// Matriks area perkiraan perbatasan
$gMatrix = array_fill_keys(array_keys($eigenVectorMapped), 1); // Initialize $gMatrix with the keys from $eigenVectorMapped

foreach ($weightedMatrix as $row) {
    foreach ($row as $key => $value) {
        if (!isset($gMatrix[$key])) {
            // Handle invalid key
            throw new Exception("Invalid key in weightedMatrix: " . $key);
        }
        $gMatrix[$key] *= $value; // Perkalian nilai elemen dalam kolom
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
        if (!isset($gMatrix[$key])) {
            // Handle invalid key
            throw new Exception("Invalid key in gMatrix: " . $key);
        }
        $qRow[$key] = round($value - $gMatrix[$key], 3); // Mengambil 3 angka di belakang koma
    }
    $qMatrix[$id_pengaduan] = $qRow;
}

// Hasil akhir MABAC
$finalScores = [];
foreach ($qMatrix as $id_pengaduan => $row) {
    $finalScores[$id_pengaduan] = round(array_sum($row), 3); // Mengambil 3 angka di belakang koma
}

// Mengurutkan $finalScores dari yang terbesar ke yang terkecil
arsort($finalScores);


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

    $pengaduanList = PengaduanModel::with(['users', 'jenis_pengaduan', 'hasil_prioritas'])
        ->whereHas('status_pengaduan', function ($query) {
            $query->where('status_kode', 'ACCEPT');
        })
        ->whereHas('hasil_prioritas', function ($query) {
            $query->whereNotNull('final_score');
            $query->orderBy('final_score', 'desc');
        })
        ->select('id_pengaduan', 'user_id', 'id_jenis_pengaduan', 'deskripsi')
        
        ->get();

    return DataTables::of($pengaduanList)
        ->addIndexColumn()
        ->addColumn('aksi', function ($row) {
            $btn = '<a href="' . url('/hasil/' . $row->id_pengaduan) . '" class="btn btn-info btn-sm">Tindakan </a>';
            $btn .= ' ';
            $btn .= '<a href="' . url('/hasil/edit-nilai/' . $row->id_pengaduan) . '" class="btn btn-warning btn-sm"><i class=" fas fa-edit"></i> edit nilai</a>';
            
            return  $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
}
// app/Http/Controllers/PengaduanController.php

public function editNilaiAlternatif($id)
{
     // Menampilkan halaman awal user
     $breadcrumb = (object) [
        'title' => 'Edit Nilai Alternatif',
        'list' => ['Home', 'Edit Alternatif']
    ];

    $page = (object) [
        'title' => 'Edit  Nilai Alternatif'
    ];

    $activeMenu = 'hasil'; //set menu yang aktif
    $pengaduan = PengaduanModel::with('jenis_pengaduan', 'users', 'nilaiAlternatif')->find($id);
    $kriteriaList = Kriteria::with('subKriteria')->get();

    return view('admin.prioritas.editAlternatif', [
        'pengaduan' => $pengaduan,
        'breadcrumb' => $breadcrumb,
        'page' => $page,
        'activeMenu' => $activeMenu,
        'pengaduan_nama' => $pengaduan->jenis_pengaduan->pengaduan_nama,
        'nama' => $pengaduan->users->nama,
        'deskripsi' => $pengaduan->deskripsi,
        'bukti_foto' => $pengaduan->bukti_foto,
        'kriteriaList' => $kriteriaList,
    ]);
}

public function updateNilaiAlternatif(Request $request, $id)
{
    $this->validate($request, [
        'sub_kriteria' => 'required|array',
    ]);

    $pengaduan = PengaduanModel::findOrFail($id);

    foreach ($request->input('sub_kriteria') as $kriteriaId => $subKriteriaValue) {
        // Cek apakah sudah ada record nilai alternatif untuk kriteria tersebut
        $nilaiAlternatif = PenilaianAlternatif::where('id_pengaduan', $id)
                            ->where('kriteria_id', $kriteriaId)
                            ->first();

        if ($nilaiAlternatif) {
            // Jika sudah ada, update nilai
            $nilaiAlternatif->update(['nilai' => $subKriteriaValue]);
        } else {
            // Jika belum ada, buat record baru
            PenilaianAlternatif::create([
                'id_pengaduan' => $id,
                'kriteria_id' => $kriteriaId,
                'nilai' => $subKriteriaValue,
            ]);
        }
    }

    return redirect('/hasil/accepted')->with('success', 'Nilai alternatif berhasil diperbarui.');
}


public function show($id)
{
    try {
        $detail = PengaduanModel::with([
            'nilaiAlternatif.kriteria',
            'nilaiAlternatif.subKriteria',
            'users', // Assuming user relationship exists
            'jenis_pengaduan' // Assuming jenis_pengaduan relationship exists
        ])->findOrFail($id);
    } catch (ModelNotFoundException $e) {
        return redirect()->back()->with('error', 'Data pengaduan tidak ditemukan.');
    }

    $status_pengaduan = StatusPengaduanModel::all();

    $breadcrumb = (object) [
        'title' => 'Detail Pengaduan',
        'list' => ['Home', 'Pengaduan', 'Detail']
    ];

    $page = (object) [
        'title' => 'Detail Pengaduan'
    ];

    $activeMenu = 'hasil';

    return view('admin.prioritas.detail_prioritas', [
        'breadcrumb' => $breadcrumb,
        'page' => $page,
        'detail' => $detail,
        'activeMenu' => $activeMenu,
        'status_pengaduan' => $status_pengaduan
    ]);
}



public function updateStatus(Request $request, $id)
{
    $pengaduan = PengaduanModel::findOrFail($id);

    // Debugging: Print the status name from the request
    // dd($request->status_pengaduan);

    // Cari ID status pengaduan berdasarkan nama
    $status = StatusPengaduanModel::where('status_nama', $request->status_pengaduan)->first();

    if ($status) {
        // Simpan ID status pengaduan ke dalam data pengaduan
        $pengaduan->id_status_pengaduan = $status->id_status_pengaduan;
        $pengaduan->save();

        // Redirect atau respons lainnya
        return redirect('hasil/accepted')->with('success', 'Status pengaduan berhasil diperbarui.');
    } else {
        // Handle the case where the status is not found
        return redirect()->back()->with('error', 'Status pengaduan tidak ditemukan.');
    }
}



}
