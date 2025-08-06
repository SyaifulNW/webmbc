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
            $kategori = [
                'pribadi' => 'Aktivitas Pribadi',
                'mencari_leads' => 'Aktivitas Mencari Leads',
                'memprospek' => 'Aktivitas Memprospek',
                'closing' => 'Aktivitas Closing',
                'merawat_customer' => 'Aktivitas Merawat Customer',
            ];
        @endphp

        @foreach ($kategori as $key => $judul)
            <div class="activity-section mb-4">
                <h5>{{ $loop->iteration }}. {{ $judul }}</h5>
                <div id="{{ $key }}-container">
                    @for ($i = 0; $i < 1; $i++) {{-- Default 1 baris --}}
                        <div class="row mb-2">
                            <div class="col-md-3">
                                <input type="text" name="{{ $key }}[0][aktivitas]" placeholder="Aktivitas" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="{{ $key }}[0][deskripsi]" placeholder="Deskripsi" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="{{ $key }}[0][target]" placeholder="Target Daily" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="{{ $key }}[0][real]" placeholder="Real" class="form-control">
                            </div>
                        </div>
                    @endfor
                </div>
                <button type="button" class="btn btn-sm btn-secondary" onclick="addRow('{{ $key }}')">+ Tambah Aktivitas</button>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary mt-3">Simpan Aktivitas</button>
    </form>
</div>

<script>
    const counters = {
        pribadi: 1,
        mencari_leads: 1,
        memprospek: 1,
        closing: 1,
        merawat_customer: 1
    };

    function addRow(section) {
        const container = document.getElementById(`${section}-container`);
        const index = counters[section];

        const row = document.createElement('div');
        row.className = 'row mb-2';
        row.innerHTML = `
            <div class="col-md-3">
                <input type="text" name="${section}[${index}][aktivitas]" placeholder="Aktivitas" class="form-control">
            </div>
            <div class="col-md-3">
                <input type="text" name="${section}[${index}][deskripsi]" placeholder="Deskripsi" class="form-control">
            </div>
            <div class="col-md-2">
                <input type="number" name="${section}[${index}][target]" placeholder="Target Daily" class="form-control">
            </div>
            <div class="col-md-2">
                <input type="number" name="${section}[${index}][real]" placeholder="Real" class="form-control">
            </div>
        `;
        container.appendChild(row);
        counters[section]++;
    }
</script>
@endsection
