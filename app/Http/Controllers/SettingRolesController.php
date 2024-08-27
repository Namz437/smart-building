<?php

namespace App\Http\Controllers;

use App\Models\AksesRoles;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingRolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Roles::all();
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Roles::all();
        return view('roles.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_role' => 'required|string|max:255|unique:roles',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Buat role baru
        $role = Roles::create([
            'nama_role' => $request->get('nama_role'),
        ]);
    
        // Buat akses role otomatis setelah role ditambahkan dengan ruangan_id kosong
        AksesRoles::create([
            'roles_id' => $role->id,
            'ruangan_id' => '', // atau sesuai dengan format default kosong
        ]);
    
        return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $roles = Roles::find($id);
        return view('roles.edit', compact('roles'));
    }


    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_role' => 'required|string|max:255',
        ]);

        if (empty($validator)) {
            return view('roles.index')->with('error', 'Role tidak ditemukan');
        }
        $roles = Roles::find($id);
        $roles->nama_role = $request->get('nama_role');
        $roles->save();
        return redirect()->route('roles.index')->with('success', 'Role berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $roles = Roles::find($id);
        $roles->delete();
        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus');
    }
}
