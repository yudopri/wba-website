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

@php
    $bulanList = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];
@endphp

<div class="form-group">
    <label for="bulan">Bulan</label>
    <select name="bulan" class="form-control @error('bulan') is-invalid @enderror" required>
        <option value="">-- Pilih Bulan --</option>
        @foreach ($bulanList as $angka => $nama)
            <option value="{{ $nama }}" {{ old('bulan', $invoice->bulan ?? '') == $nama ? 'selected' : '' }}>
                {{ $nama }}
            </option>
        @endforeach
    </select>
    @error('bulan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


                <div class="form-group">
                    <label for="date_send">Tanggal Kirim</label>
                    <input type="date" name="date_send" class="form-control @error('date_send') is-invalid @enderror"
                        value="{{ old('date_send', isset($invoice->date_send) ? \Carbon\Carbon::parse($invoice->date_send)->format('Y-m-d') : '') }}">
                    @error('date_send')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="date_pay">Tanggal Bayar</label>
                    <input type="date" name="date_pay" class="form-control @error('date_pay') is-invalid @enderror"
                        value="{{ old('date_pay', isset($invoice->date_pay) ? \Carbon\Carbon::parse($invoice->date_pay)->format('Y-m-d') : '') }}">
                    @error('date_pay')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="pending" {{ old('status', $invoice->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ old('status', $invoice->status ?? '') == 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                    @error('status')
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
