@extends('layouts.masteradmin')
@section('content')
<div class="container-fluid px-4">
    <h3 class="mb-4">Edit Database CRM</h3>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Edit Data CRM
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.database.update', $crm->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $crm->nama }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Sumnber Leads</label>
                    <input type="text" class="form-control" id="leads" name="leads" value="{{ $crm->leads }}" required>
                </div>
                <div class="mb-3">
                    <label for="telepon" class="form-label">Kota</label>
                    <input type="text" class="form-control" id="kota" name="kota" value="{{ $crm->kota }}" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Nama Bisnis</label>
                    <input type="text" class="form-control" id="nama_bisnis" name="nama_bisnis" value="{{ $crm->nama_bisnis }}" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">No WA</label>
                    <input type="text" class="form-control" id="no_wa" name="no_wa" value="{{ $crm->no_wa }}" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Kendala</label>
                    <input type="text" class="form-control" id="kendala" name="kendala" value="{{ $crm->kendala }}" >
                </div>
                <div class="mb-3">
                    <label for="fu1" class="form-label">FU1</label>
                    <input type="text" class="form-control" id="fu1" name="fu1" value="{{ $crm->fu1 }}">
                </div>
                <div class="mb-3">
                    <label for="fu2" class="form-label">FU2</label>
                    <input type="text" class="form-control" id="fu2" name="fu2" value="{{ $crm->fu2 }}">
                </div>
                <div class="mb-3">
                    <label for="fu3" class="form-label">FU3</label>
                    <input type="text" class="form-control" id="fu3" name="fu3" value="{{ $crm->fu3 }}">
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="cold" {{ $crm->status == 'cold' ? 'selected' : '' }}>Cold</option>
                        <option value="warm" {{ $crm->status == 'warm' ? 'selected' : '' }}>Warm</option>
                        <option value="hot" {{ $crm->status == 'hot' ? 'selected' : '' }}>Hot</option>
                        <option value="hot" {{ $crm->status == 'No' ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.database.database') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection

