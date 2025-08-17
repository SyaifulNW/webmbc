@extends('layouts.masteradmin')
@section('content')
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        font-size: 14px;
        padding: 6px;
        text-align: left;
    }

    @media only screen and (max-width: 768px) {

        table,
        thead,
        tbody,
        th,
        td,
        tr {
            display: block;
        }

        thead {
            display: none;
        }

        td {
            position: relative;
            padding-left: 50%;
        }

        td:before {
            position: absolute;
            left: 6px;
            white-space: nowrap;
            font-weight: bold;
        }

        td:nth-of-type(1):before {
            content: "Nama";
        }

        td:nth-of-type(2):before {
            content: "Kelas";
        }

        td:nth-of-type(3):before {
            content: "FU1 Hasil";
        }

        td:nth-of-type(4):before {
            content: "FU1 TL";
        }

        td:nth-of-type(5):before {
            content: "FU2 Hasil";
        }

        td:nth-of-type(6):before {
            content: "FU2 TL";
        }

        td:nth-of-type(7):before {
            content: "FU3 Hasil";
        }

        td:nth-of-type(8):before {
            content: "FU3 TL";
        }

        td:nth-of-type(9):before {
            content: "FU4 Hasil";
        }

        td:nth-of-type(10):before {
            content: "FU4 TL";
        }

        td:nth-of-type(11):before {
            content: "FU5 Hasil";
        }

        td:nth-of-type(12):before {
            content: "FU5 TL";
        }
    }
</style>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        Sales Plan
        @if($kelasFilter)
        / {{ $kelasFilter }}
        @endif
    </h1>

    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item">Sales Plan</li>
            @if($kelasFilter)
            <li class="breadcrumb-item active">{{ $kelasFilter }}</li>
            @endif
        </ol>
    </div>
</div>

@if(session('message'))
<div class="alert alert-info">
    {{ session('message') }}
</div>
@endif

@if($salesplans->isEmpty())
<div class="alert alert-info">
    Tidak ada data yang sesuai dengan filter.
</div>
@else
{{-- tampilkan tabel atau isi salesplans --}}
@endif

