<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\History;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Buat ngambil 50 data baru
        $historys = History::with('users', 'device')
            ->orderBy('created_at', 'desc') // ngurutin data create masuknya, dengan descending
            ->limit(50) // di limitkan 50 data history
            ->get();
        $users = User::all();
        $device = Device::all();

        return view('history.index', compact('historys', 'users', 'device'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
