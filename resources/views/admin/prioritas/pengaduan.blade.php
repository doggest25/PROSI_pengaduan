@extends('layouts.template')

@section('content')
<table id="pengaduanTable" class="table table-bordered table-striped table-hover table-sm">
    <thead>
        <tr>
            <th>ID Pengaduan</th>
            <th>Jenis Pengaduan</th>
            <th>Score</th>
            <th>Aksi</th> <!-- Tambahkan kolom aksi -->
        </tr>
    </thead>
</table>
@endsection

@push('css')
@endpush

@push('js')
<script>
    $(document).ready(function() {
        $('#pengaduanTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('prioritas.pengaduan.data') !!}',
            columns: [
                { 
                    data: 'id_pengaduan', 
                    name: 'vp.id_pengaduan'
                },
                { 
                    data: 'pengaduan_nama', 
                    name: 'jp.pengaduan_nama'
                },
                { 
                    data: 'score', 
                    name: 'hp.score'
                },
                { 
                    data: 'action', 
                    name: 'action',
                    className: "text-center", 
                    orderable: false, 
                    searchable: false
                }
            ]
        });
    });
</script>
@endpush
