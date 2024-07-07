<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //LOGIN
    public function login()
    {
        return view ('login');
    }

    //LOGOUT
    public function logout()
    {
        session_start();
        // session_unset($_SESSION["id"]);
        session_destroy();
        Auth::logout();
        return redirect ('/');
    }

    //DAFTAR AKUN
    public function daftar()
    {
        return view ('daftar');
    }

    //MENYIMPAN AKUN
    public function simpan(Request $request)
    {
        User::create([
            'id_user' => 200,
            'nama' => $request->nama,
            'role' => $request->role,
            'telp' => $request->telp,
            'email' => $request->email,
            'password' => bcrypt($request->kata_sandi)
        ]);
        return redirect('/');
    }

    //AUTENTIKASI DAN AUTORISASI
    public function cekLogin(Request $request)
    {
        $login = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $pengguna = User::where('email',$request->email)->first();
        if($pengguna!=null){
            $id = $pengguna->id;
            session_start();
            $_SESSION["id"] = $id;
        }

        if(Auth::attempt($login))
        {
            if(Auth::user()->role == 'Pengguna')
            {
                return redirect('/pengguna_home');
            }
            else if(Auth::user()->role == 'Petugas')
            {
                return redirect('/petugas_home');
            }
            else if(Auth::user()->role == 'Bank')
            {
                return redirect('/bank_home');
            }
        }
        else
        {
            return redirect('/')->with('alert','Email atau Password salah!');
        }
    }
}
