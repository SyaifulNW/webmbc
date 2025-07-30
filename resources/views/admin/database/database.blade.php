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
                        @foreach($data as $data)
                        <tr
                            @php
                            $rowClass='' ;
                            if($data->status == 'cold') $rowClass = 'table-secondary';
                            elseif($data->status == 'warm') $rowClass = 'table-warning';
                            elseif($data->status == 'hot') $rowClass = 'table-success';
                            elseif($data->status == 'no') $rowClass = 'table-danger';
                            @endphp
                            >
                            <td class="{{ $rowClass }}">{{ $loop->iteration }}</td>
                            <td class="{{ $rowClass }}">{{ $data->nama }}</td>
                            <td class="{{ $rowClass }}">{{ $data->leads }}</td>
                            <td class="{{ $rowClass }}">{{ $data->kota }}</td>
                            <td class="{{ $rowClass }}">{{ $data->nama_bisnis }}</td>
                            <td class="{{ $rowClass }}">{{ $data->no_wa }}</td>
                            <td class="{{ $rowClass }}">{{ $data->kendala }}</td>
                            <td class="{{ $rowClass }}">{{ $data->fu1 }}</td>
                            <td class="{{ $rowClass }}">{{ $data->fu2 }}</td>
                            <td class="{{ $rowClass }}">{{ $data->fu3 }}</td>
                            <td style="color: white;">
                                <span
                                    class="badge status-badge
            @if($data->status == 'cold') bg-secondary
            @elseif($data->status == 'warm') bg-warning
            @elseif($data->status == 'hot') bg-success
            @elseif($data->status == 'no') bg-danger
            @else bg-light
            @endif"
                                    data-id="{{ $data->id }}"
                                    data-status="{{ $data->status }}"
                                    style="cursor: pointer;"
                                    onclick="changeStatus(this)">
                                    {{ ucfirst($data->status) }}
                                </span>
                            </td>
                            <td class="d-flex justify-content-center border-0">
                                <a class="btn btn-info" href="{{ route('admin.database.show', $data->id) }}"><i class="fa-solid fa-eye"></i></a>
                                &nbsp;
                                <a class="btn btn-primary" href="{{ route('admin.database.edit', $data->id) }}"><i class="fa-solid fa-pen-to-square"></i></a>
                                &nbsp;
                                <a class="btn btn-danger" href="{{ route('delete-database', $data->id) }}" onclick="event.preventDefault(); if(confirm('Apakah anda yakin menghapus data ini?')) { document.getElementById('delete-form-{{ $data->id }}').submit(); }"><i class="fa-solid fa-trash"></i></a>
                                <form id="delete-form-{{ $data->id }}" action="{{ route('delete-database', $data->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPesertaModalLabel">Tambah Calon Peserta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.database.store') }}" method="POST" id="createForm" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="card-body">
                        <!-- Nama Peserta -->
                        <div class="form-group">
                            <label for="nama_peserta">Nama Peserta</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <!--Sumber Leads -->
                        <div class="form-group">
                            <select name="leads" id="leads" onchange="toggleCustomLead(this)">
                                <option value="Iklan">Iklan</option>
                                <option value="Instagram">Instagram</option>
                                <option value="Facebook">Facebook</option>
                                <option value="Tiktok">Tiktok</option>
                                <option value="Lain-Lain">Lain-Lain</option>
                            </select>

                            <input type="text" name="leads_custom" id="leads_custom" style="display:none;" placeholder="Isi sumber lainnya">
                            <script>
                                function toggleCustomLead(select) {
                                    const input = document.getElementById('leads_custom');
                                    if (select.value === 'Lain-Lain') {
                                        input.style.display = 'block';
                                    } else {
                                        input.style.display = 'none';
                                        input.value = ''; // reset jika bukan "Lain-Lain"
                                    }
                                }
                            </script>

                        </div>
                        <!-- Provinsi -->
                        <div class="form-group">
                            <label for="provinsi">Provinsi</label>
                            <select name="provinsi_id" id="provinsi" class="form-control" required></select>
                            <input type="hidden" name="provinsi_nama" id="provinsi_nama">
                        </div>

                        <div class="form-group">
                            <label for="kota">Kota/Kabupaten</label>
                            <select name="kota_id" id="kota" class="form-control" required></select>
                            <input type="hidden" name="kota_nama" id="kota_nama">
                        </div>
                        <!-- Script API Wilayah Indonesia -->
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const provinsiSelect = document.getElementById('provinsi');
                                const kotaSelect = document.getElementById('kota');
                                const provinsiNama = document.getElementById('provinsi_nama');
                                const kotaNama = document.getElementById('kota_nama');

                                // Ambil daftar provinsi
                                fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
                                    .then(res => res.json())
                                    .then(data => {
                                        data.forEach(prov => {
                                            provinsiSelect.innerHTML += `<option value="${prov.id}" data-nama="${prov.name}">${prov.name}</option>`;
                                        });
                                    });

                                // Saat provinsi dipilih
                                provinsiSelect.addEventListener('change', function() {
                                    const provId = this.value;
                                    const provText = this.options[this.selectedIndex].getAttribute('data-nama');
                                    provinsiNama.value = provText;

                                    // Reset kota
                                    kotaSelect.innerHTML = '<option value="">Loading...</option>';

                                    // Ambil kota berdasarkan provinsi
                                    fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provId}.json`)
                                        .then(res => res.json())
                                        .then(data => {
                                            kotaSelect.innerHTML = '<option value="">-- Pilih Kota/Kabupaten --</option>';
                                            data.forEach(kota => {
                                                kotaSelect.innerHTML += `<option value="${kota.id}" data-nama="${kota.name}">${kota.name}</option>`;
                                            });
                                        });
                                });

                                // Simpan nama kota saat dipilih
                                kotaSelect.addEventListener('change', function() {
                                    const kotaText = this.options[this.selectedIndex].getAttribute('data-nama');
                                    kotaNama.value = kotaText;
                                });
                            });
                        </script>
                        <!-- Jenis Bisnis -->
                        <div class="form-group">
                            <select name="kategori_bisnis_id" class="form-control">
                                @foreach($kategori_bisnis as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nama Bisnis -->
                        <div class="form-group">
                            <label for="nama_bisnis">Nama Bisnis</label>
                            <input type="text" class="form-control" id="nama_bisnis" name="nama_bisnis" required>
                        </div>
                        <!-- No. WA -->
                        <div class="form-group">
                            <label for="no_wa">No. WA</label>
                            <input type="text" class="form-control" id="no_wa" name="no_wa" required>
                        </div>
                        <!-- Situasi bisnis -->
                        <div class="form-group ">
                            <label for="situasi_bisnis">Situasi Bisnis</label>
                            <input type="text" class="form-control" id="situasi_bisnis" name="situasi_bisnis" required>
                        </div>

                        <!-- Kendala -->
                        <div class="form-group ">
                            <label for="kendala">Kendala</label>
                            <textarea class="form-control" id="kendala" name="kendala" required></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
            </form>
        </div>
    </div>
</div>


<!-- End Modal Create -->



<div class="modal fade" id="updatePesertaModal" tabindex="-1" role="dialog" aria-labelledby="updatePesertaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatePesertaModalLabel">Update Calon Peserta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updateForm">
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="update_nama_peserta">Nama Peserta</label>
                            <input type="text" class="form-control" id="update_nama_peserta" name="nama_peserta" required>
                        </div>
                        <div class="form-group">
                            <label for="update_sumber_leads">Sumber Leads</label>
                            <input type="text" class="form-control" id="update_sumber_leads" name="sumber_leads" required>
                        </div>
                        <div class="form-group">
                            <label for="update_kota">Kota</label>
                            <input type="text" class="form-control" id="update_kota" name="kota" required>
                        </div>
                        <div class="form-group">
                            <label for="update_nama_bisnis">Nama Bisnis</label>
                            <input type="text" class="form-control" id="update_nama_bisnis" name="nama_bisnis" required>
                        </div>
                        <div class="form-group  ">
                            <label for="update_no_wa">No. WA</label>
                            <input type="text" class="form-control" id="update_no_wa" name="no_wa" required>
                        </div>
                        <div class="form-group">
                            <label for="update_kendala">Kendala</label>
                            <textarea class="form-control" id="update_kendala" name="kendala" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="update_fu1">Follow Up 1</label>
                            <input type="text" class="form-control" id="update_fu1" name="fu1" required>
                        </div>
                        <div class="form-group">
                            <label for="update_fu2">Follow Up 2</label>
                            <input type="text" class="form-control" id="update_fu2" name="fu2" required>
                        </div>
                        <div class="form-group">
                            <label for="update_fu3">Follow Up 3</label>
                            <input type="text" class="form-control" id="update_fu3" name="fu3" required>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="deletePesertaModal" tabindex="-1" role="dialog" aria-labelledby="deletePesertaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePesertaModalLabel">Delete Calon Peserta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this participant?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="updateDatabaseModal" tabindex="-1" role="dialog" aria-labelledby="updateDatabaseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateDatabaseModalLabel">Update Database</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updateDatabaseForm">
                <div class="modal-body 
                    ">
                    <div class="form-group">
                        <label for="update_database_file">Select Database File</label>
                        <input type="file" class="form-control-file" id="update_database_file" name="database_file" accept=".csv, .xlsx, .xls" required>
                    </div>
                    <div class="form-group">
                        <label for="update_database_description">Description</label>
                        <textarea class="form-control" id="update_database_description" name="description" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Database</button>
                </div>
            </form>
        </div>
    </div>
</div>