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
         // Ambil bulan dan kelas dari request (atau default ke bulan ini)
     // Ambil bulan dan kelas dari request (atau default ke bulan ini)
    $bulan = $request->input('bulan') ?? Carbon::now()->format('Y-m');
    $kelas_id = $request->input('kelas_id');

    // Ambil semua kelas untuk opsi filter
    $kelas = Kelas::all();

    // Ambil data kelas beserta salesplans yang sesuai filter
    $kelasOmset = Kelas::with(['salesplans' => function ($query) use ($bulan) {
        $query->where('tanggal', 'like', $bulan . '%');
    }]);

    // Jika user memilih filter kelas tertentu
    if ($kelas_id) {
        $kelasOmset->where('id', $kelas_id);
    }

    $kelasOmset = $kelasOmset->get();

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

    // ===== Tambahan untuk hitung Jumlah Lead Aktif =====
    $cold = SalesPlan::where('status', 'cold')->count();
    $warm = SalesPlan::where('status', 'warm')->count();
    $hot = SalesPlan::where('status', 'hot')->count();
    $no = SalesPlan::where('status', 'no')->count();

    $totalLeadAktif = $cold + $warm + $hot + $no;

    // Kirim semua data ke view
    return view('home', compact(
        'kelasOmset',
        'kelas',
        'cold',
        'warm',
        'hot',
        'no',
        'totalLeadAktif'
    ));
}
}
