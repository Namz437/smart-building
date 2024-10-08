<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SettingUserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Roles::all();
        $perusahaans = Perusahaan::all();
        return view('settingusers.index', compact('users', 'roles', 'perusahaans'));
    }

    public function create()
    {
        $users = User::all();
        $roles = Roles::all();
        $perusahaans = Perusahaan::all();
        return view('settingusers.create', compact('users', 'roles', 'perusahaans'));
    }

    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'no_id' => 'required|integer|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'roles_id' => 'required',
            'rfid' => 'required',
            'perusahaan_id' => 'required',
        ]);

        if (empty($validator)) {
            return redirect()->route('settingusers.index')->with('error', 'User tidak ditemukan');
        }

        $users = User::create([
            'no_id' => request('no_id'),
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'roles_id' => request('roles_id'),
            'rfid' => request('rfid'),
            'perusahaan_id' => request('perusahaan_id'),
        ]);
        return redirect()->route('settingusers.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $users = User::where('id', $id)->first();
        $roles = Roles::all();
        $perusahaans = Perusahaan::all();
        return view('settingusers.edit', compact('users', 'roles', 'perusahaans'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(request()->all(), [
            'no_id' => 'required|integer|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            // 'password' => 'required|string|min:6|confirmed',
            'roles_id' => 'required',
            'rfid' => 'required',
            'perusahaan_id' => 'required',
        ]);

        if (empty($validator)) {
            return redirect()->route('settingusers.index')->with('error', 'User tidak ditemukan');
        }

        // Ambil data user yang akan diupdate
        $user = User::find($id);

        $users = User::where('id', $id)->update([
            'no_id' => request('no_id'),
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('no_id')),
            'roles_id' => request('roles_id'),
            'rfid' => request('rfid'),
            'perusahaan_id' => request('perusahaan_id'),
        ]);

        // Redirect dengan pesan sukses yang menyertakan nama
        return redirect()->route('settingusers.index')->with('success', 'User ' . $user->name . ' berhasil diupdate');
    }

    public function destroy($id)
    {
        $users = User::find($id);
        $users->delete();
        return redirect()->route('settingusers.index')->with('success', 'User berhasil dihapus');
    }

    public function resetPassword($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('settingusers.index')->with('error', 'User tidak ditemukan');
        }

        // Generate a random password
        $newPassword = Str::random(12); // You can adjust the length as needed

        // Hash the new password
        $hashedPassword = bcrypt($newPassword);

        // Reset password to the generated random value
        $user->password = $hashedPassword;

        // Store the hashed password in a separate column for future checks
        $user->reset_password_hash = $hashedPassword;

        // Set flag indicating the password has been reset
        $user->is_password_reset = true;

        $user->save();

        return redirect()->route('settingusers.index')->with('success', 'Password untuk user ' . $user->name . ' berhasil direset ke "' . $newPassword . '"');
    }
}
