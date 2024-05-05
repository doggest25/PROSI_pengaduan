@extends('layout.template')

@section('content')
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="card card-outline card-primary">
    
    <div class="card-body">
        @empty($pengaduan)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
            Data yang Anda cari tidak ditemukan.
        </div>
        <a href="{{ url('level') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        @else
        <<form method="POST" action="{{ url('/warga/'.$pengaduan->id_pengaduan) }}" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            {!! method_field('PUT') !!}
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Deskripsi</label>
                <div class="col-10">
                    <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="{{ old('deskripsi', $pengaduan->deskripsi) }}" required>
                    @error('deskripsi')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Bukti_foto</label>
                <div class="col-10">
                    <input type="file" class="form-control" id="bukti_foto" name="bukti_foto" required>
                    @error('bukti_foto')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 control-label col-form-label"></label>
                <div class="col-10">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ url('warga/detail') }}">Kembali</a>
                </div>
            </div>
        </form>
        
        @endempty
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
