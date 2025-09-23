@extends('layouts.masteradmin')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
    .badge-lg {
        font-size: 1.1rem;   /* font lebih besar */
        padding: 0.8rem 1.4rem; /* padding biar lebih lebar */
    }
</style>


<div class="container-fluid px-4">
    <h3 class="mb-4 fw-bold text-dark text-center">
   DASHBOARD CS MBC
    </h3>

    @php
        use Carbon\Carbon;

        // Ambil bulan yang dipilih (default sekarang)
        $bulanDipilih = request('bulan', now()->format('Y-m'));
        $namaBulan    = Carbon::parse($bulanDipilih)->format('F');
        $tahun        = Carbon::parse($bulanDipilih)->year;

        // Mapping bulan ke kelas
        $kelasPerBulan = [
            'September' => ['Repeat Order', 'Great Manager'],
            'October'   => ['Keuangan', 'CS dan Sales Jago Closing'],
            'November'  => ['Scale-Up 10X', 'Leadership'],
            'December'  => ['HRD Mastery'],
        ];

        // Mapping jadwal kelas
        $jadwalKelas = [
            'Repeat Order'              => '10-12 September',
            'Great Manager'             => '24-26 September',
            'Keuangan'                  => '15-17 Oktober',
            'CS dan Sales Jago Closing' => '29-31 Oktober',
            'Scale-Up 10X'              => '12-14 November',
            'Leadership'                => '26-28 November',
            'HRD Mastery'               => '10-12 Desember',
        ];

        // Ambil kelas sesuai bulan
        $kelasTersedia = $kelasPerBulan[$namaBulan] ?? [];
        $kelasOmsetFiltered = collect($kelasOmset)
            ->whereIn('nama_kelas', $kelasTersedia)
            ->sortBy(function ($item) use ($jadwalKelas, $namaBulan, $tahun) {
                $jadwal = $jadwalKelas[$item['nama_kelas']] ?? null;

                if ($jadwal) {
                    preg_match('/(\d{1,2})/', $jadwal, $matches);
                    $tanggalAwal = $matches[1] ?? 1;
                    return Carbon::parse("$tahun-$namaBulan-$tanggalAwal");
                }

                return Carbon::parse("$tahun-$namaBulan-01");
            })
            ->values();
    @endphp

    {{-- Filter Bulan & Kelas --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('home') }}" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label for="bulan" class="form-label fw-semibold">ðŸ“… Pilih Bulan Kelas:</label>
                    <input 
                        type="month" 
                        id="bulan" 
                        name="bulan" 
                        class="form-control" 
                        value="{{ $bulanDipilih }}">
                </div>
                <div class="col-md-6 text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-search me-1"></i> Tampilkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Omset Per Kelas --}}
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-success text-white fw-bold">
            ðŸ’° OMSET KELAS ({{ strtoupper($namaBulan) }} {{ $tahun }})
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
           <thead class="table-primary">
    <tr>
        <th>Nama Kelas</th>
        <th>Tanggal</th>
        <th>Omset</th>
        <th>Target</th>
        <th>% Tercapai</th>
        <th>Komisi</th>
    </tr>
</thead>
<tbody>
    @forelse ($kelasOmsetFiltered as $k)
        @php
            $komisiSementara = $k['omset'] * 0.01; // contoh komisi 1%
            $komisiTotal = $k['omset'] >= $k['target']
                ? $komisiSementara + 300000
                : $komisiSementara;
        @endphp
        <tr>
            <td class="fw-semibold">{{ $k['nama_kelas'] }}</td>
            <td>{{ $jadwalKelas[$k['nama_kelas']] ?? '-' }}</td>
            <td class="text-success fw-bold">Rp {{ number_format($k['omset'], 0, ',', '.') }}</td>
            <td>Rp {{ number_format($k['target'], 0, ',', '.') }}</td>
            <td class="{{ $k['persen'] >= 100 ? 'text-success fw-bold' : ($k['persen'] >= 75 ? 'text-warning fw-bold' : 'text-danger fw-bold') }}">
                {{ $k['persen'] }}%
            </td>
            <td class="text-primary fw-bold">
                Rp {{ number_format($komisiTotal, 0, ',', '.') }}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="text-muted fst-italic">Tidak ada data untuk bulan ini</td>
        </tr>
    @endforelse
