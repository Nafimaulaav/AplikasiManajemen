<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();

        //kalau belum login
        if (!$user){
            return redirect()->route('login')->with('error', 'Silahkan login terlebih dahulu');
        }

        //mengecek role
        if (!in_array($user->role, $roles)){
            return redirect('login')->with('error','Anda tidak memiliki akses kehalaman ini');
        }

        return $next($request);
    }
}
