@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @empty($typeComplain)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
            Data yang Anda cari tidak ditemukan.
        </div>
        @else
        <table class="table table-bordered table-striped table-hover table-sm">
            <tr>
                <th>ID</th>
                <td>{{ $typeComplain->id_jenis_pengaduan }}</td>
            </tr>
            <tr>
                <th>Kode Level</th>
                <td>{{ $typeComplain->pengaduan_kode }}</td>
            </tr>
            <tr>
                <th>Nama Level</th>
                <td>{{ $typeComplain->pengaduan_nama }}</td>
            </tr>
        </table>
        @endempty
        <a href="{{ url('jpengaduan') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush