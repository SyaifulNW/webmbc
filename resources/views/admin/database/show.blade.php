@extends('layouts.masteradmin')
@section('content')

<div class="container-fluid px-4">
    <h3 class="mb-4">Detail Database</h3>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Detail Data CRM
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $crm->id }}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>{{ $crm->nama }}</td>
                </tr>
                <tr>
                    <th>Leads</th>
                    <td>{{ $crm->leads }}</td>
                </tr>
                <tr>
                    <th>Kota</th>
                    <td>{{ $crm->kota }}</td>
                </tr>
                <tr>
                    <th>Nama Bisnis</th>
                    <td>{{ $crm->nama_bisnis }}</td>
                </tr>
                <tr>
                    <th>No. Whatsapp</th>
                    <td>{{ $crm->no_wa }}</td>
                </tr>
                <tr>
                    <th>Total Omset</th>
                    <td>{{ $crm->total_omset }}</td>
                </tr>
                <tr>
                    <th>Kendala</th>
                    <td>{{ $crm->kendala }}</td>
                </tr>
                <tr>
                    <th>FU 1</th>
                    <td>{{ $crm->fu1 }}</td>
                </tr>
                <tr>
                    <th>FU 2</th>
                    <td>{{ $crm->fu2 }}</td>
                </tr>
                <tr>
                    <th>FU 3</th>
                    <td>{{ $crm->fu3 }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $crm->status }}</td>
                </tr>
                <!-- Add more fields as necessary -->
            </table>
        </div>
    </div>
    <div class="mt-3">
        <a href="{{ route('admin.database.database') }}" class="btn btn-secondary">Kembali ke Daftar</a>
    </div>
</div>





@endsection