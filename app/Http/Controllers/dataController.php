<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas; // Ensure you import the Kelas model
use App\Models\data;
use App\Models\Alumni; // Ensure you import the Alumni model
use App\Models\salesplan; // Ensure you import the Salesplan model
use App\Models\jenisbisnis; // Ensure you import the Jenis model
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\dataImport;




class dataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        $user = Auth::user();


        // Ambil data sesuai role
        if ($user->email == 'mbchamasah@gmail.com') {
            $data = data::all();
        } else {
            // Filter hanya data yang diinput oleh user login
            $data = data::where('created_by', $user->name)->get();
            // Jika di database kamu menyimpan email, ganti jadi:
            // $data = data::where('created_by', $user->email)->get();
        }

        $kelas = Kelas::all();

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
    public function updateInline(Request $request)
    {

        $data = data::findOrFail($request->id);
        $field = $request->field;
        $data->$field = $request->value;
        $data->save();

        return response()->json(['success' => true]);
    }




    public function store(Request $request)
    {
        $data = new data();
        $data->nama = $request->input('nama');
        $data->status_peserta = $request->input('status_peserta', 'peserta_baru');
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
        // Enum Peserta Baru


        // Role
        $data->created_by = Auth::user()->name;
        $data->created_by_role = Auth::user()->role;
        $data->save();
        return redirect()->route('admin.database.database')->with('success', 'Data has been added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updatePotensi(Request $request, $id)
    {
        $data = data::findOrFail($id);
        $data->kelas_id = $request->kelas_id;
        $data->save();

        return response()->json(['success' => true]);
    }


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
        $data->status_peserta = $request->input('status_peserta', 'Peserta Baru');
        // Enum field
        $data->leads = $request->input('leads'); // Assuming 'leads' is an enum field
        // Custom field
        if ($request->input('leads_custom') === null) {
            $data->leads_custom = ''; // Set to empty string if null
        } else {
            $data->leads_custom = $request->input('leads_custom');
        }
        $data->provinsi_id = $request->input('provinsi_id');

        $data->kota_nama = $request->input('kota_nama');
        $data->jenisbisnis = $request->input('jenisbisnis');
        $data->nama_bisnis = $request->input('nama_bisnis');
        $data->no_wa = $request->input('no_wa');
        $data->situasi_bisnis = $request->input('situasi_bisnis');
        $data->kendala = $request->input('kendala');

        // Ya atau tidak

        $data->save();



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


    // app/Http/Controllers/DatabaseController.php

    public function peserta_baru()
    {
        if (Auth::user()->email === 'mbchamasah@gmail.com') {
            $data = data::where('status_peserta', 'peserta_baru')->get();
        } else {
            $data = data::where('status_peserta', 'peserta_baru')
                ->where('created_by', Auth::user()->name)
                ->get();
        }
        return view('admin.database.database', compact('data'));
    }

    public function alumni()
    {
        if (Auth::user()->email === 'mbchamasah@gmail.com') {
            $data = data::where('status_peserta', 'alumni')->get();
        } else {
            $data = data::where('status_peserta', 'alumni')
                ->where('created_by', Auth::user()->name)
                ->get();
        }
        return view('admin.database.database', compact('data'));
    }




    public function pindahkesalesplan($id)
    {
        // Ambil data peserta dari tabel data
        $data = Data::findOrFail($id);
        $salesPlan = new SalesPlan();
        $salesPlan->nama = $data->nama;          // dari tabel peserta
        $salesPlan->situasi_bisnis      = $data->situasi_bisnis; // dari tabel peserta
        $salesPlan->kendala      = $data->kendala;       // dari tabel peserta
        $salesPlan->kelas_id     = $data->kelas_id;
        $salesPlan->created_by   = auth()->id();
        $salesPlan->status       = 'cold'; // default awal

        // Kolom tambahan biarkan kosong dulu, admin yang isi nant
        $salesPlan->save();


        // Kalau mau pindahkan (hapus dari tabel data) bisa tambahkan:
        // $data->delete();

        return redirect()->route('admin.salesplan.index')
            ->with('success', 'Peserta berhasil dipindahkan ke Sales Plan.');
    }
}
