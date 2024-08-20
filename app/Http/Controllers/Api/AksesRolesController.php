<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AksesRoles;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AksesRolesController extends Controller
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
            $validator = Validator::make($request->all(), [
                'roles_id' => 'required',
                'ruangan_id' => 'required',
            ]);

            // Cek Validasi jika data gagal
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $aksesRoles = AksesRoles::create([
                'roles_id' => $request->roles_id,
                'ruangan_id' => $request->ruangan_id,
            ]);

            $response = [
                'success' => true,
                'data' => $aksesRoles,
                'message' => 'Data Akses Roles berhasil ditambahkan',
            ];

            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Data Akses Roles gagal ditambahkan',
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AksesRoles $aksesRoles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AksesRoles $aksesRoles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AksesRoles $aksesRoles)
    {
        //
    }
}
