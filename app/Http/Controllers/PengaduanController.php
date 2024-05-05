<?php

namespace App\Http\Controllers;

use App\Models\JPengaduanModel;
use App\Models\PengaduanModel;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index() 
    {
    
        $jenis_pengaduan = JPengaduanModel::all();
    
        return view('warga.detail_pengaduan.index',['jenis_pengaduan' => $jenis_pengaduan]);
    }

    
    public function create() 
{

    $id_jenis_pengaduan = JPengaduanModel::all(); 

    return view('warga.pengaduan.create', compact('id_jenis_pengaduan'));
}
public function store(Request $request)
    {
       
        $request->validate([
            'user_id' => 'required',
            'id_jenis_pengaduan' => 'required',
            'deskripsi' => 'required',
            'bukti_foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Maksimum 2MB
        ]);

        // Simpan bukti foto ke storage
        $bukti_foto = $request->file('bukti_foto')->store('bukti_foto');

        // Buat pengaduan baru
        PengaduanModel::create([
            'user_id' => $request->user_id,
            'id_jenis_pengaduan' => $request->id_jenis_pengaduan,
            'deskripsi' => $request->deskripsi,
            'bukti_foto' => $bukti_foto,
            'id_status_pengaduan' => $request->id_status_pengaduan,
        ]);

        return redirect('/dashWarga')->with('success', 'Pengaduan berhasil dilaporkan');
    }


}
