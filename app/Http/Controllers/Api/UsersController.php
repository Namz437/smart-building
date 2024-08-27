<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::all();
        $response = [
            'success' => true,
            'data' => $data,
            'message' => 'Data tersedia',
        ];
        return response()->json($response, 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function resetPassword(Request $request, $id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['error' => 'User tidak ditemukan'], 404);
    }

    // Generate a random password
    $newPassword = Str::random(12);

    // Reset password to the generated random value
    $user->password = bcrypt($newPassword);
    $user->save();

    return response()->json([
        'success' => true,
        'message' => 'Password berhasil direset',
        'user' => [
            'name' => $user->name,
            'email' => $user->email,
            'new_password' => $newPassword
        ]
    ], 200);
}
}
