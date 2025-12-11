<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EditSpesifikasiGreenhouseController extends Controller
{
    // buat nampilin form edit spesifikasi greenhouse
    public function FormEditSpesifikasiGH($id_greenhouse)
    {

    }

    // update data spesifikasi greenhouse
    public function UpdateSpesifikasiGH(Request $request, $id_greenhouse)
    {
        $request->validate([
            'luas_greenhouse' => 'required|numeric',
            'tinggi_greenhouse' => 'required|numeric',
            'sistem_dipakai_greenhouse' => 'required|string|max:50',
        ]);

        // update data di database
        ModelGreenhouse::where('id_greenhouse', $id_greenhouse)->update([
            'luas_greenhouse' => $request->luas_greenhouse,
            'tinggi_greenhouse' => $request->tinggi_greenhouse,
            'sistem_dipakai_greenhouse' => $request->sistem_dipakai_greenhouse,
        ]);

        // balik ke halaman detail greenhouse dengan pesan sukses
        
    }
}
