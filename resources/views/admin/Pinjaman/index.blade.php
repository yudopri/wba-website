@extends('adminlte::page')
@section('title', 'Data Pinjaman')

@section('content')
<h1>Data Pinjaman</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="row mb-4">
    <!-- Saldo Pinjaman -->
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-xl" style="background: linear-gradient(135deg, #8E44AD, #BB8FCE);">
            <div class="card-header bg-transparent border-0 text-white">
                <h3 class="card-title"><i class="fas fa-wallet mr-2"></i> Saldo Pinjaman</h3>
            </div>
            <div class="card-body text-center">
                <h1 class="display-4 text-white">Rp. {{ number_format($saldo ?? 0, 0, ',', '.') }}</h1>
                <p class="lead text-white mb-0">Saldo Tersedia</p>
            </div>
        </div>
    </div>

    <!-- Total Kredit -->
    <div class="col-md-6 position-relative">
        <div class="card shadow-lg border-0 rounded-xl" style="background: linear-gradient(135deg, #C0392B, #E74C3C); position: relative;">

            <!-- Filter Tanggal -->
            <form method="GET" action="{{ route('pinjaman.index') }}"
                  class="position-absolute d-flex align-items-center"
                  style="top: 10px; right: 10px; z-index: 10; padding: 5px 10px; border-radius: 8px;">

                <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}"
                       class="form-control form-control-sm bg-white text-dark border-0 me-1"
                       style="width: 130px;" title="Dari Tanggal">

                <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                       class="form-control form-control-sm bg-white text-dark border-0 me-1"
                       style="width: 130px;" title="Sampai Tanggal">

                <button type="submit" class="btn btn-sm btn-primary me-1">OK</button>

                <!-- Tombol Reset -->
                <a href="{{ route('pinjaman.index') }}" class="btn btn-sm btn-secondary">Reset</a>
            </form>

            <div class="card-header bg-transparent border-0 text-white">
                <h3 class="card-title"><i class="fas fa-money-bill-wave mr-2"></i> Total Kredit</h3>
            </div>
            <div class="card-body text-center">
                <h1 class="display-4 text-white">Rp. {{ number_format($totalKredit ?? 0, 0, ',', '.') }}</h1>
                <p class="lead text-white mb-0">Total Kredit</p>
            </div>
        </div>
    </div>
</div>

<!-- Tombol Form -->
<div class="mb-3">
    <button class="btn btn-success" id="toggleFormDebit">+ Tambah Pinjaman</button>
    <button class="btn btn-danger" id="toggleFormKredit">- Bayar Pinjaman</button>
</div>

<!-- Form Tambah Pinjaman -->
<div class="card mb-3" id="formDebit" style="display: none;">
    <div class="card-header">Tambah Pinjaman</div>
    <div class="card-body">
        <form method="POST" action="{{ route('pinjaman.store') }}">
            @csrf
            <input type="text" name="keterangan" class="form-control mb-2" placeholder="Keterangan" required>
            <input type="number" name="debit" class="form-control mb-2" placeholder="Jumlah Pinjaman" required>
            <button class="btn btn-success">Simpan</button>
        </form>
    </div>
</div>

<!-- Form Bayar Pinjaman -->
<div class="card mb-3" id="formKredit" style="display: none;">
    <div class="card-header">Bayar Pinjaman</div>
    <div class="card-body">
        <form method="POST" action="{{ route('pinjaman.kredit') }}">
            @csrf
            <input type="text" name="keterangan" class="form-control mb-2" placeholder="Keterangan" required>
            <input type="number" name="kredit" class="form-control mb-2" placeholder="Jumlah Pembayaran" required>
            <button class="btn btn-danger">Simpan</button>
        </form>
    </div>
</div>

<!-- Tabel Transaksi -->
<div class="table-responsive">
    <table class="table table-bordered table-striped mt-3">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Keterangan</th>
                <th>Debit</th>
                <th>Kredit</th>
                <th>Saldo Setelah</th>
                <th>User</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->keterangan }}</td>
                <td>Rp. {{ number_format($item->debit, 0, ',', '.') }}</td>
                <td>Rp. {{ number_format($item->kredit, 0, ',', '.') }}</td>
                <td>Rp. {{ number_format($item->saldo, 0, ',', '.') }}</td>
                <td>{{ $item->user->name ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Script Form Toggle -->
<script>
    document.getElementById('toggleFormDebit').addEventListener('click', function () {
        let form = document.getElementById('formDebit');
        form.style.display = (form.style.display === 'none') ? 'block' : 'none';
    });
    document.getElementById('toggleFormKredit').addEventListener('click', function () {
        let form = document.getElementById('formKredit');
        form.style.display = (form.style.display === 'none') ? 'block' : 'none';
    });
</script>
@endsection
