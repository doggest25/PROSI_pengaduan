@extends('layout.template')

@section('content')
<div class="card card-outline card-primary">
    
    <div class="card-body">
        @empty($detail)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
            Data yang Anda cari tidak ditemukan.
        </div>
        @else
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>Nama</th>
                        <td>{{ $detail->users->nama }}</td>
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
                        <th>Dibuat</th>
                        <td>{{ $detail->created_at }}</td>
                    </tr>
                    <tr>
                        <th>Dipebaharui</th>
                        <td>{{ $detail->updated_at }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6 text-center">
                <div style="border: 1px solid #6b9ef5; padding: 10px;">
                    <h4>Bukti foto</h4>
                    <img src="{{ asset('storage/bukti_foto/' . basename($detail->bukti_foto)) }}" alt="Bukti Foto Pengaduan" style="max-width: 100%; height: auto;">
                </div>
            </div>
        </div>
        
        
        @endempty
        <a href="{{ url('warga/detail') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
