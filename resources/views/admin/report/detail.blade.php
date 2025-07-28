@extends('adminlte::page')

@section('content')

<div class="container p-4">
    <h1 class="mb-4">Detail Pengaduan</h1>

    <div class="card mb-4">
        <div class="card-header">
            <strong>{{ $pengaduan->judul }}</strong>
        </div>
        <div class="card-body">
            <p><strong>Deskripsi:</strong> {{ $pengaduan->deskripsi }}</p>
            <p><strong>Status:</strong> {{ $pengaduan->status }}</p>
            <p><strong>Pelapor:</strong> {{ $pengaduan->pelapor }}</p>
        </div>
    </div>

    <h4>Riwayat Tindakan</h4>
    <ul class="list-group mb-4">
        @forelse ($pengaduan->logs as $log)
            <li class="list-group-item">
                <strong>{{ $log->created_at->format('d M Y H:i') }}</strong><br>
                <small>{{ $log->person }} - {{ $log->keterangan }}</small><br>
                {{ $log->deskripsi }}
            </li>
        @empty
            <li class="list-group-item">Belum ada riwayat tindakan.</li>
        @endforelse
    </ul>

    <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary">Kembali</a>
</div>

@endsection
