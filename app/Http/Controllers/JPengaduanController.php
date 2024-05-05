<?php

namespace App\Http\Controllers;

use App\Models\JPengaduanModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class JPengaduanController extends Controller
{
    public function index() 
    {
        // Menampilkan halaman awal 
        $breadcrumb = (object) [
            'title' => 'Daftar Jenis Pengaduan',
            'list' => ['Home', 'Jenis Pengaduan']
        ];

        $page = (object) [
            'title' => 'Daftar jenis pengaduan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'jpengaduan'; //set menu yang aktif

        return view('admin.jenis_pengaduan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    // Ambil data  dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $typeComplains = JPengaduanModel::select('id_jenis_pengaduan', 'pengaduan_kode', 'pengaduan_nama');

        return DataTables::of($typeComplains)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($typeComplain) { // menambahkan kolom aksi
                $btn = '<a href="'.url('/jpengaduan/' . $typeComplain->id_jenis_pengaduan).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/jpengaduan/' . $typeComplain->id_jenis_pengaduan . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/jpengaduan/'.$typeComplain->id_jenis_pengaduan).'">'.
                            csrf_field() . method_field('DELETE') .
                            '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    public function create() 
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Jenis Pengaduan',
            'list' => ['Home', 'Jenis Pengaduan', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Jenis Pengaduan Baru'
        ];

        $activeMenu = 'jpengaduan'; //set menu yang aktif

        return view('admin.jenis_pengaduan.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    // Menyimpan data  baru
    public function store(Request $request)
    {
        $request->validate([
            'pengaduan_kode' => 'required|string|min:3|unique:jenis_pengaduan,pengaduan_kode',
            'pengaduan_nama' => 'required|string|max:100'
        ]);

        JPengaduanModel::create([
            'pengaduan_kode' => $request->pengaduan_kode,
            'pengaduan_nama' => $request->pengaduan_nama
        ]);

        return redirect('/jpengaduan')->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $typeComplain = JPengaduanModel::find($id);
        $breadcrumb = (object) [
            'title' => 'Detail Jenis Pengaduan',
            'list' => ['Home', 'Jenis Pengaduan', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Jenis'
        ];

        $activeMenu = 'jpengaduan'; //set menu yang aktif

        return view('admin.jenis_pengaduan.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'typeComplain' => $typeComplain, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit level
    public function edit($id) 
    {
        $typeComplain = JPengaduanModel::find($id);
        $breadcrumb = (object) [
            'title' => 'Edit Jenis Pengaduan',
            'list' => ['Home', 'Jenis Pengaduan', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Pengaduan'
        ];

        $activeMenu = 'jpengaduan'; //set menu yang aktif

        return view('admin.jenis_pengaduan.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'typeComplain' =>  $typeComplain, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan data  yang telah diedit
    public function update(Request $request, $id)
    {
        $request->validate([
            'pengaduan_kode' => 'required|string|min:3|unique:jenis_pengaduan,pengaduan_kode,'.$id.',id_jenis_pengaduan',
            'pengaduan_nama' => 'required|string|max:100'
        ]);

        JPengaduanModel::find($id)->update([
            'pengaduan_kode' => $request->pengaduan_kode,
            'pengaduan_nama' => $request->pengaduan_nama
        ]);

        return redirect('/jpengaduan')->with('success', 'Data level berhasil diubah');
    }
// Menghapus data level
public function destroy($id)
{
    $check = JPengaduanModel::find($id);
    if (!$check) {
        return redirect('/jpengaduan')->with('error', 'Data level tidak ditemukan');
    }
    
    try {
        JPengaduanModel::destroy($id);

        return redirect('/jpengaduan')->with('success', 'Data level berhasil dihapus');
    } catch (\Illuminate\Database\QueryException $e) {
        return redirect('/jpengaduan')->with('error', 'Data level gagal dihapus' . $e->getMessage());
    }
}

}
