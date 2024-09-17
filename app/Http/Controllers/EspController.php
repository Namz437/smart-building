<?php

namespace App\Http\Controllers;

use App\Models\AksesRoles;
use App\Models\Device;
use App\Models\Perusahaan;
use App\Models\Ruangan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class EspController extends Controller
{
    public function logindevice(Request $macAddress)
    {
        try {
            $device = Device::where('mac_address', $macAddress->mac_address)->first();

            $token = $device->createToken('auth_token')->plainTextToken;
            $response = $token;
        //  print( Auth::user());
            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Data Mac Address tidak tersedia',
            ];
            return response()->json($response, 500);
        }
    }

    public function espstatuspintu (Request $request)
{
    try {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'mac_address' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Temukan device berdasarkan id
        $device = Device::where('mac_address', $request->mac_address)->first();
        if (!$device) {
            return response()->json(['message' => 'Device tidak ditemukan'], 404);
        }

        // $index = 0;
        // if ($device->qr_code != null && $device->qr_code == 0) {
        //     $index = 1;
        // } else {
        //     $index = 0;
        // }
        // Update status device
        $device->update(['status' => $request->status]);

        // Temukan entri terakhir di History untuk device ini

        $response = [
            'success' => true,
            'message' => 'status berhasil diupdate',
        ];

        return response()->json($response, 200);
    } catch (Exception $e) {
        // Log error message untuk debugging
        Log::error('Error updating status: ' . $e->getMessage());

        $response = [
            'success' => false,
            'message' => 'Status gagal diupdate: ' . $e->getMessage(),
        ];
        return response()->json($response, 500);
    }

}

public function accessallrfid(Request $request)
{
    // Langkah 1: Dapatkan device berdasarkan MAC address
    $device = Device::where('mac_address', $request->mac_address)->first();

    // Cek apakah device ditemukan
    if ($device) {
        // Dapatkan ruangan_id dari device
        $ruanganId = $device->ruangan_id;

        // Langkah 2: Cari roles_id di tabel AksesRoles berdasarkan ruangan_id
        $rolesIds = AksesRoles::where('ruangan_id', 'LIKE', '%[' . $ruanganId . ']%')
                                ->orWhere('ruangan_id', 'LIKE', '%[' . $ruanganId . ',%')
                                ->orWhere('ruangan_id', 'LIKE', '%,' . $ruanganId . ',%')
                                ->orWhere('ruangan_id', 'LIKE', '%,' . $ruanganId . ']%')
                                ->pluck('roles_id'); // Ambil roles_id saja

        // Cek apakah ada roles_id yang ditemukan
        if ($rolesIds->isNotEmpty()) {
            // Langkah 3: Cari pengguna berdasarkan roles_id yang ditemukan
            $rfids = User::whereIn('roles_id', $rolesIds)
                         ->pluck('rfid')
                         ->filter()
                         ->unique()
                         ->values() // Mengatur ulang kunci array dan mengembalikan array yang baru
                         ->all(); // Mengonversi koleksi menjadi array

            // Jika tidak ada RFID ditemukan
            if (!empty($rfids)) {
                // Return daftar RFID sebagai array
                return response()->json([
                    $rfids, // RFID sebagai array
                ]);
            } else {
                // Handle jika tidak ada RFID yang ditemukan
                return response()->json([
                    'status' => 'error',
                    'message' => 'No RFID found for these users',
                ], 404);
            }
        } else {
            // Handle jika tidak ada roles_id yang ditemukan
            return response()->json([
                'status' => 'error',
                'message' => 'No roles found for this ruangan',
            ], 404);
        }
    } else {
        // Handle jika device tidak ditemukan
        return response()->json([
            'status' => 'error',
            'message' => 'Device not found',
        ], 404);
    }
}

// untuk get pin
public function getpin($macAddress)
{
    // Ambil device berdasarkan macAddress
    $device = Device::where('mac_address', $macAddress)->first();
    
    if ($device) {
        // Ambil ruangan dengan relasi perusahaan, lantai, gedung, dan perusahaan di gedung
        $ruangan = Ruangan::with('perusahaan', 'lantai.gedung.perusahaan')
                         ->where('id', $device->ruangan_id)
                         ->first();

        if ($ruangan) {
            // Ambil pin dari perusahaan yang terkait dengan ruangan
            $perusahaan = $ruangan->perusahaan;

            if ($perusahaan) {
                $pin = $perusahaan->pin;

                return response()->json([
                    $pin
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Perusahaan tidak tersedia',
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Ruangan tidak tersedia',
            ]);
        }
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Data Mac Address tidak tersedia',
        ]);
    }
}
}
