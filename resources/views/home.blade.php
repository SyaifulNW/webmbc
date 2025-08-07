@extends('layouts.masteradmin')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">


<div class="container-fluid px-4">
    <h3 class="mb-4 font-weight-bold text-dark">📊 DASHBOARD CS MBC</h3>

<form method="GET" action="{{ route('home') }}" class="row mb-4 align-items-end">
    <div class="col-md-6">
        <label for="bulan" class="form-label">📅 Bulan:</label>
        <input type="month" id="bulan" name="bulan" class="form-control" value="{{ request('bulan') }}">
    </div>
    <div class="col-md-6">
        <label for="kelas_id" class="form-label">Kelas</label>
        <select class="form-select" id="kelas_id" name="kelas_id">
            <option value="">Pilih Kelas</option>
            @foreach($kelas as $kelasItem)
            <option value="{{ $kelasItem->id }}" {{ request('kelas_id') == $kelasItem->id ? 'selected' : '' }}>
                {{ $kelasItem->nama_kelas }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-12 mt-3">
        <button type="submit" class="btn btn-primary">🔍 Tampilkan</button>
    </div>
</form>


    {{-- Omset Per Kelas --}}
    <div class="card mb-4 border-success shadow-sm">
        <div class="card-header bg-white text-success font-weight-bold">
            💰 OMSET PER KELAS (BULAN INI)
        </div>
        <div class="card-body">
            <table class="table table-bordered table-sm text-center">
                <thead class="thead-light">
                    <tr>
                        <th>Nama Kelas</th>
                        <th>Omset</th>
                        <th>Target</th>
                        <th>% Tercapai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kelasOmset as $kelas)
                    <tr>
                        <td>{{ $kelas['nama_kelas'] }}</td>
                        <td>Rp {{ number_format($kelas['omset'], 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($kelas['target'], 0, ',', '.') }}</td>
                        <td class="{{ $kelas['persen'] >= 100 ? 'text-success' : ($kelas['persen'] >= 75 ? 'text-warning' : 'text-danger') }}">
                            {{ $kelas['persen'] }}%
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <hr>
            <h5 class="mt-3">Total Omset: <span class="badge bg-success text-white">Rp 45.000.000</span></h5>
        </div>
    </div>

    {{-- Informasi Utama --}}
    <div class="row">

        {{-- JUMLAH LEAD AKTIF --}}
        <div class="col-md-3">
            <div class="card border-primary shadow-sm mb-3">
                <div class="card-header bg-white text-primary fw-bold">
                    <i class="fas fa-thumbtack me-1"></i> JUMLAH LEAD AKTIF
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Cold
                            <span class="badge bg-secondary text-white">0</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Warm
                            <span class="badge bg-warning text-white">4</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Hot
                            <span class="badge bg-success text-white">7</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            No
                            <span class="badge bg-danger text-white">2</span>
                        </li>
                    </ul>
                    <p class="mb-0 text-end"><strong>Total Lead Aktif:</strong> 13</p>
                </div>
            </div>
        </div>

        {{-- TOTAL LEAD --}}
        <div class="col-md-3">
            <div class="card border-info shadow-sm mb-3">
                <div class="card-header bg-white text-info fw-bold">
                    <i class="fas fa-download me-1"></i> TOTAL LEAD
                </div>
                <div class="card-body">
                    <p>Total Semua Lead: <span class="badge bg-info text-white">55</span></p>
                    <p>Jumlah Lead Kelas: <span class="badge bg-info text-white">22</span></p>
                </div>
            </div>
        </div>

        {{-- JUMLAH ALUMNI --}}
        <div class="col-md-3">
            <div class="card border-success shadow-sm mb-3">
                <div class="card-header bg-white text-success fw-bold">
                    <i class="fas fa-graduation-cap me-1"></i> JUMLAH ALUMNI
                </div>
                <div class="card-body">
                    <h4 class="mb-0">34 Peserta</h4>
                </div>
            </div>
        </div>

        {{-- KOMISI SEMENTARA --}}
        <div class="col-md-3">
            <div class="card border-secondary shadow-sm mb-3">
                <div class="card-header bg-light text-dark fw-bold">
                    <i class="fas fa-file-invoice-dollar me-1"></i> KOMISI SEMENTARA
                </div>
                <div class="card-body">
                    <p class="mb-0">Rp. 300.000</p>
                </div>
            </div>
        </div>

    </div>



    {{-- DAILY ACTIVITY --}}
    <div class="container my-4">
        <h4 class="mb-3 text-center text-primary">📅 DAILY ACTIVITY</h4>

        <!-- Aktivitas Pribadi -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">1. Aktivitas Pribadi</div>
            <div class="card-body p-0">
                <table class="table table-bordered table-sm mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Aktivitas</th>
                            <th>Deskripsi</th>
                            <th>Target Daily</th>
                            <th>Target</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Niat & Doa Pagi</td>
                            <td>Niatkan untuk memberi manfaat kepada sesama Muslim melalui coaching</td>
                            <td>1</td>
                            <td>26</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Review Target Harian</td>
                            <td>Melihat kembali target prospek dan closing</td>
                            <td>1</td>
                            <td>26</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Belajar dan Catat</td>
                            <td>Apa tambahan Ilmu dan perbaikan saya hari ini</td>
                            <td>1</td>
                            <td>26</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Aktivitas Mencari Leads -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">2. Aktivitas Mencari Leads</div>
            <div class="card-body p-0">
                <table class="table table-bordered table-sm mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Aktivitas</th>
                            <th>Deskripsi</th>
                            <th>Target Daily</th>
                            <th>Target</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Konten Harian (Story, Feed, TikTok, dll.)</td>
                            <td>Posting Edukasi, testimoni, penawaran soft selling (bergantian)</td>
                            <td>4</td>
                            <td>104</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>List Building / Sales Plan</td>
                            <td>Tambah database baru WA, email, atau DM list</td>
                            <td>5</td>
                            <td>130</td>
                        </tr>
                        <tr>
                            <td rowspan="3">3</td>
                            <td>Interaksi Manual</td>
                            <td>Komentar</td>
                            <td>10</td>
                            <td>260</td>
                        </tr>
                        <tr>
                            <td>Follow akun market</td>
                            <td></td>
                            <td>100</td>
                            <td>2600</td>
                        </tr>
                        <tr>
                            <td>Like</td>
                            <td></td>
                            <td>100</td>
                            <td>2600</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Join Komunitas</td>
                            <td>Bergabung ke grup yang prospek</td>
                            <td>1</td>
                            <td>26</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Aktivitas Memprospek -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-white">3. Aktivitas Memprospek</div>
            <div class="card-body p-0">
                <table class="table table-bordered table-sm mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Aktivitas</th>
                            <th>Deskripsi</th>
                            <th>Target Daily</th>
                            <th>Target</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Follow-Up Soft</td>
                            <td>Kirim konten edukatif, reminder kelas, testimoni</td>
                            <td>200</td>
                            <td>560</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Membangun Hubungan</td>
                            <td>Menggali masalah dan impian calon peserta</td>
                            <td>20</td>
                            <td>520</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Kirim Penawaran</td>
                            <td>Kirim info kelas dengan penjelasan manfaat</td>
                            <td>20</td>
                            <td>520</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Aktivitas Closing -->
        <div class="card mb-4">
            <div class="card-header bg-danger text-white">4. Aktivitas Closing</div>
            <div class="card-body p-0">
                <table class="table table-bordered table-sm mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Aktivitas</th>
                            <th>Deskripsi</th>
                            <th>Target Daily</th>
                            <th>Target</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Tanya Keberatan</td>
                            <td>Apa yang menghambat mereka daftar?</td>
                            <td>20</td>
                            <td>520</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Atasi Keberatan</td>
                            <td>Kirim voice note, testimoni, atau diskusi</td>
                            <td>20</td>
                            <td>520</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Penawaran Khusus</td>
                            <td>Diskon, bonus, urgency terbatas</td>
                            <td>10</td>
                            <td>260</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Pendaftaran</td>
                            <td>Fix mengikuti dan hadir kelas</td>
                            <td>2,500,000</td>
                            <td>50,000,000</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Finalisasi Pembayaran</td>
                            <td>Kirim link invoice, konfirmasi pembayaran</td>
                            <td>2,500,000</td>
                            <td>50,000,000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Aktivitas Merawat Customer -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">5. Aktivitas Merawat Customer</div>
            <div class="card-body p-0">
                <table class="table table-bordered table-sm mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Aktivitas</th>
                            <th>Deskripsi</th>
                            <th>Target Daily</th>
                            <th>Target</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Follow-up Peserta</td>
                            <td>Bangun Hubungan, tanya progress, kirim semangat</td>
                            <td>50</td>
                            <td>1300</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Minta Testimoni</td>
                            <td>Peserta yang puas diminta testimoni</td>
                            <td>3</td>
                            <td>6</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Program Referral</td>
                            <td>Ajak mereka referensikan teman</td>
                            <td>10</td>
                            <td>260</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Edukasi Lanjutan</td>
                            <td>Kirim konten lanjutan/upgrade kelas berikutnya</td>
                            <td>20</td>
                            <td>520</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Komentar Positive</td>
                            <td>Komentari positif untuk peserta MBC</td>
                            <td>10</td>
                            <td>260</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    {{-- CATATAN KOMISI --}}
    <!-- <div class="card mt-4 border-dark shadow-sm">
        <div class="card-header bg-white font-weight-bold text-dark">
            📝 CATATAN KOMISI
        </div>
        <div class="card-body">
            <ul>
                <li>Komisi Leader: 1% dari omset</li>
                <li>Komisi CS: 0.5% dari omset</li>
                <li>Bonus Rp 300.000 jika omset ≥ 25 juta per kelas</li>
                <li>Bonus Rp 600.000 jika total omset ≥ 50 juta (meski target kelas belum tercapai)</li>
            </ul>
        </div>
    </div> -->
</div>

@endsection