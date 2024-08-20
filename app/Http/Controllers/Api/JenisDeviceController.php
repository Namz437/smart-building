<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JenisDevice;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JenisDeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = jenisDevice::all();
            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Data tersedia',
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Data tidak tersedia',
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
                'nama_jenis' => 'required|string|max:255',
                'deskripsi' => 'required',
                'category_device_id' => 'required',
            ]);

            // Cek validasi jika validasi diatas gagal
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            // Create jenisDevice
            $jenisDevice = jenisDevice::create([
                'nama_jenis' => $request->nama_jenis,
                'deskripsi' => $request->deskripsi,
                'category_device_id' => $request->category_device_id,
            ]);
            $response = [
                'success' => true,
                'data' => $jenisDevice,
                'message' => 'Jenis Device berhasil dibuat',
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Jenis Device gagal dibuat',
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $data = jenisDevice::find($id);
            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Data Jenis Device Tersedia',
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Data Jenis Device Tidak Tersedia',
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisDevice $jenisDevice)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama_jenis' => 'required|string|max:255',
                'deskripsi' => 'required',
                'category_device_id' => 'required',
            ]);

            // Cek validasi jika validasi diatas gagal
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            // Update JenisDevice
            $jenisDevice->update([
                'nama_jenis' => $request->nama_jenis,
                'deskripsi' => $request->deskripsi,
                'category_device_id' => $request->category_device_id,
            ]);
            $response = [
                'success' => true,
                'data' => $jenisDevice,
                'message' => 'Jenis Device berhasil diupdate',
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Jenis Device gagal diupdate',
            ];
            return response()->json($response, 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisDevice $jenisDevice)
    {
        try {
            $jenisDevice->delete();
            $response = [
                'success' => true,
                'message' => 'Jenis Device berhasil di hapus',
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Jenis Device gagal di hapus',
            ];
            return response()->json($response, 500);
        }
    }
}
