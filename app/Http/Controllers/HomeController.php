<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use Carbon\Carbon;
use App\Models\SalesPlan;
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
    public function index()
    {
        $bulanIni = Carbon::now()->format('Y-m');

        $kelasOmset = Kelas::with(['salesplans' => function ($query) use ($bulanIni) {
            $query->where('tanggal', 'like', $bulanIni . '%');
        }])->get();

        // Hitung omset per kelas dan targetnya
        $kelasOmset = $kelasOmset->map(function ($kelas) {
            $omset = $kelas->salesplans->sum('nominal');
            return [
                'nama_kelas' => $kelas->nama_kelas,
                'omset' => $omset,
                'target' => 25000000, // target default per kelas, bisa ubah sesuai kebutuhan
                'persen' => $kelas->salesplans->count() ? round(($omset / 25000000) * 100) : 0,
            ];
        });

        return view('home', compact('kelasOmset'));
    }
}
