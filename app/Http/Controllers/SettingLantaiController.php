<?php

namespace App\Http\Controllers;

use App\Models\Gedung;
use App\Models\Lantai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingLantaiController extends Controller
{
    public function index()
    {
        $lantais = Lantai::all();
        $gedungs = Gedung::all();

        return view('settinglantai.index', compact('lantais', 'gedungs'));
    }
    public function create()
    {
        $lantais = Lantai::all();
        $gedungs = Gedung::all();

        return view('settinglantai.create', compact('lantais', 'gedungs'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gedung_id' => 'required|string',
            'lantai' => 'required|string|max:255',
            'deskripsi' => 'required',
        ]);

        if (empty($validator)) {
            return redirect()->route('settinglantai.index')->with('error', 'Lantai tidak ditemukan');
        }

        $lantais = Lantai::create($request->all());
        return redirect()->route('settinglantai.index')->with('success', 'Lantai berhasil ditambahkan');
    }


    public function show($id)
    {
        $lantais = Lantai::with('gedung')->find($id);
        $gedungs = Gedung::all();

        return view('settinglantai.show', compact('lantais', 'gedungs'));
    }

    public function edit($id)
    {
        $lantais = Lantai::with('gedung')->find($id);
        $gedungs = Gedung::all();

        return view('settinglantai.edit', compact('lantais', 'gedungs'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'gedung_id' => 'required',
            'lantai' => 'required|string|max:255',
            'deskripsi' => 'required',
        ]);

        if (empty($validator)) {
            return redirect()->route('settinglantai.index')->with('error', 'Lantai tidak ditemukan');
        }

        $lantais = Lantai::find($id);
        $lantais->update($request->all());
        return redirect()->route('settinglantai.index')->with('success', 'Lantai berhasil diperbarui');
    }

    public function destroy($id)
    {
        $lantais = Lantai::find($id);
        $lantais->delete();
        return redirect()->route('settinglantai.index')->with('success', 'Lantai berhasil dihapus');
    }
}
