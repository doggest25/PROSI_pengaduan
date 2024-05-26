<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AhpController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\DetailPengaduanController;
use App\Http\Controllers\HasilPrioritasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JPengaduanController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MABACController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PrioritasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\WelcomeController;
use App\Models\HasilPrioritas;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Monolog\Level;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


//Dashboard admin


//About us page
Route::get('/about', [AboutController::class, 'index']);
Route::get('/contact', [AboutController::class, 'contact']);

//Mengelola data user -> Admin
Route::group(['middleware' => ['auth', 'cek_login:2']], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [UserController::class, 'index']); //menampilkan halaman awal user
        Route::post('/list', [UserController::class, 'list']); //menampilkan data user dalam bentuk json untuk database
        Route::get('create', [UserController::class, 'create']); //menampilkan halaman form tambah user
        Route::post('/', [UserController::class, 'store']); //menyimpan data user baru
        Route::get('/{id}', [UserController::class, 'show']); //menampilkan detail user
        Route::get('/{id}/edit', [UserController::class, 'edit']); //menampilkan halaman form edit user
        Route::put('/{id}', [UserController::class, 'update']); //menyimpan perubahan data user
        Route::delete('/{id}', [UserController::class, 'destroy']); //menghapus data user
    });   
});


//Mengelola data jenis pengaduan -> Admin
Route::group(['middleware' => ['auth', 'cek_login:2']], function () {
    Route::group(['prefix' => 'jpengaduan'], function () {
        Route::get('/', [JPengaduanController::class, 'index']); //menampilkan halaman awal 
        Route::post('/list', [JPengaduanController::class, 'list']); //menampilkan data  dalam bentuk json untuk database
        Route::get('create', [JPengaduanController::class, 'create']); //menampilkan halaman form tambah 
        Route::post('/', [JPengaduanController::class, 'store']); //menyimpan data  baru
        Route::get('/{id}', [JPengaduanController::class, 'show']); //menampilkan detail 
        Route::get('/{id}/edit', [JPengaduanController::class, 'edit']); //menampilkan halaman form edit 
        Route::put('/{id}', [JPengaduanController::class, 'update']); //menyimpan perubahan data 
        Route::delete('/{id}', [JPengaduanController::class, 'destroy']); //menghapus data 
    });
});


//Mengelola data detail pengaduan -> Admin
Route::group(['middleware' => ['auth', 'cek_login:2']], function () {
    Route::group(['prefix' => 'dpengaduan'], function () {
        Route::get('/', [DetailPengaduanController::class, 'index']); //menampilkan halaman awal 
        Route::post('/list', [DetailPengaduanController::class, 'list']); //menampilkan data  dalam bentuk json untuk database
        Route::get('create', [DetailPengaduanController::class, 'create']); //menampilkan halaman form tambah 
        Route::post('/', [DetailPengaduanController::class, 'store']); //menyimpan data  baru
        Route::get('/{id}', [DetailPengaduanController::class, 'show']); //menampilkan detail
        Route::post('/update_status_pengaduan/{id}', [DetailPengaduanController::class, 'updateStatus'])->name('update_status_pengaduan');
        Route::put('/{id}', [DetailPengaduanController::class, 'update']); //menyimpan perubahan data 
        Route::delete('/{id}', [DetailPengaduanController::class, 'destroy']); //menghapus data 
    });  
});
Route::group(['middleware' => ['auth', 'cek_login:2']], function () {
    Route::group(['prefix' => 'pesan'], function () {
        Route::get('/', [AdminController::class, 'tampil']); //menampilkan halaman awal 
        Route::post('/list', [AdminController::class, 'list']); //menampilkan data  dalam bentuk json untuk database
        Route::get('/{id}', [AdminController::class, 'show']); //menampilkan detail
        Route::delete('/{id}', [AdminController::class, 'destroy']); //menghapus data 
    });  
});


//Dashboard warga


