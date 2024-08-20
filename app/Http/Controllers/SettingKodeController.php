<?php

namespace App\Http\Controllers;

use App\Models\KodeKontrol;
use App\Models\Merk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingKodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kode_kontrols = KodeKontrol::with('merk')->get();
        $merks = Merk::all();
        return view('kodekontrol.index', compact('kode_kontrols', 'merks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kode_kontrols = KodeKontrol::with('merk')->get();
        $merks = Merk::all();
        return view('kodekontrol.create', compact('kode_kontrols', 'merks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'merk_id' => 'required',
            'kode' => 'required',
            'alias' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('kodekontrol.index')->withErrors($validator)->withInput();
        }

        $kode_kontrol = new KodeKontrol();
        $kode_kontrol->merk_id = $request->merk_id;
        $kode_kontrol->kode = $request->kode;
        $kode_kontrol->alias = $request->alias;
        $kode_kontrol->save();

        return redirect()->route('kodekontrol.index')->with('success', 'Kode Kontrol Berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $kode_kontrol = KodeKontrol::with('merk')->find($id);
        if (!$kode_kontrol) {
            return redirect()->route('kodekontrol.index')->with('error', 'Data tidak ditemukan');
        }

        $merks = Merk::all();
        return view('kodekontrol.edit', compact('kode_kontrol', 'merks'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'merk_id' => 'required',
            'kode' => 'required',
            'alias' => 'required',
        ]);

        if (empty($validator)) {
            return redirect()->route('kodekontrol.index')->with('error', 'Data tidak ditemukan');
        }

        $kode_kontrols = KodeKontrol::find($id);
        $kode_kontrols->update($request->all());
        return redirect()->route('kodekontrol.index')->with('success', 'Kode Kontrol Berhasil ditambahkan');
    }

    public function destroy(string $id)
    {
        $kode_kontrols = KodeKontrol::find($id);
        $kode_kontrols->delete();
        return redirect()->route('kodekontrol.index')->with('success', 'Kode Kontrol Berhasil dihapus');
    }
}
