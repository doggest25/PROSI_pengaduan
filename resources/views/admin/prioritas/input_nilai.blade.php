@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Tambah Nilai Pengaduan</h3>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ url('/prioritas/simpan/' . $pengaduan->id_pengaduan) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="biaya">Biaya (Cost):</label>
                <select class="form-control" id="biaya" name="biaya">
                    <option value="1">< Rp. 100.000</option>
                    <option value="2">Rp. 100.000 - Rp. 200.000</option>
                    <option value="3">Rp. 200.000 - Rp. 300.000</option>
                    <option value="4">Rp. 300.000 - Rp. 400.000</option>
                    <option value="5">> Rp. 400.000</option>
                </select>
            </div>
            <div class="form-group">
                <label for="sdm">SDM (Cost):</label>
                <select class="form-control" id="sdm" name="sdm">
                    <option value="1">Sangat Sedikit (1-10)</option>
                    <option value="2">Sedikit (11-20)</option>
                    <option value="3">Sedang (21-30)</option>
                    <option value="4">Banyak (31-40)</option>
                    <option value="5">Sangat Banyak (41-50)</option>
                </select>
            </div>
            <div class="form-group">
                <label for="efektivitas">Tingkat Efektivitas Solusi (Benefit):</label>
                <select class="form-control" id="efektivitas" name="efektivitas">
                    <option value="1">Sangat Tidak Efektif (Solusi tidak berhasil)</option>
                    <option value="2">Tidak Efektif (Solusi kurang berhasil)</option>
                    <option value="3">Netral (Solusi memiliki hasil campuran)</option>
                    <option value="4">Efektif (Solusi berhasil)</option>
                    <option value="5">Sangat Efektif (Solusi sangat berhasil)</option>
                </select>
            </div>
            <div class="form-group">
                <label for="urgensi">Urgensi (Benefit):</label>
                <select class="form-control" id="urgensi" name="urgensi">
                    <option value="1">Sangat Rendah (Tidak mendesak)</option>
                    <option value="2">Rendah (Tidak terlalu mendesak)</option>
                    <option value="3">Sedang (Mendesak)</option>
                    <option value="4">Tinggi (Sangat mendesak)</option>
                    <option value="5">Sangat Tinggi (Darurat)</option>
                </select>
            </div>
            <div class="form-group">
                <label for="dampak">Dampak Warga (Benefit):</label>
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
