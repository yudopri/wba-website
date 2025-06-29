@extends('adminlte::page')

@section('title', 'Data Gaji')

@section('content')
<h1 class="mb-4">Data Seluruh Gaji</h1>

{{-- Alert Success --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

{{-- Card Filter & Tambah --}}
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('gaji.index') }}" method="GET" class="row align-items-end">
            {{-- Filter Nama Perusahaan --}}
            <div class="col-md-4 mb-2">
                <label for="search">Nama Perusahaan</label>
                <input type="text" name="search" id="search" class="form-control" placeholder="Cari nama perusahaan" value="{{ request('search') }}">
            </div>

            {{-- Filter Bulan --}}
            <div class="col-md-3 mb-2">
                <label for="gada">Bulan</label>
                <select name="gada" id="gada" class="form-control">
                    <option value="">-- Pilih Bulan --</option>
                    @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bulan)
                        <option value="{{ $bulan }}" {{ request('gada') == $bulan ? 'selected' : '' }}>{{ $bulan }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tombol Filter --}}
            <div class="col-auto mb-2">
                <label>&nbsp;</label>
                <div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('gaji.index') }}" class="btn btn-secondary">
                        <i class="fas fa-sync-alt"></i> Reset
                    </a>
                </div>
            </div>

            {{-- Tombol Tambah Gaji --}}
            <div class="col-auto ml-auto mb-2 text-right">
                <label>&nbsp;</label>
                <div>
                    <a href="{{ route('gaji.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Buat Gaji Baru
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Tabel Gaji --}}
<div class="card">
    <div class="card-body p-0">
        <table class="table table-bordered table-hover mb-0">
            <thead class="thead-dark">
                <tr>
                    <th style="width: 50px">No</th>
                    <th>Nama Perusahaan</th>
                    <th>Nominal</th>
                    <th>Bulan</th>
                    <th>Status</th>
                    <th style="width: 130px" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dataGaji as $index => $gaji)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $gaji->nama_pt }}</td>
                        <td>Rp {{ number_format($gaji->nominal, 0, ',', '.') }}</td>
                        <td>{{ $gaji->bulan }}</td>
                        <td>
                            <span class="badge 
                                @if($gaji->status == 'Menunggu') badge-warning 
                                @elseif($gaji->status == 'Dikonfirmasi') badge-success 
                                @endif">
                                {{ $gaji->status }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('gaji.detail', $gaji->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('gaji.konfirmasi', $gaji->id) }}" class="btn btn-sm btn-warning" title="Konfirmasi">
                                    <i class="fas fa-check"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Tidak ada data gaji ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
