<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SettingRoles;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SettingRolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = SettingRoles::all();
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
            // Cek apakah request berisi users_id dan roles_id
            $validator = Validator::make($request->all(), [
                'users_id' => 'required',
                'roles_id' => 'required',
            ]);

            // Kalau tidak akan mengembalikan error
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'message' => 'Validasi gagal'
                ], 422);
            }

            // Kalau ya maka akan membuat setting_roles baru
            $data = SettingRoles::create([
                'users_id' => $request->users_id,
                'roles_id' => $request->roles_id,
            ]);

            // Data akan di kirimkan dalam bentuk response list
            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Data berhasil disimpan',
            ];

            // Jika berhasil maka akan mengirimkan status code 201
            return response()->json($response, 201);
        } catch (Exception $th) {
            // Log error untuk debugging
            Log::error('Error in storing setting roles: ' . $th->getMessage());

            $response = [
                'success' => false,
                'message' => 'Gagal Menyimpan Data',
            ];
            // Jika error maka akan mengirimkan status code 500
            return response()->json($response, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            // Find id setting_roles
            $data = SettingRoles::find($id);
            if ($data == null) {
                $response = [
                    'success' => false,
                    'message' => 'ID Tidak Ditemukan',
                ];
                return response()->json($response, 404);
            }

            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Data Tersedia',
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'users_id' => 'required',
                'roles_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            $data = SettingRoles::find($id);
            $data->users_id = $request->users_id;
            $data->roles_id = $request->roles_id;
            $data->save();

            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'ID Role berhasil diubah',
            ];

            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => $th,
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $save = SettingRoles::find($id);
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
