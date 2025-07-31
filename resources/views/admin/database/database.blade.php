@extends('layouts.masteradmin')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Database Calon Peserta</h1>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Database Calon Peserta</li>
        </ol>
    </div>
</div>
<div class="content">
    <div class="card card-info card-outline">
        <div class="card-header">
            <div class="card-tools d-flex justify-content-between">
                <a href="#" class="btn btn-success" onclick="create()">Tambah &nbsp;<i class="fa-solid fa-plus"></i></a>
                <!-- <a href="#" class="btn btn-warning">Update Database &nbsp;<i class="fa-solid fa-sync"></i></a> -->
            </div>
        </div>
        <div class="card-body">
            <div style="overflow-x: auto; overflow-y: auto; width: 100%; max-height: 500px;">
                <table id="myTable" class="table table-bordered table-striped nowrap" style="width: max-content;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Peserta</th>
                            <th>Sumber Leads</th>
                            <th>Provinsi</th>
                            <th>Kota</th>
                            <th>Nama Bisnis</th>
                            <th>Jenis Bisnis</th>
                            <th>No.WA</th>
                            <th>Situasi Bisnis</th>
                            <th>Kendala</th>
                            <th>Ikut Kelas / Tidak</th>
                     
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->leads }}</td>
                            <td>{{ $item->provinsi_nama }}</td>
                            <td>{{ $item->kota_nama }}</td>
                            <td>{{ $item->nama_bisnis }}</td>
                            <td>{{ $item->jenisbisnis }}</td>
                            <td>{{ $item->no_wa }}</td>
                            <td>{{ $item->situasi_bisnis }}</td>
                            <td>{{ $item->kendala }}</td>
                            <td>{{ $item->ikut_kelas == 1 ? 'Ya' : 'Tidak' }}</td>
                            <td>
                                <a href="{{ route('admin.database.show', $item->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                                </a>
                                <a href="{{ route('admin.database.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fa-solid fa-pencil" style="color: #ffffff;"></i>
                                </a>
                                <form action="{{ route('delete-database', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-trash" style="color: #ffffff;"></i>
                                    </button>
                                </form>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
              
            </div>
        </div>
    </div>
</div>
@endsection
<!-- Modal Create -->



<script>
    function create() {
        $('#createPesertaModal').modal('show');
    }

    $('#createForm').on('submit', function(e) {
        e.preventDefault();
        // Add your AJAX call here to save the data
        alert('Data saved successfully!');
        $('#createPesertaModal').modal('hide');
    });
</script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            responsive: true,
            autoWidth: false,
        });
    });
</script>



<!-- Modal Create -->
<div class="modal fade" id="createPesertaModal" tabindex="-1" role="dialog" aria-labelledby="createPesertaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPesertaModalLabel">Tambah Peserta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="createForm" action="{{ route('admin.database.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama">Nama Peserta</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="leads">Sumber Leads</label>
                        <select name="leads" id="leads" class="form-control">
                            <option value="Iklan">Iklan</option>
                            <option value="Instagram">Instagram</option>
                            <option value="Facebook">Facebook</option>
                            <option value="Tiktok">Tiktok</option>
                            <option value="Lain-Lain">Lain-Lain</option>
                        </select>

                        <input type="text" name="leads_custom" class="form-control mt-2" placeholder="Isi jika Lain-Lain">
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


                    <div class="form-group">
                        <label for="nama_bisnis">Nama Bisnis</label>
                        <input type="text" class="form-control" id="nama_bisnis" name="nama_bisnis" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_bisnis">Jenis Bisnis</label>
                        <input type="text" class="form-control" id="jenisbisnis" name="jenisbisnis" required>
                    </div>
                    <div class="form-group">
                        <label for="no_wa">No. WA</label>
                        <input type="text" class="form-control" id="no_wa" name="no_wa" required>
                    </div>
                    <div class="form-group">
                        <label for="situasi_bisnis">Situasi Bisnis</label>
                        <textarea class="form-control" id="situasi_bisnis" name="situasi_bisnis" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="kendala">Kendala</label>
                        <textarea class="form-control" id="kendala" name="kendala" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="ikut_kelas">Apakah Prospek Ikut Kelas / Tidak</label>
                        <select class="form-control" id="ikut_kelas" name="ikut_kelas" required>
                            <option value="Ya">Ya</option>
                            <option value="Tidak">Tidak</option>
                        </select>
                    </div>

                    <!-- Kelas -->
                    <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <select class="form-control" id="kelas" name="kelas_id" required>
                            <option value="">Pilih Kelas</option>
                            @foreach($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="created_at">Tanggal Daftar</label>
                        <input type="date" class="form-control" id="created_at" name="created_at" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- End Modal Create -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>