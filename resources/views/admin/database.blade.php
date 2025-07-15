@extends('layouts.masteradmin')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"> Database Calon Peserta</h1>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active">Database Calon Peserta</li>
            </ol>
        </div>

    </div>
    <div class="content">
        <div class="card card-info card-outline">
            <div class="card-header">
                <div class="card-tools">
                    <a href="#" class="btn btn-success" onclick="create()"> Tambah &nbsp;<i class="fa-solid fa-plus"></i></a>
                    &nbsp;
                    <br>
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
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Syaiful</td>
                    <td>MBC</td>
                    <td>Karanganyar</td>
                    <td>PT. MBC</td>
                    <td>085123456789</td>
                    <td>Rp. 10.000.000</td>
                    <td>Belum ada kendala</td>
                    <th>Isi FU 1</th>
                    <th>Isi FU 2</th>
                    <th>Isi FU 3</th>
                    <td class="d-flex justify-content-center border-0">
                        <a class="btn btn-info" href="#"><i class="fa-solid fa-eye"></i></a>
                        &nbsp;
                        <a class="btn btn-primary" href="#"><i class="fa-solid fa-pen-to-square"></i></a>
                        &nbsp;
                        <a class="btn btn-danger" onclick="confirmation(event)" href="#" data-confirm-delete="true">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

                <div class="card-footer"> </div>
            </div>

        </div>

        <!-- Content Row -->

        <!-- /.container-fluid -->

    </div>
<style>
  table.dataTable {
    width: 100% !important;
    white-space: nowrap;
}

</style>
<script>
  $(document).ready(function() {
    $('#myTable').DataTable({
        responsive: true,
        scrollX: true
    });
});
</script>

    
@endsection