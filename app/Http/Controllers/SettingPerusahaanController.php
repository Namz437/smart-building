<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingPerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perusahaans = Perusahaan::all();
        return view('settingperusahaan.index', compact('perusahaans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $perusahaans = Perusahaan::all();
        return view('settingperusahaan.create', compact('perusahaans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'deskripsi' => 'required',
            'lokasi' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kwh' => 'required',
            'harga_kwh' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $url = null; // Default value in case no image is uploaded
    
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('images', 'public');
            $url = Storage::url($path); // Correctly generate the URL
        }
    
        $data = Perusahaan::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'image' => $url,
            'kwh' => $request->kwh,
            'harga_kwh' => $request->harga_kwh,
        ]);
    
        return redirect()->route('settingperusahaan.index')->with('success', 'Perusahaan created successfully');
    }
    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $perusahaans = Perusahaan::find($id);

        if (empty($perusahaans->image)) {
            $perusahaans->image = 'default.png';
        }

        return view('settingperusahaan.show', compact('perusahaans'));
    }


    public function edit($id)
    {
        $perusahaans = Perusahaan::find($id);
        return view('settingperusahaan.edit', compact('perusahaans'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'deskripsi' => 'required',
            'lokasi' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kwh' => 'required',
            'harga_kwh' => 'required',
        ]);

        $perusahaans = Perusahaan::find($id);

        if ($validator->fails()) {
            return redirect()->route('settingperusahaan.index')->withErrors($validator)->withInput();
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($perusahaans->image) {
                Storage::disk('public')->delete($perusahaans->image);
            }

            // Store the new image
            $file = $request->file('image');
            $path = $file->store('images', 'public');
            $perusahaans->image = $path;
        }

        // Update other fields
        $perusahaans->nama = $request->nama;
        $perusahaans->deskripsi = $request->deskripsi;
        $perusahaans->lokasi = $request->lokasi;
        $perusahaans->kwh = $request->kwh;
        $perusahaans->harga_kwh = $request->harga_kwh;

        // Save the updated model
        $perusahaans->save();

        return redirect()->route('settingperusahaan.index')->with('success', 'Perusahaan updated successfully');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $perusahaans = Perusahaan::find($id);
        $perusahaans->delete();

        return redirect()->route('settingperusahaan.index')->with('success', 'Perusahaan deleted successfully');
    }
}
