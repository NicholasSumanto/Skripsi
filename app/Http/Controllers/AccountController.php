<?php

namespace App\Http\Controllers;

use Http;
use Illuminate\Http\Request;

class AccountController extends Controller
{

    public function googleLogin(Request $request)
    {
        $credential = $request->input('credential');

        $response = Http::get('https://oauth2.googleapis.com/tokeninfo', [
            'id_token' => $credential,
        ]);

        if ($response->ok()) {
            $data = $response->json();

            // Cek domainnya ukdw.ac.id
            if (isset($data['hd']) && $data['hd'] === 'students.ukdw.ac.id') {
                return response()->json([
                    'name' => $data['name'],
                    'email' => $data['email'],
                ]);
            } else {
                return response()->json(['error' => 'Unauthorized domain'], 401);
            }
        } else {
            return response()->json(['error' => 'Invalid token'], 400);
        }
    }
}
