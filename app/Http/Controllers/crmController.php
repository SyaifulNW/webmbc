<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Crm; // Assuming you have a Crm model for the crms table

class crmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Logic to retrieve and display database information
        $crms = Crm::all(); // Fetch all records from the crms table
        return view('admin.database.database', compact('crms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Logic to show the form for creating a new database entry
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
        $crm = new Crm();
        $crm->nama = $request->input('nama');
        $crm->leads = $request->input('leads');
        $crm->kota = $request->input('kota');
        $crm->nama_bisnis = $request->input('nama_bisnis');
        $crm->no_wa = $request->input('no_wa');
        $crm->total_omset = $request->input('total_omset');
        $crm->kendala = $request->input('kendala');
        $crm->fu1 = $request->input('fu1');
        $crm->fu2 = $request->input('fu2');
        $crm->fu3 = $request->input('fu3');
        $crm->status = $request->input('status', 'cold');
        $crm->save();
        return redirect()->route('admin.database.database')->with('success', 'Database entry created successfully.');
 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $crm = Crm::find($id);
        return view('admin.database.show', compact('crm'));
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Logic to show the form for editing a specific database entry
        $crm = Crm::findOrFail($id);
        return view('admin.database.edit', compact('crm'));
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
        $crm = Crm::findOrFail($id);
        $crm->nama = $request->input('nama');
        $crm->leads = $request->input('leads');
        $crm->kota = $request->input('kota');
        $crm->nama_bisnis = $request->input('nama_bisnis');
        $crm->no_wa = $request->input('no_wa');
        $crm->total_omset = $request->input('total_omset');
        $crm->kendala = $request->input('kendala');
        $crm->fu1 = $request->input('fu1');
        $crm->fu2 = $request->input('fu2');
        $crm->fu3 = $request->input('fu3');
        $crm->status = $request->input('status', 'cold');
        $crm->save();

        return redirect()->route('admin.database.database')->with('success', 'Database entry updated successfully.');
        // Logic to update a specific database entry

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        crm::where('id', $id)->delete();
        return redirect()->route('admin.database.database')->with('success', 'Database entry deleted successfully.');
        // Logic to delete a specific database entry
        
    }
}
