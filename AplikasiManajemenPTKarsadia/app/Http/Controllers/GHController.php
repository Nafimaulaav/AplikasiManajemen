<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelGreenhouse;

class GHController extends Controller
{
    // buat nampilin halaman greenhouse
    public function index()
    {
        $greenhouses = ModelGreenhouse::all();
        return view('greenhouse.index', compact('greenhouses'));
    }

    // buat form tambah greenhouse
    public function create()
    {
        // generate id
        $last = ModelGreenhouse::orderBy('id_greenhouse', 'desc')->first();
        if($last){
            $num = intval(substr($last->id_greenhouse, 2)) + 1;
            $newid = 'GH' . str_pad($num, 4, '0', STR_PAD_LEFT);
        } else {
            $newid = 'GH0001';
        }
        return view('greenhouse.create', compact('newid'));
    }

    // buat nyimpen greenhouse baru di form tambah
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_greenhouse' => 'required|string|max:10',
            'nama_greenhouse' => 'required|string|max:100',
            'alamat_greenhouse' => 'required|string|max:255',
            'gambar_greenhouse' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'status_greenhouse' => 'required|in:Aktif,Tidak Aktif,Perbaikan',
        ]);

        $greenhouse = ModelGreenhouse::create([
            'id_greenhouse' => $validated['id_greenhouse'],
            'nama_greenhouse' => $validated['nama_greenhouse'],
            'alamat_greenhouse' => $validated['alamat_greenhouse'],
            'status_greenhouse' => $validated['status_greenhouse'],
        ]);

        if ($request->hasFile('gambar_greenhouse')) {
            $imagePath = $request->file('gambar_greenhouse')->store('greenhouse_images', 'public');
            $greenhouse->gambar_greenhouse = $imagePath;
            $greenhouse->save();
        }

        return redirect()
            ->route('greenhouse.index')
            ->with('success', 'Greenhouse berhasil ditambahkan');
    }

    //form updete list greenhouse
    public function FromUpdateGreenhouse($id_greenhouse)
    {
        $greenhouse = ModelGreenhouse::findOrFail($id_greenhouse);
        return view('greenhouse.edit', compact('greenhouse'));
    }

    //update greenhouse
    public function UpdateGreenhouse(Request $request, $id_greenhouse){
        $greenhouse = ModelGreenhouse::findOrFail($id_greenhouse);

        $validated = $request->validate([
            'nama_greenhouse' => 'required|string|max:100',
            'alamat_greenhouse' => 'required|string|max:255',
            'status_greenhouse' => 'required|in:Aktif,Tidak Aktif,Perbaikan',
        ]);

        $greenhouse->update($validated);
        return redirect()->route('greenhouse.index')->with('success', 'Greenhouse berhasil diperbarui');
    }


    // buat nampilin detail greenhouse
    public function show($id_greenhouse)
    {
        $greenhouse = ModelGreenhouse::with('LogQC')
            ->where('id_greenhouse', $id_greenhouse)
            ->firstOrFail();
        return view('greenhouse.show', compact('greenhouse'));
    }

    // buat update monitoring GH
    public function updateMonitoring(Request $request, $id_greenhouse)
    {
        $greenhouse = ModelGreenhouse::findOrFail($id_greenhouse);

        $validated = $request->validate([
            'suhu_greenhouse' => 'required|numeric',
            'kelembaban_greenhouse' => 'required|numeric',
            'intensitas_cahaya_greenhouse' => 'required|numeric',
            'volume_air_greenhouse' => 'required|numeric',
        ]);

        $greenhouse->update($validated);

        return redirect()
            ->route('greenhouse.show', $id_greenhouse)
            ->with('success', 'Monitoring greenhouse berhasil diperbarui');
    }

    // buat update spek GH
    public function updateSpecs(Request $request, $id_greenhouse)
    {
        $greenhouse = ModelGreenhouse::findOrFail($id_greenhouse);

        $validated = $request->validate([
            'luas_greenhouse' => 'required|numeric',
            'tinggi_greenhouse' => 'required|numeric',
            'sistem_dipakai_greenhouse' => 'required|string|max:100',
        ]);

        $greenhouse->update($validated);

        return redirect()
            ->route('greenhouse.show', $id_greenhouse)
            ->with('success', 'Spesifikasi greenhouse berhasil diperbarui');
    }
}
