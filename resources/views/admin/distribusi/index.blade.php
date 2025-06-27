@extends('adminlte::page')
@section('content')
<h1>Data Distribusi</h1>
<div class="mb-4">
        <form action="{{ route('admin.employee.index') }}" method="GET" class="form-inline">
            <!-- Pencarian Nama atau NIK -->
            <div class="form-group mb-2 mr-2">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Cari nama karyawan atau barang"
                    value="{{ request('search') }}">
            </div>

            <!-- Filter GADA -->
            <div class="form-group mb-2 mr-2">
                <select name="gada" class="form-control">
                    <option value="">-- Jenis Barang --</option>

                        <option value="Januari">
                            Alat
                        </option>
                        <option value="Februari">
                            Baju
                        </option>
                </select>
            </div>

            <!-- Tombol Filter -->
            <button type="submit" class="btn btn-primary mb-2">Filter</button>
            <a href="{{ route('admin.employee.index') }}" class="btn btn-secondary mb-2 ml-2">Reset</a>
        </form>
    </div>
<a href="/pengaduan/form" class="btn btn-primary mt-3">Tambah Data</a>
<table class="table table-bordered mt-4">
    <tr>
        <th>No</th>
        <th>Nama Karyawan</th>
        <th>Nama Barang</th>
        <th>Quantity</th>
        <th>Jenis Barang</th>
        <th>Keterangan</th>
        <th>Harga</th>
        <th>Aksi</th>
    </tr>
    <tr>
        <td>1</td>
        <td>Fajar</td>
        <td>Baju</td>
        <td>1</td>
        <td>Baju</td>
        <td>uk : L</td>
        <td>80.000</td>
        <td>
            <a href="{{ route('stockbarang.detail') }}" class="btn btn-info">Detail</a>
            <a href="/pengaduan/validasi" class="btn btn-warning">Edit</a>
        </td>
    </tr>
</table>

<!-- Script untuk menampilkan/menghilangkan form -->
<script>
    document.getElementById('toggleForm').addEventListener('click', function() {
        var form = document.getElementById('saldoForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });
</script>
@endsection
