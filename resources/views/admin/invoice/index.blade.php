@extends('adminlte::page')

@section('content')
<h1>Data Seluruh Invoice</h1>
 @if(auth()->user()->role === 'Keuangan' || auth()->user()->role === 'Manager')
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
                @if ($invoice->foto_bukti)
    <a href="{{ asset($invoice->foto_bukti) }}" target="_blank" class="btn btn-success">
        Lihat Bukti
    </a>
@else
<form action="{{ route('admin.invoice.upload', $invoice->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
        @csrf
        <div class="mb-3">
            <label for="foto_bukti_{{ $invoice->id }}" class="form-label fw-semibold">Konfirmasi Bukti:</label>
            <input type="file" name="foto_bukti" id="foto_bukti_{{ $invoice->id }}" accept="image/*" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">
            Upload Bukti
        </button>
    </form>
@endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
    <!-- Script untuk menampilkan/menghilangkan form -->
<script>
    document.getElementById('toggleForm').addEventListener('click', function() {
        var form = document.getElementById('saldoForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });

    $('#updateBuktiModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var form = $('#updateBuktiForm');

    // Bentuk URL aksi, misal: /admin/distribution/5/upload
    var route = `/admin/invoice/${id}/upload`;
    form.attr('action', route);
});

// Preview gambar
document.getElementById('updateBuktiFoto').addEventListener('change', function(event) {
    const preview = document.getElementById('updatePreview');
    preview.innerHTML = '';

    const file = event.target.files[0];
    if (file && file.type.startsWith('image/')) {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.style.maxWidth = '100%';
        img.classList.add('img-fluid', 'mt-2');
        preview.appendChild(img);
    }
});

</script>
@if ($errors->any())
<script>
    $(document).ready(function() {
        $('#updateBuktiModal').modal('show');
    });
</script>
@endif
@else
        <h3>Anda Tidak Memiliki Akses</h3>
    @endif
@endsection
