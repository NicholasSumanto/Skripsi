<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected function handleProvidersCallback(Request $request)
    {
        return response()->json(['message' => 'Callback received successfully']);
    }
}
