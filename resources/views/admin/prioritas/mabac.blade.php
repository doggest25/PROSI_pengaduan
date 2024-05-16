<!DOCTYPE html>
<html>
<head>
    <title>Hasil MABAC</title>
</head>
<body>
    <h1>Hasil Perhitungan MABAC</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Jenis Pengaduan</th>
                <th>Nilai MABAC</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasilAkhir as $jenisPengaduanId => $nilaiMABAC)
                <tr>
                    <td>{{ $jenisPengaduanId }}</td>
                    <td>{{ $nilaiMABAC }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
