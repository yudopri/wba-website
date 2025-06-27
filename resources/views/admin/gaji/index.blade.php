@extends('adminlte::page')
@section('content')
<h1>Data Seluruh Gaji</h1>
<div class="mb-4">
        <form action="{{ route('admin.employee.index') }}" method="GET" class="form-inline">
            <!-- Pencarian Nama atau NIK -->
            <div class="form-group mb-2 mr-2">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Cari nama perusahaan"
                    value="{{ request('search') }}">
            </div>

            <!-- Filter GADA -->
            <div class="form-group mb-2 mr-2">
                <select name="gada" class="form-control">
                    <option value="">-- Bulan --</option>

                        <option value="Januari">
                            Januari
                        </option>
                        <option value="Februari">
                            Februari
                        </option>
                        <option value="Januari">
                            Maret
                        </option>
                        <option value="Januari">
                            April
                        </option>
                </select>
            </div>

            <!-- Tombol Filter -->
            <button type="submit" class="btn btn-primary mb-2">Filter</button>
            <a href="{{ route('admin.employee.index') }}" class="btn btn-secondary mb-2 ml-2">Reset</a>
        </form>
    </div>
<a href="/pengaduan/form" class="btn btn-primary">Buat Invoice</a>
<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Nama Karyawan</th>
        <th>Nominal</th>
        <th>Bulan</th>
        <th>Aksi</th>
    </tr>
    <tr>
        <td>1</td>
        <td>Fajar</td>
        <td>Rp. 500.000</td>
        <td>April</td>
        <td><a href="{{ route('gaji.detail') }}" class="btn btn-info">Detail</a>
            <a href="/pengaduan/validasi" class="btn btn-warning">Konfirmasi</a>
    </tr>
</table>
@endsection
