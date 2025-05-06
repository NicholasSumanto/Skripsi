<?php

namespace App\Http\Controllers;

use Http;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function googleLogin(Request $request)
    {
        $credential = $request->input('credential');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $credential,
        ])->get('https://www.googleapis.com/oauth2/v3/userinfo');

        if ($response->ok()) {
            $data = $response->json();

            if (isset($data['hd']) && $data['hd'] === 'students.ukdw.ac.id') {
                return response()->json([
                    'name' => $data['name'],
                    'email' => $data['email'],
                ]);
            } else {
                return response()->json(['error' => 'Domain email harus ukdw.ac.id'], 401);
            }
        } else {
            return response()->json(['error' => 'Invalid token'], 400);
        }
    }
}
