<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\SettingRoles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Setting_RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting_roles = SettingRoles::with(['users', 'roles'])->get();
        $users = User::all();
        $roles = Roles::all();
        return view('settingroles.index', compact('setting_roles', 'users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $setting_roles = SettingRoles::with(['users', 'roles'])->get();
        $users = User::all();
        $roles = Roles::all();
        return view('settingroles.create', compact('setting_roles', 'users', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'users_id' => 'required',
            'roles_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        SettingRoles::create($request->all());

        return redirect()->route('settingroles.index')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $setting_roles = SettingRoles::with(['users', 'roles'])->find($id);

        if (empty($setting_roles)) {
            return redirect()->route('settingroles.index')->with('error', 'Data Tidak Ditemukan');
        }

        $users = User::all();
        $roles = Roles::all();

        // Debugging
        // dd($setting_roles);

        return view('settingroles.edit', compact('setting_roles', 'users', 'roles'));
    }


    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'users_id' => 'required',
            'roles_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $setting_roles = SettingRoles::find($id);

        if (empty($setting_roles)) {
            return redirect()->route('settingroles.index')->with('error', 'Data Tidak Ditemukan');
        }

        $setting_roles->update($request->all());

        return redirect()->route('settingroles.index')->with('success', 'Data Berhasil Diupdate');
    }


    public function destroy(string $id)
    {
        $setting_roles = SettingRoles::find($id);
        $setting_roles->delete();

        return redirect()->route('settingroles.index')->with('success', 'Data Berhasil Dihapus');
    }
}
