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
    public function store(Request $request)
    {
        
    }

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
        $kelas = Kelas::all(); // Fetch all classes for dropdowns or other purposes
        $alumni = Alumni::findOrFail($id);
        // Return a view to edit the alumni details
        return view('admin.alumni.edit', compact('alumni'));
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
            $alumni->nama = $request->input('nama');
            $alumni->leads = $request->input('leads');
            $alumni->leads_custom = $request->input('leads_custom') ?? ''; // Set to empty string if null
            $alumni->provinsi_id = $request
                ->input('provinsi_id');
            $alumni->provinsi_nama = $request->input('provinsi_nama');
            $alumni->kota_id = $request->input('kota_id');
            $alumni->kota_nama = $request->input('kota_nama');
            $alumni->jenis_bisnis = $request->input('jenis_bisnis');
            $alumni->nama_bisnis = $request->input('nama_bisnis');
            $alumni->no_wa = $request->input('no_wa');
            $alumni->kendala = $request->input('kendala');
            $alumni->ikut_kelas = $request->input('ikut_kelas', false); // Default to false if not provided
            $alumni->kelas_id = $request->input('kelas_id') ?? null; // Set to null if not provided
            $alumni->sudah_pernah_ikut_kelas_apa_saja = $request->input('sudah_pernah_ikut_kelas_apa_saja');
            $alumni->kelas_yang_belum_diikuti_apa_saja = $request->input('kelas_yang_belum_diikuti_apa_saja');
            $alumni->save(); // Save the updated alumni record  
            // Redirect back to the alumni index with a success message
            return redirect()->route('admin.alumni.alumni')->with('success', 'Alumni data has been updated successfully.');

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
