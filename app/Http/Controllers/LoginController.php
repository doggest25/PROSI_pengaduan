<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index(){
        //kita ambil data user lalu simpan pada variabel $user
        $user =Auth::user();
        //kondisi jika user nya ada
        if($user){
          
            if($user->level_id == '1') {

                return redirect()->intended('warga');
            }
           
            else if($user->level_id == '2'){
                return redirect()->intended('admin');
            }
        }
        
        return view('login.login',);
    }
    public function proses_login(Request $request){

        //kita buat validasi pada saat tombol login di klik
        //validasi nya username & password wajib diisi
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        //ambil data request username & password saja
        $credential = $request->only('username', 'password');
        //cek jika data username dan password valid (sesuai) dengan data
        if(Auth::attempt($credential)) {
            //kalau berhasil simpan data user yg di variabel $user

            $user =Auth::user();
            
            //cek lagi jika level user admin maka arahkan ke halaman warga
            if($user->level_id == '1'){
                //dd($user->level_id)
                return redirect()->intended('warga');
            }
            //tapi jika level usernya biasa maka arahkan ke halaman admin
            elseif ($user->level_id == '2'){
                return redirect()->intended('admin');
            }
            //jika belum ada role maka kehalaman /
            return redirect()->intended('/');
        }
        //jika ga ada data user yang valid maka kembalikan lagi ke halaman login
        //pastikan kirim pesan erro juga kalau login gagal ya
        return redirect('login')
        ->withInput()
        ->withErrors(['login_gagal' => 'Pastikan kembali username dan password yang dimasukan sudah benar']);
    }
    public function register(){
        //tampilkan view register
        return view('login.register');
    }

    public function proses_register(Request $request){

      
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|min:3|unique:v_user,username',
            'nama' => 'required|string|max:100',
            'password' => 'required|min:5',
            'alamat' => 'required',
            'ktp' => 'required|integer|min:1000000000000000|max:9999999999999999',
        ], [
            'username.required' => 'Username harus diisi.',
            'username.string' => 'Username harus berupa string.',
            'username.min' => 'Username minimal terdiri dari :min karakter.',
            'username.unique' => 'Username sudah digunakan.',
            'nama.required' => 'Nama harus diisi.',
            'nama.string' => 'Nama harus berupa string.',
            'nama.max' => 'Nama maksimal terdiri dari :max karakter.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal terdiri dari :min karakter.',
            'alamat.required' => 'Alamat harus diisi.',
            'ktp.required' => 'Nomor KTP harus diisi.',
            'ktp.integer' => 'Nomor KTP harus berupa angka.',
            'ktp.min' => 'Nomor KTP minimal terdiri dari 16 angka.',
            'ktp.max' => 'Nomor KTP maksimal terdiri dari 16 angka.',
        ]);
        
       
        

        //kalau gagal kembali ke halaman register dengan munculnya pesan error
        if($validator->fails()) {
            return redirect('/register')
            ->withErrors($validator)
            ->withInput();
        }
        // kalau berhasil isi level & hash passwordnya ya biar secure
        $request['level_id'] = '1';
        $request['password'] = Hash::make($request->password);

        //masukan semua data pada request ke table user
        UserModel::create($request->all());

        //kalo berhasil arahkan ke halaman login
        return redirect()->route('login')->with('success', 'Akun berhasil berhasil dibuat');
    }

    public function logout(Request $request){

        //logout itu harus menghapus sessionnya
        $request->session()->flush();

        //jalan kan juga fungsi logout pada auth
        Auth::logout();
        //kembali kan ke halaman login
        return redirect('login');
    }
}
