<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\salesplan; // Ensure you import the Salesplan model
use App\Models\data; // Ensure you import the Data model
use Illuminate\Support\Facades\DB;
use App\Models\Kelas; // Ensure you import the Kelas model
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;

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
            ->when(auth()->user()->email !== 'mbchamasah@gmail.com', function ($query) {
                // Filter berdasarkan nama user di kolom created_by
                $query->where('created_by', auth()->user()->name);
            })
            ->get();

        $kelasList = Kelas::all(); // untuk daftar di sidebar

        if ($salesplans->count() === 0) {
            return view('admin.salesplan.index', [
                'salesplans'  => $salesplans,
                'kelasList'   => $kelasList,
                'kelasFilter' => $kelasFilter,
                'message'     => 'Data tidak ditemukan untuk kelas yang dipilih.'
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

        $salesplan->keterangan = $request->input('keterangan');
        $salesplan->status = $request->input('status');
        $salesplan->nominal = $request->input('nominal');
        $salesplan->tanggal = Carbon::now()->format('Y-m-d'); // atau gunakan $request->input('tanggal') jika pakai input manual

        $salesplan->save();

        return redirect()->route('admin.salesplan.index')->with('success', 'Sales plan berhasil diperbarui.');
    }

    public function updateFU(Request $request, $id, $fu)
    {
        $plan = SalesPlan::findOrFail($id);

        // Pastikan FU hanya 1-5
        if ($fu < 1 || $fu > 5) {
            abort(404);
        }

        $plan->{'fu' . $fu . '_hasil'} = $request->input('fu' . $fu . '_hasil');
        $plan->{'fu' . $fu . '_tindak_lanjut'} = $request->input('fu' . $fu . '_tindak_lanjut');
        $plan->save();

        return back()->with('success', "FU{$fu} berhasil diperbarui.");
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
