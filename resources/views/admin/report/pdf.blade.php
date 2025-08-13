<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengaduan</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
            position: relative;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        .ttd-container {
            width: 100%;
            text-align: center;
            position: fixed;
            bottom: 50px;
        }
        .ttd-col {
            display: inline-block;
            width: 45%;
        }
        /* Logo watermark */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            z-index: -1;
        }
    </style>
</head>
<body>

    {{-- Logo watermark --}}
    <div class="watermark">
        <img src="{{ public_path('assets/logo/logo.png') }}" style="width: 700px;">
    </div>

    <h2>Laporan Pengaduan</h2>

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
            </tr>
        </thead>
        <tbody>
            @foreach($pengaduan->logs as $log)
            <tr>
                <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                <td>{{ $log->user->name }}</td>
                <td>{{ $log->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Tanda Tangan --}}
    <div class="ttd-container">
        <div class="ttd-col">
            Pelapor,<br><br><br><br>
            (__________________)
        </div>
        <div class="ttd-col">
            .........., {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
            Penganggung Jawab,<br><br><br><br>
            (__________________)
        </div>
    </div>

</body>
</html>
