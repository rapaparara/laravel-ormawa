<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsMahasiswa
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if ($request->user()->role != "mahasiswa") {
                if ($request->user()->role == "kemahasiswaan") {
                    return redirect()->route('kemahasiswaan.index')->with('role', 'kemahasiswaan');
                } else  return redirect()->route('admin.index')->with('role', 'admin');
            }
            return $next($request);
        } else return redirect()->route('login');
        return $next($request);
    }
}
