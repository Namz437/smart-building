<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KodeKontrol;
use App\Models\SettingKodeKontrol;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SettingKodeKontrolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function show($deviceId)
    {
        try {
            $cek = SettingKodeKontrol::where([
                'device_id' => $deviceId])->with('kode_kontrol')->first();
            if (isset($cek)) {
                $response = [
                    'success' => true,
                    'data' => $cek,
                    'message' => 'Data tersedia',
                ];

                return response()->json($response, 200);
            } else {
                $response = [
                    'success' => true,
                    'data' => null,
                    'message' => 'Data null',
                ];
                return response()->json($response, 200);
            }

        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Error',
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'device_id' => 'required',
                'kode_kontrol_id' => 'required',
            ]);

            // Cek respon jika validasi gagal
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $cek = SettingKodeKontrol::where([
                'device_id' => $request->device_id,
                // 'kode_kontrol_id' => $request->kode_kontrol_id,
            ])->first();
            if (isset($cek)) {
                $cek->device_id = $request->device_id;
                $cek->kode_kontrol_id = $request->kode_kontrol_id;

                $cek->save();
                $response = [
                    'success' => true,
                    'data' => $cek,
                    'message' => 'Ruangan berhasil ditambahkan',
                ];

                return response()->json($response, 200);
            } else {
                // Create Ruangan
                $ruangan = SettingKodeKontrol::create([
                    'device_id' => $request->device_id,
                    'kode_kontrol_id' => $request->kode_kontrol_id,
                ]);

                $response = [
                    'success' => true,
                    'data' => $ruangan,
                    'message' => 'Data berhasil ditambahkan',
                ];

                // Return response
                return response()->json($response, 200);
            }

        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Data tidak berhasil ditambahkan',
            ];
            return response()->json($response, 500);
        }
    }

    public function update(SettingKodeKontrol $settingKodeKontrol)
    {
    }

    public function cek_on_off_ac($mac_address)
    {
        try {
            $cek = DB::table('history')
                ->where('device.mac_address', $mac_address)
                ->join('device', 'device.id', '=', 'history.device_id')
                ->join('merk', 'merk.id', '=', 'device.merk_id')
            // ->join('kode_kontrol', 'merk.id', '=', 'kode_kontrol.merk_id')
                ->select(['history.*', 'merk.id as merk_id'])
                ->orderBy('history.id', 'desc')
                ->first();
            $d = "";
            if ($cek->status == 0) {
                $d = KodeKontrol::where('merk_id', $cek->merk_id)->where('alias', 'OFF')->first();
            } else {
                $d = KodeKontrol::where('merk_id', $cek->merk_id)->where('alias', 'ON')->first();
            }

            $response = [
                'alias' => $d->alias,
                'kode' => $d->kode,
            ];
            return response()->json($response, 200);

        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Data tidak berhasil ditambahkan',
            ];
            return response()->json($response, 500);
        }
    }
    public function cek_current_kode($mac_address)
    {
        try {
            $cek = DB::table('device')
                ->where('device.mac_address', $mac_address)
                ->join('setting_kode_kontrol', 'device.id', '=', 'setting_kode_kontrol.device_id')
                ->join('kode_kontrol', 'kode_kontrol.id', '=', 'setting_kode_kontrol.kode_kontrol_id')
                ->select('kode_kontrol.*')
                ->orderBy('setting_kode_kontrol.id', 'desc')
                ->first();

            $response = [
                'alias' => $cek->alias,
                'kode' => $cek->kode,
            ];
            return response()->json($response, 200);

        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Data tidak berhasil ditambahkan',
            ];
            return response()->json($response, 500);
        }
    }
}
