<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublikasiController extends Controller
{
    public function liputan()
    {
        return view('pemohon.publikasi.liputan');
    }

    public function promosi()
    {
        return view('pemohon.publikasi.promosi');
    }
}
