<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumni; // Ensure you import the Alumni model
use App\Models\data; // Ensure you import the data model
use Illuminate\Support\Facades\DB;
use App\Models\Kelas; // Ensure you import the Kelas model

class alumniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch all alumni data
        $alumni = Alumni::all(); // Use pagination for better performance if needed
        $kelas = Kelas::all(); // Fetch all classes for dropdowns or other purposes
        // Return a view with the alumni data
        return view('admin.alumni.alumni', compact('alumni', 'kelas'));
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
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Fetch the specific alumni record by ID
        $kelas = Kelas::all(); // Fetch all classes for dropdowns or other purposes
        $alumni = Alumni::findOrFail($id);
        // Return a view to show the alumni details
        return view('admin.alumni.show', compact('alumni', 'kelas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Fetch the specific alumni record by ID for editing

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

        $alumni = Alumni::findOrFail($id);

        // Daftar tetap semua kelas MBC
        $kelasMBC = [
            'Sistemasi Bisnis',
            'Great Manager',
            'Scale-Up 10X',
            'Leadership',
            'CS dan Sales Jago Closing',
            'Repeat Order',
            'Keuangan',
            'HRD Mastery',
            'Public Speaking'
        ];

        // Ambil input kelas yang sudah diikuti, pastikan di-trim dan dipisah benar
        $sudah = explode(',', $request->input('sudah_pernah_ikut_kelas_apa_saja'));
        $sudah = array_map('trim', $sudah); // Hilangkan spasi
        $alumni->sudah_pernah_ikut_kelas_apa_saja = implode(', ', $sudah); // Simpan ulang rapi

        // Jika input kelas belum diikuti kosong, hitung otomatis
        if (!$request->filled('kelas_yang_belum_diikuti_apa_saja')) {
            $belum = array_diff($kelasMBC, $sudah); // Hitung kelas yang belum diikuti
            $alumni->kelas_yang_belum_diikuti_apa_saja = implode(', ', $belum);
        } else {
            $alumni->kelas_yang_belum_diikuti_apa_saja = $request->input('kelas_yang_belum_diikuti_apa_saja');
        }

        $alumni->save();

        return redirect()->route('admin.alumni.alumni')->with('success', 'Data alumni berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find the alumni record by ID
        $alumni = Alumni::findOrFail($id);
        // Delete the alumni record
        $alumni->delete();
        // Redirect back to the alumni index with a success message
        return redirect()->route('admin.alumni.alumni')->with('success', 'Alumni data has been deleted successfully.');
    }
}
