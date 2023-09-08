<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah pengguna memiliki peran "admin"
        if ($request->user() && $request->user()->hasRole('admin')) {
            return $next($request);
        }

        // Jika tidak, kembalikan ke halaman sebelumnya atau tindakan lainnya
        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengubah halaman ini.');
    }
}
