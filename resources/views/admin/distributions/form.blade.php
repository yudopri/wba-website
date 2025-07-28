@extends('adminlte::page')

@section('content')
<h1>{{ isset($distribution) ? 'Edit Distribusi' : 'Tambah Distribusi' }}</h1>

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

<form action="{{ isset($distribution) ? route('admin.distributions.update', $distribution->id) : route('admin.distributions.store') }}" method="POST">
    @csrf
    @if(isset($distribution))
        @method('PUT')
    @endif

    <div class="form-group">
        <label for="id_karyawan">Nama Karyawan</label>
        <select name="id_karyawan" id="id_karyawan" class="form-control" required>
            <option value="">-- Pilih Karyawan --</option>
            @foreach($employees as $employee)
                <option value="{{ $employee->id }}" {{ (old('id_karyawan') ?? $distribution->id_karyawan ?? '') == $employee->id ? 'selected' : '' }}>
                    {{ $employee->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="id_inventori">Nama Barang</label>
        <select name="id_inventori" id="id_inventori" class="form-control" required>
            <option value="">-- Pilih Barang --</option>
            @foreach($inventoryItems as $item)
                <option value="{{ $item->id }}" {{ (old('id_inventori') ?? $distribution->id_inventori ?? '') == $item->id ? 'selected' : '' }}>
                    {{ $item->nama_barang }} (Stock: {{ $item->stock }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="quantity">Quantity</label>
        <input type="number" min="1" name="quantity" id="quantity" class="form-control" required value="{{ old('quantity', $distribution->quantity ?? '') }}">
    </div>

    <div class="form-group">
        <label for="keterangan">Keterangan</label>
        <textarea name="keterangan" id="keterangan" class="form-control">{{ old('keterangan', $distribution->keterangan ?? '') }}</textarea>
    </div>

    <div class="form-group">
        <label for="status">Status</label>
        <select name="status" id="status" class="form-control" required>
            <option value="">-- Pilih Status --</option>
            <option value="Dalam Proses" {{ (old('status') ?? $distribution->status ?? '') == 'Dalam Proses' ? 'selected' : '' }}>Dalam Proses</option>
            <option value="Selesai" {{ (old('status') ?? $distribution->status ?? '') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">{{ isset($distribution) ? 'Update' : 'Simpan' }}</button>
    <a href="{{ route('admin.distributions.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
