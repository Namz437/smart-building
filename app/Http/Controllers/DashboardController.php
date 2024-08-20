<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Lantai;
use App\Models\Perusahaan;
use App\Models\Ruangan;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        $company = Perusahaan::all();
        $users = User::all();

        // Chart counting data
        $user = User::all()->count();
        $perusahaan = Perusahaan::all()->count();
        $device = Device::all()->count();

        return view('/dashboard', [
            'company' => $company,
            'users' => $users,
            // Chart counting data views
            'totalUser' => $user,
            'totalPerusahaan' => $perusahaan,
            'totalDevice' => $device
        ]);
    }
}
