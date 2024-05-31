@extends('layouts.template')

@section('content')
@if(session('success'))
<div class="alert alert-success"> {{ session('success') }} </div>
@endif
@if(session('error'))
<div class="alert alert-danger"> {{ session('error') }} </div>
@endif
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Add Kriteria</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('kriteria.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama">Nama Kriteria:</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}">
                @error('nama')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="jenis">Jenis Kriteria:</label>
                <select class="form-control" id="jenis" name="jenis">
                    <option value="cost" {{ old('jenis') == 'cost' ? 'selected' : '' }}>Cost</option>
                    <option value="benefit" {{ old('jenis') == 'benefit' ? 'selected' : '' }}>Benefit</option>
                </select>
                @error('jenis')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
