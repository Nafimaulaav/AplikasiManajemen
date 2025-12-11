<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EditMonitorGreenhouseController extends Controller
{
    // nampilin form edit monitor greenhouse
    public function FormEditMonitorGH($id_greenhouse)
    {
        
    }

    // update data monitor greenhouse
    public function UpdateMonitorGH(Request $request, $id_greenhouse)
    {
        $request->validate([
            'suhu_greenhouse' => 'required|numeric',
            'kelembaban_greenhouse' => 'required|numeric',
            'intensitas_cahaya_greenhouse' => 'required|numeric',
            'volume_air_greenhouse' => 'required|numeric',
        ]);

        // update data di database
        ModelGreenhouse::where('id_greenhouse', $id_greenhouse)->update([
            'suhu_greenhouse' => $request->suhu_greenhouse,
            'kelembaban_greenhouse' => $request->kelembaban_greenhouse,
            'intensitas_cahaya_greenhouse' => $request->intensitas_cahaya_greenhouse,
            'volume_air_greenhouse' => $request->volume_air_greenhouse,
        ]);

        

    }
}
