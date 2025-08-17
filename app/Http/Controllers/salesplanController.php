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
        $kelasFilter = $request->input('kelas'); // nama kelas dari URL
        $userId      = auth()->id();

        $salesplans = SalesPlan::with('kelas')
            ->when($kelasFilter, function ($query) use ($kelasFilter) {
                $query->whereHas('kelas', function ($subQuery) use ($kelasFilter) {
                    $subQuery->where('nama_kelas', $kelasFilter);
                });
            })
            ->when($userId !== 1, function ($query) use ($userId) {
                // kalau bukan admin, hanya data yang dia input
                $query->where('created_by', $userId);
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
    // app/Http/Controllers/SalesPlanController.php
    public function filter($kelas)
    {
        // Ambil semua kelas untuk ditampilkan di sidebar
        $listKelas = Kelas::all();

        // Ambil data sales plan sesuai kelas
        $salesPlans = SalesPlan::where('kelas_nama', $kelas)->get();

        return view('admin.salesplan.index', compact('salesPlans', 'listKelas', 'kelas'));
    }


    public function inlineUpdate(Request $request)
    {
        $plan = SalesPlan::findOrFail($request->id);

        $field = $request->field;
        $value = $request->value;

        // keamanan: hanya boleh update kolom tertentu
        $allowedFields = [
            'fu1_hasil',
            'fu1_tindak_lanjut',
            'fu2_hasil',
            'fu2_tindak_lanjut',
            'fu3_hasil',
            'fu3_tindak_lanjut',
            'fu4_hasil',
            'fu4_tindak_lanjut',
            'fu5_hasil',
            'fu5_tindak_lanjut',
            'nominal',
            'keterangan'
        ];

        if (!in_array($field, $allowedFields)) {
            return response()->json(['error' => 'Field tidak diizinkan'], 400);
        }

        $plan->$field = $value;
        $plan->save();

        return response()->json(['success' => true, 'message' => 'Data berhasil diupdate']);
    }

    public function updateStatus(Request $request, $id)
    {
        $plan = salesPlan::findOrFail($id);
        $plan->status = $request->status;
        $plan->save();

        return response()->json(['success' => true, 'status' => $plan->status]);
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
        $plan = SalesPlan::findOrFail($id);

        // Kirim data ke view edit
        return view('admin.salesplan.edit', compact('plan'));
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
