@extends('layouts.template')

@section('content')

    <div class="card-body">
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
                <p>1. <strong>Hasil Akhir Perhitungan</strong> setiap <strong>pengaduan</strong> yang sudah diisi nilai alternatifnya akan langsung dihitung dan menghasilkan <strong>final score</strong><br></p>
                <p>2. <strong>Final Score</strong> yang memiliki nilai paling besar merupakan prioritas paling utama </strong><br></p>
                <p>3. <strong>Pengurutan</strong>, anda juga dapat mengurutkan <strong>final score</strong> jika anda kesulitan melihat perangkingan dengan menekan symbol disebelah kanan kolom <strong>final score</strong> agar dapat memudahkan anda untuk menentukan keputusan</strong><br></p>
                <p>3. <strong>Tindakan</strong>, setelah anda memlih dan selesai menindak <strong>pengaduan</strong>,anda dapat merubah status menjadi "<strong>selesai</strong>" agar <strong>pengaduan</strong> keluar dari perankingan</strong><br></p>
               
            </div>
        </div>
        <table class="table table-bordered table-striped table-hover table-sm" id="pengaduan-table">
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>No. pengaduan</th>
                    <th>Nama User</th>
                    <th>jenis</th>
                    <th>Deskripsi</th>
                    <th>Final Score</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@push('css')
@endpush

@push('js')
<script>
    $(document).ready(function() {
        $('#pengaduan-table').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('hasil/list') }}",
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
                {   data: "id_pengaduan", 
                    name: "",
                    orderable: true,
                    searchable: true
                },
                {   data: "users.nama", 
                    name: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "jenis_pengaduan.pengaduan_nama", 
                    name: "",
                    orderable: true,
                    searchable: true
                },
                {   data: "deskripsi", 
                    name: "",
                    orderable: true,
                    searchable: true
                },
                {   data: "hasil_prioritas.final_score", 
                    name: "",
                    orderable: true,
                    searchable: true
                },
                {   data: 'aksi', 
                    className: "text-center", 
                    orderable: false, 
                    searchable: false
                },
            ]
        });
    });
</script>
@endpush
