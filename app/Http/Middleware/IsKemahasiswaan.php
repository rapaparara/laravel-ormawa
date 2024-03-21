<?php

namespace App\Http\Middleware;

use App\Models\users_kemahasiswaan;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsKemahasiswaan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if ($request->user()->role != "kemahasiswaan") {
                if ($request->user()->role == "admin") {
                    return redirect()->route('admin.index')->with('role', 'admin');
                } else  return redirect()->route('mahasiswa.index')->with('role', 'mahasiswa');
            }
            return $next($request);
        } else return redirect()->route('login');
    }
}
