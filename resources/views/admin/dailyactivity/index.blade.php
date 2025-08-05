@extends('layouts.masteradmin')
@section('content')
<div class="container mt-4">
    <h3 class="text-center mb-4">Daily Activity</h3>

    {{-- Aktivitas Pribadi --}}
    <table class="table table-bordered text-center align-middle">
        <thead class="table-info">
            <tr>
                <th colspan="6">Aktivitas Pribadi</th>
                <th colspan="3" style="background: yellow;">Tanggal</th>
            </tr>
            <tr>
                <th>No</th>
                <th>Aktivitas</th>
                <th>Deskripsi</th>
                <th>Target Daily</th>
                <th>Target</th>
                <th>Bobot</th>
                <th>Real</th>
                <th>Nilai</th>
                <th>1</th>
                <th>2</th>
                <th>3</th>
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
                <td>3</td>
                <td>3</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Review Target Harian</td>
                <td>Melihat kembali target prospek dan closing</td>
                <td>1</td>
                <td>26</td>
                <td>20</td>
                <td>3</td>
                <td>2</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Belajar dan Catat</td>
                <td>Apa tambahan ilmu dan perbaikan saya hari ini</td>
                <td>1</td>
                <td>26</td>
                <td>50</td>
                <td>3</td>
                <td>6</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
            </tr>
            <tr class="table-success fw-bold">
                <td colspan="5" class="text-end">Total</td>
                <td>100</td>
                <td>9</td>
                <td>12</td>
                <td colspan="3"></td>
            </tr>
        </tbody>
    </table>

    {{-- Aktivitas Mencari Leads --}}
    <table class="table table-bordered text-center align-middle mt-5">
        <thead class="table-info">
            <tr>
                <th colspan="6">Aktivitas Mencari Leads</th>
            </tr>
            <tr>
                <th>No</th>
                <th>Aktivitas</th>
                <th>Deskripsi</th>
                <th>Target Daily</th>
                <th>Target</th>
                <th>Bobot</th>
                <th>Real</th>
                <th>Nilai</th>
                <th>1</th>
                <th>2</th>
                <th>3</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Konten Harian (Story, Feed, TikTok, dll.)</td>
                <td>Posting Edukasi, testimoni, penawaran soft selling (bergantian)</td>
                <td>4</td>
                <td>104</td>
                <td>20</td>
                <td>12</td>
                <td>2.31</td>
                <td>4</td>
                <td>4</td>
                <td></td>
            </tr>
            <tr>
                <td>2</td>
                <td>List Building / sales plan</td>
                <td>Tambah database baru WA, email, atau DM list</td>
                <td>5</td>
                <td>130</td>
                <td>40</td>
                <td>12</td>
                <td>3.69</td>
                <td>5</td>
                <td>4</td>
                <td></td>
            </tr>
            <tr>
                <td>3</td>
                <td>Interaksi Manual</td>
                <td>Komentar</td>
                <td>10</td>
                <td>260</td>
                <td>10</td>
                <td>8</td>
                <td>0.31</td>
                <td>3</td>
                <td>3</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>

@endsection




