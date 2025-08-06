<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas; // Ensure you import the Kelas model
use App\Models\data;
use App\Models\DailyActivity;
use App\Models\DailyActivityitem;

class DailyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch all data from the 'data' table
        $data = data::all(); // Use pagination for better performance
        $kelas = Kelas::all(); // Fetch all classes
        // Return a view with the data
        return view('admin.dailyactivity.index', compact('data', 'kelas'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $daily = DailyActivity::create([
        'tanggal' => $request->tanggal,
    ]);

    $kategoriKeys = ['pribadi', 'mencari_leads', 'memprospek', 'closing', 'merawat_customer'];

    foreach ($kategoriKeys as $kategori) {
        if ($request->has($kategori)) {
            foreach ($request->$kategori as $item) {
                DailyActivityitem::create([
                    'daily_activity_id' => $daily->id,
                    'kategori' => $kategori,
                    'aktivitas' => $item['aktivitas'] ?? null,
                    'deskripsi' => $item['deskripsi'] ?? null,
                    'target' => $item['target'] ?? null,
                    'real' => $item['real'] ?? null,
                ]);
            }
        }
    }

    return redirect()->back()->with('success', 'Aktivitas harian berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
