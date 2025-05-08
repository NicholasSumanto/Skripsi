<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UmumController extends Controller
{
    public function home()
    {
        return view('umum.home'); 
    }

    public function unduhan()
    {
        return view('umum.unduhan');
    }
}
