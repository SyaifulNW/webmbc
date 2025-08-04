<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\salesplan; // Ensure you import the Salesplan model
use App\Models\data; // Ensure you import the Data model
use Illuminate\Support\Facades\DB;
use App\Models\Kelas; // Ensure you import the Kelas model


class salesplanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kelasFilter = $request->input('kelas'); // hindari override variabel $kelas

        $salesplans = SalesPlan::with('data')
            ->when($kelasFilter, function ($query) use ($kelasFilter) {
                $query->whereHas('data', function ($subQuery) use ($kelasFilter) {
                    $subQuery->where('kelas', $kelasFilter); // pastikan nama kolomnya benar
                });
            })
            ->get();

        $kelasList = Kelas::all(); // jika kamu ingin menampilkan daftar kelas di view

        return view('admin.salesplan.index', compact('salesplans', 'kelasList', 'kelasFilter'));
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
        //
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
