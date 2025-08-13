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
    <h1 class="h3 mb-0 text-gray-800">Sales Plan /  HRD Mastery</h1>   
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Sales Plan</li>
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
    <div style="overflow-x: auto; white-space: nowrap;">
        <table style="border-collapse: collapse; width: 100%; text-align: center; font-family: Arial, sans-serif; font-size: 14px; min-width: 1300px;">
            <thead>
                <tr style="background: linear-gradient(to right, #376bb9ff, #1c7f91ff); color: white;">
                    <th rowspan="2" style="padding: 10px; border: 1px solid #ccc;">No</th>
                    <th rowspan="2" style="padding: 10px; border: 1px solid #ccc;">Nama</th>
                    <th rowspan="2" style="padding: 10px; border: 1px solid #ccc;">Situasi</th>
                    <th rowspan="2" style="padding: 10px; border: 1px solid #ccc;">Kendala</th>
                    @for ($i = 1; $i <= 5; $i++)
                        <th colspan="3" style="padding: 10px; border: 1px solid #ccc;">FU{{ $i }}</th>
                        @endfor
                        <th rowspan="2" style="padding: 10px; border: 1px solid #ccc;">Potensi</th>
                        <th rowspan="2" style="padding: 10px; border: 1px solid #ccc;">Keterangan</th>
                        <th rowspan="2" style="padding: 10px; border: 1px solid #ccc;">Status</th>
                        <th rowspan="2" style="padding: 10px; border: 1px solid #ccc;">Action</th>
                </tr>
                <tr style="background: linear-gradient(to right, #376bb9ff, #1c7f91ff); color: white;">
                    @for ($i = 1; $i <= 5; $i++)
                        <th style="padding: 8px; border: 1px solid #ccc;">Hasil</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Tindak Lanjut</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Aksi</th>
                        @endfor
                </tr>
            </thead>
            <tbody>
                @forelse ($salesplans as $plan)
                <tr class="
                @if($plan->status == 'hot') table-success
                @elseif($plan->status == 'warm') table-warning
                @elseif($plan->status == 'no') table-danger
                @endif"
                    style="background: linear-gradient(to right, #e6e7e9ff, #fafbfcff); color: black;">

                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $loop->iteration }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $plan->data->nama ?? '-' }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $plan->data->situasi_bisnis ?? '-' }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $plan->data->kendala ?? '-' }}</td>

                    {{-- FU1 - FU5 --}}
                    @for ($i = 1; $i <= 5; $i++)
                        {{-- Hasil --}}
                        <td style="padding: 8px; border: 1px solid #ccc;">
                        {{ $plan->{'fu'.$i.'_hasil'} ?? '-' }}
                        </td>

                        {{-- Tindak Lanjut --}}
                        <td style="padding: 8px; border: 1px solid #ccc;">
                            {{ $plan->{'fu'.$i.'_tindak_lanjut'} ?? '-' }}
                        </td>

                        {{-- Aksi --}}
                        <td style="padding: 8px; border: 1px solid #ccc; text-align: center;">
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editFU{{ $i }}Modal{{ $plan->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>

                        {{-- Modal Edit FU --}}
                        <div class="modal fade" id="editFU{{ $i }}Modal{{ $plan->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <form method="POST" action="{{ route('admin.salesplan.update-fu', [$plan->id, $i]) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit FU{{ $i }}</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>FU{{ $i }} Hasil</label>
                                                <input type="text" name="fu{{ $i }}_hasil" class="form-control" value="{{ $plan->{'fu'.$i.'_hasil'} }}">
                                            </div>
                                            <div class="form-group">
                                                <label>FU{{ $i }} Tindak Lanjut</label>
                                                <input type="text" name="fu{{ $i }}_tindak_lanjut" class="form-control" value="{{ $plan->{'fu'.$i.'_tindak_lanjut'} }}">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Simpan</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endfor

                        <td style="padding: 8px; border: 1px solid #ccc;">Rp {{ number_format($plan->nominal, 0, ',', '.') }}</td>
                        <td style="padding: 8px; border: 1px solid #ccc;">{{ $plan->keterangan }}</td>
                        <td style="padding: 8px; border: 1px solid #ccc; color: white;">
                            <span class="badge 
                    @if($plan->status == 'cold') bg-secondary
                    @elseif($plan->status == 'warm') bg-warning
                    @elseif($plan->status == 'hot') bg-success
                    @elseif($plan->status == 'no') bg-danger
                    @else bg-light
                    @endif"
                                style="padding: 6px 12px; font-size: 13px;">
                                {{ ucfirst($plan->status) }}
                            </span>
                        </td>
                        <td style="padding: 8px; border: 1px solid #ccc;">
                            <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editModal{{ $plan->id }}">
                                <i class="fas fa-pen"></i>
                            </button>
                        </td>
                </tr>
                @empty
                <tr>
                    <td colspan="22" style="text-align: center; padding: 20px; color: #999;">
                        Tidak ada data sales plan ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>



    <!-- Modal Edit -->
    <div class="modal fade" id="editModal{{ $plan->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $plan->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST" action="{{ route('admin.salesplan.update', $plan->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $plan->id }}">Edit Sales Plan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row">
        
                            <div class="form-group col-md-6">
                            <label>FU{{ $i }} Hasil</label>
                            <input type="text" name="fu{{ $i }}_hasil" class="form-control" value="{{ $plan->{'fu'.$i.'_hasil'} }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>FU{{ $i }} Tindak Lanjut</label>
                        <input type="text" name="fu{{ $i }}_tindak_lanjut" class="form-control" value="{{ $plan->{'fu'.$i.'_tindak_lanjut'} }}">
                    </div>
          
                    <div class="form-group col-md-12">
                        <label for="nominal">Potensi</label>
                        <input type="number" name="nominal" class="form-control" id="nominal" placeholder="Masukkan nominal">
                    </div>

                    <div class="form-group col-md-12">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="2">{{ $plan->keterangan }}</textarea>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="cold" {{ $plan->status == 'cold' ? 'selected' : '' }}>cold</option>
                            <option value="warm" {{ $plan->status == 'warm' ? 'selected' : '' }}>Mau Transfer</option>
                            <option value="hot" {{ $plan->status == 'hot' ? 'selected' : '' }}>Sudah Transfer</option>
                            <option value="no" {{ $plan->status == 'no' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
        </div>
        </form>
    </div>
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