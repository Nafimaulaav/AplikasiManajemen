<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelGreenhouse;
use App\Helpers\RiwayatHelper;

class GHController extends Controller
{
    // buat nampilin halaman greenhouse
    public function index()
    {
        $greenhouses = ModelGreenhouse::all();

        // generate id baru
        $last = ModelGreenhouse::orderBy('id_greenhouse', 'desc')->first();
        if ($last) {
            $num = intval(substr($last->id_greenhouse, 2)) + 1;
            $newid = 'GH' . str_pad($num, 4, '0', STR_PAD_LEFT);
        } else {
            $newid = 'GH0001';
        }

        return view('greenhouse.index', compact('greenhouses', 'newid'));
    }

    
    // buat nyimpen greenhouse baru di form tambah
    public function StoreGreenhouse(Request $request)
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
            $file = $request->file('gambar_greenhouse');
            $filename = time() . '_' . $file->getClientOriginalName();
            // simpan ke storage/public/greenhouse_images
            $path = $file->storeAs('greenhouse_images', $filename, 'public');
            // nyimpen path ke database
            $greenhouse->gambar_greenhouse = 'storage/' . $path;
            $greenhouse->save();
        }

        // buat record tambah ke riwayat
        RiwayatHelper::catat(
            'Tambah',
            'Greenhouse',
            'Menambahkan greenhouse baru: ' . $greenhouse->nama_greenhouse
        );

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
            'gambar_greenhouse' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        if($request->hasFile('gambar_greenhouse')){
            $file = $request->file('gambar_greenhouse');
            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('images'), $filename);

           $validated['gambar_greenhouse'] = 'images/' . $filename;
        }

        $greenhouse->update($validated);
        return redirect()->route('greenhouse.index')->with('success', 'Greenhouse berhasil diperbarui');
    }


    // buat nampilin detail greenhouse
public function DetailGreenhouse($id_greenhouse)
    {
        $greenhouse = ModelGreenhouse::with(['LogQC' => function ($query) {
            $query->orderBy('tanggal_qc', 'desc'); // atau 'created_at' kalau kamu mau urut berdasarkan waktu input
        }])->findOrFail($id_greenhouse);

        return view('greenhouse.detailgh', compact('greenhouse'));
    }

    // buat form update monitoring GH
    public function FormUpdateMonitoring($id_greenhouse)
    {
        $greenhouse = ModelGreenhouse::findOrFail($id_greenhouse);
        return view('greenhouse.detailgh', compact('greenhouse'));
    }

    // buat update monitoring GH
    public function updateMonitoring(Request $request, $id_greenhouse)
    {
        $greenhouse = ModelGreenhouse::findOrFail($id_greenhouse);

        $validated = $request->validate([
            'waktu_monitoring' => 'required|date',
            'suhu_greenhouse' => 'required|numeric',
            'kelembaban_greenhouse' => 'required|numeric',
            'intensitas_cahaya_greenhouse' => 'required|numeric',
            'volume_air_greenhouse' => 'required|numeric',
        ]);

        $greenhouse->update($validated);

        return redirect()
            ->route('detail_greenhouse', $id_greenhouse)
            ->with('success', 'Monitoring greenhouse berhasil diperbarui');
    }


    // buat form update spek GH
    public function FormUpdateSpesifikasi($id_greenhouse)
    {
        $greenhouse = ModelGreenhouse::findOrFail($id_greenhouse);
        return view('update_spesifikasi', compact('greenhouse'));
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
            ->route('detail_greenhouse', $id_greenhouse)
            ->with('success', 'Spesifikasi greenhouse berhasil diperbarui');
    }

    public function DestroyGreenhouse($id_greenhouse){
        $greenhouse = ModelGreenhouse::findOrFail($id_greenhouse);
        $greenhouse->delete();
        return redirect()
        ->route('greenhouse.index')
        ->with('success', 'Greenhouse Berhasil Dihapus');
    }

}
