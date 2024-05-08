<?php

namespace App\Http\Controllers;

use App\Models\JPengaduanModel;
use App\Models\PengaduanModel;
use App\Models\StatusPengaduanModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class WargaController extends Controller
{
    public function index(){
        return view('warga.dashboard.dashboard');
    }
    
    public function detail()
    {
        return view('warga.detail_pengaduan.index');
    }

    public function list(Request $request)
{
    $detailPengaduan = PengaduanModel::select('id_pengaduan', 'id_jenis_pengaduan', 'id_status_pengaduan', 'created_at', 'updated_at')
        ->with('users', 'jenis_pengaduan', 'status_pengaduan')
        ->where('user_id', Auth::id())
        ->get();

    if ($request->id_status_pengaduan) {
        $detailPengaduan = $detailPengaduan->where('id_status_pengaduan', $request->id_status_pengaduan);
    }

    return DataTables::of($detailPengaduan)
        ->addIndexColumn()
        ->addColumn('aksi', function ($detail) {
            $editDeleteBtns = '';
            if ($detail->status_pengaduan->status_nama !== 'Diterima' && $detail->status_pengaduan->status_nama !== 'Selesai' ) {
                $editDeleteBtns .= '<a href="' . url('/warga/' . $detail->id_pengaduan . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $editDeleteBtns .= '<form class="d-inline-block" method="POST" action="'. url('/warga/'.$detail->id_pengaduan).'">'.
                        csrf_field() . method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
            }
            $detailBtn = '<a href="' . url('/warga/' . $detail->id_pengaduan) . '" class="btn btn-info btn-sm">Detail</a> ';

            return $detailBtn . $editDeleteBtns;
        })
        ->rawColumns(['aksi'])
        ->make(true);
}



    

    public function create() 
{

    $id_jenis_pengaduan = JPengaduanModel::all(); 

    return view('warga.pengaduan.create', compact('id_jenis_pengaduan'));
}
    public function store(Request $request)
    {
       
        $request->validate([
            'id_jenis_pengaduan' => 'required',
            'deskripsi' => 'required',
            'lokasi' => 'required',
            'bukti_foto' => 'required|image|mimes:jpeg,png,jpg|max:5120', // Maksimum 5MB
        ]);

        // Simpan bukti foto ke direktori public
        $bukti_foto= $request->file('bukti_foto')->store('public/bukti_foto');




        // Buat pengaduan baru
        PengaduanModel::create([
            'user_id' => $request->user_id,
            'id_jenis_pengaduan' => $request->id_jenis_pengaduan,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'bukti_foto' => $bukti_foto,
            'id_status_pengaduan' => $request->id_status_pengaduan,
        ]);

        return redirect('/warga')->with('success', 'Pengaduan berhasil dilaporkan');
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

    

    return view('warga.detail_pengaduan.show', ['detail' => $detail,'status_pengaduan' => $status_pengaduan]);
}
    public function edit($id)
    {
        $pengaduan = PengaduanModel::find($id);
        
        return view('warga.detail_pengaduan.edit', ['pengaduan' => $pengaduan]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'deskripsi' => 'required',
            'lokasi' => 'required',
            'bukti_foto' => 'required|image|mimes:jpeg,png,jpg|max:5120', // Maksimum 5MB
        ]);
        // Simpan bukti foto ke direktori public
        $bukti_foto= $request->file('bukti_foto')->store('public/bukti_foto');

        PengaduanModel::find($id)->update([
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'bukti_foto' => $bukti_foto,
        ]);

        return redirect('/warga/detail')->with('success', 'Data berhasil diubah');
    }
    public function destroy(String $id)
    {
        $check = PengaduanModel::find($id);
        if (!$check) { //untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
            return redirect('/warga/detail')->with('error', 'Data user tidak ditemukan');
        }

        try {
            PengaduanModel::destroy($id); //menghapus data level

            return redirect('/warga/detail')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            //jika terjadi error ketika menghapus data, redirect kembali ke halaman user dengan membawa pesan error
            return redirect('/warga/detail')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini' . $e->getMessage());
        }
    }
    
    
}