//Mengelola data warga ->warga
Route::group(['middleware' => ['auth', 'cek_login:1']], function () {
Route::group(['prefix' => 'warga'], function () {
    Route::get('/pengaduan', [WargaController::class, 'create']);//melakukan pengaduan
    Route::post('/save', [WargaController::class, 'store']);
    Route::get('/detail', [WargaController::class, 'detail']);
    Route::post('/list', [WargaController::class, 'list']);//history pengaduan individu
    Route::get('/{id}', [WargaController::class, 'show']); //menampilkan detailRoute::get('/pengaduan', [WargaController::class, 'create']);
    Route::get('/{id}/edit', [WargaController::class, 'edit']); //menampilkan halaman form edit 
    Route::put('/{id}', [WargaController::class, 'update']); //menyimpan perubahan data 
    Route::delete('/{id}', [WargaController::class, 'destroy']); //menghapus data 
      
});
Route::group(['prefix' => 'warga'], function () {
    Route::get('/pengaduan', [WargaController::class, 'create']);//melakukan pengaduan
    Route::post('/save', [WargaController::class, 'store']);
    Route::get('/detail', [WargaController::class, 'detail']);
    Route::post('/list', [WargaController::class, 'list']);//history pengaduan individu
    Route::get('/{id}', [WargaController::class, 'show']); //menampilkan detailRoute::get('/pengaduan', [WargaController::class, 'create']);
    Route::get('/{id}/edit', [WargaController::class, 'edit']); //menampilkan halaman form edit 
    Route::put('/{id}', [WargaController::class, 'update']); //menyimpan perubahan data 
    Route::delete('/{id}', [WargaController::class, 'destroy']); //menghapus data 
      
});
});

//halaman awal website
Route::get('/', [HomeController::class, 'index']);
// Mengirim Kririk dan saran
Route::post('/contact', [ContactFormController::class, 'store'])->name('contact.store');
//login & register website



//login user
Route::get('login',[LoginController::class, 'index'])->name('login');
Route::get('register',[LoginController::class, 'register'])->name('register');
Route::post('proses_login',[LoginController::class, 'proses_login'])->name('proses_login');
Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

Route::post('proses_register',[LoginController::class, 'proses_register'])->name('proses_register');


//masuk halaman sesuai level
Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['cek_login:1']], function(){
        Route::resource('warga', WargaController::class);
    });

    Route::group(['middleware' => ['cek_login:2']], function(){
        Route::resource('admin', AdminController::class);
    });
});






//prioritas pengaduan
Route::group(['middleware' => ['auth', 'cek_login:2']], function () {
    Route::group(['prefix' => 'prioritas'], function () {
        Route::get('/kriteria', [PrioritasController::class, 'tampilKriteria']);
        Route::post('/list', [PrioritasController::class, 'listKriteria']);
        Route::get('/perhitungan', [PrioritasController::class, 'calculate']); // Letakkan ini sebelum rute dengan parameter dinamis
        Route::get('/pengaduanDiterima', [PrioritasController::class, 'tampilDiterima']);
        Route::post('/listDiterima', [PrioritasController::class, 'listDiterima']);
       

        Route::get('/{id}', [PrioritasController::class, 'showFormNilai']);
        Route::post('/simpan/{id}', [PrioritasController::class, 'simpanNilai']);
    });
});


Route::get('/users', [LevelController::class, 'index']);


//hasil prioritas
Route::group(['middleware' => ['auth', 'cek_login:2']], function () {
    Route::group(['prefix' => 'hasil'], function () {
        Route::get('/accepted', [PrioritasController::class, 'index']);
        Route::post('/list', [PrioritasController::class, 'listAcceptedPengaduan']);
        Route::get('/detail/{id}', [PrioritasController::class, 'showPengaduan']);
        Route::get('/{id}', [PrioritasController::class, 'show']);
        Route::post('/update_status_pengaduan/{id}', [PrioritasController::class, 'updateStatus'])->name('update_status_pengaduan2');

    });
});


