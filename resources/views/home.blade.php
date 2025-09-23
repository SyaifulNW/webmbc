@extends('layouts.masteradmin')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<div class="container-fluid px-4">
    <h3 class="mb-4 font-weight-bold text-dark">📊 DASHBOARD CS MBC</h3>
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
        // Ambil jadwal dari mapping
        $jadwal = $jadwalKelas[$item['nama_kelas']] ?? null;

        if ($jadwal) {
            // Pecah jadwal "10-12 September" → ambil tanggal awal
            preg_match('/(\d{1,2})/', $jadwal, $matches);
            $tanggalAwal = $matches[1] ?? 1;

            // Buat objek tanggal lengkap sesuai bulan & tahun
            return Carbon::parse("$tahun-$namaBulan-$tanggalAwal");
        }

        return Carbon::parse("$tahun-$namaBulan-01"); // fallback kalau tidak ada jadwal
    })
    ->values();
@endphp


{{-- Filter Bulan & Kelas --}}
<form method="GET" action="{{ route('home') }}" class="row mb-4 align-items-end">
    <div class="col-md-6">
        <label for="bulan" class="form-label">📅 Bulan:</label>
        <input 
            type="month" 
            id="bulan" 
            name="bulan" 
            class="form-control" 
            value="{{ $bulanDipilih }}">
    </div>

    <div class="col-md-6 text-end mt-3">
        <button type="submit" class="btn btn-primary">🔍 Tampilkan</button>
    </div>
</form>

{{-- Omset Per Kelas --}}
<div class="card mb-4 border-success shadow-sm">
    <div class="card-header bg-white text-success font-weight-bold">
        💰 OMSET KELAS ({{ strtoupper($namaBulan) }} {{ Carbon::parse($bulanDipilih)->year }})
    </div>
    <div class="card-body">
        <table class="table table-bordered table-sm text-center">
            <thead class="thead-light">
                <tr>
                    <th>Nama Kelas</th>
                    <th>Tanggal</th>
                    <th>Omset</th>
                    <th>Target</th>
                    <th>% Tercapai</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kelasOmsetFiltered as $k)
                    <tr>
                        <td>{{ $k['nama_kelas'] }}</td>
                        <td>{{ $jadwalKelas[$k['nama_kelas']] ?? '-' }}</td>
                        <td>Rp {{ number_format($k['omset'], 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($k['target'], 0, ',', '.') }}</td>
                        <td class="{{ $k['persen'] >= 100 ? 'text-success' : ($k['persen'] >= 75 ? 'text-warning' : 'text-danger') }}">
                            {{ $k['persen'] }}%
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-muted">Tidak ada data untuk bulan ini</td>
                    </tr>
                @endforelse
            </tbody>

            {{-- Tambahkan foot total --}}
            <tfoot>
                <tr style="background: #f2f2f2; font-weight: bold; color: #040e0f;">
                    <td colspan="3" style="text-align: right;">Total Omset</td>
                    <td colspan="2" style="text-align: left;">
                        Rp {{ number_format($kelasOmsetFiltered->sum('omset'), 0, ',', '.') }}
                    </td>
                </tr>
                <tr style="background: #d1e7dd; font-weight: bold; color: #0f5132;">
                    <td colspan="3" style="text-align: right;">Target Omset</td>
                    <td colspan="2" style="text-align: left;">
                        Rp {{ number_format($kelasOmsetFiltered->sum('target'), 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

{{-- Informasi Utama --}}
<div class="row">

    {{-- Lead Aktif --}}
   <div class="col-md-3">
    <div class="card border-info shadow-sm mb-3">
        <div class="card-header bg-white text-info fw-bold">
            <i class="fas fa-thumbtack me-1"></i> JUMLAH LEAD 
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.salesplan.index', ['status' => 'cold', 'bulan' => $bulanDipilih]) }}" class="text-decoration-none text-dark">
                        Cold
                    </a>
                    <span class="badge bg-secondary text-white">{{ $cold }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.salesplan.index', ['status' => 'tertarik', 'bulan' => $bulanDipilih]) }}" class="text-decoration-none text-dark">
                        Tertarik
                    </a>
                    <span class="badge bg-warning text-white">{{ $tertarik }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.salesplan.index', ['status' => 'mau_transfer', 'bulan' => $bulanDipilih]) }}" class="text-decoration-none text-dark">
                        Mau Transfer
                    </a>
                    <span class="badge bg-success text-white">{{ $mau_transfer }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.salesplan.index', ['status' => 'sudah_transfer', 'bulan' => $bulanDipilih]) }}" class="text-decoration-none text-dark">
                        Sudah Transfer
                    </a>
                    <span class="badge bg-info text-white">{{ $sudah_transfer }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.salesplan.index', ['status' => 'no', 'bulan' => $bulanDipilih]) }}" class="text-decoration-none text-dark">
                        No
                    </a>
                    <span class="badge bg-danger text-white">{{ $no }}</span>
                </li>
            </ul>
            <p class="mb-0 text-end">
                <strong>Total Lead ({{ \Carbon\Carbon::parse($bulanDipilih.'-01')->translatedFormat('F Y') }}):</strong>
                <span class="badge bg-primary text-white">{{ $totalLeadAktif }}</span>
            </p>
        </div>
    </div>
</div>


    {{-- Total Lead --}}
<div class="col-md-3">
    <div class="card border-info shadow-sm mb-3">
        <div class="card-header bg-white text-info fw-bold">
            <i class="fas fa-download me-1"></i> JUMLAH LEAD BARU 
        </div>
        <div class="card-body">
        
            <p>Jumlah Lead Baru ({{ \Carbon\Carbon::parse($bulan.'-01')->translatedFormat('F Y') }}):
                <span class="badge bg-success text-white">{{ $totalLeadBaru }}</span>
            </p>
        </div>
    </div>
</div>
    {{-- Jumlah Alumni --}}
    <!--<div class="col-md-3">-->
    <!--    <div class="card border-success shadow-sm mb-3">-->
    <!--        <div class="card-header bg-white text-success fw-bold">-->
    <!--            <i class="fas fa-graduation-cap me-1"></i> JUMLAH ALUMNI-->
    <!--        </div>-->
    <!--        <div class="card-body">-->
    <!--            <h4 class="mb-0"> Peserta</h4>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->

    {{-- Komisi --}}
    <div class="col-md-3">
        <div class="card border-secondary shadow-sm mb-3">
            <div class="card-header bg-light text-dark fw-bold">
                <i class="fas fa-file-invoice-dollar me-1"></i> KOMISI SEMENTARA
            </div>
            <div class="card-body">
                <p class="mb-0">Rp 0</p>
            </div>
        </div>
    </div>

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
                        <td class="fw-bold text-dark">{{ $row['target'] }}%</td>
                        <td class="fw-bold text-dark">{{ $row['bobot'] }}</td>
                        <td class="fw-bold text-dark">{{ $row['persentase'] }}%</td>
                        <td class="fw-bold text-dark">{{ number_format($row['nilai'],2) }}</td>
                    </tr>
                @endforeach
                <tr class="table-success fw-bold fs-6">
                    <td colspan="3" class="text-center text-dark">TOTAL</td>
                    <td class="text-dark">{{ $totalBobot }}</td>
                    <td>—</td>
                    <td class="text-dark">{{ number_format($totalNilai,2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
{{-- ==================================================== --}}




@endsection
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
