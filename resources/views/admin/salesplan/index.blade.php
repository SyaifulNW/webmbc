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
                <td style="padding: 8px; border: 1px solid #ccc;" >
                      <a href="#" class="btn btn-warning btn-sm" title="Edit Data">
                                    <i class="fa-solid fa-pencil" style="color: #ffffff;"></i>
                                </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


</div>
@endsection