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
            'usernama' => 'required',
            'password' => 'required'
        ]);

        // cek email dan password berhasil
        if (Auth::attempt($request->only('email','password'))) {
            $request->session()->regenerate();
            return $this->redirectToDashboard();
        }
        // klo gagal
        return back()
        ->withErrors(['email'=>'Email atau Password salah'])
        ->withInput();
    }

    // buat ngarahin ke dashboard sesuai role
    public function redirectToDashboard()
    {
        $user = Auth::user();
        if ($user->role == 'admin') {
            return redirect('/admin/dashboard');
        } elseif ($user->role == 'petugas') {
            return redirect('/petugas/dashboard');
        } else {
            return redirect('/login');
        }
    }

    // buat logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('auth/login');
    }
}
