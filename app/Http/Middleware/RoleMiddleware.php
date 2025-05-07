<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('umum.dashboard')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // Jika role user tidak sesuai
        if (!in_array($user->role, $roles)) {
            $redirectRoutes = [
                'pemohon' => 'pemohon.home',
                'staff'   => 'staff.home',
                'umum'    => 'umum.home',
            ];

            $redirectRoute = $redirectRoutes[$user->role] ?? 'umum.home';

            if ($request->routeIs($redirectRoute)) {
                return $next($request);
            }

            return redirect()->route($redirectRoute)->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
