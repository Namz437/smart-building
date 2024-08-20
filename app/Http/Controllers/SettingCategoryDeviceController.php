<?php

namespace App\Http\Controllers;

use App\Models\CategoryDevice;
use Illuminate\Http\Request;

class SettingCategoryDeviceController extends Controller
{

    public function index()
    {
        $category_devices = CategoryDevice::all();
        return view('categorydevice.index', compact('category_devices'));
    }


    public function create()
    {
        $category_devices = CategoryDevice::all();
        return view('categorydevice.create', compact('category_devices'));
    }


    public function store(Request $request)
    {
        $validator = $request->validate([
            'nama_category' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
        ]);
        CategoryDevice::create($validator);
        return redirect()->route('categorydevice.index')->with('success', 'Data Category Device Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $category_devices = CategoryDevice::find($id);
        return view('categorydevice.edit', compact('category_devices'));
    }

    public function update(Request $request, string $id)
    {

        $validator = $request->validate([
            'nama_category' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
        ]);
        $category_devices = CategoryDevice::find($id);
        $category_devices->update($validator);
        return redirect()->route('categorydevice.index')->with('success', 'Data Berhasil Diubah');
    }


    public function destroy(string $id)
    {
        $category_devices = CategoryDevice::find($id);
        $category_devices->delete();
        return redirect()->route('categorydevice.index')->with('success', 'Data Berhasil Dihapus');
    }
}
