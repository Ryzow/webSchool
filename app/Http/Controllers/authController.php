<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class authController extends Controller
{
    public function index_login()
    {
        return view('auth.login');
    }
    public function store_login(Request $request)
    {
        $request->validate([
            
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8',
        ],[
            
            
           
            'email.required' => 'Data wajib diisi',
            'email.email' => 'gunakan format akhir @gmail.com',
            'exists' => 'Maaf email belum terdaftar',
            

            'password.required' => 'Data wajib diisi',
            'password.min' => 'Password Minimal 8 Karakter',
           
        
        ]);
        $infoLogin = [
            'email'=> $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($infoLogin)) {
        // ✅ Cek role
        if (Auth::user()->role === 'admin') {
            return redirect('/dashboard'); // langsung ke dashboard admin
        }

        return redirect('/'); // user biasa ke home
    } else {
        return redirect()->back()->withErrors([
            'password' => 'Password is Invalid'
        ]);
    }
    }



    public function index_register()
    {
        return view('auth.register');
    }

    public function store_register(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ],[
            'name.required' => 'Form wajib diisi',
            'name.min' => 'Nama Anda minimal 3 Karakter Huruf',
           
            'email.required' => 'Form wajib diisi',
            'email.email' => 'isi dengan format @gmail.com',
            'email.unique' => 'Maaf, Email ini sudah terdaftar',

            'password.required' => 'Form wajib diisi',
            'password.min' => 'Password Minimal 8 Karakter',
            'password.confirmed' => 'Maaf, konfirmasi password tidak sesuai'
        
        ]);
        
        $register = new User();
        $register->name = $request->name;
        $register->email = $request->email;
        $register->password = Hash::make($request->password);
        $register->role = 'user';

        $register->save();
       
        Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);
        
        return redirect('/');
    
    }

    public function _logout()
    {
        Auth::logout();
        return redirect('/');
    }

    
}
