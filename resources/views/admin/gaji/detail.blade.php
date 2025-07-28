@extends('adminlte::page')

@section('content')

<div class="container p-4">
    <h1 class="mb-4">Detail Gaji</h1>

    <div class="card mb-4">
    <div class="card-header">
        <strong>Nama Karyawan: {{ $gaji->karyawan->nama ?? 'Tidak ditemukan' }}</strong>
    </div>
    <div class="card-body">
        <p><strong>Nama User:</strong> {{ $gaji->user->name ?? 'Tidak ditemukan' }}</p>
        <p><strong>Nominal:</strong> Rp {{ number_format($gaji->nominal, 0, ',', '.') }}</p>
        <p><strong>Bulan:</strong> {{ $gaji->bulan }}</p>
    </div>
</div>


    <h4>Riwayat Tindakan</h4>
    <ul class="list-group mb-4">
        @forelse ($gaji->logs as $log)
            <li class="list-group-item">
                <strong>{{ $log->created_at->format('d M Y H:i') }}</strong><br>
                <small>{{ $log->person }} - {{ $log->keterangan }}</small><br>
                {{ $log->deskripsi }}
            </li>
        @empty
            <li class="list-group-item">Belum ada riwayat tindakan.</li>
        @endforelse
    </ul>

    <a href="{{ route('gaji.index') }}" class="btn btn-secondary">Kembali</a>
</div>

@endsection
