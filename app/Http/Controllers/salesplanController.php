<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\salesplan; // Ensure you import the Salesplan model
use App\Models\data; // Ensure you import the Data model
use Illuminate\Support\Facades\DB;
use App\Models\Kelas; // Ensure you import the Kelas model
use Rap2hpoutre\FastExcel\FastExcel;


class salesplanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kelasFilter = $request->input('kelas'); // berisi nama kelas dari parameter URL

        $salesplans = SalesPlan::with(['data.kelas']) // eager load nested relation
            ->when($kelasFilter, function ($query) use ($kelasFilter) {
                $query->whereHas('data.kelas', function ($subQuery) use ($kelasFilter) {
                    $subQuery->where('nama_kelas', $kelasFilter); // filter by nama_kelas dari tabel kelas
                });
            })
            ->get();

        $kelasList = Kelas::all(); // untuk daftar di sidebar
        if ($salesplans->count() === 0) {
            return view('admin.salesplan.index', [
                'salesplans' => $salesplans,
                'kelasList' => $kelasList,
                'kelasFilter' => $kelasFilter,
                'message' => 'Data tidak ditemukan untuk kelas yang dipilih.'
            ]);
        }


        return view('admin.salesplan.index', compact('salesplans', 'kelasList', 'kelasFilter'));
    }

    public function export()
    {
        $sales = SalesPlan::all();

        return (new FastExcel($sales))->download('sales_plan.xlsx');
    }


    public function show($id) {}

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
        $salesplan = SalesPlan::findOrFail($id);

        for ($i = 1; $i <= 5; $i++) {
            $salesplan->{'fu' . $i . '_hasil'} = $request->input('fu' . $i . '_hasil');
            $salesplan->{'fu' . $i . '_tindak_lanjut'} = $request->input('fu' . $i . '_tindak_lanjut');
        }

        $salesplan->keterangan = $request->input('keterangan');
        $salesplan->status = $request->input('status');
        $salesplan->nominal = $request->input('nominal');
        $salesplan->save();

        return redirect()->route('admin.salesplan.index')->with('success', 'Sales plan berhasil diperbarui.');
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
