<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoryDevice;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryDeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $category_device = CategoryDevice::all();
            $response = [
                'success' => true,
                'message' => 'Category Device Berhasil ditampilkan',
                'data' => $category_device
            ];
            return response()->json($category_device);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Category Device Gagal ditampilkan',
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
                'nama_category' => 'required|string|max:255',
                'deskripsi' => 'required',
            ]);

            // Cek validasi jika gagal
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }


            $category_device = CategoryDevice::create([
                'nama_category' => $request->nama_category,
                'deskripsi' => $request->deskripsi,
            ]);

            $response = [
                'success' => true,
                'message' => 'Category Device Berhasil ditambahkan',
                'data' => $category_device
            ];
            return response()->json($category_device);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Category Device Gagal ditambahkan',
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
            $data = CategoryDevice::find($id);
            $response = [
                'success' => true,
                'message' => 'Category Device Berhasil ditampilkan',
                'data' => $data
            ];
            return response()->json($data);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Category Device Gagal ditampilkan',
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoryDevice $categoryDevice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryDevice $categoryDevice)
    {
        //
    }
}
