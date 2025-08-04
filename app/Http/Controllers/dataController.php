<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas; // Ensure you import the Kelas model
use App\Models\data;
use App\Models\Alumni; // Ensure you import the Alumni model
use App\Models\salesplan; // Ensure you import the Salesplan model
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
        $kelas = Kelas::all(); // Fetch all classes
        // Return a view with the data
        return view('admin.database.database', compact('data', 'kelas'));
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
        // Fetch the data by ID
        $data = data::findOrFail($id);
        $kelas = Kelas::all(); // Fetch all classes for the sidebar
        // Return a view to show the data
        return view('admin.database.show', compact('data', 'kelas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Fetch the data by ID
        $data = data::findOrFail($id);

        $kelas = Kelas::all(); // Fetch all classes for the sidebar
        // Return a view to edit the data
        return view('admin.database.edit', compact('data', 'kelas'));
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
        // Validate the request data
        $data = data::findOrFail($id);
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

        // Otomatis masuk ke Sales Plan jika ikut kelas
        if ($data->ikut_kelas && $data->kelas_id && !$data->salesPlan) {
            SalesPlan::create([
                'data_id' => $data->id,
                'keterangan' => 'Dimasukkan otomatis saat peserta memilih ikut kelas',
                'indikator_warna' => 'kuning',
            ]);
        }

        // Redirect to the index page with a success message
        return redirect()->route('admin.database.database')->with('success', 'Data has been updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Fetch the data by ID
        $data = data::findOrFail($id);
        // Delete the data
        $data->delete();
        // Redirect to the index page with a success message
        return redirect()->route('admin.database.database')->with('success', 'Data has been deleted successfully.');
    }

    public function pindahKeAlumni($id)
    {
        // Fetch the data by ID
        $data = data::findOrFail($id);

        // Create a new Alumni instance
        $alumni = new \App\Models\Alumni();
        $alumni->nama = $data->nama;
        $alumni->leads = $data->leads;
        $alumni->leads_custom = $data->leads_custom;
        $alumni->provinsi_id = $data->provinsi_id;
        $alumni->provinsi_nama = $data->provinsi_nama;
        $alumni->kota_id = $data->kota_id;
        $alumni->kota_nama = $data->kota_nama;
        $alumni->jenis_bisnis = $data->jenisbisnis;
        $alumni->nama_bisnis = $data->nama_bisnis;
        $alumni->no_wa = $data->no_wa;
        $alumni->kendala = $data->kendala;
        $alumni->ikut_kelas = $data->ikut_kelas;
        $alumni->kelas_id = $data->kelas_id;
        // Additional fields for alumni
        $alumni->sudah_pernah_ikut_kelas_apa_saja = null; // Set as needed
        $alumni->kelas_yang_belum_diikuti_apa_saja = null; // Set as needed

        // Save the alumni record
        $alumni->save();

        // Delete the original data record
        $data->delete();

        // Redirect to the alumni index page with a success message
        return redirect()->route('admin.alumni.alumni')->with('success', 'Data has been moved to Alumni successfully.');
    }

    public function pindahkesalesplan($id)
    {
        $data = Data::with('kelas')->findOrFail($id);

        // Cek apakah sudah punya sales plan
        if ($data->salesplan->isNotEmpty()) {
            return redirect()->back()->with('error', 'Data ini sudah memiliki Sales Plan.');
        }
        // Cek apakah ikut kelas
        if (!$data->ikut_kelas || !$data->kelas_id) {
            return back()->with('error', 'Peserta belum memilih kelas.');
        }
        // Simpan ke database salesplan
        SalesPlan::create([
            'data_id' => $data->id,
            'keterangan' => 'Dimasukkan otomatis berdasarkan kelas: ' . ($data->kelas->nama ?? 'Tidak diketahui'),
            'status' => 'cold', // default warna indikator
        ]);
        // Redirect ke halaman sales plan
        return redirect()->route('admin.salesplan.index')->with('success', 'Data telah ditambahkan ke Sales Plan.');
    }
}
