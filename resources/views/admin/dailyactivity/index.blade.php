@extends('layouts.masteradmin') 
@section('content')
<div class="container mt-4">
    <h3 class="text-center mb-4">DAILY ACTIVITY</h3>

    <form action="{{ route('admin.daily-activity.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Tanggal:</label>
            <input type="date" name="tanggal" class="form-control" style="width: 200px;" required>
        </div>

        @php
            // Daftar aktivitas statis tanpa deskripsi
            $activities = [
                'pribadi' => [
                    ['aktivitas' => 'Niat & Doa Pagi', 'bobot' => 1],
                    ['aktivitas' => 'Review Target Harian', 'bobot' => 1],
                    ['aktivitas' => 'Belajar dan Catat', 'bobot' => 1],
                ],
                'mencari_leads' => [
                    ['aktivitas' => 'Konten Harian', 'bobot' => 4],
                    ['aktivitas' => 'List Building / Sales Plan', 'bobot' => 5],
                    ['aktivitas' => 'Interaksi Manual - Komentar', 'bobot' => 10],
                    ['aktivitas' => 'Interaksi Manual - Follow', 'bobot' => 100],
                    ['aktivitas' => 'Interaksi Manual - Like', 'bobot' => 100],
                    ['aktivitas' => 'Join Komunitas', 'bobot' => 1],
                ],
                'memprospek' => [
                    ['aktivitas' => 'Follow-Up Soft', 'bobot' => 200],
                    ['aktivitas' => 'Membangun Hubungan', 'bobot' => 20],
                    ['aktivitas' => 'Kirim Penawaran', 'bobot' => 20],
                ],
                'closing' => [
                    ['aktivitas' => 'Tanya Keberatan', 'bobot' => 20],
                    ['aktivitas' => 'Atasi Keberatan', 'bobot' => 20],
                    ['aktivitas' => 'Penawaran Khusus', 'bobot' => 10],
                    ['aktivitas' => 'Pendaftaran', 'bobot' => 2500000],
                    ['aktivitas' => 'Finalisasi Pembayaran', 'bobot' => 2500000],
                ],
                'merawat_customer' => [
                    ['aktivitas' => 'Follow-up Peserta', 'bobot' => 50],
                    ['aktivitas' => 'Minta Testimoni', 'bobot' => 3],
                    ['aktivitas' => 'Program Referral', 'bobot' => 10],
                    ['aktivitas' => 'Edukasi Lanjutan', 'bobot' => 20],
                    ['aktivitas' => 'Komentar Positif', 'bobot' => 10],
                ],
            ];
        @endphp

        @foreach ($activities as $kategori => $items)
            <div class="activity-section mb-4">
                <h5>{{ ucfirst(str_replace('_',' ', $kategori)) }}</h5>
                <table class="table table-bordered daily-table" data-kategori="{{ $kategori }}">
                    <thead>
                        <tr class="table-primary">
                            <th>No</th>
                            <th>Aktivitas</th>
                            <th>Target Daily</th>
                            <th>Realisasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $i => $item)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>{{ $item['aktivitas'] }}</td>
                                <td>
                                    <input type="number" 
                                           name="{{ $kategori }}[{{ $i }}][target]" 
                                           class="form-control" 
                                           value="{{ $item['bobot'] }}" 
                                           readonly>
                                    <input type="hidden" 
                                           name="{{ $kategori }}[{{ $i }}][bobot]" 
                                           value="{{ $item['bobot'] }}">
                                </td>
                                <td>
                                    <input type="number" 
                                           name="{{ $kategori }}[{{ $i }}][real]" 
                                           class="form-control real-input" 
                                           step="any" 
                                           required>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-secondary">
                            <th colspan="3" class="text-end">Total:</th>
                            <th class="total-cell">0</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary mt-3">Simpan Aktivitas</button>
    </form>
</div>

<script>
document.addEventListener('input', function(e) {
    if (e.target.classList.contains('real-input')) {
        const table = e.target.closest('.daily-table');
        let total = 0;
        table.querySelectorAll('.real-input').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        table.querySelector('.total-cell').textContent = total;
    }
});
</script>

@endsection
