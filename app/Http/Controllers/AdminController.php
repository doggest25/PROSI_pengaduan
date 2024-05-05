<?php

namespace App\Http\Controllers;

use App\Models\PengaduanModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'W E L C O M E',
            'list' => ['Home', 'Admin']
        ];
    
        $page = (object) [
            'title' => 'Dashboard admin'
        ];
        $total = UserModel::count(); // Menghitung total pengguna
        $total2 = PengaduanModel::count(); // Menghitung total pengguna
    
        $activeMenu = 'dashboard';
        return view('admin.dashboard.welcome', compact('total','total2', 'breadcrumb', 'page', 'activeMenu'));
    }
    
    

}
