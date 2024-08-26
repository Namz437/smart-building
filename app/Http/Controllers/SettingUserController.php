<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SettingUserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('settingusers.index', compact('users'));
    }

    public function create()
    {
        $users = User::all();
        return view('settingusers.create', compact('users'));
    }

    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'no_id' => 'required|integer|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (empty($validator)) {
            return redirect()->route('settingusers.index')->with('error', 'User tidak ditemukan');
        }

        $users = User::create([
            'no_id' => request('no_id'),
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
        ]);
        return redirect()->route('settingusers.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $users = User::where('id', $id)->first();
        return view('settingusers.edit', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(request()->all(), [
            'no_id' => 'required|integer|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (empty($validator)) {
            return redirect()->route('settingusers.index')->with('error', 'User tidak ditemukan');
        }

        $users = User::where('id', $id)->update([
            'no_id' => request('no_id'),
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
        ]);
        return redirect()->route('settingusers.index')->with('success', 'User berhasil diupdate');
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
    
        // Reset password to the generated random value
        $user->password = bcrypt($newPassword);
        $user->save();
    
        return redirect()->route('settingusers.index')->with('success', 'Password untuk user ' . $user->name . ' berhasil direset ke "' . $newPassword . '"');
    }

}
