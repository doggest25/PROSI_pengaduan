
@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        
    </div>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success"> {{ session('success') }} </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger"> {{ session('error') }} </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Filter:</label>
                    <div class="col-3">
                        <select name="id_status_pengaduan" id="id_status_pengaduan" class="form-control" required>
                            @foreach ($detailFilter as $id => $status)
                            <option value="{{ $id }}">{{ $status }}</option>
                            @endforeach
                            </select>
                            <small class="form-text text-muted">Status Pengaduan</small>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-striped table-hover table-sm" id="table_detail_pengaduan">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Jenis Pengaduan</th>
                    <th>Status Pengaduan</th>
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
    var dataUser = $('#table_detail_pengaduan').DataTable({
        serverSide: true,
        ajax: {
            "url": "{{ url('dpengaduan/list') }}",
            "dataType": "json",
            "type": "POST",
            "data": function (d) {
                d.id_status_pengaduan = $('#id_status_pengaduan').val();
            }
        },
        columns: [
            {
                data: "DT_RowIndex",
                className: "text-center",
                orderable: false,
                searchable: false
            },
            {
                data: "users.nama",
                className: "",
                orderable: true,
                searchable: true
            },
            {
                data: "jenis_pengaduan.pengaduan_nama",
                className: "",
                orderable: true,
                searchable: true
            },
            {
                data: "status_pengaduan.status_nama",
                className: "text-center",
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
            var status = data.status_pengaduan.status_nama;
            if (status === 'Diterima') {
                $(row).find('td:eq(3)').html('<span class="badge badge-success">Diterima</span>');
            } else if (status === 'Ditolak') {
                $(row).find('td:eq(3)').html('<span class="badge badge-danger">Ditolak</span>');
            } else if (status === 'Diproses') {
                $(row).find('td:eq(3)').html('<span class="badge badge-warning">Diproses</span>');
            }
            
        }
    });

    $('#id_status_pengaduan').on('change', function() {
        dataUser.ajax.reload();
    });
});

</script>

@endpush
