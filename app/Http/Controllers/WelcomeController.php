<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'dashboard',
            'list' => ['Home', 'Admin']
        ];
    
        $page = (object) [
            'title' => 'Dashboard admin'
        ];
        $total = UserModel::count(); // Menghitung total pengguna
    
        $activeMenu = 'dashboard';
        return view('admin.dashboard.welcome', compact('total', 'breadcrumb', 'page', 'activeMenu'));
    }
    

    public function index2()
    {
        

        return view('warga.dashboard.dashboard');
    }


}
