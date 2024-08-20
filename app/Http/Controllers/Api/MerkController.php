<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Merk;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MerkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Merk::all();
            $response = [
                'success' => true,
                'message' => 'Data merk tersedia',
                'data' => $data,
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Data merk tidak tersedia',
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
            $validate = Validator::make($request->all(), [
                'nama_merk' => 'required|string|max:255',
                'deskripsi' => 'required',
            ]);

            // Cek validasi jika validasi diatas gagal
            if ($validate->fails()) {
                return response()->json($validate->errors(), 422);
            }

            // Create Merk
            $merk = Merk::create([
                'nama_merk' => $request->nama_merk,
                'deskripsi' => $request->deskripsi,
            ]);
            $response = [
                'success' => true,
                'data' => $merk,
                'message' => 'Merk berhasil ditambahkan',
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Merk gagal ditambahkan',
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
            $data = Merk::find($id);
            $response = [
                'success' => true,
                'message' => 'Data merk tersedia',
                'data' => $data,
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Data merk tidak tersedia',
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Merk $merk)
    {
        try {
            $validate = Validator::make($request->all(), [
                'nama_merk' => 'required|string|max:255',
                'deskripsi' => 'required',
            ]);

            // Cek validasi jika gagal
            if ($validate->fails()) {
                return response()->json($validate->errors(), 422);
            }

            // Update Merk
            $merk->update([
                'nama_merk' => $request->nama_merk,
                'deskripsi' => $request->deskripsi,
            ]);
            $response = [
                'success' => true,
                'message' => 'Merk berhasil diupdate',
                'data' => $merk,
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Merk gagal diupdate',
            ];

            return response()->json($response, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Merk $merk)
    {
        try {
            $merk->delete();
            $response = [
                'success' => true,
                'message' => 'Merk berhasil dihapus',
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Merk gagal dihapus',
            ];
            return response()->json($response, 500);
        }
    }
}
