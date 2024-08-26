<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Setting_RolesController;
use App\Http\Controllers\SettingAksesRolesController;
use App\Http\Controllers\SettingCategoryDeviceController;
use App\Http\Controllers\SettingDeviceController;
use App\Http\Controllers\SettingGedungController;
use App\Http\Controllers\SettingHistoryController;
use App\Http\Controllers\SettingJenisDeviceController;
use App\Http\Controllers\SettingKodeController;
use App\Http\Controllers\SettingKodeKontrolController as ControllersSettingKodeKontrolController;
use App\Http\Controllers\SettingLantaiController;
use App\Http\Controllers\SettingMerkController;
use App\Http\Controllers\SettingPerusahaanController;
use App\Http\Controllers\SettingRfidController;
use App\Http\Controllers\SettingRolesController as ControllersSettingRolesController;
use App\Http\Controllers\SettingRuanganController;
use App\Http\Controllers\SettingUserController;
use Illuminate\Support\Facades\Route;


// Rute login hanya bisa diakses oleh yang (belum login)
Route::get('/', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::post('prosesLogin', [AuthController::class, 'prosesLogin'])->name('proseslogin');


Route::get('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


Route::group(['middleware' => 'auth:sanctum', 'admin'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route Company Management
    Route::resource('/settingruangan', SettingRuanganController::class);
    Route::resource('/settingperusahaan', SettingPerusahaanController::class);
    Route::resource('/settinggedung', SettingGedungController::class);
    Route::resource('/settinglantai', SettingLantaiController::class);
    // End Route Company Managemnet

    // Route Users Management
    Route::resource('/settingusers', SettingUserController::class);
    Route::resource('/roles', ControllersSettingRolesController::class);
    Route::resource('/settingroles', Setting_RolesController::class);
    Route::resource('/settingaksesroles', SettingAksesRolesController::class);

    // Route Device Management
    Route::resource('/device', SettingDeviceController::class);
    Route::resource('/categorydevice', SettingCategoryDeviceController::class);
    Route::resource('/jenisdevice', SettingJenisDeviceController::class);
    Route::resource('/merk', SettingMerkController::class);
    Route::resource('/kodekontrol', SettingKodeController::class);
    Route::resource('/settingkodekontrol', ControllersSettingKodeKontrolController::class);
    Route::resource('/settingrfid', SettingRfidController::class);
    Route::resource('/history', SettingHistoryController::class);

    // Buat Reset Password User
    Route::get('/settingusers/{id}/resetpassword', [SettingUserController::class, 'resetPassword'])->name('settingusers.resetpassword');
    Route::put('/settingusers/{id}/updatepassword', [SettingUserController::class, 'updatePassword'])->name('settingusers.updatepassword');
    // End Buat Reset Password User

});
