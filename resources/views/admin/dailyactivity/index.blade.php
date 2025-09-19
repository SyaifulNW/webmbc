@extends('layouts.masteradmin')

@section('content')
<div class="container my-4">
    <h4 class="mb-3 text-center text-primary">📅 DAILY ACTIVITY</h4>

    <form id="daily-activity-form" action="{{ route('admin.daily-activity.store') }}" method="POST">
        @csrf

    <div class="mb-3">
    <label><strong>Tanggal:</strong></label>
    <input type="date" name="tanggal" class="form-control" 
           value="{{ $tanggal }}"
           onchange="window.location='?tanggal=' + this.value">
</div>


        @foreach($activities as $kategoriId => $list)
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    {{ $list->first()->kategori->nama ?? 'Tanpa Kategori' }}
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0 table-sm align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width:5%">No</th>
                                <th style="width:25%">Aktivitas</th>
                                <th style="width:10%">Target Daily</th>
                                <th style="width:10%">Target Bulan</th>
                                <th style="width:10%">Bobot</th>
                                <th style="width:15%">Realisasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $i => $act)
                                <tr>
                                    <td class="text-center">{{ $i+1 }}</td>
                                    <td>{{ $act->nama }}</td>
                                    <td class="text-center">{{ $act->target_daily }}</td>
                                    <td class="text-center">{{ $act->target_bulanan }}</td>
                                    <td class="text-center">{{ $act->bobot }}</td>
                                    <td>
                                        <input type="number" 
                                               name="realisasi[{{ $act->id }}]" 
                                               class="form-control form-control-sm"
                                               min="0"
                                               value="{{ $daily[$act->id] ?? 0 }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-success">
            💾 Simpan Aktivitas
        </button>
    </form>
    {{-- ================= KPI BULANAN ================= --}}
<div class="card mt-5">
    <div class="card-header bg-info text-white text-center">
        KEY PERFORMANCE INDEX CS MBC
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered mb-0 text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Aktivitas</th>
                    <th>Target</th>
                    <th>Bobot</th>
                    <th>Presentase</th>
                    <th>Nilai</th>
                </tr>
            </thead>
          <tbody>
    @foreach($kpiData as $i => $row)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $row['nama'] }}</td>
            <td>{{ $row['target'] }}</td>
            <td>{{ $row['bobot'] }}</td>
            <td>{{ $row['persentase'] }}%</td>   {{-- ini ganti realisasi --}}
            <td>{{ number_format($row['nilai'],2) }}</td>
        </tr>
    @endforeach
    <tr class="table-success fw-bold">
        <td colspan="3">Total</td>
        <td>{{ $totalBobot }}</td>
        <td></td>
        <td>{{ number_format($totalNilai,2) }}</td>
    </tr>
</tbody>

        </table>
    </div>
</div>
{{-- ==================================================== --}}

</div>


@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
    $('#daily-activity-form').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let url = form.attr('action');
        let data = form.serialize();

        Swal.fire({
            title: 'Menyimpan...',
            text: 'Harap tunggu',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.post(url, data)
            .done(function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: response.message || 'Data berhasil disimpan',
                    timer: 2000,
                    showConfirmButton: false
                });
            })
            .fail(function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: xhr.responseJSON?.message || 'Terjadi kesalahan saat menyimpan',
                });
            });
    });
});
</script>
@endpush
