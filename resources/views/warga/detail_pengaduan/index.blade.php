@extends('layout.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">

        <div class="card-tools">
            
        </div>
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
                
            </div>
        </div>
        <table class="table table-bordered table-striped table-hover table-sm" id="table_detail_pengaduan">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Jenis pengaduan</th>
                    <th>Status pengaduan</th>
                    <th>Create at</th>
                    <th>Update at</th>
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
                "url": "{{ url('warga/list') }}",
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
                    data: "created_at",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "updated_at",
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
            ],
            createdRow: function(row, data, dataIndex) {
                var status = data.status_pengaduan.status_nama;
                var statusClass = '';
                var statusText = '';
                if (status === 'Diterima') {
                    statusClass = 'badge-primary';
                    statusText = 'Diterima';
                } else if (status === 'Ditolak') {
                    statusClass = 'badge-danger';
                    statusText = 'Ditolak';
                } else if (status === 'Diproses') {
                    statusClass = 'badge-warning';
                    statusText = 'Diproses';
                }   else if (status === 'Selesai') {
                    statusClass = 'badge-success';
                    statusText = 'Selesai';
                }
                $(row).find('td:eq(2)').html('<span class="badge ' + statusClass + '">' + statusText + '</span>');

                // Ubah format tanggal created_at dan updated_at
            var created_at = new Date(data.created_at);
            var updated_at = new Date(data.updated_at);

            $(row).find('td:eq(3)').text(created_at.toLocaleDateString() + ' (' + created_at.toLocaleTimeString() + ')');
            $(row).find('td:eq(4)').text(updated_at.toLocaleDateString() + ' (' + updated_at.toLocaleTimeString() + ')');
            }
        });

        $('#id_status_pengaduan').on('change', function() {
            dataUser.ajax.reload();
        });
    });
</script>


@endpush