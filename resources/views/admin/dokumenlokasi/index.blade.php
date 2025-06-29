@extends('adminlte::page')
@section('content')
<div class="container">
    <h1>Dokumen Lokasi Kerja</h1>
    <a href="{{ route('dokumenlokasi.create') }}" class="btn btn-success mb-3">Upload Baru</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Lokasi</th>
                <th>Nama File</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dokumen as $dokumen)
                <tr>
                    <td>{{ $dokumen->nama_lokasi }}</td>
                    <td>{{ $dokumen->nama_file }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $dokumen->file_path) }}" width="120" alt="Tidak Ditemukan">
                    </td>
                    <td>
                        <form action="{{ route('dokumenlokasi.destroy', $dokumen->id) }}" method="POST"
                            onsubmit="return confirm('Yakin hapus dokumen ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                        <a href="{{ route('dokumenlokasi.show', $dokumen->id) }}" class="btn btn-sm btn-info mt-1">Detail</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
