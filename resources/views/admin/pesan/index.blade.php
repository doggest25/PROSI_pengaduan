@extends('layouts.template')

@section('content')
@if(session('success'))
<div class="alert alert-success"> {{ session('success') }} </div>
@endif
@if(session('error'))
<div class="alert alert-danger"> {{ session('error') }} </div>
@endif
<div class="card card-outline">
    <div class="card-header bg-warning d-flex justify-content-between align-items-center">
        <h3 class="card-title"><strong>Informasi fungsi fitur !</strong></h3>
        <button class="btn btn-link ml-auto font-weight-bold" type="button" data-toggle="collapse" data-target="#featureInfo" aria-expanded="false" aria-controls="featureInfo">
            <i class="bi bi-chevron-down"></i>
        </button>
    </div>
    <div id="featureInfo" class="collapse card-body">
        <p>1. <strong>Kritik & Saran</strong>, yang masuk akan diterima dengan user anonim<br></p>
        <p>2. <strong>Status</strong>, jika pesan masuk maka akan berstatus <strong>"Belum dilihat"</strong>  jika sudah Menekan Detail maka status berubah menjadi <strong>"Sudah dilihat"</strong> <br></p>
        <p>3. <strong>Detail</strong>, informasi detail dari pesan Kritik & Saran <br></p>
            
    </div>
</div>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
      
        <table class="table table-bordered table-striped table-hover table-sm" id="table_pesan">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Pesan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('css')
<style>
    .message {
        display: -webkit-box;
        -webkit-line-clamp: 10; /* Jumlah baris yang diizinkan */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        var dataLevel = $('#table_pesan').DataTable({
            serverSide: true, // serverSide: true, jika ingin menggunakan server side processing
            ajax: {
                "url": "{{ url('pesan/list') }}",
                "dataType": "json",
                "type": "POST"
            },
            columns: [
                {
                    data: "id_pesan", // nomor urut dari laravel datatable addIndexColumn()
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "name",
                    className: "",
                    orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                    searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                },
                {
                    data: "email",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "is_read",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "message",
                    className: "message",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "aksi",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }
            ],
            "createdRow": function(row, data, dataIndex) {
                var status = data.is_read;
                if (status === 'Sudah dilihat') {
                    $(row).find('td:eq(3)').html('<span class="badge badge-success">Sudah dilihat</span>');
                } else if (status === 'Belum dilihat') {
                    $(row).find('td:eq(3)').html('<span class="badge badge-warning">Belum dilihat</span>');
                }
            }
        });
    });
</script>
@endpush
