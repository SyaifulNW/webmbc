<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use Carbon\Carbon;

use App\Models\salesplan; // Ensure you import the Salesplan model
// Ensure you import the Kelas model


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $bulan = $request->input('bulan') ?? Carbon::now()->format('Y-m');

        // Ambil semua kelas dan relasi salesplan yang sesuai bulan
        $kelas = Kelas::all();

        $kelasOmset = Kelas::with(['salesplans' => function ($query) use ($bulan) {
            $query->where('tanggal', 'like', $bulan . '%');
        }])->get();

        $kelasOmset = $kelasOmset->map(function ($kelas) {
            $omset = $kelas->salesplans->sum('nominal');
            $target = 25000000;

            return [
                'nama_kelas' => $kelas->nama_kelas,
                'omset'      => $omset,
                'target'     => $target,
                'persen'     => $omset > 0 ? round(($omset / $target) * 100) : 0,
            ];
        });

        return view('home', compact('kelasOmset', 'kelas'));
    }
}
