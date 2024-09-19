<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Perusahaan::all();
            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Data tersedia',
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Data tidak tersedia',
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi Rules
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required',
            'lokasi' => 'required',
            'image' => 'required',
            'kwh' => 'required',
            'harga_kwh' => 'required',
        ]);

        // Cek validasi jika validasi diatas gagal
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Simpan image
        // $file = $request->file('image');
        // $path = $file->store('images', 'public');
        // $url = Storage::url($path);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->storeAs('images', $file->hashName(), 'public');
        }

        // Buat Perusahaan
        $perusahaan = Perusahaan::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'kwh' => $request->kwh,
            'harga_kwh' => $request->harga_kwh,
            'image' => $path,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Perusahaan berhasil ditambahkan',
            'data' => $perusahaan,
        ]);

        // Response jika gagal
        return response()->json([
            'success' => false,
            'message' => 'Perusahaan gagal ditambahkan',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $history1 = DB::table('perusahaan')
                ->where('perusahaan.id', $id)
                ->join('gedung', 'perusahaan.id', '=', 'gedung.perusahaan_id')
                ->join('lantai', 'gedung.id', '=', 'lantai.gedung_id')
                ->join('ruangan', 'lantai.id', '=', 'ruangan.lantai_id')
                ->join('device', 'ruangan.id', '=', 'device.ruangan_id')
                ->join('history', 'device.id', '=', 'history.device_id')
                ->where('history.created_at', '>=', Carbon::now()->subMonths(6))
                ->where('history.status', 0)
                ->select(
                    DB::raw('YEAR(history.created_at) as year'),
                    DB::raw('MONTH(history.created_at) as month'),
                    DB::raw('SUM(history.harga) as total_harga'),
                    DB::raw('SUM(history.waktu) as total_waktu'),
                    DB::raw('COUNT(DISTINCT history.id) as jumlah_entri') // Count distinct history entries
                )
                ->groupBy(DB::raw('YEAR(history.created_at), MONTH(history.created_at)'));

            $history2 = DB::table('perusahaan')
                ->where('perusahaan.id', $id)
                ->join('ruangan', 'perusahaan.id', '=', 'ruangan.perusahaan_id')
                ->join('device', 'ruangan.id', '=', 'device.ruangan_id')
                ->join('history', 'device.id', '=', 'history.device_id')
                ->where('history.created_at', '>=', Carbon::now()->subMonths(6))
                ->where('history.status', 0)
                ->select(
                    DB::raw('YEAR(history.created_at) as year'),
                    DB::raw('MONTH(history.created_at) as month'),
                    DB::raw('SUM(history.harga) as total_harga'),
                    DB::raw('SUM(history.waktu) as total_waktu'),
                    DB::raw('COUNT(DISTINCT history.id) as jumlah_entri') // Count distinct history entries
                )
                ->groupBy(DB::raw('YEAR(history.created_at), MONTH(history.created_at)'));

            $unionQuery = DB::table(DB::raw("({$history1->toSql()} UNION ALL {$history2->toSql()}) as combined"))
                ->mergeBindings($history1)
                ->mergeBindings($history2)
                ->selectRaw('year, month, SUM(total_harga) as total_harga, SUM(total_waktu) as total_waktu, SUM(jumlah_entri) as jumlah_entri')
                ->groupBy('year', 'month')
                ->get();

            $data = Perusahaan::where('id', $id)
                ->with([
                    'gedung.lantai.ruangan.devices.jenis_device',
                    'gedung.lantai.ruangan.devices.history' => function ($query) {
                        $query->whereDate('created_at', Carbon::today());
                    },
                    'gedung.lantai.ruangan.devices.merk.kodekontrol',
                    'ruangan.devices.jenis_device',
                    'ruangan.devices.history' => function ($query) {
                        $query->whereDate('created_at', Carbon::today());
                    },
                    'ruangan.devices.merk.kodekontrol',

                ])
                ->first();

            $data['chart_data'] = $unionQuery;

            if (!$data) {
                throw new Exception('Data not found');
            }

            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Data perusahaan tersedia',
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Data perusahaan tidak tersedia',
            ];
            return response()->json($response, 500);
        }
    }
    public function show_pemagang($id)
    {
        try {

            $data1 = DB::table('device')
                ->join('ruangan', 'ruangan.id', '=', 'device.ruangan_id')
                ->join('lantai', 'lantai.id', '=', 'ruangan.lantai_id')
                ->join('gedung', 'gedung.id', '=', 'lantai.gedung_id')
                ->join('perusahaan', 'perusahaan.id', '=', 'gedung.perusahaan_id')
                ->where('perusahaan.id', $id)
                ->where('device.jenis_device_id', 1)
                ->select(
                    'device.*', 'ruangan.nama_ruangan', 'lantai.nama as nama_lantai', 'gedung.nama_gedung', 'perusahaan.nama as nama_perusahaan', 'perusahaan.id as perusahaan_id'
                )->get();
            $data2 = DB::table('device')
                ->join('ruangan', 'ruangan.id', '=', 'device.ruangan_id')
                ->join('perusahaan', 'perusahaan.id', '=', 'ruangan.perusahaan_id')
                ->where('perusahaan.id', $id)
                ->where('device.jenis_device_id', 1)
                ->select(
                    'device.*', 'ruangan.nama_ruangan', 'perusahaan.nama as nama_perusahaan', 'perusahaan.id as perusahaan_id'
                )->get();
            $data = $data1->merge($data2);

            if (!$data) {
                throw new Exception('Data not found');
            }

            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Data perusahaan tersedia',
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Data perusahaan tidak tersedia',
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'deskripsi' => 'required',
                'lokasi' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'kwh' => 'required',
                'harga_kwh' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors());
            }

            $url = null;
            if ($request->image != null) {
                $n = str_replace(' ', '-', $request->image);

                $file = $request->file('image');
                $path = $file->store('images', 'public');
                $url = Storage::url($path);
            }

            $data = Perusahaan::find($id);
            $data->nama = $request->nama;
            $data->deskripsi = $request->deskripsi;
            $data->lokasi = $request->lokasi;
            $data->image = $url;
            $data->kwh = $request->kwh;
            $data->harga_kwh = $request->harga_kwh;

            $data->save();

            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Data perusahaan berhasil diubah',
            ];

            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Data perusahaan tidak berhasil diubah',
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perusahaan $perusahaan)
    {
        try {
            $perusahaan->delete();
            $response = [
                'success' => true,
                'message' => 'Data perusahaan berhasil dihapus',
            ];
            return response()->json($response, 200);
        } catch (Exception $th) {
            $response = [
                'success' => false,
                'message' => 'Data perusahaan tidak berhasil dihapus',
            ];
            return response()->json($response, 500);
        }
    }
}
