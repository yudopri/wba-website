@extends('adminlte::page')

@section('content')
<h1>Data Kas Logistik</h1>

{{-- Notifikasi --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<!-- ROW SALDO & TOTAL PENGELUARAN -->
<div class="row mb-4">
    <!-- SALDO -->
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-xl" style="background: linear-gradient(135deg, #8E44AD, #D2B4DE);">
            <div class="card-header bg-transparent border-0 text-white">
                <h3 class="card-title"><i class="fas fa-wallet mr-2"></i> Saldo Kas Logistik</h3>
            </div>
            <div class="card-body text-center">
                <h1 class="display-4 text-white">Rp. {{ number_format($saldo, 0, ',', '.') }}</h1>
                <p class="lead text-white mb-0">Saldo Tersedia</p>
            </div>
        </div>
    </div>

    <!-- TOTAL PENGELUARAN -->
    <div class="col-md-6 position-relative">
        <form method="GET" action="{{ url('/admin/kaslogistik') }}">
            <div class="card shadow-lg border-0 rounded-xl position-relative" style="background: linear-gradient(135deg, #C0392B, #E74C3C);">
                <div class="card-header bg-transparent border-0 text-white">
                    <h3 class="card-title"><i class="fas fa-money-bill-wave mr-2"></i> Total Pengeluaran</h3>
                    <!-- Dropdown Filter Range -->
                    <div style="position: absolute; top: 10px; right: 15px;">
                        <select name="range" class="form-select form-select-sm bg-light text-dark" onchange="this.form.submit()" style="width: 130px;">
                            <option value="7hari" {{ $range == '7hari' ? 'selected' : '' }}>7 Hari</option>
                            <option value="1bulan" {{ $range == '1bulan' ? 'selected' : '' }}>1 Bulan</option>
                            <option value="3bulan" {{ $range == '3bulan' ? 'selected' : '' }}>3 Bulan</option>
                            <option value="1tahun" {{ $range == '1tahun' ? 'selected' : '' }}>1 Tahun</option>
                        </select>
                    </div>
                </div>
                <div class="card-body text-center">
                    <h1 class="display-4 text-white">Rp. {{ number_format($totalPengeluaran, 0, ',', '.') }}</h1>
                    <p class="lead text-white mb-0">Total Kredit</p>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- FORM -->
<div class="mb-3">
    <button class="btn btn-success" id="toggleForm">+ Tambah Saldo</button>
    <button class="btn btn-danger" id="toggleFormKredit">- Buat Transaksi</button>
</div>

<!-- FORM TAMBAH SALDO -->
<div class="card mb-3" id="formDebit" style="display: none;">
    <div class="card-header">Tambah Saldo</div>
    <div class="card-body">
        <form method="POST" action="{{ route('kaslogistik.store') }}">
            @csrf
            <input type="text" name="keterangan" class="form-control mb-2" placeholder="Keterangan" required>
            <input type="number" name="debit" class="form-control mb-2" placeholder="Jumlah Saldo Masuk" required>
            <button class="btn btn-success">Simpan</button>
        </form>
    </div>
</div>

<!-- FORM TAMBAH PENGELUARAN -->
<div class="card mb-3" id="formKredit" style="display: none;">
    <div class="card-header">Pengeluaran</div>
    <div class="card-body">
        <form method="POST" action="{{ route('kaslogistik.kredit') }}">
            @csrf
            <input type="text" name="keterangan" class="form-control mb-2" placeholder="Keterangan" required>
            <input type="number" name="kredit" class="form-control mb-2" placeholder="Jumlah Pengeluaran" required>
            <button class="btn btn-danger">Simpan</button>
        </form>
    </div>
</div>

<!-- TABEL TRANSAKSI -->
<div class="card">
    <div class="card-header bg-dark text-white">
        <h4 class="mb-0"><i class="fas fa-history mr-2"></i> Riwayat Transaksi</h4>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0">
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
                        <td>{{ $key+1 }}</td>
                        <td>{{ $item->keterangan }}</td>
                        <td>Rp. {{ number_format($item->debit, 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format($item->kredit, 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format($item->saldo_setelah, 0, ',', '.') }}</td>
                        <td>{{ $item->user->name ?? '-' }}</td>
                        <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script>
    document.getElementById('toggleForm').addEventListener('click', function () {
        let form = document.getElementById('formDebit');
        form.style.display = (form.style.display === 'none') ? 'block' : 'none';
    });
    document.getElementById('toggleFormKredit').addEventListener('click', function () {
        let form = document.getElementById('formKredit');
        form.style.display = (form.style.display === 'none') ? 'block' : 'none';
    });
</script>
@endsection
