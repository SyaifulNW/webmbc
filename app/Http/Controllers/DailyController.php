<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;        // Master data aktivitas
use App\Models\DailyActiviti;   // Input realisasi harian
use Carbon\Carbon;

class DailyController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->toDateString());
        $userId  = auth()->id();

        // Ambil master aktivitas, dikelompokkan per kategori (key = categories_id)
        $activities = Activity::orderBy('categories_id')->get()->groupBy('categories_id');

        // Ambil realisasi user untuk TANGGAL yang dipilih (dipakai saat render form)
        $daily = DailyActiviti::where('user_id', $userId)
            ->whereDate('tanggal', $tanggal)
            ->pluck('realisasi', 'activity_id');

        // Persiapan periode (bulan & tahun) untuk rekap bulanan
        $carbon = Carbon::parse($tanggal);
        $bulan   = $carbon->month;
        $tahun   = $carbon->year;

        // Hari kerja: semua hari kecuali MINGGU (Sabtu masuk kerja)
        $daysInMonth = $carbon->daysInMonth;
        $hariKerja = 0;
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $day = Carbon::create($tahun, $bulan, $d);
            if ($day->dayOfWeek != Carbon::SUNDAY) {
                $hariKerja++;
            }
        }

        // Bobot KPI per kategori (sesuaikan nama kategori sesuai seeder)
        $categoryKpiWeights = [
            'Aktivitas Pribadi' => 10,
            'Aktivitas Mencari Leads' => 20,
            'Aktivitas Memprospek' => 20,
            'Aktivitas Closing' => 40,
            'Aktivitas Merawat Customer' => 10,
        ];

        // Hitung rekap KPI per kategori (kpiData) dan total KPI akhir
        $kpiData = [];
        $totalKpi = 0;
        $totalBobot = 0;

        foreach ($activities as $kategoriId => $list) {
            $categoryName = $list->first()->kategori->nama ?? ("Kategori " . $kategoriId);

            $activityPercents = []; // tiap aktivitas -> persentase cap 100%

            foreach ($list as $act) {
                $targetDaily = (float) ($act->target_daily ?? 0);
                $targetBulanan = $targetDaily * $hariKerja;

                // total realisasi bulan ini untuk aktivitas ini (user spesifik)
                $totalRealisasi = (float) DailyActiviti::where('user_id', $userId)
                    ->where('activity_id', $act->id)
                    ->whereMonth('tanggal', $bulan)
                    ->whereYear('tanggal', $tahun)
                    ->sum('realisasi');

                $percent = 0;
                if ($targetBulanan > 0) {
                    $percent = ($totalRealisasi / $targetBulanan) * 100;
                    if ($percent > 100) $percent = 100;
                }

                $activityPercents[] = $percent;
            }

            // skor kategori = rata-rata persentase aktivitas di kategori
            $skorKategori = count($activityPercents) ? (array_sum($activityPercents) / count($activityPercents)) : 0;

            // ambil bobot kategori dari mapping; default 0 kalau tidak ditemukan
            $bobotKategori = $categoryKpiWeights[$categoryName] ?? 0;

            // nilai kategori = (skorKategori% / 100) * bobotKategori
            $nilaiKategori = ($skorKategori / 100) * $bobotKategori;

            $kpiData[] = [
                'categories_id' => $kategoriId,
                'nama'        => $categoryName,
                'target'      => '100%',
                'bobot'       => $bobotKategori,
                'persentase'  => round($skorKategori, 2),   // tampilkan sebagai % (mis. 86.00)
                'nilai'       => round($nilaiKategori, 2),  // poin kontribusi dari kategori
            ];

            $totalKpi += $nilaiKategori;
            $totalBobot += $bobotKategori;
        }

        // Kirim ke view: activities, daily (harian), tanggal, dan kpiData + totals
      $totalNilai = $totalKpi; // alias biar nyambung dengan blade
return view('admin.dailyactivity.index', compact(
    'activities', 'daily', 'tanggal',
    'kpiData', 'totalNilai', 'totalBobot'
));
    }

    public function store(Request $request)
    {
        $tanggal = $request->input('tanggal');

        foreach ($request->realisasi as $activityId => $value) {
            DailyActiviti::updateOrCreate(
                [
                    'user_id'    => auth()->id(),
                    'tanggal'    => $tanggal,
                    'activity_id'=> $activityId,
                ],
                [
                    'realisasi'  => $value ?? 0
                ]
            );
        }

        if ($request->ajax()) {
            return response()->json(['message' => 'Berhasil disimpan']);
        }

        return redirect()->back()->with('success', 'Aktivitas berhasil disimpan!');
    }
}
