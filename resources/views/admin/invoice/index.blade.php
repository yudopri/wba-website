@extends('adminlte::page')

@section('content')
<h1>Data Seluruh Invoice</h1>

<div class="mb-4">
    <form action="{{ route('admin.invoice.index') }}" method="GET" class="form-inline">
        <!-- Pencarian Nama Perusahaan -->
        <div class="form-group mb-2 mr-2">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Cari nama perusahaan"
                value="{{ request('search') }}">
        </div>

        <!-- Filter Bulan -->
        <div class="form-group mb-2 mr-2">
            <select name="gada" class="form-control">
                <option value="">-- Bulan --</option>
                <option value="Januari">Januari</option>
                <option value="Februari">Februari</option>
                <option value="Maret">Maret</option>
                <option value="April">April</option>
                <!-- Tambahkan bulan lain jika perlu -->
            </select>
        </div>

        <!-- Tombol Filter -->
        <button type="submit" class="btn btn-primary mb-2">Filter</button>
        <a href="{{ route('admin.invoice.index') }}" class="btn btn-secondary mb-2 ml-2">Reset</a>
    </form>
</div>

<a href="{{ route('admin.invoice.create') }}" class="btn btn-primary mb-3">Buat Invoice</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Perusahaan</th>
            <th>Jumlah Personil</th>
            <th>Nominal</th>
            <th>Bulan</th>
            <th>TGL Pengiriman</th>
            <th>TGL Pembayaran</th>
            <th>Status Tagihan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($invoices as $invoice)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $invoice->lokasi_kerja }}</td>
            <td>{{ $invoice->jumlah_personil }}</td>
            <td>Rp. {{ number_format($invoice->nominal, 0, ',', '.') }}</td>
            <td>{{ $invoice->bulan }}</td>
            <td>{{ $invoice->date_send }}</td>
            <td>{{ $invoice->date_pay }}</td>
            <td>{{ $invoice->status }}</td>
            <td>
                <a href="{{ route('admin.invoice.show', $invoice->id) }}" class="btn btn-info btn-sm">Detail</a>
                <a href="/pengaduan/validasi" class="btn btn-warning btn-sm">Konfirmasi</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
