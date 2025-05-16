<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAuthencicated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($request->routeIs('pemohon.verifikasi')) {
                $token = $request->route('token');
                return redirect()->route('umum.verifikasi', ['token' => $token]);
            }

            if ($request->routeIs('pemohon.lacak')) {
                $kode_proses = $request->input('kode_proses');
                return redirect()->route('umum.lacak', ['kode_proses' => $kode_proses]);
            }
        }
        return $next($request);
    }
}
