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
                            <th>Kota</th>
                            <th>Nama Bisnis</th>
                            <th>No.WA</th>
                            <th>Total Omset</th>
                            <th>Kendala</th>
                            <th>FU 1</th>
                            <th>FU 2</th>
                            <th>FU 3</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($crms as $crm)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $crm->nama }}</td>
                            <td>{{ $crm->leads }}</td>
                            <td>{{ $crm->kota }}</td>
                            <td>{{ $crm->nama_bisnis }}</td>
                            <td>{{ $crm->no_wa }}</td>
                            <td>{{ $crm->total_omset }}</td>
                            <td>{{ $crm->kendala }}</td>
                            <td>{{ $crm->fu1 }}</td>
                            <td>{{ $crm->fu2 }}</td>
                            <td>{{ $crm->fu3 }}</td>
                            <td style="color: white;">
                                <span 
                                    class="badge 
                                        @if($crm->status == 'cold') bg-secondary
                                        @elseif($crm->status == 'warm') bg-warning
                                        @elseif($crm->status == 'hot') bg-success
                                        @elseif($crm->status == 'no') bg-danger
                                        @else bg-light
                                        @endif
                                        status-badge"
                                    data-id="{{ $crm->id }}"
                                    style="cursor:pointer;"
                                    onclick="changeStatus({{ $crm->id }}, '{{ $crm->status }}', this)"
                                >
                                    {{ ucfirst($crm->status) }}
                                </span>
                            </td>
                            <script>
                            function changeStatus(id, currentStatus, el) {
                                // Define the order of statuses
                                const statuses = ['cold', 'warm', 'hot', 'no'];
                                let idx = statuses.indexOf(currentStatus);
                                let nextStatus = statuses[(idx + 1) % statuses.length];

                                // AJAX request to update status in backend
                                $.ajax({
                                    url: '/admin/database/change-status/' + id,
                                    type: 'POST',
                                    data: {
                                        status: nextStatus,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function(response) {
                                        // Update badge color and text
                                        el.textContent = nextStatus.charAt(0).toUpperCase() + nextStatus.slice(1);
                                        el.classList.remove('bg-secondary', 'bg-warning', 'bg-success', 'bg-danger', 'bg-light');
                                        if(nextStatus === 'cold') el.classList.add('bg-secondary');
                                        else if(nextStatus === 'warm') el.classList.add('bg-warning');
                                        else if(nextStatus === 'hot') el.classList.add('bg-success');
                                        else if(nextStatus === 'no') el.classList.add('bg-danger');
                                        else el.classList.add('bg-light');
                                    }
                                });
                            }
                            </script>
                            
                            <td class="d-flex justify-content-center border-0">
                                <a class="btn btn-info" href="{{ route('admin.database.show', $crm->id) }}"><i class="fa-solid fa-eye"></i></a>
                                &nbsp;
                                <a class="btn btn-primary" href="{{ route('admin.database.edit', $crm->id) }}"><i class="fa-solid fa-pen-to-square"></i></a>
                                &nbsp;
                                <a class="btn btn-danger" href="{{ route('delete-database', $crm->id) }}" onclick="event.preventDefault(); if(confirm('Apakah anda yakin menghapus data ini?')) { document.getElementById('delete-form-{{ $crm->id }}').submit(); }"><i class="fa-solid fa-trash"></i></a>
                                <form id="delete-form-{{ $crm->id }}" action="{{ route('delete-database', $crm->id) }}" method="POST" style="display: none;">
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
                <h5 class="modal-title" id="createPesertaModalLabel">Tambah  Calon  Peserta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.database.store') }}" method="POST" id="createForm" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="nama_peserta">Nama Peserta</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="sumber_leads">Sumber Leads</label>
                            <input type="text" class="form-control" id="leads" name="leads" required>
                        </div>
                        <div class="form-group">
                            <label for="kota">Kota</label>
                            <input type="text" class="form-control" id="kota" name="kota" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_bisnis">Nama Bisnis</label>
                            <input type="text" class="form-control" id="nama_bisnis" name="nama_bisnis" required>
                        </div>
                        <div class="form-group">
                            <label for="no_wa">No. WA</label>
                            <input type="text" class="form-control" id="no_wa" name="no_wa" required>
                        </div>
                        <div class="form-group">
                            <label for="total_omset">Total Omset</label>
                            <input type="text" class="form-control" id="total_omset" name="total_omset" required>
                        </div>
                        <div class="form-group">
                            <label for="kendala">Kendala</label>
                            <textarea class="form-control" id="kendala" name="kendala" ></textarea>
                        </div>
                        <div class="form-group">
                            <label for="fu1">Follow Up 1</label>
                            <input type="text" class="form-control" id="fu1" name="fu1" >
                        </div>
                        <div class="form-group">
                            <label for="fu2">Follow Up 2</label>
                            <input type="text" class="form-control" id="fu2" name="fu2">
                        </div>
                        <div class="form-group">
                            <label for="fu3">Follow Up 3</label>
                            <input type="text" class="form-control" id="fu3" name="fu3">
                        </div>
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
                        <label for="update_total_omset">Total Omset</label>
                        <input type="text" class="form-control" id="update_total_omset" name="total_omset" required>
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