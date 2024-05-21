
    
    @extends('layouts.template')

    @section('content')
    <div class="container">
    <h2>Perhitungan Prioritas</h2>
    <h3>Hasil AHP</h3>
    <p>Eigen Vector: {{ is_array($eigenVector) ? json_encode($eigenVector) : htmlspecialchars($eigenVector) }}</p>
    <p>Lambda Max: {{ is_array($lambdaMax) ? json_encode($lambdaMax) : htmlspecialchars($lambdaMax) }}</p>
    <p>CI: {{ is_array($ci) ? json_encode($ci) : htmlspecialchars($ci) }}</p>
    <p>CR: {{ is_array($cr) ? json_encode($cr) : htmlspecialchars($cr) }}</p>
</div>
    <h3>Normalisasi elemen matriks</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Jenis Pengaduan</th>
                @foreach ($normalizedMatrix[array_key_first($normalizedMatrix)] as $key => $value)
                    <th>Kriteria {{ $key }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($normalizedMatrix as $id_jenis_pengaduan => $row)
                <tr>
                    <td>{{ $id_jenis_pengaduan }}</td>
                    @foreach ($row as $value)
                        <td>{{ round($value, 3) }}</td> <!-- Mengambil 3 angka di belakang koma -->
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Matriks tertimbang</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Jenis Pengaduan</th>
                @foreach ($weightedMatrix[array_key_first($weightedMatrix)] as $key => $value)
                    <th>Kriteria {{ $key }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($weightedMatrix as $id_jenis_pengaduan => $row)
                <tr>
                    <td>{{ $id_jenis_pengaduan }}</td>
                    @foreach ($row as $value)
                        <td>{{ $value }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>G Matrix</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                @foreach ($kriteria as $kriteriaItem)
                    <th>{{ $kriteriaItem->nama }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach ($gMatrix as $value)
                    <td>{{ $value }}</td> <!-- Menampilkan 3 angka di belakang koma -->
                @endforeach
            </tr>
        </tbody>
    </table>
    
    <h3>Normalisasi elemen matriks</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Alternatif</th>
                <th>Final Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach($finalScores as $key => $score)
            <tr>
                <td>{{ $key }}</td>
                <td>{{ is_array($score) ? json_encode($score) : htmlspecialchars($score) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    
@endsection
