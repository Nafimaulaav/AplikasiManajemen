<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelGreenhouse;

class TambahGreenhouseController extends Controller
{
    // tampilkan form
    public function FormCreateGH()
    {
        return view('tambah_greenhouse');
    }

    // simpan data greenhouse baru
    public function StoreGH(Request $request)
    {
        // validasi
        $validated = $request->validate([
            'nama_greenhouse' => 'required|string|max:50',
            'alamat_greenhouse' => 'required|string|max:100',
            'gambar_greenhouse' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // buat record baru
        $greenhouse = ModelGreenhouse::create([
            'nama_greenhouse' => $validated['nama_greenhouse'],
            'alamat_greenhouse' => $validated['alamat_greenhouse'],
        ]);

        // upload gambar
        if ($request->hasFile('gambar_greenhouse')) {
            $path = $request->file('gambar_greenhouse')->store('greenhouse', 'public');
            $greenhouse->update(['gambar_greenhouse' => $path]);
        }

        return redirect()->route('daftar_greenhouse')->with('success', 'Greenhouse berhasil ditambahkan!');
    }
}
