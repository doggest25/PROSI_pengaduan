<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index() 
    {
        // Menampilkan halaman awal user
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar User yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user'; //set menu yang aktif

        $level = LevelModel::all(); //ambil data level untuk filter level

        return view('admin.user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }
    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
                ->with('level');

        // Filter data user berdasarkan level_id
        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($user) { // menambahkan kolom aksi
                $btn = '<a href="'.url('/user/' . $user->user_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/user/' . $user->user_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/user/'.$user->user_id).'">'.
                            csrf_field() . method_field('DELETE') .
                            '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create() 
{
    $breadcrumb = (object) [
        'title' => 'Tambah User',
        'list' => ['Home', 'User', 'Tambah']
    ];

    $page = (object) [
        'title' => 'Tambah User Baru'
    ];

    // Mengambil data level dari tabel v_level
    $level = LevelModel::all(); 

    $activeMenu = 'user'; //set menu yang aktif

    return view('admin.user.create', compact('breadcrumb', 'page', 'level', 'activeMenu'));
}


//Menyimpan data user baru
public function store(Request $request)
{
    $request->validate([    
    //Username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik didalam tabel m_user kolom username
        'username' => 'required|string|min:3|unique:v_user,username',
        'nama' => 'required|string|max:100', //nama harus diisi, berupa string, dan maksimal 100 karakter
        'password' => 'required|min:5', //password harus diisi dan minimal 5 karakter
        'level_id' => 'required|integer', //level_id harus diisi dan berupa angka
        'ktp' => 'required|integer|min:16',

    ]);

    UserModel::create([
        'level_id' => $request->level_id,
        'username' => $request->username,
        'nama' => $request->nama,
        'password' => bcrypt($request->password), //password dienkripsi sebelum disimpan
        'ktp' => $request->ktp,
        'alamat' => $request->alamat,
        'telepon' => $request->telepon
    ]);

    return redirect('/user')->with('success', 'Data user berhasil disimpan');
}
public function show($id)
{
    $user = UserModel::find($id);
    $breadcrumb = (object) [
        'title' => 'Detail User',
        'list' => ['Home', 'User', 'Detail']
    ];

    $page = (object) [
        'title' => 'Detail User'
    ];

    $activeMenu = 'user'; //set menu yang aktif

    return view('admin.user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
}
public function edit($id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all(); //ambil data level untuk ditampilkan di form

        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit User'
        ];

        $activeMenu = 'user'; //set menu yang aktif

        return view('admin.user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    //Menyimpan data user yang telah diedit
    public function update(Request $request, $id)
    {
        $request->validate([
            //Username harus diisi, berupa string, minimal 3 karakter, 
            //dan bernilai unik didalam tabel m_user kolom username kecuali untuk user dengan id yang sedang diedit
            'username' => 'required|string|min:3|unique:v_user,username,'.$id.',user_id',
            'nama' => 'required|string|max:100', //nama harus diisi, berupa string, dan maks 100 karakter
            'password' => 'nullable|min:5', //password bisa diisi min 5 karakter dan bisa tidak diisi
            'level_id' => 'required|integer', //level_id harus diisi dan berupa angka
            'ktp' => 'required|integer|min:16'
        ]);

        UserModel::find($id)->update([
            'level_id' => $request->level_id,
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password, //password dienkripsi jika diisi, jika tidak diisi maka password tetap
            'ktp' => $request->ktp,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon
        ]);

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }
    public function destroy(String $id)
    {
        $check = UserModel::find($id);
        if (!$check) { //untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            UserModel::destroy($id); //menghapus data level

            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            //jika terjadi error ketika menghapus data, redirect kembali ke halaman user dengan membawa pesan error
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini' . $e->getMessage());
        }
    }

}
