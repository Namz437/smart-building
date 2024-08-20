<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\JenisDevice;
use App\Models\Merk;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingDeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $devices = Device::with('jenis_device', 'ruangan', 'merk')->get();
        $jenis_devices = JenisDevice::all();
        $ruangans = Ruangan::all();
        $merks = Merk::all();
        return view('/device.index', compact('devices', 'jenis_devices', 'ruangans', 'merks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $devices = Device::with('jenis_device', 'ruangan', 'merk')->get();
        $jenis_devices = JenisDevice::all();
        $ruangans = Ruangan::all();
        $merks = Merk::all();
        return view('/device.create', compact('devices', 'jenis_devices', 'ruangans', 'merks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_device' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'jenis_device_id' => 'required',
            'ruangan_id' => 'required',
            'merk_id' => 'required',
            'suhu' => 'required|nullable',
            'min_suhu' => 'required|nullable',
            'max_suhu' => 'required|nullable',
            'watt' => 'required|nullable',
            'mac_address' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Device::create($request->all());
        return redirect()->route('device.index')->with('success', 'Data Berhasil Ditambahkan');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $devices = Device::with('jenis_device', 'ruangan', 'merk')->find($id);
        $device = Device::find($id);
        $jenis_devices = JenisDevice::all();
        $ruangans = Ruangan::all();
        $merks = Merk::all();
        return view('/device.edit', compact('devices', 'device', 'jenis_devices', 'ruangans', 'merks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_device' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'merk_id' => 'required',
            'ruangan_id' => 'required',
            'jenis_device_id' => 'required',
            'suhu' => 'required|nullable',
            'min_suhu' => 'required|nullable',
            'max_suhu' => 'required|nullable',
            'watt' => 'required|nullable',
            'mac_address' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $device = Device::find($id);
        $device->update($request->all());
        return redirect()->route('device.index')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $devices = Device::find($id);
        $devices->delete();
        return redirect()->route('device.index')->with('success', 'Data Berhasil Dihapus');
    }
}
