@extends('layouts.template')

@section('content')
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
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form action="{{ url('/prioritas/simpan/' . $pengaduan->id_pengaduan) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="biaya">Perkiraan Kebutuhan Biaya:</label>
                <input type="number" class="form-control" id="biaya_input" name="biaya_input" min="0" step="1000">
                <input type="hidden" id="biaya" name="biaya">
            </div>
            <div class="form-group">
                <label for="sdm_input">Perkiraan Kebutuhan Sumber Daya Manusia:</label>
                <input type="number" class="form-control" id="sdm_input" name="sdm_input" min="1" step="1">
                <input type="hidden" id="sdm" name="sdm">
            </div>
            <div class="form-group">
                <label for="efektivitas">Tingkat Efektivitas Solusi:</label>
                <select class="form-control" id="efektivitas" name="efektivitas">
                    <option value="1">Sangat Tidak Efektif (Solusi tidak berhasil)</option>
                    <option value="2">Tidak Efektif (Solusi kurang berhasil)</option>
                    <option value="3">Netral (Solusi memiliki hasil campuran)</option>
                    <option value="4">Efektif (Solusi berhasil)</option>
                    <option value="5">Sangat Efektif (Solusi sangat berhasil)</option>
                </select>
            </div>
            <div class="form-group">
                <label for="urgensi">Urgensi:</label>
                <select class="form-control" id="urgensi" name="urgensi">
                    <option value="1">Sangat Rendah (Tidak mendesak)</option>
                    <option value="2">Rendah (Tidak terlalu mendesak)</option>
                    <option value="3">Sedang (Mendesak)</option>
                    <option value="4">Tinggi (Sangat mendesak)</option>
                    <option value="5">Sangat Tinggi (Darurat)</option>
                </select>
            </div>
            <div class="form-group">
                <label for="dampak">Dampak Terhadap Warga:</label>
                <select class="form-control" id="dampak" name="dampak">
                    <option value="1">Sangat Rendah (Tidak berdampak signifikan)</option>
                    <option value="2">Rendah (Dampak ringan)</option>
                    <option value="3">Sedang (Dampak moderat)</option>
                    <option value="4">Tinggi (Dampak signifikan)</option>
                    <option value="5">Sangat Tinggi (Dampak sangat signifikan)</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const biayaInput = document.getElementById('biaya_input');
        const biayaHidden = document.getElementById('biaya');

        biayaInput.addEventListener('input', function() {
            const value = parseInt(biayaInput.value);

            if (value < 100000) {
                biayaHidden.value = 5;
            } else if (value >= 100000 && value < 200000) {
                biayaHidden.value = 4;
            } else if (value >= 200000 && value < 300000) {
                biayaHidden.value = 3;
            } else if (value >= 300000 && value < 400000) {
                biayaHidden.value = 2;
            } else if (value >= 400000) {
                biayaHidden.value = 1;
            } else {
                biayaHidden.value = '';
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const sdmInput = document.getElementById('sdm_input');
        const sdmHidden = document.getElementById('sdm');

        sdmInput.addEventListener('input', function() {
            const value = parseInt(sdmInput.value);

            if (value >= 1 && value <= 10) {
                sdmHidden.value = 5;
            } else if (value >= 11 && value <= 20) {
                sdmHidden.value = 4;
            } else if (value >= 21 && value <= 30) {
                sdmHidden.value = 3;
            } else if (value >= 31 && value <= 40) {
                sdmHidden.value = 2;
            } else if (value >= 41 && value <= 50) {
                sdmHidden.value = 1;
            } else {
                sdmHidden.value = '';
            }
        });
    });
 
    $(document).ready(function(){
        $('[data-toggle="collapse"]').on('click', function() {
            var $this = $(this);
            var $collapse = $($this.data('target'));
            $collapse.collapse('toggle');
        });
    });

</script>
@endpush
