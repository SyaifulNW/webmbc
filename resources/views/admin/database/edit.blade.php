@extends('layouts.masteradmin')
@section('content')

<div class="container-fluid px-4">
    <h3 class="mb-4">Edit Database Peserta</h3>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Edit Data Peserta: {{ $data->nama }}
        </div>
        <div class="card-body">
            <form action="{{ route('admin.database.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama"
                        value="{{ old('nama', $data->nama) }}" required>
                </div>

                {{-- Status Peserta --}}
                <div class="mb-3">
                    <label for="status_peserta" class="form-label">Status Peserta</label>
                    <select class="form-select" id="status_peserta" name="status_peserta" required>
                        <option value="peserta_baru" {{ $data->status_peserta === 'peserta_baru' ? 'selected' : '' }}>Peserta Baru</option>
                        <option value="alumni" {{ $data->status_peserta === 'alumni' ? 'selected' : '' }}>Alumni</option>
                    </select>
                </div>

                {{-- Sumber Leads --}}
                <div class="form-group">
                    <label for="leads">Sumber Leads</label>
                    <select name="leads" id="leads" class="form-control">
                        <option value="Iklan" {{ $data->leads === 'Iklan' ? 'selected' : '' }}>Iklan</option>
                        <option value="Instagram" {{ $data->leads === 'Instagram' ? 'selected' : '' }}>Instagram</option>
                        <option value="Facebook" {{ $data->leads === 'Facebook' ? 'selected' : '' }}>Facebook</option>
                        <option value="Tiktok" {{ $data->leads === 'Tiktok' ? 'selected' : '' }}>Tiktok</option>
                        <option value="Lain-Lain" {{ $data->leads === 'Lain-Lain' ? 'selected' : '' }}>Lain-Lain</option>
                    </select>
                    <input type="text" name="leads_custom" class="form-control mt-2"
                        placeholder="Isi jika Lain-Lain"
                        value="{{ old('leads_custom', $data->leads_custom) }}">
                </div>

                {{-- Provinsi --}}
                <div class="form-group">
                    <label for="provinsi">Provinsi</label>
                    <select id="provinsi_disabled" class="form-control" disabled>
                        <option value="{{ $data->provinsi_id }}">{{ $data->provinsi_nama }}</option>
                    </select>
                    <input type="hidden" name="provinsi_id" value="{{ $data->provinsi_id }}">
                    <input type="hidden" name="provinsi_nama" value="{{ $data->provinsi_nama }}">
                </div>

                {{-- Kota --}}
                <div class="form-group">
                    <label for="kota">Kota</label>
                    <select id="kota_disabled" class="form-control" disabled>
                        <option value="{{ $data->kota_id }}">{{ $data->kota_nama }}</option>
                    </select>
                    <input type="hidden" name="kota_id" value="{{ $data->kota_id }}">
                    <input type="hidden" name="kota_nama" value="{{ $data->kota_nama }}">
                </div>


                {{-- Nama Bisnis --}}
                <div class="mb-3">
                    <label for="nama_bisnis" class="form-label">Nama Bisnis</label>
                    <input type="text" class="form-control" id="nama_bisnis" name="nama_bisnis"
                        value="{{ old('nama_bisnis', $data->nama_bisnis) }}" required>
                </div>

                {{-- Jenis Bisnis --}}
                <div class="mb-3">
                    <label for="jenisbisnis" class="form-label">Jenis Bisnis</label>
                    <select name="jenisbisnis" id="jenisbisnis" class="form-control">
                        @php
                        $jenisList = [
                        "Bisnis Properti",
                        "Bisnis Manufaktur",
                        "Bisnis F&B (Food & Beverage)",
                        "Bisnis Jasa",
                        "Bisnis Digital",
                        "Bisnis Online",
                        "Bisnis Franchise",
                        "Bisnis Edukasi & Pelatihan",
                        "Bisnis Kreatif",
                        "Bisnis Agribisnis",
                        "Bisnis Kesehatan & Kecantikan",
                        "Bisnis Keuangan",
                        "Bisnis Transportasi & Logistik",
                        "Bisnis Pariwisata & Hospitality",
                        "Bisnis Sosial (Social Enterprise)"
                        ];
                        @endphp
                        @foreach($jenisList as $jenis)
                        <option value="{{ $jenis }}" {{ $data->jenisbisnis === $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- No Whatsapp --}}
                <div class="mb-3">
                    <label for="no_wa" class="form-label">No. Whatsapp</label>
                    <input type="text" class="form-control" id="no_wa" name="no_wa"
                        value="{{ old('no_wa', $data->no_wa) }}" required>
                </div>

                {{-- Kendala --}}
                <div class="mb-3">
                    <label for="kendala" class="form-label">Kendala</label>
                    <textarea class="form-control" id="kendala" name="kendala" rows="3" required>{{ old('kendala', $data->kendala) }}</textarea>
                </div>

                {{-- Situasi Bisnis --}}
                <div class="mb-3">
                    <label for="situasi_bisnis" class="form-label">Situasi Bisnis</label>
                    <textarea class="form-control" id="situasi_bisnis" name="situasi_bisnis" rows="3" required>{{ old('situasi_bisnis', $data->situasi_bisnis) }}</textarea>
                </div>

 

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('admin.database.database') }}" class="btn btn-secondary">Kembali ke Daftar</a>
    </div>
</div>

@endsection