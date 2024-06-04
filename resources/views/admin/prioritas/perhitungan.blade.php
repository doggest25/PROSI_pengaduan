@extends('layouts.template')

@section('content')
{{-- <h1>Hasil Perhitungan</h1>

<table>
    <thead>
        <tr>
            <th>Kriteria</th>
            <th>Nilai Eigen Vector</th>
        </tr>
    </thead>
    <tbody>
        @for ($i = 0; $i < $n; $i++)
            <tr>
                <td>Kriteria {{ $i + 1 }}</td>
                <td>{{ $eigenVector[$i] }}</td>
            </tr>
        @endfor
    </tbody>
</table>

<p>λ_max: {{ $lambdaMax }}</p>
<p>CI: {{ $ci }}</p>
<p>CR: {{ $cr }}</p> --}}


<div class="card card-outline">
    <div class="card-header bg-warning d-flex justify-content-between align-items-center">
        <h1 class="card-title"><strong>Hasil Perhitungan</strong></h1>
        <button class="btn btn-link ml-auto font-weight-bold" type="button" data-toggle="collapse" data-target="#calculationResults" aria-expanded="false" aria-controls="calculationResults">
            <i class="bi bi-chevron-down"></i>
        </button>
    </div>
    <div id="calculationResults" class="collapse card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kriteria</th>
                    <th>Nilai Eigen Vector</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < $n; $i++)
                    <tr>
                        <td>Kriteria {{ $i + 1 }}</td>
                        <td>{{ $eigenVector[$i] }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>
        <p></p>
        <p>λ_max: {{ $lambdaMax }}</p>
        <p>CI: {{ $ci }}</p>
        <p>CR: {{ $cr }}</p>
    </div>
</div>


{{-- <h1>Matriks Keputusan</h1>

<table class="table table-bordered table-striped table-hover table-sm">
    <thead>
        <tr>
            <th>ID Pengaduan</th>
            @foreach($kriteria as $k)
                <th>{{ $k->nama }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($decisionMatrix as $id_pengaduan => $nilaiKriteria)
            <tr>
                <td>{{ $id_pengaduan }}</td>
                @foreach($kriteria as $k)
                    <td>{{ $nilaiKriteria[$k->id] ?? 'N/A' }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table> --}}

<div class="card card-outline">
    <div class="card-header bg-warning d-flex justify-content-between align-items-center">
        <h3 class="card-title"><strong>Matriks Keputusan</strong></h3>
        <button class="btn btn-link ml-auto font-weight-bold" type="button" data-toggle="collapse" data-target="#decisionMatrix" aria-expanded="false" aria-controls="decisionMatrix">
            <i class="bi bi-chevron-down"></i>
        </button>
    </div>
    <div id="decisionMatrix" class="collapse card-body">
        <table class="table table-bordered table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th>ID Pengaduan</th>
                    @foreach($kriteria as $k)
                        <th>{{ $k->nama }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($decisionMatrix as $id_pengaduan => $nilaiKriteria)
                    <tr>
                        <td>{{ $id_pengaduan }}</td>
                        @foreach($kriteria as $k)
                            <td>{{ $nilaiKriteria[$k->id] ?? 'N/A' }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


{{-- <h1>Normalisasi Matriks</h1>
<table class="table table-bordered table-striped table-hover table-sm">
    <thead>
        <tr>
            <th>ID Jenis Pengaduan</th>
            @foreach($kriteria as $k)
                <th>{{ $k->nama }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($normalizedMatrix as $id_jenis_pengaduan => $nilaiKriteria)
            <tr>
                <td>{{ $id_jenis_pengaduan }}</td>
                @foreach($kriteria as $k)
                    <td>{{ number_format($nilaiKriteria[$k->id] ?? 0, 2) }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table> --}}

<div class="card card-outline">
    <div class="card-header bg-info d-flex justify-content-between align-items-center">
        <h3 class="card-title"><strong>Normalisasi Matriks</strong></h3>
        <button class="btn btn-link ml-auto font-weight-bold" type="button" data-toggle="collapse" data-target="#normalizedMatrix" aria-expanded="false" aria-controls="normalizedMatrix">
            <i class="bi bi-chevron-down"></i>
        </button>
    </div>
    <div id="normalizedMatrix" class="collapse card-body">
        <table class="table table-bordered table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th>ID Jenis Pengaduan</th>
                    @foreach($kriteria as $k)
                        <th>{{ $k->nama }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($normalizedMatrix as $id_jenis_pengaduan => $nilaiKriteria)
                    <tr>
                        <td>{{ $id_jenis_pengaduan }}</td>
                        @foreach($kriteria as $k)
                            <td>{{ number_format($nilaiKriteria[$k->id] ?? 0, 2) }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- <h1>Matriks Tertimbang</h1>
<table class="table table-bordered table-striped table-hover table-sm">
    <thead>
        <tr>
            <th>ID Jenis Pengaduan</th>
            @foreach($kriteria as $k)
                <th>{{ $k->nama }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($weightedMatrix as $id_jenis_pengaduan => $nilaiKriteria)
            <tr>
                <td>{{ $id_jenis_pengaduan }}</td>
                @foreach($kriteria as $k)
                    <td>{{ number_format($nilaiKriteria[$k->id] ?? 0, 3) }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table> --}}

<div class="card card-outline">
    <div class="card-header bg-info d-flex justify-content-between align-items-center">
        <h3 class="card-title"><strong>Matriks Tertimbang</strong></h3>
        <button class="btn btn-link ml-auto font-weight-bold" type="button" data-toggle="collapse" data-target="#weightedMatrix" aria-expanded="false" aria-controls="weightedMatrix">
            <i class="bi bi-chevron-down"></i>
        </button>
    </div>
    <div id="weightedMatrix" class="collapse card-body">
        <table class="table table-bordered table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th>ID Jenis Pengaduan</th>
                    @foreach($kriteria as $k)
                        <th>{{ $k->nama }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($weightedMatrix as $id_jenis_pengaduan => $nilaiKriteria)
                    <tr>
                        <td>{{ $id_jenis_pengaduan }}</td>
                        @foreach($kriteria as $k)
                            <td>{{ number_format($nilaiKriteria[$k->id] ?? 0, 3) }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- <h1>Matriks Area Perkiraan Perbatasan</h1>
<table class="table table-bordered table-striped table-hover table-sm">
    <thead>
        <tr>
            <th>Kriteria</th>
            <th>Geometric Mean</th>
        </tr>
    </thead>
    <tbody>
        @foreach($kriteria as $k)
            <tr>
                <td>{{ $k->nama }}</td>
                <td>{{ number_format($gMatrix[$k->id], 3) }}</td>
            </tr>
        @endforeach
    </tbody>
</table> --}}

<div class="card card-outline">
    <div class="card-header bg-secondary d-flex justify-content-between align-items-center">
        <h3 class="card-title"><strong>Matriks Area Perkiraan Perbatasan</strong></h3>
        <button class="btn btn-link ml-auto font-weight-bold" type="button" data-toggle="collapse" data-target="#borderEstimateMatrix" aria-expanded="false" aria-controls="borderEstimateMatrix">
            <i class="bi bi-chevron-down"></i>
        </button>
    </div>
    <div id="borderEstimateMatrix" class="collapse card-body">
        <table class="table table-bordered table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th>Kriteria</th>
                    <th>Geometric Mean</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kriteria as $k)
                    <tr>
                        <td>{{ $k->nama }}</td>
                        <td>{{ number_format($gMatrix[$k->id], 3) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


{{-- <h1>Matriks Jarak Alternatif</h1>
<table class="table table-bordered table-striped table-hover table-sm">
    <thead>
        <tr>
            <th>ID Jenis Pengaduan</th>
            @foreach($kriteria as $k)
                <th>{{ $k->nama }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($qMatrix as $id_jenis_pengaduan => $nilaiKriteria)
            <tr>
                <td>{{ $id_jenis_pengaduan }}</td>
                @foreach($kriteria as $k)
                    <td>{{ number_format($nilaiKriteria[$k->id] ?? 0, 3) }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table> --}}

<div class="card card-outline">
    <div class="card-header bg-secondary d-flex justify-content-between align-items-center">
        <h3 class="card-title"><strong>Matriks Jarak Alternatif</strong></h3>
        <button class="btn btn-link ml-auto font-weight-bold" type="button" data-toggle="collapse" data-target="#alternativeDistanceMatrix" aria-expanded="false" aria-controls="alternativeDistanceMatrix">
            <i class="bi bi-chevron-down"></i>
        </button>
    </div>
    <div id="alternativeDistanceMatrix" class="collapse card-body">
        <table class="table table-bordered table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th>ID Jenis Pengaduan</th>
                    @foreach($kriteria as $k)
                        <th>{{ $k->nama }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($qMatrix as $id_jenis_pengaduan => $nilaiKriteria)
                    <tr>
                        <td>{{ $id_jenis_pengaduan }}</td>
                        @foreach($kriteria as $k)
                            <td>{{ number_format($nilaiKriteria[$k->id] ?? 0, 3) }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- <h1>Hasil Akhir</h1>
<table class="table table-bordered table-striped table-hover table-sm">
    <thead>
        <tr>
            <th>ID Pengaduan</th>
            <th>Hasil Akhir MABAC</th>
        </tr>
    </thead>
    <tbody>
        @foreach($finalScores as $id_pengaduan => $score)
            <tr>
                <td>{{ $id_pengaduan }}</td>
                <td>{{ $score }}</td>
            </tr>
        @endforeach
    </tbody>
</table> --}}

<div class="card card-outline">
    <div class="card-header bg-success d-flex justify-content-between align-items-center">
        <h3 class="card-title"><strong>Hasil Akhir</strong></h3>
        <button class="btn btn-link ml-auto font-weight-bold" type="button" data-toggle="collapse" data-target="#finalScores" aria-expanded="false" aria-controls="finalScores">
            <i class="bi bi-chevron-down"></i>
        </button>
    </div>
    <div id="finalScores" class="collapse card-body">
        <table class="table table-bordered table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th>ID Pengaduan</th>
                    <th>Hasil Akhir MABAC</th>
                </tr>
            </thead>
            <tbody>
                @foreach($finalScores as $id_pengaduan => $score)
                    <tr>
                        <td>{{ $id_pengaduan }}</td>
                        <td>{{ $score }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
