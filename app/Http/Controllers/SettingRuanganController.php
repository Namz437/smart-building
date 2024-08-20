<?php

namespace App\Http\Controllers;

use App\Models\Lantai;
use App\Models\Perusahaan;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingRuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ruangans = Ruangan::with('perusahaan', 'lantai')->get();
        $perusahaans = Perusahaan::all();
        $lantais = Lantai::all();

        return view('settingruangan.index', compact('ruangans', 'perusahaans', 'lantais'));
    }

    public function create()
    {
        $ruangans = Ruangan::with('perusahaan', 'lantai')->get();
        $perusahaans = Perusahaan::all();
        $lantais = Lantai::all();
        return view('settingruangan.create', [
            'ruangans' => $ruangans,
            'perusahaans' => $perusahaans,
            'lantais' => $lantais
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'perusahaan_id' => 'nullable|string',
            'lantai_id' => 'nullable|string',
            'nama_ruangan' => 'required|string|max:255',
            'deskripsi' => 'required',
            'ukuran' => 'required',
        ]);

        if (empty($validator)) {
            return redirect()->route('settingruangan.index')->with('error', 'Ruangan tidak ditemukan');
        }

        $ruangans = Ruangan::create($request->all());
        return redirect()->route('settingruangan.index')->with('success', 'Ruangan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $ruangans = Ruangan::with(['perusahaan', 'lantai'])->find($id);

        // Cek validasi
        if (empty($ruangans)) {
            return redirect()->route('settingruangan.index')->with('error', 'Ruangan tidak ditemukan');
        }

        $perusahaans = Perusahaan::all();
        $lantais = Lantai::all();

        return view('settingruangan.edit', compact('ruangans', 'perusahaans', 'lantais'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'perusahaan_id' => 'nullable|string',
            'lantai_id' => 'nullable|string',
            'nama_ruangan' => 'required|string|max:255',
            'deskripsi' => 'required',
            'ukuran' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('settingruangan.index')->withErrors($validator)->withInput();
        }

        $ruangan = Ruangan::find($id);
        if (!$ruangan) {
            return redirect()->route('settingruangan.index')->with('error', 'Ruangan tidak ditemukan');
        }

        $ruangan->update($request->all());
        return redirect()->route('settingruangan.index')->with('success', 'Ruangan berhasil diupdate');
    }

    public function show($id)
    {
        $ruangans = Ruangan::with(['perusahaan', 'lantai'])->find($id);
        return view('settingruangan.show', compact('ruangans', 'perusahaans', 'lantais'));
    }


    public function destroy($id)
    {
        $ruangans = Ruangan::find($id);
        if (!$ruangans) {
            return redirect()->route('settingruangan.index')->with('error', 'Ruangan tidak ditemukan');
        }
        $ruangans->delete();
        return redirect()->route('settingruangan.index')->with('success', 'Ruangan berhasil dihapus');
    }
}
