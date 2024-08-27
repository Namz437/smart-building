<?php

namespace App\Http\Controllers;

use App\Models\AksesRoles;
use App\Models\Roles;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingAksesRolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $akses_roles = AksesRoles::with(['roles', 'ruangan'])->get();
        $roles = Roles::all();
        $ruangans = Ruangan::all();
        return view('settingaksesroles.index', compact('akses_roles', 'roles', 'ruangans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $akses_roles = AksesRoles::with(['roles', 'ruangan'])->get();
        $roles = Roles::all();
        $ruangans = Ruangan::all();

        return view('settingaksesroles.create', compact('akses_roles', 'roles', 'ruangans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'roles_id' => 'required|exists:roles,id',
            'ruangan_id' => 'required|array',
            'ruangan_id.*' => 'exists:ruangan,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cek apakah AksesRoles dengan roles_id tersebut sudah ada
        $akses_roles = AksesRoles::where('roles_id', $request->roles_id)->first();

        if ($akses_roles) {
            // Jika sudah ada, gabungkan ruangan_id lama dengan yang baru tanpa duplikasi
            $existing_ruangan_ids = array_map('trim', explode(',', trim($akses_roles->ruangan_id, '[]')));
            $new_ruangan_ids = $request->ruangan_id;

            // Menggabungkan dan menghilangkan duplikasi
            $merged_ruangan_ids = array_unique(array_merge($existing_ruangan_ids, $new_ruangan_ids));

            // Simpan kembali dalam format yang sesuai
            $akses_roles->ruangan_id = '[' . implode(',', $merged_ruangan_ids) . ']';
            $akses_roles->save();

            $message = 'Data berhasil diperbarui';
        } else {
            // Jika belum ada, buat entri baru
            $akses_roles = new AksesRoles();
            $akses_roles->roles_id = $request->roles_id;
            $akses_roles->ruangan_id = '[' . implode(',', $request->ruangan_id) . ']';
            $akses_roles->save();

            $message = 'Data berhasil ditambahkan';
        }

        return redirect()->route('settingaksesroles.index')->with('success', $message);
    }

    public function edit(string $id)
    {
        $akses_roles = AksesRoles::with(['roles', 'ruangan'])->find($id);
        $roles = Roles::all();
        $ruangans = Ruangan::all();
        return view('settingaksesroles.edit', compact('akses_roles', 'roles', 'ruangans'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'roles_id' => 'required',
            'ruangan_id' => 'required|array', // array
            'ruangan_id.*' => 'exists:ruangan,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $akses_roles = AksesRoles::find($id);
        $akses_roles->roles_id = $request->roles_id;
        $akses_roles->ruangan_id = '[' . implode(',', $request->ruangan_id) . ']';
        $akses_roles->save();

        return redirect()->route('settingaksesroles.index')->with('success', 'Data berhasil diubah');
    }

    public function destroy(string $id)
    {
        $akses_roles = AksesRoles::find($id);
        $akses_roles->delete();

        return redirect()->route('settingaksesroles.index')->with('success', 'Data berhasil dihapus');
    }
}
