<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\KodeKontrol;
use App\Models\SettingKodeKontrol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingKodeKontrolController extends Controller
{

    public function index()
    {
        $setting_kode_kontrols = SettingKodeKontrol::with('device', 'kode_kontrol')->get();
        $devices = Device::all();
        $kode_kontrols = KodeKontrol::all();
        return view('settingkodekontrol.index', compact('setting_kode_kontrols', 'devices', 'kode_kontrols'));
    }

    public function create()
    {
        $setting_kode_kontrols = SettingKodeKontrol::with('device', 'kode_kontrol')->get();
        $devices = Device::all();
        $kode_kontrols = KodeKontrol::all();
        return view('settingkodekontrol.create', compact('setting_kode_kontrols', 'devices', 'kode_kontrols'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required',
            'kode_kontrol_id' => 'required',
        ]);

        // Cek respon jika validasi gagal
        if (empty($validator)) {
            return redirect()->route('settingkodekontrol.index')->with('error', 'Data tidak ditemukan');
        }

        $setting_kode_kontrols = SettingKodeKontrol::create($request->all());
        return redirect()->route('settingkodekontrol.index')->with('success', 'Kode Kontrol Berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $setting_kode_kontrols = SettingKodeKontrol::with('device', 'kode_kontrol')->find($id);
        $devices = Device::all();
        $kode_kontrols = KodeKontrol::all();
        return view('settingkodekontrol.edit', compact('setting_kode_kontrols', 'devices', 'kode_kontrols'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required',
            'kode_kontrol_id' => 'required',
        ]);

        // Cek respon jika validasi gagal
        if (empty($validator)) {
            return redirect()->route('settingkodekontrol.index')->with('error', 'Data tidak ditemukan');
        }

        $setting_kode_kontrols = SettingKodeKontrol::find($id);
        $setting_kode_kontrols->device_id = $request->device_id;
        $setting_kode_kontrols->kode_kontrol_id = $request->kode_kontrol_id;
        $setting_kode_kontrols->save();

        return redirect()->route('settingkodekontrol.index')->with('success', 'Kode Kontrol Berhasil diubah');
    }

    public function destroy(string $id)
    {
        $kode_kontrols = SettingKodeKontrol::find($id);
        $kode_kontrols->delete();
        return redirect()->route('settingkodekontrol.index')->with('success', 'Kode Kontrol Berhasil dihapus');
    }
}
