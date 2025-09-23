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

    // ============ BAGIAN KPI BULANAN =============
    $tanggalHariIni = now()->toDateString();
    $carbon = Carbon::parse($tanggalHariIni);

    // hitung hari kerja (Sabtu masuk, Minggu libur)
    $daysInMonth = $carbon->daysInMonth;
    $hariKerja = 0;
    for ($d = 1; $d <= $daysInMonth; $d++) {
        $day = Carbon::create($tahun, $bulanNum, $d);
        if ($day->dayOfWeek != Carbon::SUNDAY) {
            $hariKerja++;
        }
    }

    $activities = \App\Models\Activity::orderBy('categories_id')->get()->groupBy('categories_id');

    $categoryKpiWeights = [
        'Aktivitas Pribadi' => 10,
        'Aktivitas Mencari Leads' => 20,
        'Aktivitas Memprospek' => 20,
        'Aktivitas Closing' => 40,
        'Aktivitas Merawat Customer' => 10,
    ];

    $kpiData = [];
    $totalKpi = 0;
    $totalBobot = 0;

    foreach ($activities as $kategoriId => $list) {
        $categoryName = $list->first()->kategori->nama ?? ("Kategori " . $kategoriId);

        $activityPercents = [];
        foreach ($list as $act) {
            $targetDaily = (float) ($act->target_daily ?? 0);
            $targetBulanan = $targetDaily * $hariKerja;

            $totalRealisasi = (float) \App\Models\DailyActiviti::where('user_id', $csId)
                ->where('activity_id', $act->id)
                ->whereMonth('tanggal', $bulanNum)
                ->whereYear('tanggal', $tahun)
                ->sum('realisasi');

            $percent = 0;
            if ($targetBulanan > 0) {
                $percent = ($totalRealisasi / $targetBulanan) * 100;
                if ($percent > 100) $percent = 100;
            }
            $activityPercents[] = $percent;
        }

        $skorKategori = count($activityPercents) ? (array_sum($activityPercents) / count($activityPercents)) : 0;
        $bobotKategori = $categoryKpiWeights[$categoryName] ?? 0;
        $nilaiKategori = ($skorKategori / 100) * $bobotKategori;

        $kpiData[] = [
            'categories_id' => $kategoriId,
            'nama'        => $categoryName,
            'target'      => '100%',
            'bobot'       => $bobotKategori,
            'persentase'  => round($skorKategori, 2),
            'nilai'       => round($nilaiKategori, 2),
        ];

        $totalKpi += $nilaiKategori;
        $totalBobot += $bobotKategori;
    }

    $totalNilai = $totalKpi;

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
           'bulan',
        'kpiData',
        'totalBobot',
        'totalNilai'
    ));
}
}
