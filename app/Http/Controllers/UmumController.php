<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UmumController extends Controller
{
    public function homepage()
    {
        return view('umum.home');
    }
}
