<?php

namespace App\Http\Controllers;

use App\Models\Merk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingMerkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $merks = Merk::all();
        return view('merk.index', compact('merks'));
    }

    public function create()
    {
        $merks = Merk::all();
        return view('merk.create', compact('merks'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_merk' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
        ]);

        if (empty($validator)) {
            return redirect()->route('merk.index')->with('error', 'Merk tidak ditemukan');
        }

        $merks = Merk::create($request->all());
        return redirect()->route('merk.index');
    }


    public function edit(string $id)
    {
        $merks = Merk::find($id);
        return view('merk.edit', compact('merks'));
    }


    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_merk' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('merk.index')->withErrors($validator)->withInput();
        }

        $merks = Merk::find($id);
        $merks->update($request->all());
        return redirect()->route('merk.index');
    }

    public function destroy(string $id)
    {
        $merks = Merk::find($id);
        $merks->delete();
        return redirect()->route('merk.index');
    }
}
