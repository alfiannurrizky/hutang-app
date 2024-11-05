<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Hutang Bulanan</title>
</head>

<body>
    <h1>Laporan Hutang Bulanan</h1>
    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Total Hutang (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($months as $index => $month)
                <tr>
                    <td>{{ $month }}</td>
                    <td>Rp{{ number_format($totalDebts[$index], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
