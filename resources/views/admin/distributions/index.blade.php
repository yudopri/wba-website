@extends('adminlte::page')
@section('content')
<h1>Data Distribusi</h1>
@if(auth()->user()->role === 'Logistik' || auth()->user()->role === 'Manager')
<div class="mb-4">
        <form action="{{ route('admin.distributions.index') }}" method="GET" class="form-inline">
    <!-- Pencarian Nama atau Barang -->
    <div class="form-group mb-2 mr-2">
        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Cari nama karyawan atau barang"
            value="{{ request('search') }}">
    </div>

    <!-- Filter Jenis Barang -->
    <div class="form-group mb-2 mr-2">
        <select name="jenis" class="form-control">
            <option value="">-- Jenis Barang --</option>
            <option value="Alat" {{ request('jenis') == 'Alat' ? 'selected' : '' }}>Alat</option>
            <option value="Baju" {{ request('jenis') == 'Baju' ? 'selected' : '' }}>Baju</option>
        </select>
    </div>

    <!-- Tombol Filter -->
    <button type="submit" class="btn btn-primary mb-2">Filter</button>
    <a href="{{ route('admin.distributions.index') }}" class="btn btn-secondary mb-2 ml-2">Reset</a>
</form>

    </div>
<a href="{{ route('admin.distributions.create') }}" class="btn btn-primary mt-3">Tambah Data</a>
@endif
<table class="table table-bordered mt-4">
    <tr>
        <th>No</th>
        <th>Nama Karyawan</th>
        <th>Nama Barang</th>
        <th>Quantity</th>
        <th>Jenis Barang</th>
        <th>Keterangan</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
    @forelse($distributions as $distribution)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $distribution->employee->name ?? '-' }}</td>
        <td>{{ $distribution->inventoryItem->nama_barang ?? '-' }}</td>
        <td>{{ $distribution->quantity }}</td>
        <td>{{ $distribution->inventoryItem->jenis_barang ?? '-' }}</td>
        <td>{{ $distribution->keterangan ?? '-' }}</td>
        <td>{{ $distribution->status }}</td>
        <td>
            @if(auth()->user()->role === 'Logistik' || auth()->user()->role === 'Manager')
            <a href="{{ route('admin.distributions.show', $distribution->id) }}" class="btn btn-info">Detail</a>
            <a href="{{ route('admin.distributions.edit', $distribution->id) }}" class="btn btn-warning">Edit</a>
            @endif

        @if ($distribution->foto_bukti)
    <a href="{{ asset($distribution->foto_bukti) }}" target="_blank" class="btn btn-success">
        Lihat Bukti
    </a>
@else
    <form action="{{ route('admin.distributions.upload', $distribution->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
        @csrf
        <div class="mb-3">
            <label for="foto_bukti_{{ $distribution->id }}" class="form-label fw-semibold">Upload Bukti Foto:</label>
            <input type="file" name="foto_bukti" id="foto_bukti_{{ $distribution->id }}" accept="image/*" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">
            Upload Bukti
        </button>
    </form>
@endif


        </td>
    </tr>
    @endforeach
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
    var route = `/admin/distributions/${id}/upload`;
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
@endsection
