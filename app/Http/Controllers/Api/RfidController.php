<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rfid;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RfidController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $rfid = Rfid::all();
            $response = [
                'success' => true,
                'message' => 'Data RFID',
                'data' => $rfid
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Data RFID tidak ditemukan',
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
                'users_id' => 'required',
                'rfid' => 'required|unique:rfid',
            ]);

            // Cek validasi jika gagal
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            // Jika validasi sukses
            $rfid = Rfid::create([
                'users_id' => $request->users_id,
                'rfid' => $request->rfid,
            ]);

            $response = [
                'success' => true,
                'message' => 'RFID berhasil dibuat',
                'data' => $rfid
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'RFID sama tidak berhasil dibuat',
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
            $rfid = Rfid::find($id);
            if ($rfid) {
                $response = [
                    'success' => true,
                    'message' => 'Data RFID',
                    'data' => $rfid
                ];
                return response()->json($response, 200);
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Data RFID tidak ditemukan',
                ];
                return response()->json($response, 500);
            }
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Data RFID tidak ditemukan',
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rfid $rfid)
    {
        try {
            $validator = Validator::make($request->all(), [
                'users_id' => 'required|unique:users_id',
                'rfid' => 'required|unique:rfid',
            ]);

            // Cek validasi jika gagal
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            // Jika validasi sukses
            $rfid->update([
                'users_id' => $request->users_id,
                'rfid' => $request->rfid,
            ]);

            $response = [
                'success' => true,
                'message' => 'RFID berhasil diupdate',
                'data' => $rfid
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'RFID sama tidak berhasil diupdate',
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rfid $rfid)
    {
        try {
            $rfid->delete();
            $response = [
                'success' => true,
                'message' => 'RFID berhasil dihapus',
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'RFID gagal dihapus',
            ];
            return response()->json($response, 500);
        }
    }
}
