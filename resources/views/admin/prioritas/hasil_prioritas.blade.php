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
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('hasil/list') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            columns: [
                {data: 'id_pengaduan', name: 'id_pengaduan'},
                {data: 'nama', name: 'nama'},
                {data: 'pengaduan_nama', name: 'pengaduan_nama'},
                {data: 'deskripsi', name: 'deskripsi'},
                {data: 'final_score', name: 'final_score'},
                {data: 'aksi', name: 'aksi', orderable: false, searchable: false},
            ]
        });
    });
</script>
@endpush
