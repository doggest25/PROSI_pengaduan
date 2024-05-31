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
        <h3 class="card-title"><strong>Informasi penting fitur !</strong></h3>
        <button class="btn btn-link ml-auto font-weight-bold" type="button" data-toggle="collapse" data-target="#featureInfo" aria-expanded="false" aria-controls="featureInfo">
            <i class="bi bi-chevron-down"></i>
        </button>
    </div>
    <div id="featureInfo" class="collapse card-body">
        <p>1. <strong>Tambah</strong>, anda dapat menambahkan <strong>jenis pengaduan</strong> sesuai kebutuhan RW <br></p>
        <p>2. <strong>Detail</strong>, anda dapat melihat informasi <strong>jenis pengaduan</strong> lebih detail<br></p>
        <p>3. <strong>Edit</strong>, anda dapat mengubah <strong>jenis pengaduan</strong>Jika ada kesalahan <br></p>
        <p>4. <strong>Hapus</strong>, hati - hati saat menghapus <strong>jenis pengaduan</strong> karena akan mengapus semua data secara permanen ! <br></p>    
    </div>
</div>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('jpengaduan/create') }}">Tambah</a>
        </div>
    </div>
    <div class="card-body">
        
        <table class="table table-bordered table-striped table-hover table-sm" id="table_jpengaduan">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode Pengaduan</th>
                    <th>Jenis Pengaduan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
<script>
    $(document).ready(function() {
        var dataLevel = $('#table_jpengaduan').DataTable({
            serverSide: true, // serverSide: true, jika ingin menggunakan server side processing
            ajax: {
                "url": "{{ url('jpengaduan/list') }}",
                "dataType": "json",
                "type": "POST"
            },
            columns: [
                {
                    data: "DT_RowIndex", // nomor urut dari laravel datatable addIndexColumn()
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "pengaduan_kode",
                    className: "",
                    orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                    searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                },
                {
                    data: "pengaduan_nama",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "aksi",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>
@endpush