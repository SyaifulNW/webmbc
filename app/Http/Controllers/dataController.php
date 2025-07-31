<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas; // Ensure you import the Kelas model
use App\Models\data;
use App\Models\jenisbisnis; // Ensure you import the Jenis model
use Illuminate\Support\Facades\DB;



class dataController extends Controller
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
        $jenisBisnis = jenisbisnis::all(); // Fetch all jenis bisnis
        $kelas = Kelas::all(); // Fetch all classes
        // Return a view with the data
        return view('admin.database.database', compact('data', 'kelas', 'jenisBisnis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return a view to create a new resource
        return view('admin.database.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new data();
        $data->nama = $request->input('nama');
        // Enum field
        $data->leads = $request->input('leads'); // Assuming 'leads' is an enum field
        // Custom field
        if ($request->input('leads_custom') === null) {
            $data->leads_custom = ''; // Set to empty string if null
        } else { 
            $data->leads_custom = $request->input('leads_custom');
        }
        $data->provinsi_id = $request->input('provinsi_id');
        $data->provinsi_nama = $request->input('provinsi_nama');
        $data->kota_id = $request->input('kota_id');
        $data->kota_nama = $request->input('kota_nama');
        $data->jenisbisnis = $request->input('jenisbisnis');
        $data->nama_bisnis = $request->input('nama_bisnis');
        $data->no_wa = $request->input('no_wa');
        $data->situasi_bisnis = $request->input('situasi_bisnis');
        $data->kendala = $request->input('kendala');
        // Ya atau tidak
        $data->ikut_kelas = $request->input('ikut_kelas') ? 1 : 0; // Convert to boolean
        $data->kelas_id = $request->input('kelas_id');
        $data->save();
        // Redirect to the index page with a success message
        return redirect()->route('admin.database.database')->with('success', 'Data has been added successfully.');

        
        
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
