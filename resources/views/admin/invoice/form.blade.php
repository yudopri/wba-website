@extends('adminlte::page')

@section('title', isset($invoice) ? 'Edit Invoice' : 'Tambah Invoice')

@section('content_header')
    <h1>{{ isset($invoice) ? 'Edit Invoice' : 'Tambah Invoice' }}</h1>
@stop

@section('content')
    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif

    <div class="card">
        <div class="card-body">
            <form
                action="{{ isset($invoice)
                    ? route('admin.invoice.update', $invoice->id)
                    : route('admin.invoice.store') }}"
                method="POST">

                @csrf
                @if(isset($invoice))
                    @method('PUT')
                @endif

               <div class="form-group">
    <label for="lokasi_kerja">Lokasi Kerja</label>
    <select name="lokasi_kerja" class="form-control @error('lokasi_kerja') is-invalid @enderror" required>
        <option value="">-- Pilih Lokasi --</option>
        @foreach ($works as $work)
            <option value="{{ $work->name }}"
                {{ old('lokasi_kerja', $invoice->lokasi_kerja ?? '') == $work->name ? 'selected' : '' }}>
                {{ $work->name }}
            </option>
        @endforeach
    </select>
    @error('lokasi_kerja')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


                <div class="form-group">
                    <label for="jumlah_personil">Jumlah Personil</label>
                    <input type="number" name="jumlah_personil" class="form-control @error('jumlah_personil') is-invalid @enderror"
                        value="{{ old('jumlah_personil', $invoice->jumlah_personil ?? '') }}" required>
                    @error('jumlah_personil')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nominal">Nominal</label>
                    <input type="number" name="nominal" class="form-control @error('nominal') is-invalid @enderror"
                        value="{{ old('nominal', $invoice->nominal ?? '') }}" required>
                    @error('nominal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

<div class="form-group">
    <label for="bulan">Bulan & Tahun</label>
    <input type="month"
           name="bulan"
           class="form-control @error('bulan') is-invalid @enderror"
           value="{{ old('bulan', isset($invoice->bulan) ? date('Y-m', strtotime($invoice->bulan)) : '') }}"
           required>
    @error('bulan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>



                <button type="submit" class="btn btn-primary">
                    {{ isset($invoice) ? 'Update' : 'Simpan' }}
                </button>
                <a href="{{ route('admin.invoice.index') }}" class="btn btn-secondary ml-2">Kembali</a>
            </form>
        </div>
    </div>
@stop
