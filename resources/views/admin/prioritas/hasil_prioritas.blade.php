@extends('layouts.template')

@section('content')

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success"> {{ session('success') }} </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger"> {{ session('error') }} </div>
        @endif
        <table class="table table-bordered table-striped table-hover table-sm" id="pengaduan-table">
            <thead>
                <tr>
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
                {   data: "id_pengaduan", 
                    name: "",
                    orderable: true,
                    searchable: true
                },
                {   data: "nama", 
                    name: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "pengaduan_nama", 
                    name: "",
                    orderable: true,
                    searchable: true
                },
                {   data: "deskripsi", 
                    name: "",
                    orderable: true,
                    searchable: true
                },
                {   data: "final_score", 
                    name: "",
                    orderable: true,
                    searchable: true
                },
                {   data: 'aksi', 
                    name: 'aksi', 
                    orderable: false, 
                    searchable: false
                },
            ]
        });
    });
</script>
@endpush
