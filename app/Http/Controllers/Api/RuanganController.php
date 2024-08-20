<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Mengambil semua ruangan beserta devices
            $ruangan = Ruangan::with('lantai.gedung.perusahaan','devices', 'perusahaan')
                ->get()
                ->groupBy(function ($r) {
                    // Memisahkan ruangan berdasarkan keberadaan dan status devices
                    if ($r->devices->isEmpty()) {
                        return 'empty';
                    } else {
                        return $r->devices->contains('status', 1) ? 'running' : 'not_running';
                    }
                });

            // Menggabungkan hasil ke dalam urutan yang diinginkan
            $sortedRuangan = collect([
                'running' => $ruangan->get('running', collect()),
                'not_running' => $ruangan->get('not_running', collect()),
                'empty' => $ruangan->get('empty', collect()),
            ])->collapse();

            // Log data yang diurutkan untuk debugging
            // Log::info('Sorted ruangan data:', ['data' => $sortedRuangan]);

            $response = [
                'success' => true,
                'data' => $sortedRuangan,
                'message' => 'Data ruangan dan device tersedia',
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            Log::error('Error: ', ['error' => $th]);
            $response = [
                'success' => false,
                'message' => 'Data ruangan dan device tidak tersedia',
            ];
            return response()->json($response, 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama_ruangan' => 'required|string|max:255|unique:ruangan',
                'deskripsi' => 'required',
                'ukuran' => 'required',
            ]);

            // Cek respon jika validasi gagal
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            // Create Ruangan
            $ruangan = Ruangan::create([
                'nama_ruangan' => $request->nama_ruangan,
                'deskripsi' => $request->deskripsi,
                'ukuran' => $request->ukuran,
            ]);

            $response = [
                'success' => true,
                'data' => $ruangan,
                'message' => 'Ruangan berhasil ditambahkan' . $ruangan->id,
            ];

            // Return response
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Ruangan tidak berhasil ditambahkan',
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
            $data = Ruangan::find($id);
            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Data ruangan tersedia',
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Data ruangan tidak tersedia',
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ruangan $ruangan)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama_ruangan' => 'required|string|max:255|unique:ruangan,nama_ruangan,' . $ruangan->id,
                'deskripsi' => 'required',
                'ukuran' => 'required',
            ]);

            // Cek respon jika validasi gagal
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $ruangan->update([
                'nama_ruangan' => $request->nama_ruangan,
                'deskripsi' => $request->deskripsi,
                'ukuran' => $request->ukuran,
            ]);

            $response = [
                'success' => true,
                'message' => 'Ruangan Berhasil Diubah',
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Ruangan tidak berhasil diubah',
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ruangan $ruangan)
    {
        try {
            $ruangan->delete();
            $response = [
                'success' => true,
                'message' => 'Ruangan Berhasil Dihapus',
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Ruangan tidak berhasil dihapus',
            ];
            return response()->json($response, 500);
        }
    }

    public function search(Request $request)
    {
        try {

            // $ruangan = $request->search;
            // Mengambil semua ruangan beserta devices
            $ruangan = Ruangan::where('nama_ruangan', 'LIKE', '%'. $request->search .'%')-> with('lantai.gedung.perusahaan','devices', 'perusahaan')
                ->get()
                ->groupBy(function ($r) {
                    // Memisahkan ruangan berdasarkan keberadaan dan status devices
                    if ($r->devices->isEmpty()) {
                        return 'empty';
                    } else {
                        return $r->devices->contains('status', 1) ? 'running' : 'not_running';
                    }
                });

            // Menggabungkan hasil ke dalam urutan yang diinginkan
            $sortedRuangan = collect([
                'running' => $ruangan->get('running', collect()),
                'not_running' => $ruangan->get('not_running', collect()),
                'empty' => $ruangan->get('empty', collect()),
            ])->collapse();

            // Log data yang diurutkan untuk debugging
            Log::info('Sorted ruangan data:', ['data' => $sortedRuangan]);

            $response = [
                'success' => true,
                'data' => $sortedRuangan,
                'message' => 'Data ruangan dan device tersedia',
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            Log::error('Error: ', ['error' => $th]);
            $response = [
                'success' => false,
                'message' => 'Data ruangan dan device tidak tersedia',
            ];
            return response()->json($response, 500);
        }
    }
}