<div class="container">

    <a href="{{ route('salesplan.export') }}" class="btn btn-success mb-3">
        Download Excel
    </a>
    <div class="card shadow-lg border-0 rounded-lg mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-chart-line"></i> Daftar Sales Plan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="text-white" style="background-color:#25799E;">
                        <tr>
                            <th rowspan="3">No</th>
                            <th rowspan="3">Nama</th>
                            <th rowspan="3">Situasi Bisnis</th>
                            <th rowspan="3">Kendala</th>

                            {{-- Header grup untuk FU --}}
                            <th colspan="10" class="text-center">Follow Up</th>

                            <th rowspan="3">Potensi</th>
                            <th rowspan="3">Keterangan</th>
                            <th rowspan="3">Status</th>
                            <th rowspan="3">Aksi</th>
                            <th rowspan="3">Input Oleh</th>
                        </tr>
                        <tr>
                            {{-- Header FU 1 - 5 --}}
                            @for ($i = 1; $i <= 5; $i++)
                                <th colspan="2" class="text-center">FU {{ $i }}</th>
                                @endfor
                        </tr>
                        <tr>
                            {{-- Sub kolom Hasil & Tindak Lanjut --}}
                            @for ($i = 1; $i <= 5; $i++)
                                <th>Hasil</th>
                                <th>Tindak Lanjut</th>
                                @endfor
                        </tr>
                    </thead>



                    <tbody>
                        @forelse ($salesplans as $plan)
                        @php
                        $rowColors = [
                        'hot' => 'table-success', // hijau
                        'warm' => 'table-warning', // kuning
                        'No' => 'table-danger', // merah
                        'Cold' => 'table-secondary' // abu
                        ];

                        $statusTexts = [
                        'hot' => 'Sudah Transfer',
                        'warm' => 'Mau Transfer',
                        'No' => 'Tidak Transfer',
                        'Cold' => 'Belum Transfer',
                        ];

                        $rowClass = $rowColors[$plan->status] ?? '';
                        $badgeText = $statusTexts[$plan->status] ?? ucfirst($plan->status);
                        @endphp

                        <tr class="{{ $rowClass }}">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $plan->nama ?? '-' }}</td>
                            <td>{{ $plan->situasi_bisnis ?? '-' }}</td>
                            <td>{{ $plan->kendala ?? '-' }}</td>

                            @for ($i = 1; $i <= 5; $i++)
                                <td contenteditable="true" class="editable bg-light"
                                data-id="{{ $plan->id }}"
                                data-field="fu{{ $i }}_hasil">
                                {{ $plan->{'fu'.$i.'_hasil'} ?? '-' }}
                                </td>

                                <td contenteditable="true" class="editable text-dark"
                                    data-id="{{ $plan->id }}"
                                    data-field="fu{{ $i }}_tindak_lanjut">
                                    {{ $plan->{'fu'.$i.'_tindak_lanjut'} ?? '-' }}
                                </td>
                                @endfor

                                <td contenteditable="true" class="editable fw-bold text-dark text-bold"
                                    data-id="{{ $plan->id }}"
                                    data-field="nominal">
                                    {{ number_format($plan->nominal, 0, ',', '.') }}
                                </td>

                                <td contenteditable="true" class="editable"
                                    data-id="{{ $plan->id }}"
                                    data-field="keterangan">
                                    {{ $plan->keterangan }}
                                </td>
                                @php
                                $statusMap = [
                                'hot' => ['class' => 'bg-success text-white', 'text' => 'Sudah Transfer'],
                                'warm' => ['class' => 'bg-warning text-dark', 'text' => 'Mau Transfer'],
                                'No' => ['class' => 'bg-danger text-white', 'text' => 'Tidak Transfer'],
                                'Cold' => ['class' => 'bg-secondary text-white', 'text' => 'Cold'],
                                ];

                                $badge = $statusMap[$plan->status] ?? ['class' => 'bg-light text-dark', 'text' => ucfirst($plan->status)];
                                @endphp

                                <td class="text-center">
                                    <span class="badge {{ $badge['class'] }}" style="font-size: medium;">
                                        {{ $badge['text'] }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('admin.salesplan.edit', $plan->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                                <td>
                                    @switch($plan->created_by)
                                    @case(1)
                                    Administrator
                                    @break
                                    @case(2)
                                    Linda
                                    @break
                                    @case(3)
                                    Yasmin
                                    @break
                                    @case(4)
                                    Tursia
                                    @break
                                    @case(5)
                                    Livia
                                    @break
                                    @case(6)
                                    Shafa
                                    @break
                                    @default
                                    -
                                    @endswitch
                                </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="22" class="text-center text-muted">
                                Tidak ada data sales plan ditemukan.
                            </td>
                        </tr>

                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).on('blur', '.editable', function() {
            let id = $(this).data('id');
            let field = $(this).data('field');
            let value = $(this).text().trim();

            $.ajax({
                url: "{{ route('admin.salesplan.inline-update') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    field: field,
                    value: value
                },
                success: function(res) {
                    console.log("Update sukses:", res);
                },
                error: function(err) {
                    console.error("Gagal update:", err);
                    alert("Gagal update data!");
                }
            });
        });
    </script>


    <!-- Modal Edit Status Potensi Keterangan-->
    <!-- Modal Edit Status Potensi Keterangan -->
    <!-- Modal Edit Status Potensi Keterangan -->



</div>

{{-- Tabel Sales Plan yang sudah ada --}}

{{-- Tabel Daftar Peserta --}}
<h4 style="margin-top: 30px; font-weight: bold;">Daftar Peserta / HRD Mastery</h4>
<div style="overflow-x: auto; white-space: nowrap;">
    <table style="border-collapse: collapse; width: 100%; text-align: center; font-family: Arial, sans-serif; font-size: 14px; min-width: 500px;">
        <thead>
            <tr style="background: linear-gradient(to right, #376bb9ff, #1c7f91ff); color: white;">
                <th style="padding: 10px; border: 1px solid #ccc;">No</th>
                <th style="padding: 10px; border: 1px solid #ccc;">Nama</th>
                <th style="padding: 10px; border: 1px solid #ccc;">Nominal</th>
            </tr>
        </thead>
        <tbody>

            <tr style="background: #fdfdfd; color: black;">
                <td style="padding: 8px; border: 1px solid #ccc;"></td>
                <td style="padding: 8px; border: 1px solid #ccc;"></td>
                <td style="padding: 8px; border: 1px solid #ccc;"></td>
            </tr>

            <tr>
                <td colspan="3" style="text-align: center; padding: 15px; color: #999;">
                    Belum ada peserta yang transfer.
                </td>
            </tr>

        </tbody>
    </table>
</div>


</div>
<script>
    $(document).ready(function() {
        $('.status-cell').each(function() {
            const status = $(this).text().trim().toLowerCase();
            const row = $(this).closest('tr');

            switch (status) {
                case 'hot':
                    row.css('background-color', '#d4edda'); // Hijau muda
                    break;
                case 'warm':
                    row.css('background-color', '#fff3cd'); // Kuning muda
                    break;
                case 'cold':
                    row.css('background-color', '#ffffff'); // Putih (default)
                    break;
                case 'no':
                    row.css('background-color', '#f8d7da'); // Merah muda
                    break;
                default:
                    row.css('background-color', '#f0f0f0'); // Abu (jika status tidak dikenal)
            }
        });
    });
</script>


@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>