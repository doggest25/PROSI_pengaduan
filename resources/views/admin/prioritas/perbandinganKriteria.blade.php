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
    // Jika ingin mengubah nilai perbandingan secara dinamis
    $('.nilai-perbandingan').change(function() {
        var value = $(this).val();
        var kriteriaId = $(this).attr('id').split('_')[2];
        var subKriteriaId = $(this).attr('id').split('_')[3];
        var nilai = 1 / value;
        var roundedNilai = parseFloat(nilai).toFixed(3);
        $('#nilai_perbandingan_' + subKriteriaId + '_' + kriteriaId).val(roundedNilai);
    });
</script>

@endpush
