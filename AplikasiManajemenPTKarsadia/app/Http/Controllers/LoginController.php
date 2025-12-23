<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // nampilin form login
    public function loginForm()
    {
        return view('auth.login');
    }

    // proses login
    public function loginProcess(Request $request)
    {
        // validasi input 
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ],
        [
            'username.reqired' => 'Username harus diisi',
            'password.reqired' => 'Password harus diisi'
        ]
        
    
    
    );

        // cek email dan password berhasil
        if (Auth::attempt($request->only('username','password'))) {
            $request->session()->regenerate();
            return $this->redirectToDashboard();
        }
        // klo gagal
        return back()
        ->withErrors(['username'=>'Username atau Password salah'])
        ->withInput();
    }

    // buat ngarahin ke dashboard sesuai role
    public function redirectToDashboard()
    {
        $user = Auth::user();
        if ($user->role == 'admin') {
            return redirect('/dashboard');
        } elseif ($user->role == 'petugas') {
            return redirect('/dashboard');
        } else {
            return redirect('/login');
        }
    }

    public function profile(){
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    // buat logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
