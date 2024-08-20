<?php

namespace App\Http\Controllers;

use App\Models\Rfid;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingRfidController extends Controller
{

    public function index()
    {
        $rfids = Rfid::with('users')->get();
        $users = User::all();
        return view('settingrfid.index', compact('rfids', 'users'));
    }


    public function create()
    {
        $rfids = Rfid::with('users')->get();
        $users = User::all();
        return view('settingrfid.create', compact('rfids', 'users'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'users_id' => 'required',
            'rfid' => 'required',
        ]);

        if (empty($validator)) {
            return redirect()->route('settingrfid.index')->with('error', 'Rfid tidak ditemukan');
        }

        $rfid = new Rfid();
        $rfid->users_id = $request->users_id;
        $rfid->rfid = $request->rfid;
        $rfid->save();

        return redirect()->route('settingrfid.index')->with('success', 'Rfid berhasil ditambahkan');
    }


    public function edit(string $id)
    {
        $rfids = Rfid::with('users')->find($id);
        $users = User::all();
        return view('settingrfid.edit', compact('rfids', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'users_id' => 'required',
            'rfid' => 'required',
        ]);

        if (empty($validator)) {
            return redirect()->route('settingrfid.index')->with('error', 'Rfid tidak ditemukan');
        }

        $rfid = Rfid::find($id);
        $rfid->users_id = $request->users_id;
        $rfid->rfid = $request->rfid;
        $rfid->save();

        return redirect()->route('settingrfid.index')->with('success', 'Rfid berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rfids = Rfid::find($id);
        $rfids->delete();
        return redirect()->route('settingrfid.index')->with('success', 'Rfid Berhasil Dihapus');
    }
}
