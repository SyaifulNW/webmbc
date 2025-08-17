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
                document.getElementById('tableSearch').addEventListener('keyup', function() {
                    let filter = this.value.toLowerCase(); // kata kunci pencarian
                    let rows = document.querySelectorAll('#myTable tbody tr'); // semua baris tabel

                    rows.forEach(function(row) {
                        let text = row.textContent.toLowerCase(); // gabungan semua teks dalam baris
                        row.style.display = text.includes(filter) ? '' : 'none'; // tampilkan / sembunyikan
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
                            <!-- <th>Status Peserta</th> -->
                            <th>
                                Sumber Leads

                            </th>

                            <th>Provinsi</th>
                            <th>Kota</th>
                            <th>Nama Bisnis</th>
                            <th>Jenis Bisnis</th>
                            <th>No.WA</th>
                            <th>CTA</th>
                            <th>Situasi Bisnis</th>
                            <th>Kendala</th>

                            <th>Potensi Kelas Pertama</th>
                            <th>Sale Plan</th>

                            @if(auth()->user()->email == 'mbchamasah@gmail.com')
                            <th>Input Oleh</th>
                            <th>Role</th>
                            @endif

                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr data-id="{{ $item->id }}">
                            <td>{{ $loop->iteration }}</td>

                            <td contenteditable="true" class="editable" data-field="nama">{{ $item->nama }}</td>
                            <!-- <td contenteditable="true" class="editable" data-field="status_peserta">{{ $item->status_peserta }}</td> -->
                            <td contenteditable="true" class="editable" data-field="leads">{{ $item->leads }}</td>
                            <td contenteditable="true" class="editable" data-field="provinsi_nama">{{ $item->provinsi_nama }}</td>
                            <td contenteditable="true" class="editable" data-field="kota_nama">{{ $item->kota_nama }}</td>
                            <td contenteditable="true" class="editable" data-field="nama_bisnis">{{ $item->nama_bisnis }}</td>
                            <td contenteditable="true" class="editable" data-field="jenisbisnis">{{ $item->jenisbisnis }}</td>
                            <td contenteditable="true" class="editable" data-field="no_wa">{{ $item->no_wa }}</td>

                            <td>
                                @php
                                $waNumber = preg_replace('/^0/', '62', $item->no_wa); // Ganti 0 jadi 62
                                @endphp
                                <a href="https://wa.me/{{ $waNumber }}"
                                    target="_blank"
                                    class="btn btn-success btn-sm wa-button">
                                    <i class="bi bi-whatsapp" style="color: #eeeeeeff; font-size: 1.5rem;"></i>

                                </a>
                            </td>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    document.querySelectorAll('.editable[data-field="no_wa"]').forEach(function(cell) {
                                        cell.addEventListener('input', function() {
                                            let newNumber = cell.textContent.trim();
                                            let waNumber = newNumber.replace(/^0/, '62'); // ganti 0 awal jadi 62
                                            let waButton = cell.parentElement.querySelector('.wa-button');
                                            if (waButton) {
                                                waButton.href = "https://wa.me/" + waNumber;
                                            }
                                        });
                                    });
                                });
                            </script>
                            <td contenteditable="true" class="editable" data-field="situasi_bisnis">{{ $item->situasi_bisnis }}</td>
                            <td contenteditable="true" class="editable" data-field="kendala">{{ $item->kendala }}</td>

                            <!-- Potensi Kelas Pertama sebagai dropdown -->
                            <td>
                                <select class="form-control form-control-sm select-potensi" data-id="{{ $item->id }}">
                                    <option value="">- Pilih Kelas -</option>
                                    @foreach($kelas as $k)
                                    <option value="{{ $k->id }}" {{ $item->kelas_id == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kelas }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <form action="{{ route('data.pindahKeSalesPlan', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="fa fa-arrow-right"></i>
                                    </button>
                                </form>


                            </td>

                            @if(auth()->user()->email == 'mbchamasah@gmail.com')
                            <td>{{ $item->created_by }}</td>
                            <td>{{ $item->created_by_role }}</td>
                            @endif

                            <td>
                                <!-- Action tetap sama -->
                                <a href="{{ route('admin.database.show', $item->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                                </a>
                                @if(auth()->user()->email == 'mbchamasah@gmail.com')
                                <form action="{{ route('delete-database', $item->id) }}" method="POST" style="display:inline;" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete">
                                        <i class="fa-solid fa-trash" style="color: #ffffff;"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function() {

                        // Untuk kolom text
                        $('.editable').on('blur', function() {
                            let value = $(this).text();
                            let field = $(this).data('field');
                            let id = $(this).closest('tr').data('id');

                            $.ajax({
                                url: '/admin/database/update-inline',
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id: id,
                                    field: field,
                                    value: value
                                },
                                success: function(res) {
                                    console.log('Updated:', field);
                                },
                                error: function() {
                                    alert('Gagal update data');
                                }
                            });
                        });

                        // Untuk dropdown Potensi Kelas
                        $('.select-potensi').on('change', function() {
                            let id = $(this).data('id');
                            let kelas_id = $(this).val();

                            $.ajax({
                                url: `/admin/database/update-potensi/${id}`,
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    kelas_id: kelas_id
                                },
                                success: function(response) {
                                    console.log('Potensi kelas updated');
                                },
                                error: function() {
                                    alert('Gagal update potensi kelas');
                                }
                            });
                        });

                    });
                </script>
                <style>
                    .editable {
                        cursor: pointer;
                    }

                    .editing {
                        background-color: #fff3cd !important;
                        /* kuning saat edit */
                    }

                    .status-icon {
                        margin-left: 5px;
                        font-size: 14px;
                    }

                    .status-success {
                        color: green;
                    }

                    .status-error {
                        color: red;
                    }
                </style>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function() {

                        // Untuk kolom text
                        $('.editable').on('focus', function() {
                            $(this).addClass('editing');
                        });

                        $('.editable').on('blur', function() {
                            let $this = $(this);
                            let value = $this.text();
                            let field = $this.data('field');
                            let id = $this.closest('tr').data('id');

                            $this.removeClass('editing');

                            $.ajax({
                                url: '/admin/database/update-inline',
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id: id,
                                    field: field,
                                    value: value
                                },
                                success: function() {
                                    showStatusIcon($this, true);
                                },
                                error: function() {
                                    showStatusIcon($this, false);
                                }
                            });
                        });

                        // Untuk dropdown Potensi Kelas
                        $('.select-potensi').on('change', function() {
                            let $this = $(this);
                            let id = $this.data('id');
                            let kelas_id = $this.val();
                            let iconSpan = $this.next('.status-icon');

                            $.ajax({
                                url: `/admin/database/update-potensi/${id}`,
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    kelas_id: kelas_id
                                },
                                success: function() {
                                    iconSpan.html('<i class="fa fa-check status-success"></i>');
                                    setTimeout(() => iconSpan.html(''), 2000);
                                },
                                error: function() {
                                    iconSpan.html('<i class="fa fa-times status-error"></i>');
                                    setTimeout(() => iconSpan.html(''), 2000);
                                }
                            });
                        });

                        // Fungsi tampil icon centang atau silang
                        function showStatusIcon($element, success) {
                            let iconHtml = success ?
                                '<i class="fa fa-check status-success"></i>' :
                                '<i class="fa fa-times status-error"></i>';

                            let iconSpan = $('<span class="status-icon">' + iconHtml + '</span>');
                            $element.after(iconSpan);

                            setTimeout(() => {
                                iconSpan.fadeOut(300, function() {
                                    $(this).remove();
                                });
                            }, 2000);
                        }

                    });
                </script>



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

                    {{-- Nama Peserta --}}
                    <div class="form-group">
                        <label for="nama">Nama Peserta</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>

                    {{-- Status Peserta --}}
                    <div class="form-group">
                        <label for="status_peserta">Status Peserta</label>
                        <select name="status_peserta" id="status_peserta" class="form-control">
                            <option value="Peserta Baru">Peserta Baru</option>
                            <option value="Alumni">Alumni</option>
                        </select>
                    </div>

                    {{-- Potensi Kelas --}}
                    <div class="form-group">
                        <label for="kelas_id">Potensi Kelas</label>
                        <select name="kelas_id" id="kelas_id" class="form-control">
                            <option value="">Pilih Potensi Kelas</option>
                            @foreach($kelas as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Sumber Leads --}}
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

                    {{-- Provinsi --}}
                    <div class="form-group">
                        <label for="provinsi">Provinsi</label>
                        <select id="provinsi" class="form-control" name="provinsi_id" required>
                            <option value="">Pilih Provinsi</option>
                        </select>
                        <input type="hidden" name="provinsi_nama" id="provinsi_nama">
                    </div>

                    {{-- Kota --}}
                    <div class="form-group">
                        <label for="kota">Kota</label>
                        <select id="kota" class="form-control" name="kota_id" required>
                            <option value="">Pilih Kota</option>
                        </select>
                        <input type="hidden" name="kota_nama" id="kota_nama">
                    </div>

                    {{-- Script Ambil Wilayah --}}
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        fetch('/wilayah/provinsi')
                            .then(res => res.json())
                            .then(data => {
                                data.forEach(prov => {
                                    $('#provinsi').append(`<option value="${prov.id}" data-nama="${prov.name}">${prov.name}</option>`);
                                });
                            });

                        $('#provinsi').on('change', function() {
                            const id = $(this).val();
                            const nama = $(this).find('option:selected').text();
                            $('#provinsi_nama').val(nama);

                            fetch(`/wilayah/kota/${id}`)
                                .then(res => res.json())
                                .then(data => {
                                    $('#kota').html('<option value="">Pilih Kota</option>');
                                    data.forEach(kota => {
                                        $('#kota').append(`<option value="${kota.id}" data-nama="${kota.name}">${kota.name}</option>`);
                                    });
                                });
                        });

                        $('#kota').on('change', function() {
                            const nama = $(this).find('option:selected').text();
                            $('#kota_nama').val(nama);
                        });
                    </script>

                    {{-- Nama Bisnis --}}
                    <div class="form-group">
                        <label for="nama_bisnis">Nama Bisnis</label>
                        <input type="text" class="form-control" id="nama_bisnis" name="nama_bisnis" required>
                    </div>

                    {{-- Jenis Bisnis --}}
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

                    {{-- No WA --}}
                    <div class="form-group">
                        <label for="no_wa">No. WA</label>
                        <input type="text" class="form-control" id="no_wa" name="no_wa" required>
                    </div>

                    {{-- Situasi Bisnis --}}
                    <div class="form-group">
                        <label for="situasi_bisnis">Situasi Bisnis</label>
                        <textarea class="form-control" id="situasi_bisnis" name="situasi_bisnis" rows="3"></textarea>
                    </div>

                    {{-- Kendala --}}
                    <div class="form-group">
                        <label for="kendala">Kendala</label>
                        <textarea class="form-control" id="kendala" name="kendala" rows="3"></textarea>
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