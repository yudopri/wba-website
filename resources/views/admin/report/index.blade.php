@extends('adminlte::page')

@section('title', 'Daftar Penyelesaian Masalah')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>📋 Daftar Penyelesaian Masalah</h1>
        <a href="{{ route('pengaduan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Pengaduan
        </a>
    </div>
@endsection

@section('content')

    {{-- Tabel pengaduan --}}
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
                        <td>{{ $p->user->name ?? 'Tidak diketahui' }}</td>
                        <td class="text-center">
                            {{-- Tombol Detail --}}
                            <a href="{{ route('laporanmasalah.detail', $p->id) }}" class="btn btn-info btn-sm me-1">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            @if(auth()->user()->role === 'Lapangan')
                            {{-- Tombol Validasi --}}
                            @if ($p->status == 'Diajukan')
                                <a href="{{ route('pengaduan.validasi', $p->id) }}" class="btn btn-warning btn-sm me-1">
                                    <i class="fas fa-check"></i> Validasi
                                </a>
                            @endif

                            {{-- Tombol Upload Bukti --}}
                            @if (!$p->bukti_penyelesaian)
                                <a href="{{ route('pengaduan.uploadBukti', $p->id) }}" class="btn btn-secondary btn-sm me-1">
                                    <i class="fas fa-upload"></i> Upload Bukti
                                </a>
                            @endif
                            @elseif(auth()->user()->role === 'Manager')

                            {{-- Tombol Approve --}}
                            @if ($p->status == 'Diproses')
                                <a href="{{ route('pengaduan.approve', $p->id) }}" class="btn btn-success btn-sm me-1">
                                    <i class="fas fa-check-double"></i> Approve
                                </a>
                            @endif


                            {{-- Tombol Lihat Bukti --}}
                            @if ($p->bukti_penyelesaian)
                                <a href="{{ asset('storage/' . $p->bukti_penyelesaian) }}" target="_blank" class="btn btn-dark btn-sm">
                                    <i class="fas fa-image"></i> Lihat Bukti
                                </a>
                            @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
