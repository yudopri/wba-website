@extends('adminlte::page')
@section('content')
<h1>Data Kas Logistik</h1>

<div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card shadow-lg border-0 rounded-xl" style="background: linear-gradient(135deg, #8E44AD, #D2B4DE);">
            <div class="card-header bg-transparent border-0 text-white">
                <h3 class="card-title d-flex align-items-center">
                    <i class="fas fa-boxes mr-2"></i> Saldo Kas Logistik
                </h3>
            </div>
            <div class="card-body text-center">
                <h1 class="display-3 text-white">Rp. 500.000</h1>
                <p class="lead text-white mb-4">Total Saldo Kas Logistik saat ini</p>
            </div>
            <div class="card-footer bg-transparent text-white text-center">
                <small>Data Saldo Kas Logistik terbaru</small>
            </div>
        </div>
    </div>

<!-- Tombol untuk menampilkan form -->
<button class="btn btn-primary mt-3" id="toggleForm">Tambah Saldo</button>

<!-- Form untuk menambah saldo (tersembunyi secara default) -->
<div class="card mt-4" id="saldoForm" style="display: none;">
    <div class="card-header">
        <h4>Tambah Saldo</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('kaslogistik.tambah') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan keterangan" required>
            </div>
            <div class="form-group">
                <label for="jumlah">Debit</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Masukkan jumlah saldo" required>
            </div>
            <button type="submit" class="btn btn-success">Tambah Saldo</button>
        </form>
    </div>
</div>

<a href="/pengaduan/form" class="btn btn-primary mt-3">Buat Transaksi</a>
<table class="table table-bordered mt-4">
    <tr>
        <th>No</th>
        <th>Keterangan</th>
        <th>Debit</th>
        <th>Kredit</th>
        <th>Saldo</th>
        <th>Aksi</th>
    </tr>
    <tr>
        <td>1</td>
        <td>Beli Kertas HVS</td>
        <td>Rp. 0</td>
        <td>Rp. 500.000</td>
        <td>Rp. 1.000.000</td>
        <td>
            <a href="{{ route('kaslogistik.detail') }}" class="btn btn-info">Print</a>
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
