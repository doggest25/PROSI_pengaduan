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
        <p><strong>! Ini merupakan Perbandingan Kriteria</strong>,dimana digunakan untuk menentukan bobot setiap kriteria</p>
        <p><strong>! Disarankan untuk mengisi salah satu ambang</strong>, yaitu ambang atas atau bawah. karena misal ambang batas bawah diisi ambang atas otomatis terisi begitupun sebaliknya</p>
        <p><strong>! Nilai yang diisi hanya boleh 1-9</strong> dan setiap nilai memiliki arti !</p>
        
            
    </div>
</div>
<div class="card card-outline">
    <div class="card-header bg-info d-flex justify-content-between align-items-center">
        <h3 class="card-title"><strong>Informasi Arti Setiap Nilai !</strong></h3>
        <button class="btn btn-link ml-auto font-weight-bold" type="button" data-toggle="collapse" data-target="#featureInfo1" aria-expanded="false" aria-controls="featureInfo">
            <i class="bi bi-chevron-down"></i>
        </button>
    </div>
    <div id="featureInfo1" class="collapse card-body">
        <p><strong>Nilai 1 !</strong> Kedua elemen sama pentingnya</p>
        <p><strong>Nilai 2 !</strong> Elemen yang satu sedikit lebih penting daripada elemen yang lainnya</p>
        <p><strong>Nilai 5 !</strong> Elemen yang satu lebih penting daripada yang lainnya</p>
        <p><strong>Nilai 7 !</strong> Satu elemen jelas lebih mutlak penting daripada elemen lainnya</p>
        <p><strong>Nilai 9  !</strong> Satu elemen mutlak penting daripada elemen lainnya</p>
        <p><strong>Nilai 3, 4, 6, 8 !</strong> Nilai-nilai antara dua nilai pertimbangan-pertimbangan yang berdekatan</p>
        
            
    </div>
</div>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Nilai Perbandingan Kriteria</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('update-nilai-kriteria') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="perbandingan">Perbandingan Kriteria:</label>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kriteria</th>
                            @foreach($daftar_kriteria as $kriteria)
                            <th>{{ $kriteria->nama }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($daftar_kriteria as $kriteria)
                        <tr>
                            <td>{{ $kriteria->nama }}</td>
                            @foreach($daftar_kriteria as $sub_kriteria)
                            <td>
                                @if($kriteria->id == $sub_kriteria->id)
                                1
                                @else
                                @php
                                    $perbandingan = App\Models\PerbandinganKriteria::where('kriteria_1_id', $kriteria->id)
                                        ->where('kriteria_2_id', $sub_kriteria->id)
                                        ->first();
                                    $nilai = $perbandingan ? $perbandingan->nilai_perbandingan : 1;
                                @endphp
                              <input type="number" class="form-control nilai-perbandingan" id="nilai_perbandingan_{{ $kriteria->id }}_{{ $sub_kriteria->id }}" name="nilai_perbandingan[{{ $kriteria->id }}][{{ $sub_kriteria->id }}]" value="{{ old('nilai_perbandingan.' . $kriteria->id . '.' . $sub_kriteria->id, $nilai) }}" min="0.0001" max="9" step="0.0001">


                                @endif
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@endsection
@push('css')
    
@endpush
@push('js')
<script>
    $(document).ready(function() {
        // Jika ingin mengubah nilai perbandingan secara dinamis
        $('.nilai-perbandingan').change(function() {
            var value = parseFloat($(this).val());
            var kriteriaId = $(this).attr('id').split('_')[2];
            var subKriteriaId = $(this).attr('id').split('_')[3];

            if (!isNaN(value) && value > 0) {
                // Calculate the inverse and round to three decimal places
                var nilai = 1 / value;
                var roundedNilai = Math.round((nilai + Number.EPSILON) * 1000) / 1000;

                // Ensure the rounded value has exactly three decimal places
                var formattedNilai = roundedNilai.toFixed(3);

                // Set the value in the corresponding input field
                $('#nilai_perbandingan_' + subKriteriaId + '_' + kriteriaId).val(formattedNilai);
            } else {
                $('#nilai_perbandingan_' + subKriteriaId + '_' + kriteriaId).val('0.000');
            }
        });
    });
</script>


@endpush
