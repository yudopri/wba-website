<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Distribusi Seragam</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <h2>Rekap Distribusi Seragam</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $index => $employee)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $employee->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
