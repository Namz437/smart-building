<?php

namespace App\Http\Controllers;

use App\Models\CategoryDevice;
use App\Models\JenisDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingJenisDeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenis_devices = JenisDevice::with('category_device')->get();
        $category_devices = CategoryDevice::all();
        return view('jenisdevice.index', compact('jenis_devices', 'category_devices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenis_devices = JenisDevice::all();
        $category_devices = CategoryDevice::all();
        return view('jenisdevice.create', compact('jenis_devices', 'category_devices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_device_id' => 'required',
            'nama_jenis' => 'required|max:255',
            'deskripsi' => 'required|max:255',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->route('jenisdevice.index')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Validasi gagal. Mohon lengkapi data dengan benar.');
        }

        // Create JenisDevice only if validation passes
        $jenis_device = JenisDevice::create([
            'category_device_id' => $request->category_device_id,
            'nama_jenis' => $request->nama_jenis,
            'deskripsi' => $request->deskripsi,
            // Add more attributes as needed
        ]);

        return redirect()->route('jenisdevice.index')->with('success', 'Jenis Device Berhasil Ditambahkan');
    }

    public function edit(string $id)
    {
        $jenis_devices = JenisDevice::with('category_device')->find($id);

        if (empty($jenis_devices)) {
            return redirect()->route('jenisdevice.index')->with('error', 'Jenis Device tidak ditemukan');
        }

        $category_devices = CategoryDevice::all();
        return view('jenisdevice.edit', compact('jenis_devices', 'category_devices'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'category_device_id' => 'required',
            'nama_jenis' => 'required|max:255',
            'deskripsi' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('jenisdevice.index')->withErrors($validator)->withInput();
        }

        $jenis_device = JenisDevice::find($id);

        if (!$jenis_device) {
            return redirect()->route('jenisdevice.index')->with('error', 'Jenis Device tidak ditemukan');
        }

        $jenis_device->update($validator->validated());
        return redirect()->route('jenisdevice.index')->with('success', 'Jenis Device Berhasil Diubah');
    }

    public function destroy(string $id)
    {
        // Find the jenis_device by ID with the related category_device
        $jenis_devices = JenisDevice::with('category_device')->find($id);

        // Check if jenis_device was found
        if (!$jenis_devices) {
            return redirect()->route('jenisdevice.index')->with('error', 'Jenis Device tidak ditemukan');
        }

        // Delete the jenis_device
        $jenis_devices->delete();

        // Return to the index view with a success message
        return redirect()->route('jenisdevice.index')->with('success', 'Jenis Device Berhasil Dihapus');
    }
}
