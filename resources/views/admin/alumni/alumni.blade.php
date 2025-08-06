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
                            @php
                            $kelasIds = json_decode($item->kelas_id ?? '[]', true);
                            $kelasIds = is_array($kelasIds) ? $kelasIds : [$kelasIds]; // Paksa jadi array

                            $kelasTerdaftar = \App\Models\Kelas::whereIn('id', $kelasIds)->pluck('nama_kelas')->toArray();
                            $sudahIkut = implode(', ', $kelasTerdaftar);
                            @endphp
                            <td>{{ $sudahIkut }}</td>
                            <td>{{ $item->kelas_yang_belum_diikuti_apa_saja }}</td>
                            <td>
                                <a href="{{ route('admin.alumni.show', $item->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                                </a>
                                <!-- Tombol Edit Modal -->
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editKelasModal{{ $item->id }}">
                                    <i class="fa fa-edit" style="color: white;"></i>
                                </button>
                                <!-- Modal Edit -->
                                <!-- Modal Edit Kelas -->
                                <div class="modal fade" id="editKelasModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editKelasLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form action="{{ route('admin.alumni.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header bg-success text-white">
                                                    <h5 class="modal-title" id="editKelasLabel{{ $item->id }}">Edit Kelas Alumni - {{ $item->nama }}</h5>
                                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Sudah Ikut -->
                                                    <div class="form-group">
                                                        <label>Sudah Pernah Ikut Kelas:</label>
                                                        <textarea class="form-control" rows="3" readonly>{{ $sudahIkut }}</textarea>
                                                        <small class="form-text text-muted">Otomatis berdasarkan kelas yang pernah diikuti</small>
                                                    </div>

                                                    <!-- Belum Ikut -->
                                                    <div class="form-group">
                                                        <label>Kelas Yang Belum Diikuti:</label>
                                                        <textarea name="kelas_yang_belum_diikuti_apa_saja" class="form-control" rows="3">{{ $item->kelas_yang_belum_diikuti_apa_saja }}</textarea>
                                                        <small class="form-text text-muted">Otomatis bisa digenerate jika kosong</small>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <form action="{{ route('delete-alumni', $item->id) }}" method="POST" style="display:inline;" class="delete-form">
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