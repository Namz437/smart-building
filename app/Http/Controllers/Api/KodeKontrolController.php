<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KodeKontrol;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KodeKontrolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'merk_id' => 'required',
                'kode' => 'required',
                'alias' => 'required',
            ]);

            // Cek validasi jika gagal
            if ($validation->fails()) {
                return response()->json($validation->errors(), 400);
            }

            $kodeKontrol = new KodeKontrol();
            $kodeKontrol->merk_id = $request->merk_id;
            $kodeKontrol->kode = $request->kode;
            $kodeKontrol->alias = $request->alias;
            $kodeKontrol->save();

            $response = [
                'success' => true,
                'message' => 'Kode Kontrol Berhasil ditambahkan',
                'data' => $kodeKontrol
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Kode Kontrol Gagal ditambahkan',
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(KodeKontrol $kodeKontrol)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KodeKontrol $kodeKontrol)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KodeKontrol $kodeKontrol)
    {
        //
    }
}
