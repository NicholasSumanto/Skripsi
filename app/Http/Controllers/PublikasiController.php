<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class PublikasiController extends Controller
{
    public function liputan()
    {
        $unit = Unit::with('subUnits')->get();
        $subUnit = [];
        foreach ($unit as $u) {
            foreach ($u->subUnits as $sub) {
                $subUnit[$u->id_unit][] = [
                    'id_sub_unit' => $sub->id_sub_unit,
                    'nama_sub_unit' => $sub->nama_sub_unit,
                ];
            }
        }
        $data = [
            'unit' => $unit,
            'subUnit' => $subUnit,
        ];
        return view('pemohon.publikasi.liputan', $data);
    }

    public function promosi()
    {
        return view('pemohon.publikasi.promosi');
    }
}
