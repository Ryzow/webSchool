<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthWaliKelas
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('wali')->check()) {
            return redirect()->route('wali.login.form')->with('error', 'Silakan login sebagai wali kelas.');
        }

        return $next($request);
    }
}