</tbody>
                <tfoot>
                    <tr class="bg-light fw-bold">
                        <td colspan="3" class="text-end text-dark">Total Omset</td>
                        <td colspan="2" class="text-start text-success">
                            Rp {{ number_format($kelasOmsetFiltered->sum('omset'), 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr class="bg-light fw-bold">
                        <td colspan="3" class="text-end text-dark text-bold">Target Omset</td>
                        <td colspan="2" class="text-start text-dark text-bold">
                            Rp {{ number_format($kelasOmsetFiltered->sum('target'), 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

{{-- Card Database & Komisi --}}
<div class="row g-4">
 @php
    use App\Models\Data;


    $bulanDipilih = request('bulan', now()->format('Y-m'));
    $bulanParse   = Carbon::parse($bulanDipilih);
    $namaBulanDb  = $bulanParse->translatedFormat('F');
    $tahunDb      = $bulanParse->year;

    // Hitung database baru di bulan tsb
    $databaseBaru = Data::where('created_by', auth()->user()->name)
                        ->whereYear('created_at', $tahunDb)
                        ->whereMonth('created_at', $bulanParse->month)
                        ->count();

    // Total database keseluruhan
    $totalDatabase = Data::where('created_by', auth()->user()->name)->count();

    $target = 50;

    // Ambil data sumber database
    $sumberDatabase = Data::select('leads', \DB::raw('COUNT(*) as total'))
                        ->where('created_by', auth()->user()->name)
                        ->groupBy('leads')
                        ->pluck('total','leads')
                        ->toArray();

    $labels = array_keys($sumberDatabase);
    $values = array_values($sumberDatabase);
@endphp






    {{-- Card Database --}}
    <div class="col-12 col-md-4">
        <div class="card shadow-lg border-0 h-100">
            <div class="card-header bg-info text-white fw-bold py-2">
                <i class="fas fa-database me-2"></i> JUMLAH DATABASE
            </div>
            <div class="card-body text-center">
                <h2 class="fw-bold text-dark mb-2" style="font-size: 2.5rem;">
                    {{ $databaseBaru }}
                </h2>
                <p class="text-muted mb-3">
                    Periode: {{ $namaBulanDb }} {{ $tahunDb }}
                </p>

                <div class="progress mb-3" style="height: 18px; border-radius: 10px;">
                    <div class="progress-bar bg-success fw-bold text-white"
                        role="progressbar"
                        style="width: {{ min(($databaseBaru / $target) * 100, 100) }}%">
                        {{ number_format(($databaseBaru / $target) * 100, 0) }}%
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <span class="badge bg-primary text-white px-3 py-2">
                        Target: {{ $target }}
                    </span>
                    <span class="badge bg-secondary text-white px-3 py-2">
                        Total: {{ $totalDatabase }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Card Pie Chart Asal Database --}}
    <div class="col-12 col-md-4">
        <div class="card shadow-lg border-0 h-100">
            <div class="card-header bg-primary text-white fw-bold py-2">
                <i class="fas fa-chart-pie me-2"></i> SUMBER LEADS
            </div>
            <div class="card-body d-flex justify-content-center align-items-center">
                <canvas id="pieSumberDbSmall" width="200" height="200"></canvas>
            </div>
        </div>
    </div>

    {{-- Card Komisi --}}
    <div class="col-12 col-md-4">
        <div class="card shadow-lg border-0 h-100">
            <div class="card-header bg-secondary text-white fw-bold py-2">
                <i class="fas fa-file-invoice-dollar me-2"></i> TOTAL KOMISI
            </div>
            <div class="card-body text-center">
                @php
                    $totalKomisi = collect($kelasOmsetFiltered)->sum(function($k) {
                        $komisiSementara = $k['omset'] * 0.01;
                        return $k['omset'] >= $k['target']
                            ? $komisiSementara + 300000
                            : $komisiSementara;
                    });
                @endphp

                <h2 class="fw-bold text-success mb-2" style="font-size: 2.5rem;">
                    Rp {{ number_format($totalKomisi, 0, ',', '.') }}
                </h2>
                <p class="text-muted mb-0">
                    Periode: {{ $namaBulan }} {{ $tahun }}
                </p>
            </div>
        </div>
    </div>








{{-- Script Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctxSmall = document.getElementById('pieSumberDbSmall').getContext('2d');
    new Chart(ctxSmall, {
        type: 'pie',
        data: {
            labels: @json($labels),
            datasets: [{
                data: @json($values),
                backgroundColor: [
                    '#007bff','#28a745','#ffc107','#dc3545','#6f42c1',
                    '#17a2b8','#fd7e14','#20c997','#6610f2','#e83e8c'
                ],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 12 } }
                }
            }
        }
    });
</script>

    </div>

 
{{-- ================= KPI BULANAN ================= --}}
<div class="card shadow-lg border-0 mt-5">
    <div class="card-header bg-primary text-white text-center fw-bold fs-5">
        KEY PERFORMANCE INDEX (KPI) CS MBC
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered table-striped table-hover mb-0 text-center align-middle">
            <thead class="table-info">
                <tr>
                    <th class="fw-bold text-dark">No</th>
                    <th class="fw-bold text-dark">Aktivitas</th>
                    <th class="fw-bold text-dark">Target</th>
                    <th class="fw-bold text-dark">Bobot</th>
                    <th class="fw-bold text-dark">Presentase</th>
                    <th class="fw-bold text-dark">Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kpiData as $i => $row)
                    <tr>
                        <td class="fw-bold text-dark">{{ $i+1 }}</td>
                        <td class="fw-bold text-start text-dark">{{ $row['nama'] }}</td>
                        <td class="fw-bold text-dark">{{ $row['target'] }}</td>
                        <td class="fw-bold text-dark">{{ $row['bobot'] }}</td>
                        <td class="fw-bold text-dark">{{ $row['persentase'] }}%</td>
                        <td class="fw-bold text-dark">{{ number_format($row['nilai'],2) }}</td>
                    </tr>
                @endforeach
                <tr class="table-success fw-bold fs-6">
                    <td colspan="3" class="text-center text-dark fw-bold">TOTAL</td>
                    <td class="text-dark fw-bold">{{ $totalBobot }}</td>
                    <td>—</td>
                    <td class="text-dark fw-bold">{{ number_format($totalNilai,2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
{{-- ==================================================== --}}
<br>
<br>
</div>
@endsection
