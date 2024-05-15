<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Perhitungan AHP</title>
</head>
<body>
    <h1>Hasil Perhitungan AHP</h1>

    <h2>Eigen Vector (Priority Weights)</h2>
    <ul>
        @foreach($eigenVector as $index => $bobot)
            <li>Kriteria {{ $index + 1 }}: {{ $bobot }}</li>
        @endforeach
    </ul>

    <h2>λmax</h2>
    <p>{{ $lambdaMax }}</p>

    <h2>Consistency Index (CI)</h2>
    <p>{{ $ci }}</p>

    <h2>Consistency Ratio (CR)</h2>
    <p>{{ $cr }}</p>

    @if($cr < 0.1)
        <p>Perbandingan konsisten.</p>
    @else
        <p>Perbandingan tidak konsisten.</p>
    @endif
</body>
</html>
