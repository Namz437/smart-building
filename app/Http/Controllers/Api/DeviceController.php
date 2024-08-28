<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AksesRoles;
use App\Models\Device;
use App\Models\History;
use App\Models\KodeKontrol;
use App\Models\Perusahaan;
use App\Models\Rfid;
// use App\Models\SettingRoles;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Device::all();
            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Data device tersedia',
            ];
            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Data device tidak tersedia',
            ];
            return response()->json($response, 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama_device' => 'required|string|max:255',
                'jenis_device_id' => 'required',
                'mac_address' => 'required|unique:device,mac_address',
            ]);

            // Cek validasi jika validasi diatas gagal
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            // Create Device
            $device = Device::create([
                'nama_device' => $request->nama_device,
                'jenis_device_id' => $request->jenis_device_id,
                'mac_address' => $request->mac_address,
            ]);

            $d = Device::find($device->id);
            $d->url = '/device/' . $device->id;
            $d->save();

            $response = [
                'success' => true,
                'message' => 'Device Berhasil ditambahkan',
                'data' => $d,
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Device gagal ditambahkan',
            ];
            return response()->json($response, 500);
        }
    }

    public function show($id)
    {
        try {
            $data = Device::find($id);
            $response = [
                'success' => true,
                'message' => 'Data Device tersedia',
                'data' => $data,
            ];
            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Data Device tidak tersedia',
            ];
            return response()->json($response, 500);
        }
    }
    public function esp_get_min_max_suhu($mac_address)
    {
        try {
            $data = Device::where('mac_address', $mac_address)->first();
            $response = [
                'min_suhu' => $data->min_suhu,
                'max_suhu' => $data->max_suhu,
            ];
            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                +'success' => false,
                'message' => 'Data Device tidak tersedia',
            ];
            return response()->json($response, 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_device' => 'required|string|max:255',
            'jenis_device_id' => 'required',
            'mac_address' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update Device
        $device = Device::find($id);
        if (!$device) {
            return response()->json(['message' => 'Device tidak ditemukan'], 404);
        }

        $device->update([
            'nama_device' => $request->nama_device,
            'jenis_device_id' => $request->jenis_device_id,
            'mac_address' => $request->mac_address,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Device berhasil diupdate',
            'data' => $device,
        ], 200);
    }

    public function updateSuhu(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'suhu' => 'required|nullable',
                'macAddress' => 'required|nullable',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $device = Device::where('mac_address', $request->macAddress)->first();
            if (!$device) {
                return response()->json(['message' => 'Device tidak ditemukan'], 404);
            }

            $device->update(['suhu' => $request->suhu]);

            $response = [
                'success' => true,
                'message' => 'Suhu berhasil diupdate',
                'data' => $device,
            ];

            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Suhu gagal diupdate',
            ];
            return response()->json($response, 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'status' => 'required',
                'perusahaan_id' => 'required|exists:perusahaan,id',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            // Periksa apakah pengguna terautentikasi
            $user = $request->user();
            if (!$user) {
                return response()->json(['message' => 'Anda harus login terlebih dahulu'], 401);
            }

            // Pengecekan Role
            // $setting_roles = SettingRoles::where('users_id', $user->id)->pluck('roles_id');
            // if ($setting_roles->isEmpty()) {
            //     return response()->json(['message' => 'Role tidak ditemukan'], 404);
            // }

            // Pengecekan Device
            $device = Device::find($id);
            if (!$device) {
                return response()->json(['message' => 'Device tidak ditemukan'], 404);
            }

            // Pengecekan Akses
            $akses = AksesRoles::whereIn('roles_id', $user->roles_id)
                ->where('ruangan_id', $device->ruangan_id)
                ->first();

            if (!$akses) {
                return response()->json([
                    'message' => 'Akses tidak diterima',
                    // 'akses_data' => 'Tidak ada akses yang ditemukan untuk ruangan ini'
                ], 403);
            }

            // Update status device
            $device->update(['status' => $request->status]);

            // Temukan entri terakhir di History untuk device ini
            $lastDevice = History::where('device_id', $device->id)->latest()->first();

            $time = 0;
            $harga = 0;
            $hargaMenit = 0;

            if ($lastDevice) {
                $time = $lastDevice->created_at->diffInMinutes(Carbon::now());

                // Hitung harga berdasarkan watt device dan waktu
                $hargaMenit = $device->watt / 1000 / 60 * $time;

                // Ambil data perusahaan
                $perusahaan = Perusahaan::find($request->perusahaan_id);
                $harga = $hargaMenit * $perusahaan->harga_kwh;
            }

            // Buat deskripsi dengan informasi waktu update dan waktu masuk ke dalam history
            $deskripsi = "Waktu update: " . Carbon::now()->toDateTimeString() . ", Waktu masuk history: " . Carbon::now()->toDateTimeString();

            // Buat entri baru di History
            $history = History::create([
                'users_id' => $user->id,
                'device_id' => $device->id,
                'status' => $request->status,
                'waktu' => $time,
                'harga' => $harga,
                'deskripsi' => $deskripsi,
            ]);

            $response = [
                'success' => true,
                'message' => 'Status berhasil diupdate',
                'time' => $time,
                'harga_menit' => $hargaMenit,
                'harga' => $harga,
                'data' => $device,
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
    public function updateStatusLampuESP(Request $request)
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

            //    $index = 0;
            // if ( $device->status == 0) {
            //     $index = 1;
            // } else {
            //     $index = 0;
            // }
            // Update status device
            $device->update(['status' => $request->status]);

            // Temukan entri terakhir di History untuk device ini
            $lastDevice = History::where('device_id', $device->id)->latest()->first();

            $time = 0;
            $harga = 0;
            $hargaMenit = 0;

            if ($lastDevice) {
                $time = $lastDevice->created_at->diffInMinutes(Carbon::now());

                // Hitung harga berdasarkan watt device dan waktu
                $hargaMenit = $device->watt / 1000 / 60 * $time;

                // Ambil data perusahaan
                if (isset($device->ruangan->perusahaan_id)) {
                    $perusahaan = Perusahaan::find($device->ruangan->perusahaan_id);
                    $harga = $hargaMenit * $perusahaan->harga_kwh;
                } else {
                    $perusahaan = DB::table('device')
                        ->where('device.id', $device->id)
                        ->join('ruangan', 'ruangan.id', '=', 'device.ruangan_id')
                        ->join('lantai', 'lantai.id', '=', 'ruangan.lantai_id')
                        ->join('gedung', 'gedung.id', '=', 'lantai.gedung_id')
                        ->join('perusahaan', 'perusahaan.id', '=', 'gedung.perusahaan_id')
                        ->select('perusahaan.*')
                        ->first();
                    $harga = $hargaMenit * $perusahaan->harga_kwh;
                }
            }

            // Buat deskripsi dengan informasi waktu update dan waktu masuk ke dalam history
            $deskripsi = "ESP -> Waktu update: " . Carbon::now()->toDateTimeString() . ", Waktu masuk history: " . Carbon::now()->toDateTimeString();

            // Buat entri baru di History
            $history = History::create([
                // 'users_id' => $user->id,
                'device_id' => $device->id,
                'status' => $request->status,
                'waktu' => $time,
                'harga' => $harga,
                'deskripsi' => $deskripsi,
            ]);

            $response = [
                'success' => true,
                'message' => 'Status berhasil diupdate',
                'time' => $time,
                'harga_menit' => $hargaMenit,
                'harga' => $harga,
                'data' => $device,
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
    public function updateQrLampuESP(Request $request)
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
            $device->update(['qr_code' => $request->status]);

            // Temukan entri terakhir di History untuk device ini

            $response = [
                'success' => true,
                'message' => 'ok',
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
    public function updateQrLampuKipas(Request $request)
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'mac_address' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $user = $request->user();
            if (!$user) {
                return response()->json(['message' => 'Anda harus login terlebih dahulu'], 401);
            }

            // Pengecekan Role
            // $setting_roles = SettingRoles::where('users_id', $user->id)->pluck('roles_id');
            // if ($setting_roles->isEmpty()) {
            //     return response()->json(['message' => 'Role tidak ditemukan'], 404);
            // }

            // Pengecekan Device
            $device = Device::where('mac_address', $request->mac_address)->first();
            if (!$device) {
                return response()->json(['message' => 'Device tidak ditemukan'], 404);
            }

            // Pengecekan Akses
            $akses = AksesRoles::whereIn('roles_id', $user->roles_id)
                ->where('ruangan_id', $device->ruangan_id)
                ->first();

            if (!$akses) {
                return response()->json([
                    'message' => 'Akses tidak diterima',
                    // 'akses_data' => 'Tidak ada akses yang ditemukan untuk ruangan ini'
                ], 403);
            }
            // Temukan device berdasarkan id

            $index = 0;
            if ($device->qr_code == 0) {
                $index = 1;
            } else {
                $index = 0;
            }
            // Update status device
            $device->qr_code = $index;
            $device->save();

            // Temukan entri terakhir di History untuk device ini

            $response = [
                'success' => true,
                'message' => 'ok',
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

    public function updateSuhuRange(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'min_suhu' => 'required|nullable',
            'max_suhu' => 'required|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $device = Device::find($id);
        if (!$device) {
            return response()->json(['message' => 'Device tidak ditemukan'], 404);
        }

        $device->update([
            'min_suhu' => $request->min_suhu,
            'max_suhu' => $request->max_suhu,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Min dan Max Suhu berhasil diupdate',
            'data' => $device,
        ], 200);
    }

    public function getStatusDevice($macAddress)
    {
        // Cari perangkat berdasarkan MAC address
        $device = Device::where('mac_address', $macAddress)->first();

        // Jika perangkat ditemukan, kembalikan status lampu
        if ($device) {
            return response()->json($device->status);
        }

        // Jika perangkat tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Device tidak ditemukan'], 404);
    }
    public function getStatusQrCodeDevice($macAddress)
    {
        // Cari perangkat berdasarkan MAC address
        $device = Device::where('mac_address', $macAddress)->first();

        // Jika perangkat ditemukan, kembalikan status lampu
        if ($device) {
            return response()->json($device->qr_code);
        }

        // Jika perangkat tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Device tidak ditemukan'], 404);
    }

    public function cekRfid(Request $request)
    {
        $request->validate([
            'uid' => 'required|string',
            'mac_address' => 'required|string',
        ]);

        $uid = $request->input('uid');

        // Pengecekan Rfid
        $rfid = Rfid::where('rfid', $uid)->first();
        if ($rfid == null) {
            return response()->json(['message' => 'Rfid tidak ditemukan'], 404);
        }

        // Pengecekan User
        $user = User::find($rfid->users_id);
        if ($user == null) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        // Pengecekan Role
        // $setting_roles = SettingRoles::where('users_id', $user->id)->pluck('roles_id');
        // if ($setting_roles->isEmpty()) {
        //     return response()->json(['message' => 'Role tidak ditemukan'], 404);
        // }

        // Pengecekan Device
        $device = Device::where('mac_address', $request->mac_address)->first();
        if ($device == null) {
            return response()->json(['message' => 'Device tidak ditemukan'], 404);
        }

        // Pengecekan Akses
        $akses = AksesRoles::whereIn('roles_id', $user->roles_id)
            ->where('ruangan_id', $device->ruangan_id)
            ->first();

        if (!$akses) {
            return response()->json([
                'message' => 'Akses Ditolak',
                // 'akses_data' => 'Tidak ada akses yang ditemukan untuk ruangan ini'
            ], 403);
        }

        // Deskripsi
        $deskripsi = "Waktu update: " . Carbon::now()->toDateTimeString() . ", Waktu masuk history: " . Carbon::now()->toDateTimeString();

        // Membuat History
        $history = History::create([
            'users_id' => $user->id,
            'device_id' => $device->id,
            'status' => 1,
            'waktu' => 0,
            'harga' => 0,
            'deskripsi' => $deskripsi,
        ]);

        return response()->json([
            'message' => 'Akses diterima',
        ]);
    }

    public function updateRuangan(Request $request, $id)
    {
        try {

            $device = Device::find($id);
            $device->update(['ruangan_id' => $request->ruangan_id]);
            $device->save();
            return response()->json([
                'message' => 'Ruangan berhasil diupdate',
                'data' => $device,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Ruangan gagal diupdate'], 500);
        }
    }

    public function getMacAddress(Request $macAddress)
    {
        try {
            $device = Device::where('mac_address', $macAddress->mac_address)->with('jenis_device')->first();
            $response = [
                'success' => true,
                'data' => $device,
                'message' => 'Data Mac Address tersedia',
            ];
            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Data Mac Address tidak tersedia',
            ];
            return response()->json($response, 500);
        }
    }

    public function destroy($id)
    {}

    public function get_status_ac()
    {
        // Cari perangkat berdasarkan MAC address
        $kode = KodeKontrol::where('Alias', 'hidup')->first();

        // Jika perangkat ditemukan, kembalikan status lampu
        if ($kode) {
            return response()->json($kode->kode);
        }

        // Jika perangkat tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'kode tidak ditemukan'], 404);
    }

    public function logindevice(Request $macAddress)
    {
        try {
            $device = Device::where('mac_address', $macAddress->mac_address)->first();

            $token = $device->createToken('auth_token')->plainTextToken;
            $response = $token;
            return response()->json($response, 200);
        } catch (Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Data Mac Address tidak tersedia',
            ];
            return response()->json($response, 500);
        }
    }
}
