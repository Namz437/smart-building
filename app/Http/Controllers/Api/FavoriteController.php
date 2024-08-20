<?php

namespace App\Http\Controllers\Api;

use App\Models\Favorite;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($users_id)
    {
        try {
            $data = Favorite::where('users_id', $users_id)->with('ruangan.lantai.gedung.perusahaan', 'ruangan.devices', 'ruangan.perusahaan')->get()->groupBy(function ($r) {
                // Memisahkan ruangan berdasarkan keberadaan dan status devices
                if ($r->ruangan->devices->isEmpty()) {
                    return 'empty';
                } else {
                    return $r->ruangan->devices->contains('status', 1) ? 'running' : 'not_running';
                }
            });

            // Menggabungkan hasil ke dalam urutan yang diinginkan
            $sortedRuangan = collect([
                'running' => $data->get('running', collect()),
                'not_running' => $data->get('not_running', collect()),
                'empty' => $data->get('empty', collect()),
            ])->collapse();
            $response = [
                'success' => true,
                'data' => $sortedRuangan,
                'message' => 'Data Favorite Tidak Tersedia',
            ];

            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Data Favorite Tidak Tersedia',
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
                'ruangan_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $cek = Favorite::where('users_id', $request->users_id)->where('ruangan_id', $request->ruangan_id)->first();
            if (isset($cek)) {
                return response()->json(['success' => false, 'message' => 'Already favorited']);
            }
            $jenisDevice = Favorite::create([
                'users_id' => $request->users_id,
                'ruangan_id' => $request->ruangan_id,
            ]);
            $response = [
                'success' => true,
                'data' => $jenisDevice,
                'message' => 'Ruangan difavoritkan',
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Gagal menyimpan data',
            ];
            return response()->json($response, 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($users_id, $ruangan_id)
    {
        try {
            $data = Favorite::where('users_id', $users_id)->where('ruangan_id', $ruangan_id)->first();
            if (isset($data)) {
                $response = [
                    'success' => true,
                    'data' => $data,
                    'message' => 'Data Favorite Tersedia',
                ];
            } else {
                $response = [
                    'success' => false,
                    'data' => $data,
                    'message' => 'Data Favorite Tidak Tersedia',
                ];

            }
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Data Favorite Tidak Tersedia',
            ];
            return response()->json($response, 500);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Favorite $favorite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($users_id, $ruangan_id)
    {
        try {
            $save = Favorite::where('users_id', $users_id)->where('ruangan_id', $ruangan_id)->first();
            if ($save == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Periksa kembali id yang akan dihapus',
                ], 404);
            }
            $save->delete();
            $response = [
                'success' => true,
                'message' => 'Data berhasil dihapus',
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Gagal Menghapus Data',
            ];
            return response()->json($response, 500);
        }

    }
}
