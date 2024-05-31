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
        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
@endsection
