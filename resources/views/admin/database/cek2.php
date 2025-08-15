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
                <button id="btnTambah" class="btn btn-success btn-md mb-2">Tambah +</button>

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
                            <th>Sumber Leads</th>
                            <th>Provinsi</th>
                            <th>Kota</th>
                            <th>Jenis Bisnis</th>
                            <th>No.WA</th>
                            <th>CTA</th>
                            <th>Situasi Bisnis</th>
                            <th>Kendala</th>
                            <th>Potensi Kelas Pertama</th>
                            @if(auth()->user()->email == 'mbchamasah@gmail.com')
                            <th>Input Oleh</th>
                            @endif
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr data-id="{{ $item->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td contenteditable="true" class="editable" data-field="nama">{{ $item->nama }}</td>
                            <td contenteditable="true" class="editable" data-field="leads">{{ $item->leads }}</td>
                            <td contenteditable="true" class="editable" data-field="provinsi_nama">{{ $item->provinsi_nama }}</td>
                            <td contenteditable="true" class="editable" data-field="kota_nama">{{ $item->kota_nama }}</td>
                            <td contenteditable="true" class="editable" data-field="jenisbisnis">{{ $item->jenisbisnis }}</td>
                            <td contenteditable="true" class="editable" data-field="no_wa">{{ $item->no_wa }}</td>
                            <td>
                                @php
                                $waNumber = preg_replace('/^0/', '62', $item->no_wa);
                                @endphp
                                <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="btn btn-success btn-sm wa-button">
                                    <i class="bi bi-whatsapp"></i> Chat WA
                                </a>
                            </td>
                            <td contenteditable="true" class="editable" data-field="situasi_bisnis">{{ $item->situasi_bisnis }}</td>
                            <td contenteditable="true" class="editable" data-field="kendala">{{ $item->kendala }}</td>
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
                            @if(auth()->user()->email == 'mbchamasah@gmail.com')
                            <td>{{ $item->created_by }}</td>
                            @endif
                            <td>
                                <a href="{{ route('admin.database.show', $item->id) }}" class="btn btn-info btn-sm">
                                    <i class="fa-solid fa-eye" style="color: #ffffff;"></i>
                                </a>
                      
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <script>
            document.querySelectorAll('.editable').forEach(cell => {
                cell.addEventListener('blur', function() {
                    let id = this.closest('tr').getAttribute('data-id');
                    let field = this.getAttribute('data-field');
                    let value = this.innerText.trim();

                    fetch(`/data/${id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                field: field,
                                value: value
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            console.log('Tersimpan:', data);
                        })
                        .catch(err => console.error(err));
                });
            });
        </script>

        <script>
            // Simpan semua opsi kelas di variabel JS agar aman
            let kelasOptions = `{!! collect($kelas)->map(function($k){
        return "<option value='{$k->id}'>{$k->nama_kelas}</option>";
    })->implode('') !!}`;

            $(document).ready(function() {

                // Tambah row baru
                $('#btnTambah').on('click', function() {
                    $.post('/admin/database/store-inline', {
                        _token: '{{ csrf_token() }}'
                    }, function(res) {
                        let rowCount = $('#myTable tbody tr').length + 1;
                        let newRow = `
                    <tr data-id="${res.id}">
                        <td>${rowCount}</td>
                        <td contenteditable="true" class="editable" data-field="nama"></td>
                        <td contenteditable="true" class="editable" data-field="leads"></td>
                        <td contenteditable="true" class="editable" data-field="provinsi_nama"></td>
                        <td contenteditable="true" class="editable" data-field="kota_nama"></td>
                        <td contenteditable="true" class="editable" data-field="jenisbisnis"></td>
                        <td contenteditable="true" class="editable" data-field="no_wa"></td>
                        <td><a href="https://wa.me/" target="_blank" class="btn btn-success btn-sm wa-button"><i class="bi bi-whatsapp"></i> Chat WA</a></td>
                        <td contenteditable="true" class="editable" data-field="situasi_bisnis"></td>
                        <td contenteditable="true" class="editable" data-field="kendala"></td>
                        <td>
                            <select class="form-control form-control-sm select-potensi" data-id="${res.id}">
                                <option value="">- Pilih Kelas -</option>
                                ${kelasOptions}
                            </select>
                        </td>
                        @if(auth()->user()->email == 'mbchamasah@gmail.com')
                            <td>{{ auth()->user()->name }}</td>
                        @endif
                        <td>
                            <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="${res.id}">
                                <i class="fa-solid fa-trash" style="color: #ffffff;"></i>
                            </button>
                        </td>
                    </tr>
                `;
                        $('#myTable tbody').append(newRow);
                    }, 'json');
                });

                // Auto update saat blur
                $(document).on('blur', '.editable', function() {
                    let value = $(this).text().trim();
                    let field = $(this).data('field');
                    let tr = $(this).closest('tr');
                    let id = tr.data('id');

                    if (field === 'no_wa') {
                        let waNumber = value.replace(/^0/, '62');
                        tr.find('.wa-button').attr('href', 'https://wa.me/' + waNumber);
                    }

                    if (!id) return; // Pastikan ID ada

                    $.post('/admin/database/update-inline', {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        field: field,
                        value: value
                    });
                });

                // Update tombol WA saat no_wa diubah realtime
                $(document).on('input', '.editable[data-field="no_wa"]', function() {
                    let newNumber = $(this).text().trim();
                    let waNumber = newNumber.replace(/^0/, '62');
                    $(this).closest('tr').find('.wa-button').attr('href', 'https://wa.me/' + waNumber);
                });

                // Auto-save dropdown kelas
                $(document).on('change', '.select-potensi', function() {
                    let id = $(this).data('id');
                    let kelas_id = $(this).val();
                    if (id) {
                        $.post(`/admin/database/update-potensi/${id}`, {
                            _token: '{{ csrf_token() }}',
                            kelas_id: kelas_id
                        });
                    }
                });

                // Hapus row
                $(document).on('click', '.btn-delete', function() {
                    let id = $(this).data('id');
                    let tr = $(this).closest('tr');
                    if (confirm('Yakin hapus data ini?')) {
                        $.ajax({
                            url: '/admin/database/delete/' + id,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function() {
                                tr.remove();
                            }
                        });
                    }
                });

            });
        </script>




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








<!-- End Modal Create -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>