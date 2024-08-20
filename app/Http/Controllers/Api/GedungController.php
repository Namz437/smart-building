<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gedung;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GedungController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Gedung::all();
            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Data gedung tersedia',
            ];
            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Data gedung tidak tersedia',
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
                'nama_gedung' => 'required|string|max:255|unique:gedung',
                'deskripsi' => 'required',
                'perusahaan_id' => 'required',
            ]);

            // Cek respon jika validasi gagal
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $gedung = new Gedung();
            $gedung->nama_gedung = $request->nama_gedung;
            $gedung->deskripsi = $request->deskripsi;
            $gedung->save();

            return response()->json(['message' => 'Gedung Berhasil Ditambahkan', 'data' => $gedung], 201);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Gedung tidak berhasil ditambahkan',
            ];
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $data = Gedung::where('id', $id)->first();
            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Data gedung tersedia',
            ];
            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Data gedung tidak tersedia',
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gedung $gedung)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama_gedung' => 'required|string|max:255|unique:gedung,nama_gedung,' . $gedung->id,
                'deskripsi' => 'required',
                'perusahaan_id' => 'required',
            ]);

            // Cek respon jika validasi gagal
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $gedung->nama_gedung = $request->nama_gedung;
            $gedung->deskripsi = $request->deskripsi;
            $gedung->save();

            return response()->json(['message' => 'Gedung Berhasil Diupdate', 'data' => $gedung], 201);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Gedung tidak berhasil diupdate',
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gedung $gedung)
    {
        try {
            $data = Gedung::where('id', $gedung->id)->delete();
            $response = [
                'success' => true,
                'message' => 'Gedung Berhasil Dihapus',
            ];
            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Gedung tidak berhasil dihapus',
            ];
            return response()->json($response, 500);
        }
    }
}
