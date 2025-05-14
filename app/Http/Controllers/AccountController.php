<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    public function callback(Request $request)
    {
        $accessToken = $request->credential;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->get('https://www.googleapis.com/oauth2/v3/userinfo');

        if ($response->ok()) {
            $data = $response->json();

            if ((isset($data['hd']) && str_ends_with($data['hd'], '.ukdw.ac.id')) || $data['email'] === 'nicholas.smt234@gmail.com') {
                // Cek user
                $user = Pengguna::where('google_id', $data['sub'])->orWhere('email', $data['email'])->first();

                // Cek Domain Workspace UKDW
                $hasUkdwDomain = isset($data['hd']) && str_ends_with($data['hd'], '.ukdw.ac.id');
                $isPemohon = $hasUkdwDomain;

                // Cek Staff
                $isStaff = in_array($data['email'], ['nicholas.smt234@gmail.com']);

                if (!$user) {
                    if ($isStaff) {
                        // Buat staff baru
                        $user = Pengguna::create([
                            'google_id' => $data['sub'],
                            'email' => $data['email'],
                            'name' => $data['name'],
                            'avatar' => $data['picture'] ?? null,
                            'email_verified_at' => now(),
                            'role' => 'staff',
                            'token' => $accessToken,
                        ]);
                    }

                    else if ($isPemohon) {
                        // Buat user baru
                        $user = Pengguna::create([
                            'google_id' => $data['sub'],
                            'email' => $data['email'],
                            'name' => $data['name'],
                            'avatar' => $data['picture'] ?? null,
                            'email_verified_at' => now(),
                            'role' => 'pemohon',
                            'token' => $accessToken,
                        ]);
                    }
                }

                if ($user) {
                    try {
                        Auth::login($user, true);

                        $redirect = $user->role === 'pemohon' ? route('pemohon.home') : route('staff.home');

                        return response()->json([
                            'name' => $user->name,
                            'email' => $user->email,
                            'redirect_to' => $redirect,
                        ]);
                    } catch (\Exception $e) {
                        return response()->json(['error' => 'Gagal login: ' . $e->getMessage()], 500);
                    }
                } else {
                    return response()->json(['error' => 'Gagal membuat pengguna.'], 500);
                }
            } else {
                return response()->json(['error' => 'Domain email harus students.ukdw.ac.id'], 401);
            }
        } else {
            return response()->json(['error' => 'Token tidak valid.'], 400);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Anda telah berhasil logout',
            'redirect_to' => route('umum.home'),
        ]);
    }
}
