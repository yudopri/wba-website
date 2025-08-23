<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Distribusi Seragam</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h2>Rekap Karyawan Belum Dapat Seragam</h2>
    <p>Periode: {{ now()->format('F Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
               
            </tr>
        </thead>
        <tbody>
          @forelse($employees as $key => $emp)
    <tr>
        <td>{{ $key+1 }}</td>
        <td>{{ $emp->name }}</td> <!-- sebelumnya $emp->nama -->
       
    </tr>
@empty
    <tr><td colspan="4">Semua karyawan sudah mendapatkan seragam</td></tr>
@endforelse

        </tbody>
    </table>
</body>
</html>
