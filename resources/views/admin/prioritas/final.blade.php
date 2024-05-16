<div class="container">
    <h2>Perhitungan Prioritas</h2>
    <h3>Hasil AHP</h3>
    <p>Eigen Vector: {{ is_array($eigenVector) ? json_encode($eigenVector) : htmlspecialchars($eigenVector) }}</p>
    <p>Lambda Max: {{ is_array($lambdaMax) ? json_encode($lambdaMax) : htmlspecialchars($lambdaMax) }}</p>
    <p>CI: {{ is_array($ci) ? json_encode($ci) : htmlspecialchars($ci) }}</p>
    <p>CR: {{ is_array($cr) ? json_encode($cr) : htmlspecialchars($cr) }}</p>

    <h3>Hasil MABAC</h3>
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
</div>
