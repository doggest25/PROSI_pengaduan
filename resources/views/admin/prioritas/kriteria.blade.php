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
        <h3 class="card-title"><strong>Informasi Fungsi Fitur !</strong></h3>
        <button class="btn btn-link ml-auto font-weight-bold" type="button" data-toggle="collapse" data-target="#featureInfo" aria-expanded="false" aria-controls="featureInfo">
            <i class="bi bi-chevron-down"></i>
        </button>
    </div>
    <div id="featureInfo" class="collapse card-body">
        <p>1. <strong>Tambah</strong>, digunakan untuk menambahkan <strong>kriteria</strong> yang nanti akan digunakan untuk perhitungan. <br></p>
        <p>2. <strong>Edit Sub Kriteria</strong>, Ketika anda telah menambahkan <strong>kriteria</strong>, maka <strong>sub kriteria</strong> otomatis terisi dan anda perlu merubahnya sesuai kebutuhan anda ! <br></p>
        <p>3. <strong>Edit Nilai</strong>, Ketika anda telah menambahkan <strong>kriteria</strong>, maka <strong>sub kriteria</strong> otomatis terisi secara default dan anda perlu mengisi <strong>nilai perbandingan kriteria</strong> sesuai kebutuhan anda !<br></p>
        <p>4. <strong>Hapus</strong>, Ketika anda menghapus salah satu <strong>kriteria</strong>, maka otomatis <strong>sub kriteria</strong> dan <strong>nilai perbandingan kriteria</strong> akan terhapus. Jadi berhati-hati saat menghapusnya.<br></p>    
    </div>
</div>




<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('prioritas/createKriteria') }}">Tambah</a>
        </div>
    </div>
    <div class="card-body">
       
        <table class="table table-bordered table-striped table-hover table-sm" id="kriteria">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kriteria</th>
                    <th>Jenis</th>
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
        var dataLevel = $('#kriteria').DataTable({
            serverSide: true, // serverSide: true, jika ingin menggunakan server side processing
            ajax: {
                "url": "{{ url('prioritas/list') }}",
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
                    data: "nama",
                    className: "",
                    orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                    searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                },
                {
                    data: "jenis",
                    className: "",
                    orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                    searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                },
                {
                    data: "aksi",
                    className: "text-center",
                    orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                    searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                }
            ]
        });
    });
</script>
@endpush