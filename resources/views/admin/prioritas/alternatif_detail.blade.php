@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @empty($detail)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
            Data yang Anda cari tidak ditemukan.
        </div>
        @else
        <table class="table table-bordered table-striped table-hover table-sm">
            <tr>
                <th>ID</th>
                <td>{{ $detail->id_pengaduan }}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>{{ $detail->users->nama }}</td>
            </tr>
            <tr>
                <th>No Telepon</th>
                <td>{{ $detail->users->telepon }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $detail->users->alamat }}</td>
            </tr>
            <tr>
                <th>Jenis Pengaduan</th>
                <td>{{ $detail->jenis_pengaduan->pengaduan_nama }}</td>
            </tr>
            <tr>
                <th>Deskripsi</th>
                <td>{{ $detail->deskripsi }}</td>
            </tr>
            <tr>
                <th>Lokasi</th>
                <td>{{ $detail->lokasi }}</td>
            </tr>
            <tr>
                <th>Dibuat</th>
                <td>{{ $detail->created_at }}</td>
            </tr>
            <tr>
                <th>Diperbaharui</th>
                <td>{{ $detail->updated_at }}</td>
            </tr>
            <tr>
                <th>Bukti file</th>
                <td>
                    <img src="{{ asset('storage/bukti_foto/' . basename($detail->bukti_foto)) }}" alt="Bukti Foto Pengaduan">

                </td>
            </tr>
            
            
        </table>
        @endempty
        <a href="{{ url('prioritas/pengaduanDiterima') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
