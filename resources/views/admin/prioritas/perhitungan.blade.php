@extends('layouts.template')

@section('content')
<h1>Hasil Perhitungan</h1>

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
<p>CR: {{ $cr }}</p>

<h1>Matriks Keputusan</h1>

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

<h1>Normalisasi Matriks</h1>
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

<h1>Matriks Tertimbang</h1>
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

<h1>Matriks Area Perkiraan Perbatasan</h1>
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


<h1>Matriks Jarak Alternatif</h1>
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

<h1>Hasil Akhir</h1>
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
@endsection
