<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role === 'admin') {
                return redirect()->route('admin.index')->with('role', 'admin');
            } elseif ($role === 'kemahasiswaan') {
                return redirect()->route('kemahasiswaan.index')->with('role', 'kemahasiswaan');
            } elseif ($role === 'mahasiswa') {
                return redirect()->route('mahasiswa.index')->with('role', 'mahasiswa');
            }
        }
        return $next($request);
    }
}
