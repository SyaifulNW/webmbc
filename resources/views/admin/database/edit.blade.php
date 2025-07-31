@extends('layouts.masteradmin')
@section('content')

<div class="container-fluid px-4">
    <h3 class="mb-4">Edit Database Calon Peserta</h3>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Edit Data Calon Peserta: {{ $data->nama }}
        </div>
        <div class="card-body">
            <form action="{{ route('admin.database.update', $data->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $data->nama }}" required>
                </div>
                <div class="mb-3">
                    <label for="leads" class="form-label">Leads</label>
                    <input type="text" class="form-control" id="leads" name="leads" value="{{ $data->leads }}" required>
                </div>
               <div class="form-group">
                        <label for="provinsi">Provinsi</label>
                        <select id="provinsi" class="form-control" name="provinsi_id" required>
                            <option value="">Pilih Provinsi</option>
                        </select>
                        <input type="hidden" name="provinsi_nama" id="provinsi_nama">
                    </div>

                    <div class="form-group">
                        <label for="kota">Kota</label>
                        <select id="kota" class="form-control" name="kota_id" required>
                            <option value="">Pilih Kota</option>
                        </select>
                        <input type="hidden" name="kota_nama" id="kota_nama">
                    </div>


                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        // Ambil provinsi saat halaman dibuka
                        fetch('/wilayah/provinsi')
                            .then(res => res.json())
                            .then(data => {
                                data.forEach(prov => {
                                    document.getElementById('provinsi').innerHTML += `<option value="${prov.id}" data-nama="${prov.name}">${prov.name}</option>`;
                                });
                            });

                        // Saat provinsi dipilih, ambil kota
                        document.getElementById('provinsi').addEventListener('change', function() {
                            const id = this.value;
                            const nama = this.options[this.selectedIndex].text;
                            document.getElementById('provinsi_nama').value = nama;

                            fetch(`/wilayah/kota/${id}`)
                                .then(res => res.json())
                                .then(data => {
                                    let kotaSelect = document.getElementById('kota');
                                    kotaSelect.innerHTML = '<option value="">Pilih Kota</option>';
                                    data.forEach(kota => {
                                        kotaSelect.innerHTML += `<option value="${kota.id}" data-nama="${kota.name}">${kota.name}</option>`;
                                    });
                                });
                        });

                        document.getElementById('kota').addEventListener('change', function() {
                            const nama = this.options[this.selectedIndex].text;
                            document.getElementById('kota_nama').value = nama;
                        });
                    </script>
                <div class="mb-3">
                    <label for="nama_bisnis" class="form-label">Nama Bisnis</label>
                    <input type="text" class="form-control" id="nama_bisnis" name="nama_bisnis" value="{{ $data->nama_bisnis }}" required>
                </div>
                <div class="mb-3">
                    <label for="jenisbisnis" class="form-label">Jenis Bisnis</label>
                    <input type="text" class="form-control" id="jenisbisnis" name="jenisbisnis" value="{{ $data->jenisbisnis }}" required>
                </div>
                <div class="mb-3">
                    <label for="no_wa" class="form-label">No. Whatsapp</label>
                    <input type="text" class="form-control" id="no_wa" name="no_wa" value="{{ $data->no_wa }}" required>
                </div>
                <div class="mb-3">
                    <label for="kendala" class="form-label">Kendala</label>
                    <textarea class="form-control" id="kendala" name="kendala" rows="3" required>{{ $data->kendala }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="situasi_bisnis" class="form-label">Situasi Bisnis</label>
                    <textarea class="form-control" id="situasi_bisnis" name="situasi_bisnis" rows="3" required>{{ $data->situasi_bisnis }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="ikut_kelas" class="form-label">Ikut Kelas</label>
                    <select class="form-select" id="ikut_kelas" name="ikut_kelas" required>
                        <option value="1" {{ $data->ikut_kelas == 1 ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ $data->ikut_kelas == 0 ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="kelas_id" class="form-label">Kelas</label>
                    <select class="form-select" id="kelas_id" name="kelas_id">
                        <option value="">Pilih Kelas</option>
                        @foreach($kelas as $kelasItem)
                            <option value="{{ $kelasItem->id }}" {{ $data->kelas_id == $kelasItem->id ? 'selected' : '' }}>{{ $kelasItem->nama_kelas }}</option>
                        @endforeach
                    </select>
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

