@extends('layouts.template')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(session('success'))
<div class="alert alert-success"> {{ session('success') }} </div>
@endif
@if(session('error'))
<div class="alert alert-danger"> {{ session('error') }} </div>
@endif
<div class="card card-outline">
    <div class="card-header bg-warning d-flex justify-content-between align-items-center">
        <h3 class="card-title"><strong>Informasi Panduan Pengisian !</strong></h3>
        <button class="btn btn-link ml-auto font-weight-bold" type="button" data-toggle="collapse" data-target="#featureInfo" aria-expanded="false" aria-controls="featureInfo">
            <i class="bi bi-chevron-down"></i>
        </button>
    </div>
    <div id="featureInfo" class="collapse card-body">
        <p>1. <strong>Jika jenis Kriteria Cost</strong> ,semakin rendah suatu sub kriteria berarti semakin tinggi nilai yang diberikan<br></p>
        <p>2. <strong>Jika jenis Kriteria Benefit</strong>,semakin tinggi suatu sub kriteria berarti semakin tinggi nilai yang diberikan <br></p>
        <p>3. <strong>Range pemberian nilai</strong> hanya bisa 1-5 dan tidak boleh sama !<br></p>
        <p>4. <strong>Disarankan!</strong> untuk mengisi dari atas kebawah,agar sub kriteria terurut.<br></p>
            
    </div>
</div>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Sub-Kriteria untuk {{ $kriteria->nama }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('update-sub-kriteria', $kriteria->id) }}" method="POST">
            @csrf
            @method('POST')

            @foreach($subKriteria as $index => $sub)
            <div class="form-group">
                <label for="name_{{ $index }}">Nama Sub-Kriteria {{ $index+1 }}</label>
                <input type="text" class="form-control" id="name_{{ $index }}" name="sub_kriteria[{{ $index }}][name]" value="{{ $sub->name }}" required>
                <input type="hidden" name="sub_kriteria[{{ $index }}][id]" value="{{ $sub->id }}">
            </div>
            <div class="form-group">
                <label for="bobot_{{ $index }}">Value Sub-Kriteria {{ $index+1 }}</label>
                <input type="number" class="form-control" id="bobot_{{ $index }}" name="sub_kriteria[{{ $index }}][value]" value="{{ $sub->value }}" step="0.01" required>
            </div>
            @endforeach

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
        
    </div>
    <a href="{{ url('prioritas/kriteria') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>


@endsection
