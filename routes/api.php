<?php

use App\Http\Controllers\Api\AksesRolesController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryDeviceController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\GedungController;
use App\Http\Controllers\Api\JenisDeviceController;
use App\Http\Controllers\Api\KodeKontrolController;
use App\Http\Controllers\Api\LantaiController;
use App\Http\Controllers\Api\MerkController;
use App\Http\Controllers\Api\PerusahaanController;
use App\Http\Controllers\Api\RfidController;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\RuanganController;
use App\Http\Controllers\Api\SettingKodeKontrolController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\EspController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Cek User
// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/user', [UsersController::class, 'index']);
// });

// Yang belum login
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::resource('users', UsersController::class);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    // Route::post('change_password', [AuthController::class, 'change_password']);
    Route::post('device/updateSuhu', [DeviceController::class, 'updateSuhu']);
    Route::get('device/{id}', [DeviceController::class, 'show']);
    Route::get('device/{mac_address}/mac_address', [DeviceController::class, 'getMacAddress']);
    Route::post('device/{id}/status', [DeviceController::class, 'updateStatus']);
    Route::get('perusahaan/{id}', [PerusahaanController::class, 'show']);
    Route::get('perusahaan', [PerusahaanController::class, 'index']);
    Route::get('perusahaan_pemagang/{id}', [PerusahaanController::class, 'show_pemagang']);
    Route::post('device/{id}/status', [DeviceController::class, 'updateStatus']);
    Route::post('device/{id}/statusQr', [DeviceController::class, 'updateStatusQr']);
    Route::post('device/update_qr_code', [DeviceController::class, 'updateQrCode']);
    Route::post('device/update_status_lampu_kipas', [DeviceController::class, 'updateQrLampuKipas']);
    Route::post('device/esp_update_status_lampu', [DeviceController::class, 'updateStatusLampuESP']);
    Route::post('device/esp_update_qr_lampu', [DeviceController::class, 'updateQrLampuESP']);
    Route::post('device/{id}/suhurange', [DeviceController::class, 'updateSuhuRange']);
    Route::post('device_cekrfid_mac_address', [DeviceController::class, 'cekRfid']);
    Route::post('/ruangan/search', [RuanganController::class, 'search']);
    Route::get('/ruangan', [RuanganController::class, 'index']);
    Route::get('/favorite/{users_id}/{ruangan_id}', [FavoriteController::class, 'show']);
    Route::delete('/favorite/{users_id}/{ruangan_id}', [FavoriteController::class, 'destroy']);
    Route::post('favorite', [FavoriteController::class, 'store']);
    Route::get('favorite/{users_id}', [FavoriteController::class, 'index']);
    Route::post('setting_kode_kontrol', [SettingKodeKontrolController::class, 'store']);
    Route::get('setting_kode_kontrol/{device_id}', [SettingKodeKontrolController::class, 'show']);
});

Route::group(['middleware' => 'auth:sanctum', 'isAdmin', 'prefix' => 'admin'], function () {
    Route::post('setting_kode_kontrol', [SettingKodeKontrolController::class, 'store']);
    Route::get('setting_kode_kontrol/{mac_address}/mac_address', [SettingKodeKontrolController::class, 'cek_on_off_ac']);
    Route::get('setting_kode_kontrol/{mac_address}/current_kode', [SettingKodeKontrolController::class, 'cek_current_kode']);
    Route::post('device/{id}/status', [DeviceController::class, 'updateStatus']);
    Route::post('device/{id}/suhurange', [DeviceController::class, 'updateSuhuRange']);
    Route::post('device/{id}/ruangan', [DeviceController::class, 'updateRuangan']);
    Route::get('device/{mac_address}/mac_address', [DeviceController::class, 'getMacAddress']);

    // Route::resource('setting_roles', SettingRolesController::class);
    Route::resource('perusahaan', PerusahaanController::class);
    Route::resource('gedung', GedungController::class);
    Route::resource('rfid', RfidController::class);
    Route::resource('category_device', CategoryDeviceController::class);
    Route::resource('lantai', LantaiController::class);
    Route::resource('/ruangan', RuanganController::class);
    Route::resource('jenis_device', JenisDeviceController::class);
    Route::resource('merk', MerkController::class);
    Route::resource('kode_kontrol', KodeKontrolController::class);
    Route::resource('setting_kode_kontrol', SettingKodeKontrolController::class);
    Route::resource('device', DeviceController::class);
    Route::resource('roles', RolesController::class);
    Route::resource('akses_roles', AksesRolesController::class);
});
// Login device
Route::post('logindevice/{mac_address}', [EspController::class, 'logindevice']);

// Khusus untuk esp
Route::prefix('esp')->group(function () {
    // Untuk esp kirim status pintu ke 2
    Route::post('update_status_pintu', [EspController::class, 'espstatuspintu']);
    // Untuk dikirim ke ESP 32 kirim rfid yang akses pintu apa aja
    Route::get('rfid/{mac_address}', [EspController::class, 'accessallrfid']);
    // Untuk cek status device
    Route::get('status_device/{mac_address}', [DeviceController::class, 'getStatusDevice']);
    // Untuk cek status device lampu
    Route::get('status_qr_device/{mac_address}', [DeviceController::class, 'getStatusQrCodeDevice']);
    // cek status device fan
    Route::get('status_qr_device_fan/{mac_address}', [DeviceController::class, 'getStatusQrCodeDeviceFan']);
    // Cek suhu device
    Route::get('device_esp_fan_get_min_max_suhu/{mac_address}', [DeviceController::class, 'esp_get_min_max_suhu']);
    Route::get('setting_kode_kontrol/{mac_address}/mac_address', [SettingKodeKontrolController::class, 'cek_on_off_ac']);
    Route::get('setting_kode_kontrol/{mac_address}/current_kode', [SettingKodeKontrolController::class, 'cek_current_kode']);

    // Untuk pin
    Route::get('getpin/{mac_address}', [EspController::class, 'getpin']);
});

//test
Route::get('status_ac', [DeviceController::class, 'get_status_ac']);

// Untuk reset password by id
Route::post('/user/reset-password/{id}', [UsersController::class, 'resetPassword']);
// Untuk change password by id
Route::post('users/{id}/change_password', [AuthController::class, 'changePasswordById']);
// Untuk cek apakah dia sudah change password apa belum untuk frontend
Route::get('/user/{id}/password-changed', [UsersController::class, 'isPasswordChanged']);
