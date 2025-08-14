<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengaduan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1, h3 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        td, th { border: 1px solid #000; padding: 8px; }
    </style>
</head>
<body>
    <h1>Laporan Penyelesaian Pengaduan</h1>

    <p><strong>Judul:</strong> {{ $pengaduan->judul }}</p>
    <p><strong>Deskripsi:</strong> {{ $pengaduan->deskripsi }}</p>
    <p><strong>Kronologi:</strong> {{ $pengaduan->kronologi }}</p>
    <p><strong>Status:</strong> {{ $pengaduan->status }}</p>
    <p><strong>Pelapor:</strong> {{ $pengaduan->user->name }}</p>

    <h3>Riwayat Tindakan</h3>
    <table>
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Petugas</th>
                <th>Keterangan</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengaduan->logs as $log)
            <tr>
                <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                <td>{{ $log->user->name }}</td>
                <td>{{ $log->keterangan }}</td>
                <td>{{ $log->deskripsi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
