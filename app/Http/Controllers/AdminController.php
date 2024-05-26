<?php

namespace App\Http\Controllers;

use App\Charts\MonthlyUsersChart;
use App\Models\ContactForm;
use App\Models\PengaduanModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function index(MonthlyUsersChart $chart){
        $breadcrumb = (object) [
            'title' => '',
            'list' => ['Home', 'Dashboard']
        ];
    
        $page = (object) [
            'title' => 'Dashboard admin'
        ];
        $total = UserModel::where('level_id', 1)->count(); // Menghitung total pengguna
        $total2 = PengaduanModel::count(); // Menghitung total pengguna
        $diproses = PengaduanModel::where('id_status_pengaduan', 1)->count();
        $diterima = PengaduanModel::where('id_status_pengaduan', 2)->count();
        $ditolak = PengaduanModel::where('id_status_pengaduan', 3)->count();
        $selesai = PengaduanModel::where('id_status_pengaduan', 4)->count();
        $lastComplaint = PengaduanModel::orderBy('created_at', 'desc')->first();
        $lastRegister = UserModel::orderBy('created_at', 'desc')->first();



    
        $activeMenu = 'dashboard';
        return view('admin.dashboard.welcome', ['chart' => $chart->build(),'lastComplaint' => $lastComplaint,'lastRegister' => $lastRegister,'total' => $total,'total2'=> $total2,'diproses' => $diproses,'diterima' => $diterima,'ditolak' => $ditolak,'selesai' => $selesai, 'breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function tampil() 
    {
        // Menampilkan halaman awal 
        $breadcrumb = (object) [
            'title' => 'Daftar Kritik & Saran',
            'list' => ['Home', 'Kritik & Saran']
        ];

        $page = (object) [
            'title' => 'Daftar jenis pengaduan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'pesan'; //set menu yang aktif

        return view('admin.pesan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    // Ambil data  dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $pesan = ContactForm::select('id_pesan', 'name', 'email', 'message', 'is_read');

    return DataTables::of($pesan)
        ->addColumn('aksi', function ($row) {
            $btn = '<a href="'.url('/pesan/' . $row->id_pesan).'" class="btn btn-info btn-sm">Detail</a> ';
            $btn .= '<form class="d-inline-block" method="POST" action="'. url('/pesan/'.$row->id_pesan).'">'.
                        csrf_field() . method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
            return $btn;
        })
        ->editColumn('is_read', function ($row) {
            return $row->is_read ? 'Sudah dilihat' : 'Belum dilihat';
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }
    public function show($id)
    {
        $pesan = ContactForm::find($id);
        if (!$pesan) {
            return redirect()->back()->with('error', 'Pesan tidak ditemukan.');
        }
    
        // Tandai pesan sebagai telah dilihat
        $pesan->is_read = true;
        $pesan->save();
        $breadcrumb = (object) [
            'title' => 'Detail Kritik & Saran',
            'list' => ['Home', 'Kritik & Saran']
        ];

        $page = (object) [
            'title' => 'Detail Kritik & Saran'
        ];

        $activeMenu = 'pesan'; //set menu yang aktif

        return view('admin.pesan.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'pesan' => $pesan, 'activeMenu' => $activeMenu]);
    }
    public function destroy($id)
{
    $check = ContactForm::find($id);
    if (!$check) {
        return redirect('/pesan')->with('error', 'Data  tidak ditemukan');
    }
    
    try {
        ContactForm::destroy($id);

        return redirect('/pesan')->with('success', 'Data  berhasil dihapus');
    } catch (\Illuminate\Database\QueryException $e) {
        return redirect('/pesan')->with('error', 'Data  gagal dihapus' . $e->getMessage());
    }
}
}
