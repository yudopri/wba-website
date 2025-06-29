@extends('adminlte::page')

@section('title', 'Daftar Pengaduan Masalah')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>📋 Daftar Pengaduan Masalah</h1>
        <a href="{{ route('pengaduan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Pengaduan
        </a>
    </div>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover table-striped text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Pelapor</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
    @foreach ($pengaduan as $p)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $p->judul }}</td>
        <td>{{ $p->deskripsi }}</td>
        <td>
            <span class="badge 
                @if ($p->status == 'Diajukan') bg-warning text-dark
                @elseif ($p->status == 'Diproses') bg-info text-white
                @elseif ($p->status == 'Disetujui') bg-success text-white
                @endif">
                {{ $p->status }}
            </span>
        </td>
        <td>{{ $p->pelapor ?? 'Tidak diketahui' }}</td>
        <td class="text-center">
            {{-- Tombol Detail --}}
            <a href="{{ route('laporanmasalah.detail', $p->id) }}" class="btn btn-info btn-sm me-1">
                <i class="fas fa-eye"></i> Detail
            </a>

            {{-- Tombol Validasi: semua user bisa klik jika status Diajukan --}}
            @if ($p->status == 'Diajukan')
                <a href="{{ route('pengaduan.validasi', $p->id) }}" class="btn btn-warning btn-sm me-1">
                    <i class="fas fa-check"></i> Validasi
                </a>
            @endif

            {{-- Tombol Approve: semua user bisa klik jika status Diproses --}}
            @if ($p->status == 'Diproses')
                <a href="{{ route('pengaduan.approve', $p->id) }}" class="btn btn-success btn-sm">
                    <i class="fas fa-check-double"></i> Approve
                </a>
            @endif
        </td>
    </tr>
    @endforeach
</tbody>


            </table>
        </div>
    </div>
@endsection
