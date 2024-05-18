<?php

namespace App\Http\Controllers;

use App\Charts\MonthlyUsersChart;
use App\Models\PengaduanModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

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
    
    

}
