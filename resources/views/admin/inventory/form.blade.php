@extends('adminlte::page')

@section('content')
<h1>{{ isset($inventoryItem) ? 'Edit inventoryItem' : 'Tambah inventoryItem' }}</h1>

<div class="card">
    <div class="card-body">
        <form
            action="{{ isset($inventoryItem) ? route('admin.inventory.update', $inventoryItem->id) : route('admin.inventory.store') }}"
            method="POST">
            @csrf
            @if(isset($inventoryItem))
                @method('PUT')
            @endif

            <div class="form-group">
                <label>Nama inventoryItem</label>
                <input type="text" name="nama" class="form-control"
                    value="{{ old('nama', $inventoryItem->nama_barang ?? '') }}" required>
            </div>

            <div class="form-group">
                <label>Quantity</label>
                <input type="number" name="quantity" class="form-control"
                    value="{{ old('quantity', $inventoryItem->quantity ?? '') }}" required>
            </div>

            <div class="form-group">
                <label>Jenis inventoryItem</label>
                <select name="jenis" class="form-control" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="Alat" {{ (old('jenis', $inventoryItem->jenis_barang ?? '') == 'Alat') ? 'selected' : '' }}>Alat</option>
                    <option value="Baju" {{ (old('jenis', $inventoryItem->jenis_barang ?? '') == 'Baju') ? 'selected' : '' }}>Baju</option>
                </select>
            </div>

    <!-- Harga -->
    <div class="form-group">
        <label for="harga">Harga (Rp)</label>
        <input type="number" name="price" id="price" class="form-control" placeholder="Harga" value="{{ old('price', $inventoryItem->price ?? '') }}" required min="1">
    </div>

            <button type="submit" class="btn btn-primary">
                {{ isset($inventoryItem) ? 'Update inventoryItem' : 'Simpan inventoryItem' }}
            </button>
            <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection
