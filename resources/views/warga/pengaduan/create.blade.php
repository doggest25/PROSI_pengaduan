
@extends('layout.template')
@section('content')

<h1>Form Pengaduan</h1>
<div class="card-body">
    <form method="POST" action="{{ url('warga/save') }}" class="form-horizontal" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="user_id" name="user_id" value="{{ Auth::id() }}">
        <div class="form-group row">
                <label class="col-1 control-label col-form-label">Jenis Pengaduan</label>
                <div class="col-11">
                    <select class="form-control" id="id_jenis_pengaduan" name="id_jenis_pengaduan" required>
                        <option value="">- Pilih Jenis Pengaduan -</option>
                        @foreach($id_jenis_pengaduan as $item)
                        <option value="{{ $item->id_jenis_pengaduan }}">{{ $item->pengaduan_nama }}</option>
                        @endforeach
                    </select>
                    @error('id_jenis_pengaduan')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        <div class="form-group row">
            <label class="col-1 control-label col-form-label">Deskripsi</label>
            <div class="col-11">
                <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="{{ old('deskripsi') }}" required>
                @error('deskripsi')
                <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-1 control-label col-form-label">Lokasi</label>
            <div class="col-11">
                <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{ old('lokasi') }}" required>
                @error('lokasi')
                <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-1 control-label col-form-label">Bukti foto</label>
            <div class="col-11">
                <input type="file" class="form-control" id="bukti_foto" name="bukti_foto" value="{{ old('bukti_foto') }}" required>
                @error('bukti_foto')
                <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        
        <input type="hidden" id="id_status_pengaduan" name="id_status_pengaduan" value="1"> <!-- Status Diproses -->
        <div class="form-group row">
            <label class="col-1 control-label col-form-label"></label>
            <div class="col-11">
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                <a class="btn btn-sm btn-default ml-1" href="{{ url('/warga') }}">Kembali</a>
            </div>
        </div>
    </form>
</div>

@endsection

