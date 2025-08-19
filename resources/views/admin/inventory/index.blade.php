@extends('adminlte::page')
@section('content')
<h1>Data Barang Perusahaan</h1>
@if(auth()->user()->role === 'Logistik' || auth()->user()->role === 'Manager')
<div class="mb-4">
        <form action="{{ route('admin.inventory.index') }}" method="GET" class="form-inline">
    <!-- Pencarian Nama Barang -->
    <div class="form-group mb-2 mr-2">
        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Cari nama barang"
            value="{{ request('search') }}">
    </div>

    <!-- Filter Jenis Barang -->
    <div class="form-group mb-2 mr-2">
        <select name="gada" class="form-control">
            <option value="">-- Jenis Barang --</option>
            <option value="Alat" {{ request('gada') == 'Alat' ? 'selected' : '' }}>Alat</option>
            <option value="Baju" {{ request('gada') == 'Baju' ? 'selected' : '' }}>Baju</option>
        </select>
    </div>

    <!-- Tombol Filter -->
    <button type="submit" class="btn btn-primary mb-2">Filter</button>
    <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary mb-2 ml-2">Reset</a>
</form>

    </div>
<a href="{{ route('admin.inventory.create') }}" class="btn btn-primary mt-3">Tambah Barang</a>
@endif
<table class="table table-bordered mt-4">
    <tr>
        <th>No</th>
        <th>Nama Barang</th>
        <th>Quantity</th>
        <th>Jenis Barang</th>
        <th>Stock</th>
        <th>Harga</th>
        <th>Status</th>
        @if(auth()->user()->role === 'Logistik' || auth()->user()->role === 'Manager')
        <th>Aksi</th>
        @endif
    </tr>
    @foreach ($inventoryItems as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->nama_barang }}</td>
        <td>{{ $item->quantity }}</td>
        <td>{{ $item->jenis_barang }}</td>
        <td>{{ $item->stock }}</td>
        <td>{{ number_format($item->price, 0, ',', '.') }}</td>
        <td>{{ $item->status }}</td>
         @if(auth()->user()->role === 'Logistik' || auth()->user()->role === 'Manager')
        <td>

            <a href="{{ route('admin.inventory.show', 1) }}" class="btn btn-info">Detail</a>
            <a href="{{ route('admin.inventory.edit', $item->id) }}" class="btn btn-warning">Edit</a>

        </td>
         @endif
    </tr>
    @endforeach
</table>

<!-- Script untuk menampilkan/menghilangkan form -->
<script>
    document.getElementById('toggleForm').addEventListener('click', function() {
        var form = document.getElementById('saldoForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });
</script>
@endsection
