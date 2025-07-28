@extends('adminlte::page')
@section('content')
<h1>Data Inventaris</h1>
<div class="mb-4">
    <form action="{{ route('admin.inventaris.index') }}" method="GET" class="form-inline">
        <!-- Pencarian Nama atau NIK -->
        <div class="form-group mb-2 mr-2">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Cari nama karyawan atau barang"
                value="{{ request('search') }}">
        </div>

        <!-- Filter Jenis -->
        <div class="form-group mb-2 mr-2">
            <select name="gada" class="form-control">
                <option value="">-- Jenis Barang --</option>
                <option value="Alat" {{ request('gada') == 'Alat' ? 'selected' : '' }}>Alat</option>
                <option value="Baju" {{ request('gada') == 'Baju' ? 'selected' : '' }}>Baju</option>
            </select>
        </div>

        <!-- Tombol Filter -->
        <button type="submit" class="btn btn-primary mb-2">Filter</button>
        <a href="{{ route('admin.inventaris.index') }}" class="btn btn-secondary mb-2 ml-2">Reset</a>
    </form>
</div>

<a href="{{ route('admin.inventaris.create') }}" class="btn btn-primary mt-3">Tambah Data</a>

<table class="table table-bordered mt-4">
    <tr>
        <th>No</th>
        <th>Nama Karyawan</th>
        <th>Nama Barang</th>
        <th>Quantity</th>
        <th>Jenis Barang</th>
        <th>Keterangan</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
    @forelse($inventories as $inventory)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $inventory->employee->name ?? '-' }}</td>
        <td>{{ $inventory->inventoryItem->nama_barang ?? '-' }}</td>
        <td>{{ $inventory->quantity }}</td>
        <td>{{ $inventory->inventoryItem->jenis_barang ?? '-' }}</td>
        <td>{{ $inventory->keterangan ?? '-' }}</td>
        <td>{{ $inventory->status }}</td>
        <td>
            <a href="{{ route('admin.inventaris.show', $inventory->id) }}" class="btn btn-info">Detail</a>
            <a href="{{ route('admin.inventaris.edit', $inventory->id) }}" class="btn btn-warning">Edit</a>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="8" class="text-center">Belum ada data inventaris</td>
    </tr>
    @endforelse
</table>
@endsection
