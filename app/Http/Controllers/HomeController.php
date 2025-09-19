<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\SalesPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller

{   
    public function __construct()
    {
        $this->middleware('auth');
    }

   public function index(Request $request)
{
    // Ambil bulan & kelas filter
    $bulan = $request->input('bulan') ?? Carbon::now()->format('Y-m');
    $kelas_id = $request->input('kelas_id');
    $carbonBulan = Carbon::createFromFormat('Y-m', $bulan);
    
$tahun = $carbonBulan->year;
$bulanNum = $carbonBulan->month;

    // CS yang login
    $csId   = auth()->id();
    $csName = auth()->user()->name;

    // Ambil semua kelas untuk opsi filter
    $kelas = Kelas::all();

    // Ambil data kelas + salesplan milik CS login
    $kelasOmset = Kelas::with(['salesplans' => function ($query) use ($bulan, $csId) {
        $query->where('tanggal', 'like', $bulan . '%')
              ->where('created_by', $csId); 
    }]);

    if ($kelas_id) {
        $kelasOmset->where('id', $kelas_id);
    }

    $kelasOmset = $kelasOmset->get();

    // Hitung omset per kelas
$kelasOmset = $kelasOmset->map(function ($kelas) {
    $userId = auth()->id();

    $omset = $kelas->SalesPlans()
        ->where('created_by', $userId)
        ->sum('nominal');

    $target = 25000000;

    return [
        'nama_kelas' => $kelas->nama_kelas,
        'omset'      => $omset,
        'target'     => $target,
        'persen'     => $target > 0 ? round(($omset / $target) * 100) : 0,
    ];
});



$bulanDipilih = request('bulan', now()->format('Y-m'));
$tahun = substr($bulanDipilih, 0, 4);
$bulanNum = substr($bulanDipilih, 5, 2);

$csId = auth()->id();

// Ambil semua lead CS login per bulan terpilih, dikelompokkan berdasarkan status
$leads = SalesPlan::select('status', DB::raw('count(*) as total'))
    ->where('created_by', $csId)
    ->whereYear('created_at', $tahun)
    ->whereMonth('created_at', $bulanNum)
    ->groupBy('status')
    ->pluck('total', 'status');

// Isi default 0 kalau status tidak ada di bulan ini
$cold           = $leads['cold'] ?? 0;
$tertarik       = $leads['tertarik'] ?? 0;
$mau_transfer   = $leads['mau_transfer'] ?? 0;
$sudah_transfer = $leads['sudah_transfer'] ?? 0;
$no             = $leads['no'] ?? 0;

$totalLeadAktif = $cold + $tertarik + $mau_transfer + $sudah_transfer + $no;

// 🔹 Lead baru bulan ini = sama dengan totalLeadAktif
$totalLeadBaru = $totalLeadAktif;


    return view('home', compact(
        'kelasOmset',
        'kelas',
        'cold',
        'tertarik',
        'mau_transfer',
        'sudah_transfer',
        'no',
        'totalLeadAktif',
        'totalLeadBaru', // ← kirim ke blade
        'csName',
        'bulan'
    ));
}
}
