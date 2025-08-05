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
    <h1 class="h3 mb-0 text-gray-800">Sales Plan</h1>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Sales Plan</li>
        </ol>
    </div>
</div>

<div class="container">
    <div style="overflow-x: auto; white-space: nowrap;">
        <table style="border-collapse: collapse; width: 100%; text-align: center; font-family: Arial, sans-serif; font-size: 14px; min-width: 1200px;">
            <thead>
                <tr style="background: linear-gradient(to right, #376bb9ff, #1c7f91ff); color: white;">
                    <th rowspan="2" style="text-align:center; padding: 10px; border: 1px solid #ccc;">Kelas</th>
                    <th rowspan="2" style="text-align:center; padding: 10px; border: 1px solid #ccc;">Nama</th>
                    <th rowspan="2" style="text-align:center; padding: 10px; border: 1px solid #ccc;">Sumber Lead</th>
                    <th rowspan="2" style="text-align:center; padding: 10px; border: 1px solid #ccc;">Situasi</th>
                    <th rowspan="2" style="text-align:center; padding: 10px; border: 1px solid #ccc;">Kendala</th>
                    <th colspan="2" style="text-align:center; padding: 10px; border: 1px solid #ccc;">FU1</th>
                    <th colspan="2" style="text-align:center; padding: 10px; border: 1px solid #ccc;">FU2</th>
                    <th colspan="2" style="text-align:center; padding: 10px; border: 1px solid #ccc;">FU3</th>
                    <th colspan="2" style="text-align:center; padding: 10px; border: 1px solid #ccc;">FU4</th>
                    <th colspan="2" style="text-align:center; padding: 10px; border: 1px solid #ccc;">FU5</th>
                    <th rowspan="2" style=" text-align:center; padding: 10px; border: 1px solid #ccc;">Keterangan</th>
                    <th rowspan="2" style="text-align:center; padding: 10px; border: 1px solid #ccc;">Status</th>
                    <th rowspan="2" style="text-align:center; padding: 10px; border: 1px solid #ccc;">Action</th>

                </tr>
                <tr style="background: linear-gradient(to right, #376bb9ff, #1c7f91ff); color: white;">
                    <th style="padding: 8px; border: 1px solid #ccc;">Hasil</th>
                    <th style="padding: 8px; border: 1px solid #ccc;">Tindak Lanjut</th>
                    <th style="padding: 8px; border: 1px solid #ccc;">Hasil</th>
                    <th style="padding: 8px; border: 1px solid #ccc;">Tindak Lanjut</th>
                    <th style="padding: 8px; border: 1px solid #ccc;">Hasil</th>
                    <th style="padding: 8px; border: 1px solid #ccc;">Tindak Lanjut</th>
                    <th style="padding: 8px; border: 1px solid #ccc;">Hasil</th>
                    <th style="padding: 8px; border: 1px solid #ccc;">Tindak Lanjut</th>
                    <th style="padding: 8px; border: 1px solid #ccc;">Hasil</th>
                    <th style="padding: 8px; border: 1px solid #ccc;">Tindak Lanjut</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salesplans as $plan)
                @php
                if ($plan->status === 'cold') {
                $bgColor = 'background-color: #ffffffff;'; 
                } elseif ($plan->status === 'Warm') {
                $bgColor = 'background-color: #f3ff52ff;'; 
                } elseif ($plan->status === 'No') {
                $bgColor = 'background-color: #45f035ff;'; 
                } else {
                $bgColor = 'background-color: #e92525ff;';
                }
                @endphp
                <tr style="background: linear-gradient(to right, #e6e7e9ff, #fafbfcff); color: black;">
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $plan->data->kelas->nama_kelas ?? '-' }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $plan->data->nama ?? '-' }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $plan->data->leads ?? '-' }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $plan->data->situasi_bisnis ?? '-' }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $plan->data->kendala ?? '-' }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $plan->fu1_hasil }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $plan->fu1_tindak_lanjut }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $plan->fu2_hasil }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $plan->fu2_tindak_lanjut }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $plan->fu3_hasil }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $plan->fu3_tindak_lanjut }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $plan->fu4_hasil }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $plan->fu4_tindak_lanjut }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $plan->fu5_hasil }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $plan->fu5_tindak_lanjut }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $plan->keterangan }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $plan->status }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">
                        <button class="btn btn-sm btn-warning" data-toggle="modal"
                            data-target="#editModal{{ $plan->id }}">
                            <i class="fas fa-pen"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
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
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="form-group col-md-6">
                            <label>FU{{ $i }} Hasil</label>
                            <input type="text" name="fu{{ $i }}_hasil" class="form-control" value="{{ $plan->{'fu'.$i.'_hasil'} }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label>FU{{ $i }} Tindak Lanjut</label>
                        <input type="text" name="fu{{ $i }}_tindak_lanjut" class="form-control" value="{{ $plan->{'fu'.$i.'_tindak_lanjut'} }}">
                    </div>
                    @endfor

                    <div class="form-group col-md-12">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="2">{{ $plan->keterangan }}</textarea>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="cold" {{ $plan->status == 'cold' ? 'selected' : '' }}>Cold</option>
                            <option value="warm" {{ $plan->status == 'warm' ? 'selected' : '' }}>Warm</option>
                            <option value="hot" {{ $plan->status == 'hot' ? 'selected' : '' }}>Hot</option>
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


</div>
@endsection