<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export Plans - PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #aaa; padding: 6px; text-align: left; }
        th { background-color: #f5f5f5; }
    </style>
</head>
<body>
    <h2>Daftar Plan</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Plan</th>
                <th>Harga</th>
                <th>Highlight</th>
                <th>Durasi</th>
                <th>Deskripsi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($plans as $index => $plan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $plan->name }}</td>
                    <td>Rp{{ number_format($plan->price, 0, ',', '.') }}</td>
                    <td>{{ $plan->highlight }}</td>
                    <td>{{ $plan->duration }}</td>
                    <td>{{ $plan->description }}</td>
                    <td>{{ $plan->status ? 'Aktif' : 'Nonaktif' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
