<?php

namespace App\Http\Controllers;

use App\Models\PengaduanModel;
use App\Models\StatusPengaduanModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DetailPengaduanController extends Controller
{
    public function index() 
    {
        // Menampilkan halaman awal 
        $breadcrumb = (object) [
            'title' => 'Daftar Detail Pengaduan',
            'list' => ['Home', 'Detail Pengaduan']
        ];

        $page = (object) [
            'title' => 'Daftar Detail pengaduan yang terdaftar dalam sistem'
        ];

        $detailFilter = StatusPengaduanModel::pluck('status_nama', 'id_status_pengaduan')->prepend('- Semua -', '');
      
        $activeMenu = 'dpengaduan'; //set menu yang aktif

        return view('admin.detail_pengaduan.index', ['breadcrumb' => $breadcrumb, 'page' => $page,'detailFilter' => $detailFilter, 'activeMenu' => $activeMenu]);
    }
    
public function list(Request $request)
    {
        $detailPengaduan = PengaduanModel::select('id_pengaduan','user_id', 'id_jenis_pengaduan', 'id_status_pengaduan')
        ->with('users', 'jenis_pengaduan', 'status_pengaduan')
        ->get();

        // Filter data user berdasarkan status pengaduan
if ($request->id_status_pengaduan) {
    $detailPengaduan = $detailPengaduan->where('id_status_pengaduan', $request->id_status_pengaduan);
}
        

return DataTables::of($detailPengaduan)
->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
->addColumn('aksi', function ($detail) { // menambahkan kolom aksi
    $btn = '<a href="'.url('/dpengaduan/' . $detail->id_pengaduan).'" class="btn btn-info btn-sm">Detail</a> ';
    $btn .= '<form class="d-inline-block" method="POST" action="'. url('/dpengaduan/'.$detail->id_pengaduan).'">'.
                csrf_field() . method_field('DELETE') .
                '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
    return $btn;
})
->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
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

    return view('admin.detail_pengaduan.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'detail' => $detail, 'activeMenu' => $activeMenu,'status_pengaduan' => $status_pengaduan]);
}

public function destroy(String $id)
    {
        $check = PengaduanModel::find($id);
        if (!$check) { //untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            PengaduanModel::destroy($id); //menghapus data level

            return redirect('/dpengaduan')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            //jika terjadi error ketika menghapus data, redirect kembali ke halaman user dengan membawa pesan error
            return redirect('/dpengaduan')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini' . $e->getMessage());
        }
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
    return redirect()->back()->with('success', 'Status pengaduan berhasil diperbarui.');
}


    


}
