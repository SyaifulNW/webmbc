@extends('layouts.masteradmin')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Sales Plan</h1>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Sales Plan</li>
        </ol>
    </div>
</div>

<div class="content">
    <div class="card card-info card-outline">
        <div class="card-header">
            <h3 class="card-title">Sales Plan untuk Kelas: {{ $kelas }}</h3>
        </div>
        <div class="card-body">
            <div style="overflow-x: auto; overflow-y: auto; width: 100%; max-height: 600px;">
                <table id="myTable" class="table table-bordered table-striped nowrap" style="width: max-content;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Sumber Lead</th>
                            <th>Nama Bisnis</th>
                            <th>Kendala</th>
                            @for ($i = 1; $i <= 8; $i++)
                                <th>FU {{ $i }}<br><small>Hasil & Rencana</small></th>
                            @endfor
                            <th>Keterangan</th>
                            <th>Indikator Warna</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr>
                            <form action="{{ route('sales-plan.update', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->sumber_lead }}</td>
                                <td>{{ $item->nama_bisnis }}</td>
                                <td>{{ $item->kendala }}</td>
                                
                                @for ($i = 1; $i <= 8; $i++)
                                    <td>
                                        <input type="text" name="fu{{ $i }}_hasil" class="form-control mb-1" placeholder="Hasil" value="{{ $item->{'fu'.$i.'_hasil'} }}">
                                        <input type="text" name="fu{{ $i }}_rencana" class="form-control" placeholder="Rencana" value="{{ $item->{'fu'.$i.'_rencana'} }}">
                                    </td>
                                @endfor

                                <td>
                                    <textarea name="keterangan" class="form-control" rows="2">{{ $item->keterangan }}</textarea>
                                </td>
                                <td>
                                    <select name="indikator_warna" class="form-control">
                                        <option value="green" {{ $item->indikator_warna == 'green' ? 'selected' : '' }}>Green</option>
                                        <option value="yellow" {{ $item->indikator_warna == 'yellow' ? 'selected' : '' }}>Yellow</option>
                                        <option value="red" {{ $item->indikator_warna == 'red' ? 'selected' : '' }}>Red</option>
                                    </select>
                                </td>
                                <td>
                                    <!-- Show -->
                                    <a href="{{ route('sales-plan.show', [$kelas, $item->id]) }}" class="btn btn-info btn-sm">
                                        <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                                    </a>
                                    <a href="{{ route('sales-plan.edit', [$kelas, $item->id]) }}" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-pencil" style="color: #ffffff;"></i>
                                    </a>

                                </td>
                            </form>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
