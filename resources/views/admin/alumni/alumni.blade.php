@extends('layouts.masteradmin')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Database Alumni</h1>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Database Alumni</li>
        </ol>
    </div>
</div>
<div class="content">
    <div class="card card-info card-outline">
        <div class="card-header">
            <div class="mb-3">

                <button class="btn btn-success" data-toggle="modal" data-target="#createAlumniModal">
                    <i class="fa fa-plus"></i> Tambah Alumni
                </button>

            </div>
            <div class="modal fade" id="createAlumniModal" tabindex="-1" role="dialog" aria-labelledby="createAlumniModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="{{ route('admin.alumni.store') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="createAlumniModalLabel">Tambah Alumni Baru</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Nama Peserta</label>
                                    <input type="text" name="nama" class="form-control" required>
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
                                    <label>Nama Bisnis</label>
                                    <input type="text" name="nama_bisnis" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="jenis_bisnis">Jenis Bisnis</label>
                                    <select name="jenis_bisnis" id="jenis_bisnis" class="form-control">
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
                                    <label>No. WA</label>
                                    <input type="text" name="no_wa" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Kendala</label>
                                    <textarea name="kendala" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="fw-bold mb-2">Kelas yang Belum Diikuti</label>
                                    <div class="card border-danger">
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach($kelas as $k)
                                                <div class="col-md-6 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="kelas_yang_belum_diikuti_apa_saja[]"
                                                            value="{{ $k->id }}"
                                                            id="belum_{{ $k->id }}">
                                                        <label class="form-check-label text-danger fw-semibold" for="belum_{{ $k->id }}">
                                                            {{ $k->nama_kelas }}
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <label class="fw-bold mb-2">Sudah Pernah Ikut Kelas Apa</label>
                                    <div class="card border-success">
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach($kelas as $k)
                                                <div class="col-md-6 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="sudah_pernah_ikut_kelas_apa_saja[]"
                                                            value="{{ $k->id }}"
                                                            id="sudah_{{ $k->id }}">
                                                        <label class="form-check-label text-success fw-semibold" for="sudah_{{ $k->id }}">
                                                            {{ $k->nama_kelas }}
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
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
                            <th>No.WA</th>
                            <th>Kendala</th>
                            <th>Sudah Pernah Ikut Kelas</th>
                            <th>Kelas Yang Belum Ikut</th>
                            @if(auth()->user()->email == 'mbchamasah@gmail.com')
                            <th>Input Oleh</th>
                            @endif
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alumni as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->leads }}</td>
                            <td>{{ $item->provinsi_nama }}</td>
                            <td>{{ $item->kota_nama }}</td>
                            <td>{{ $item->nama_bisnis }}</td>
                            <td>{{ $item->no_wa }}</td>
                            <td>{{ $item->kendala }}</td>
                            <td>
                                Kelas yang sudah diikuti
                            </td>

                            <td>
                                kelas yang belum diikuti
                            </td>
                            @if(auth()->user()->email == 'mbchamasah@gmail.com')
                            <td>{{$item->created_by}}</td>
                            @endif
                            <td>
                                <!-- Tombol lihat -->
                                <a href="{{ route('admin.alumni.show', $item->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                                </a>

                                <!--Tombol Edit -->
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editKelasModal{{ $item->id }}">
                                    <i class="fa fa-edit" style="color: white;"></i>
                                </button>
                                <!-- Modal Edit -->
                                <!-- Modal Edit Kelas -->



                                <!-- Tombol Pilih Kelas -->
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#salesplanModal{{ $item->id }}" title="Pilih Kelas Selanjutnya">
                                    <i class="fa fa-share-square" style="color: white;"></i>
                                </button>


                                <!-- ✅ Tambahkan ini di bawah modal -->
                                @if($item->kelas_yang_akan_diikuti)
                                <form action="{{ route('admin.alumni.toSalesplan', $item->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        Pindahkan ke Salesplan ({{ $item->kelas_yang_akan_diikuti }})
                                    </button>
                                </form>
                                @endif

                                <!-- Tombol Hapus -->
                                <form action="{{ route('delete-alumni', $item->id) }}" method="POST" style="display:inline;" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-delete" onclick="return confirm('Yakin ingin menghapus data ini?');">
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




<!-- End Modal Create -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Optional: Bootstrap 4 Theme -->
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />