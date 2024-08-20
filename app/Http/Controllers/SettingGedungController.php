<?php

namespace App\Http\Controllers;

use App\Models\Gedung;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingGedungController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gedungs = Gedung::with('perusahaan')->get();
        $perusahaans = Perusahaan::all();

        return view('settinggedung.index', compact('gedungs', 'perusahaans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gedungs = Gedung::all();
        $perusahaans = Perusahaan::all();
        return view('settinggedung.create', compact('gedungs', 'perusahaans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'perusahaan_id' => 'nullable|string',
            'gedung' => 'required|string|max:255',
            'deskripsi' => 'required',
        ]);

        if (empty($validator)) {
            return redirect()->route('settinggedung.index')->with('error', 'Gedung tidak ditemukan');
        }

        $gedungs = Gedung::create($request->all());
        return redirect()->route('settinggedung.index')->with('success', 'Gedung berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gedungs = Gedung::with('perusahaan')->find($id);
        $perusahaans = Perusahaan::all();

        return view('settinggedung.show', compact('gedungs', 'perusahaans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $gedungs = Gedung::with('perusahaan')->find($id);

        // Cek validasi
        if (empty($gedungs)) {
            return redirect()->route('settinggedung.index')->with('error', 'Gedung tidak ditemukan');
        }

        $perusahaans = Perusahaan::all();
        return view('settinggedung.edit', compact('gedungs', 'perusahaans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'perusahaan_id' => 'nullable|string',
            'gedung' => 'required|string|max:255',
            'deskripsi' => 'required',
        ]);

        if (empty($validator)) {
            return redirect()->route('settinggedung.index')->with('error', 'Gedung tidak ditemukan');
        }

        $gedungs = Gedung::find($id);
        $gedungs->update($request->all());
        return redirect()->route('settinggedung.index')->with('success', 'Gedung berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gedungs = Gedung::with('perusahaan')->find($id);
        $gedungs->delete();

        return redirect()->route('settinggedung.index')->with('success', 'Gedung berhasil dihapus');
    }
}
