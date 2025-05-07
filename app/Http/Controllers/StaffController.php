<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function home()
    {
        return view('staff.home');
    }
}
