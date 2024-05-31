@extends('layouts.template')

@section('content')
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">Detail Informasi Pengaduan !</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <strong>Nama:</strong> {{ $nama }}<br>
                <strong>Jenis Pengaduan:</strong> {{ $pengaduan_nama }}<br>
                <strong>Deskripsi:</strong> {{ $deskripsi }}<br>
            </div>
            <div class="col-md-6">
                <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#buktiFoto" aria-expanded="false" aria-controls="buktiFoto">
                    Bukti
                </button>
                <div class="collapse" id="buktiFoto">
                    <img src="{{ asset('storage/bukti_foto/' . basename($pengaduan->bukti_foto)) }}" alt="Bukti Foto Pengaduan" style="width: 100%; max-width: 400px; height: auto; object-fit: cover; margin-top: 10px;">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ url('/prioritas/simpan/' . $pengaduan->id_pengaduan) }}" method="POST">
            @csrf

            @foreach($kriteriaList as $kriteria)
            <div class="form-group">
                <label for="kriteria_{{ $kriteria->id }}">{{ $kriteria->nama }}:</label>
                <select class="form-control" id="kriteria_{{ $kriteria->id }}" name="sub_kriteria[{{ $kriteria->id }}]">
                    @foreach($kriteria->subKriteria as $subKriteria)
                    <option value="{{ $subKriteria->value }}">{{ $subKriteria->name }}</option>
                    @endforeach
                </select>
            </div>
            @endforeach

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function(){
        $('[data-toggle="collapse"]').on('click', function() {
            var $this = $(this);
            var $collapse = $($this.data('target'));
            $collapse.collapse('toggle');
        });
    });
</script>
@endpush
