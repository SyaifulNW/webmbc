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

<p class="text-muted">Menampilkan data untuk bulan: <strong>{{ \Carbon\Carbon::parse(request('bulan'))->translatedFormat('F Y') }}</strong></p>


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
            <h5 class="mt-3">Total Omset: <span class="badge bg-success text-white">-</span></h5>
        </div>
    </div>

    {{-- Informasi Utama --}}
    <div class="row">

  <div class="col-md-3">
    <div class="card border-primary shadow-sm mb-3">
        <div class="card-header bg-white text-primary fw-bold">
            <i class="fas fa-thumbtack me-1"></i> JUMLAH LEAD AKTIF
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.salesplan.index', ['status' => 'cold']) }}" class="text-decoration-none text-dark">
                        Cold
                    </a>
                    <span class="badge bg-secondary text-white">{{ $cold }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.salesplan.index', ['status' => 'warm']) }}" class="text-decoration-none text-dark">
                        Warm
                    </a>
                    <span class="badge bg-warning text-white">{{ $warm }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.salesplan.index', ['status' => 'hot']) }}" class="text-decoration-none text-dark">
                        Hot
                    </a>
                    <span class="badge bg-success text-white">{{ $hot }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.salesplan.index', ['status' => 'no']) }}" class="text-decoration-none text-dark">
                        No
                    </a>
                    <span class="badge bg-danger text-white">{{ $no }}</span>
                </li>
            </ul>
            <p class="mb-0 text-end">
                <strong>Total Lead Aktif:</strong> {{ $totalLeadAktif }}
            </p>
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
            <p>Total Semua Lead:
                <span class="badge bg-info text-white">12</span>
            </p>
            <p>Jumlah Lead Kelas:
                <span class="badge bg-info text-white">13</span>
            </p>
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




<style>
    .daily-activity-table th, 
    .daily-activity-table td {
        font-size: 14px;         /* ukuran font lebih besar */
        padding: 10px 6px;       /* jarak dalam sel lebih lega */
        min-width: 45px;         /* kolom tanggal seragam */
        vertical-align: middle;  /* teks rata tengah secara vertikal */
    }

    .daily-activity-table th[rowspan] {
        min-width: 80px;         /* kolom No/Aktivitas/Target lebih lebar */
    }

    .daily-activity-table th,
    .daily-activity-table td {
        border: 1px solid #999;  /* border lebih tegas */
    }

    .daily-activity-table thead th {
        background-color: #f8f9fa; /* latar header */
        font-weight: bold;
    }
</style>

<div class="container my-4">


    @php
        $dates = range(1, 31);
    @endphp

    <!-- Aktivitas 1 -->
 <style>
    .daily-activity-table th, 
    .daily-activity-table td {
        font-size: 14px;
        padding: 10px 6px;
        min-width: 45px;
        vertical-align: middle;
    }
    .daily-activity-table th[rowspan] {
        min-width: 80px;
    }
    .daily-activity-table th,
    .daily-activity-table td {
        border: 1px solid #999;
    }
    .daily-activity-table thead th {
        background-color: #f8f9fa;
        font-weight: bold;
    }
</style>

<div class="container my-4">
    <h4 class="mb-3 text-center text-primary">📅 DAILY ACTIVITY</h4>

      <div class="card mb-4">
        <div class="card-header bg-primary text-white">1. Aktivitas Pribadi</div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-bordered table-sm text-center align-middle mb-0 daily-activity-table">
                <thead class="table-info">
                    <tr>
                        <th>No</th>
                        <th>Aktivitas</th>
                        <th>Deskripsi</th>
                        <th>Target Daily</th>
                        <th>Target</th>
                        <th>Bobot</th>
                        <th>Real</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Niat & Doa Pagi</td>
                        <td>Niatan untuk memberi manfaat kepada sesama Muslim melalui coaching</td>
                        <td>1</td>
                        <td>26</td>
                        <td>30</td>
                        <td>21</td>
                        <td>24</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Review Target Harian</td>
                        <td>Melihat kembali target prospek dan closing</td>
                        <td>1</td>
                        <td>26</td>
                        <td>20</td>
                        <td>21</td>
                        <td>16</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Belajar dan Catat</td>
                        <td>Apa tambahan ilmu dan perbaikan saya hari ini</td>
                        <td>1</td>
                        <td>26</td>
                        <td>50</td>
                        <td>21</td>
                        <td>40</td>
                    </tr>
                    <!-- Total Row -->
                    <tr class="fw-bold text-white" style="background-color: limegreen;">
                        <td colspan="5" class="text-center">Total</td>
                        <td>100</td>
                        <td>63</td>
                        <td>81</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- 1. Aktivitas Mencari Leads -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">2. Aktivitas Mencari Leads</div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-bordered table-sm text-center align-middle mb-0">
                <thead class="table-info">
                    <tr>
                        <th>No</th>
                        <th>Aktivitas</th>
                        <th>Target Daily</th>
                        <th>Target</th>
                        <th>Bobot</th>
                        <th>Real</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1</td><td>Konten Harian (Story, Feed, TikTok, dll.)</td><td>4</td><td>104</td><td>20</td><td>90</td><td>17.30769231</td></tr>
                    <tr><td>2</td><td>List Building / sales plan</td><td>5</td><td>130</td><td>40</td><td>41</td><td>12.61538462</td></tr>
                    <tr><td rowspan="3">3</td><td>Interaksi Manual - Komentar</td><td>10</td><td>260</td><td>10</td><td>57</td><td>2.192307692</td></tr>
                    <tr><td>Interaksi Manual - Follow akun market</td><td>100</td><td>2600</td><td>10</td><td>0</td><td>0</td></tr>
                    <tr><td>Interaksi Manual - Like</td><td>100</td><td>2600</td><td>10</td><td>2525</td><td>9.711538462</td></tr>
                    <tr><td>4</td><td>Join Komunitas</td><td>1</td><td>26</td><td>10</td><td>21</td><td>8.076923077</td></tr>
                    <tr class="fw-bold text-white" style="background-color: limegreen;">
                        <td colspan="4" class="text-center">Total</td><td>100</td><td>2734</td><td>41.82692308</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 2. Aktivitas Memprospek -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">3. Aktivitas Memprospek</div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-bordered table-sm text-center align-middle mb-0">
                <thead class="table-info">
                    <tr>
                        <th>No</th>
                        <th>Aktivitas</th>
                        <th>Target Daily</th>
                        <th>Target</th>
                        <th>Bobot</th>
                        <th>Real</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1</td><td>Follow-Up Soft</td><td>200</td><td>560</td><td>60</td><td>6782</td><td>726.6428571</td></tr>
                    <tr><td>2</td><td>Membangun Hubungan</td><td>20</td><td>520</td><td>20</td><td>48</td><td>1.846153846</td></tr>
                    <tr><td>3</td><td>Kirim Penawaran</td><td>20</td><td>520</td><td>20</td><td>66</td><td>2.538461538</td></tr>
                    <tr class="fw-bold text-white" style="background-color: limegreen;">
                        <td colspan="4" class="text-center">Total</td><td>100</td><td>6896</td><td>731.0274725</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 3. Aktivitas Closing -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">4. Aktivitas Closing</div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-bordered table-sm text-center align-middle mb-0">
                <thead class="table-info">
                    <tr>
                        <th>No</th>
                        <th>Aktivitas</th>
                        <th>Target Daily</th>
                        <th>Target</th>
                        <th>Bobot</th>
                        <th>Real</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1</td><td>Tanya Keberatan</td><td>20</td><td>520</td><td>20</td><td>25</td><td>0.9615384615</td></tr>
                    <tr><td>2</td><td>Atasi Keberatan</td><td>20</td><td>520</td><td>20</td><td>65</td><td>2.5</td></tr>
                    <tr><td>3</td><td>Penawaran Khusus</td><td>10</td><td>260</td><td>20</td><td>33</td><td>2.538461538</td></tr>
                    <tr><td>4</td><td>Pendaftaran</td><td>2,500,000</td><td>50,000,000.00</td><td>20</td><td>11</td><td>0.0000044</td></tr>
                    <tr><td>5</td><td>Finalisasi Pembayaran</td><td>2,500,000</td><td>50,000,000.00</td><td>20</td><td>7</td><td>0.0000028</td></tr>
                    <tr class="fw-bold text-white" style="background-color: limegreen;">
                        <td colspan="4" class="text-center">Total</td><td>100</td><td>141</td><td>6.0000072</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 4. Aktivitas Merawat Customer -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">5. Aktivitas Merawat Customer</div>
        <div class="card-body p-0 table-responsive">
            <table class="table table-bordered table-sm text-center align-middle mb-0">
                <thead class="table-info">
                    <tr>
                        <th>No</th>
                        <th>Aktivitas</th>
                        <th>Target Daily</th>
                        <th>Target</th>
                        <th>Bobot</th>
                        <th>Real</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1</td><td>Follow-up Peserta</td><td>50</td><td>1300</td><td>20</td><td>64</td><td>0.9846153846</td></tr>
                    <tr><td>2</td><td>Minta Testimoni</td><td>3</td><td>6</td><td>20</td><td>6</td><td>20</td></tr>
                    <tr><td>3</td><td>Program Referral</td><td>10</td><td>260</td><td>40</td><td>11</td><td>1.692307692</td></tr>
                    <tr><td>4</td><td>Edukasi Lanjutan</td><td>20</td><td>520</td><td>10</td><td>39</td><td>0.75</td></tr>
                    <tr><td>5</td><td>Komentar Positive</td><td>10</td><td>260</td><td>10</td><td>56</td><td>2.153846154</td></tr>
                    <tr class="fw-bold text-white" style="background-color: limegreen;">
                        <td colspan="4" class="text-center">Total</td><td>100</td><td>176</td><td>25.58076923</td>
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