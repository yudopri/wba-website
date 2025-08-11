@extends('adminlte::page')

@section('title', 'Data Gaji')

@section('content')
<h1 class="mb-4">Data Seluruh Gaji</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('gaji.index') }}" method="GET" class="row align-items-end">
            <div class="col-md-4 mb-2">
                <label for="gada">Bulan</label>
                <select name="gada" id="gada" class="form-control">
                    <option value="">-- Pilih Bulan --</option>
                    @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bulan)
                        <option value="{{ $bulan }}" {{ request('gada') == $bulan ? 'selected' : '' }}>
                            {{ $bulan }}
                        </option>
                    @endforeach
                </select>
            </div>

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

<div class="card">
    <div class="card-body p-0">
        <table class="table table-bordered table-hover mb-0">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nama PT</th>
                    <th>User</th>
                    <th>Nominal</th>
                    <th>Bulan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dataGaji as $index => $gaji)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $gaji->partner->name_partner ?? '-' }}</td>
                        <td>{{ $gaji->user->name ?? '-' }}</td>
                        <td>Rp {{ number_format($gaji->nominal, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($gaji->bulan)->translatedFormat('F Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Tidak ada data gaji ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
