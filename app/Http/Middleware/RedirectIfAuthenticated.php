<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            switch (Auth::user()->role) {
                case 'pemohon':
                    if ($request->routeIs('umum.verifikasi')) {
                        $token = $request->route('token');
                        return redirect()->route('pemohon.verifikasi', ['token' => $token]);
                    }

                    if ($request->routeIs('umum.lacak')) {
                        $kode_proses = $request->input('kode_proses');
                        return redirect()->route('pemohon.lacak', ['kode_proses' => $kode_proses]);
                    }
                    return redirect()->route('pemohon.home');
                case 'staff':
                    return redirect()->route('staff.home');
                default:
                    return redirect('/');
            }
        }

        return $next($request);
    }
}
