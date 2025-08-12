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
            <div class="card-tools d-flex justify-content-between w-100">
                <a href="#" class="btn btn-success" onclick="create()">Tambah &nbsp;<i class="fa-solid fa-plus"></i></a>
                <div>
                    <input type="text" id="tableSearch" class="form-control" placeholder="Cari...">
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    var table = $('#myTable').DataTable({
                        responsive: true,
                        autoWidth: false,
                    });
                    $('#tableSearch').on('keyup', function() {
                        table.search(this.value).draw();
                    });
                });
            </script>
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
                            <th>Kelas</th>
                            @if(auth()->user()->email == 'mbchamasah@gmail.com')
                            <th>Input Oleh</th>
                            <th>Role</th>
                            @endif

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
                                @if($item->kelas_id)
                                {{ $item->kelas->nama_kelas }}
                                @else
                                -
                                @endif
                            </td>
                            @if(auth()->user()->email == 'mbchamasah@gmail.com')
                            <td>{{ $item->created_by }}</td>
                            <td>{{ $item->created_by_role }}</td>
                            @endif

                            <td>

                                <a href="{{ route('admin.database.show', $item->id) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                    <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                                </a>
                                <form action="{{ route('data.pindahKeAlumni', $item->id) }}" method="POST" style="display:inline;" class="pindah-alumni-form">
                                    @csrf
                                    <button type="button" class="btn btn-success btn-sm btn-pindah-alumni" title="Pindah ke Alumni">
                                        <i class="fa-solid fa-reply" style="color: #ffffff;"></i>
                                    </button>
                                </form>
                                <script>
                                    $(document).on('click', '.btn-pindah-alumni', function(e) {
                                        e.preventDefault();
                                        var form = $(this).closest('form');
                                        Swal.fire({
                                            title: 'Yakin pindah ke alumni?',
                                            text: "Data akan dipindahkan ke alumni.",
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#28a745',
                                            cancelButtonColor: '#3085d6',
                                            confirmButtonText: 'Ya, pindahkan!',
                                            cancelButtonText: 'Batal'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                form.submit();
                                            }
                                        });
                                    });
                                </script>
                                <form action="{{ route('data.pindahKeSalesPlan', $item->id) }}" method="POST" style="display:inline;" class="pindah-salesplan-form">
                                    @csrf
                                    <button type="button" class="btn btn-primary btn-sm btn-pindah-salesplan" title="Pindah ke Sales Plan">
                                        <i class="fa-solid fa-arrow-right" style="color: #ffffff;"></i>
                                    </button>
                                </form>
                                <script>
                                    $(document).on('click', '.btn-pindah-salesplan', function(e) {
                                        e.preventDefault();
                                        var form = $(this).closest('form');
                                        Swal.fire({
                                            title: 'Yakin pindah ke Sales Plan?',
                                            text: "Data akan dipindahkan ke Sales Plan.",
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#007bff',
                                            cancelButtonColor: '#3085d6',
                                            confirmButtonText: 'Ya, pindahkan!',
                                            cancelButtonText: 'Batal'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                form.submit();
                                            }
                                        });
                                    });
                                </script>
                                <a href="{{ route('admin.database.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit Data">
                                    <i class="fa-solid fa-pencil" style="color: #ffffff;"></i>
                                </a>
                         @if(auth()->user()->email == 'mbchamasah@gmail.com')
                                <form action="{{ route('delete-database', $item->id) }}" method="POST" style="display:inline;" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete">
                                        <i class="fa-solid fa-trash" style="color: #ffffff;"></i>
                                    </button>
                                </form>
                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                <script>
                                    $(document).on('click', '.btn-delete', function(e) {
                                        e.preventDefault();
                                        var form = $(this).closest('form');
                                        Swal.fire({
                                            title: 'Yakin hapus data?',
                                            text: "Data yang dihapus tidak bisa dikembalikan!",
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#d33',
                                            cancelButtonColor: '#3085d6',
                                            confirmButtonText: 'Ya, hapus!',
                                            cancelButtonText: 'Batal'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                form.submit();
                                            }
                                        });
                                    });
                                </script>
                          @endif
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
    $('#createForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                alert('Berhasil disimpan!');
                $('#createPesertaModal').modal('hide');
                location.reload(); // atau refresh tabel data
            },
            error: function(err) {
                alert('Gagal menyimpan.');
            }
        });
    });
</script>

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
                        <label for="jenisbisnis">Jenis Bisnis</label>
                        <select name="jenisbisnis" id="jenisbisnis" class="form-control">
                            <option value="Bisnis Properti">Bisnis Properti</option>
                            <option value="Bisnis Manufaktur">Bisnis Manufaktur</option>
                            <option value="Bisnis F&B (Food & Beverage)">Bisnis F&B (Food & Beverage)</option>
                            <option value="Bisnis Jasa">Bisnis Jasa</option>
                            <option value="Bisnis Digital">Bisnis Digital</option>
                            <option value="Bisnis Online">Bisnis Online</option>
                            <option value="Bisnis Franchise">Bisnis Franchise</option>
                            <option value="Bisnis Edukasi & Pelatihan">Bisnis Edukasi & Pelatihan</option>
                            <option value="Bisnis Kreatif">Bisnis Kreatif</option>
                            <option value="Bisnis Agribisnis">Bisnis Agribisnis</option>
                            <option value="Bisnis Kesehatan & Kecantikan">Bisnis Kesehatan & Kecantikan</option>
                            <option value="Bisnis Keuangan">Bisnis Keuangan</option>
                            <option value="Bisnis Transportasi & Logistik">Bisnis Transportasi & Logistik</option>
                            <option value="Bisnis Pariwisata & Hospitality">Bisnis Pariwisata & Hospitality</option>
                            <option value="Bisnis Sosial (Social Enterprise)">Bisnis Sosial (Social Enterprise)</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="no_wa">No. WA</label>
                        <input type="text" class="form-control" id="no_wa" name="no_wa" required>
                    </div>
                    <div class="form-group">
                        <label for="situasi_bisnis">Situasi Bisnis</label>
                        <textarea class="form-control" id="situasi_bisnis" name="situasi_bisnis" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="kendala">Kendala</label>
                        <textarea class="form-control" id="kendala" name="kendala" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="ikut_kelas">Apakah Prospek Ikut Kelas / Tidak</label>
                        <select class="form-control" id="ikut_kelas" name="ikut_kelas">
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>

                    <!-- Kelas -->
                    <div class="form-group" id="kelas_form_group" style="display: none;">
                        <label for="kelas">Kelas</label>
                        <select class="form-control" id="kelas" name="kelas_id">
                            <option value="">Pilih Kelas</option>
                            @foreach($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <script>
                        $(document).ready(function() {
                            $('#ikut_kelas').on('change', function() {
                                if ($(this).val() == '1') {
                                    $('#kelas_form_group').show();
                                } else {
                                    $('#kelas_form_group').hide();
                                    $('#kelas').val('');
                                }
                            });
                        });
                    </script>


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