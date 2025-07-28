@extends('adminlte::page')

@section('title', 'Buat Gaji Baru')

@section('content')
<div class="container">
    <h1 class="mb-4">Form Tambah Data Gaji</h1>

    {{-- Alert Error --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <div class="card">
        <div class="card-body">
            <form action="{{ route('gaji.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nama_pt">Nama Perusahaan / Karyawan</label>
                    <input type="text" name="nama_pt" class="form-control" value="{{ old('nama_pt') }}" required>
                </div>

                <div class="form-group">
                    <label for="nominal">Nominal Gaji (Rp)</label>
                    <input type="number" name="nominal" class="form-control" value="{{ old('nominal') }}" required>
                </div>

                <div class="form-group">
                    <label for="bulan">Bulan</label>
                    <select name="bulan" class="form-control" required>
                        <option value="">-- Pilih Bulan --</option>
                        @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $bulan)
                            <option value="{{ $bulan }}" {{ old('bulan') == $bulan ? 'selected' : '' }}>
                                {{ $bulan }}
                            </option>
                        @endforeach
                    </select>
                </div>


                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('gaji.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
