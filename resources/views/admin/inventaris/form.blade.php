@extends('adminlte::page')
<!-- jQuery (required Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@section('content')
<h1>{{ isset($inventory) ? 'Edit' : 'Tambah' }} Inventaris</h1>

<!-- Tampilkan jika ada pesan sukses atau error -->
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Form untuk menambah atau mengedit data inventaris -->
<form action="{{ isset($inventory) ? route('admin.inventaris.update', $inventory->id) : route('admin.inventaris.store') }}" method="POST">
    @csrf
    @if(isset($inventory))
        @method('PUT')  <!-- Untuk edit menggunakan method PUT -->
    @endif

    <div class="form-group">
    <label for="id_karyawan">Nama Karyawan</label>
    <select name="id_karyawan" id="id_karyawan" class="form-control select2" required>
        <option value="">-- Pilih Karyawan --</option>
        @foreach($employees as $employee)
            <option value="{{ $employee->id }}"
                {{ old('id_karyawan', $inventory->id_karyawan ?? '') == $employee->id ? 'selected' : '' }}>
                {{ $employee->name }}
            </option>
        @endforeach
    </select>
</div>



    <!-- Nama Barang -->
<div class="form-group">
    <label for="id_inventori">Nama Barang</label>
    <select name="id_inventori" id="id_inventori" class="form-control" required>
        <option value="">-- Pilih Barang --</option>
        @foreach($inventoryItems as $item)
            <option value="{{ $item->id }}"
                {{ old('id_inventori', $inventory->id_inventori ?? '') == $item->id ? 'selected' : '' }}>
                {{ $item->nama_barang }} (Stock: {{ $item->stock }})
            </option>
        @endforeach
    </select>
</div>


    <!-- Quantity -->
    <div class="form-group">
        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Quantity" value="{{ old('quantity', $inventory->quantity ?? '') }}" required min="1">
    </div>

    <!-- Keterangan -->
    <div class="form-group">
        <label for="keterangan">Keterangan</label>
        <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Keterangan" required>{{ old('keterangan', $inventory->keterangan ?? '') }}</textarea>
    </div>

    <!-- Status -->
    <div class="form-group">
        <label for="status">Status</label>
        <select name="status" id="status" class="form-control" required>
            <option value="">-- Pilih Status --</option>
            <option value="Belum Kembali" {{ old('status', $inventory->status ?? '') == 'Belum Kembali' ? 'selected' : '' }}>Belum Kembali</option>
            <option value="Sudah Kembali" {{ old('status', $inventory->status ?? '') == 'Sudah Kembali' ? 'selected' : '' }}>Sudah Kembali</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">{{ isset($inventory) ? 'Update' : 'Simpan' }}</button>
    <a href="{{ route('admin.inventaris.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@section('js')
<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: "Pilih Karyawan / Barang",
        allowClear: true,
        width: '100%'
    });
});
</script>
@endsection


@endsection
