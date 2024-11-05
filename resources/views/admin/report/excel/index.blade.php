<table>
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
