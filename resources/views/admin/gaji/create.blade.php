@extends('adminlte::page')

@section('content')
<div class="container">
    <h1>Tambah Data Gaji</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('gaji.store') }}" method="POST">
        @csrf

<<<<<<< HEAD
        <!-- ID Karyawan dari User Login -->
      <!-- ID Karyawan dari User Login -->
<div class="mb-3">
    <label for="id_karyawan">ID Karyawan</label>
    <input type="number" name="id_karyawan" class="form-control" required value="{{ old('id_karyawan') }}">
</div>


        <!-- Nominal Gaji -->
        <div class="mb-3">
            <label for="nominal">Nominal</label>
            <input type="number" name="nominal" class="form-control" required value="{{ old('nominal') }}">
        </div>

        <!-- Bulan -->
        <div class="mb-3">
            <label for="bulan">Bulan</label>
            <select name="bulan" class="form-control" required>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" @if(old('bulan') == $i) selected @endif>
                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                    </option>
                @endfor
            </select>
=======
        <div class="mb-3">
            <label for="partner_id">Nama PT</label>
            <select name="partner_id" class="form-control" required>
                <option value="">-- Pilih PT --</option>
                @foreach($partners as $partner)
                    <option value="{{ $partner->id }}" {{ old('partner_id') == $partner->id ? 'selected' : '' }}>
                        {{ $partner->name_partner }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="nominal">Nominal</label>
            <input type="number" name="nominal" class="form-control" required value="{{ old('nominal') }}">
        </div>

        <div class="mb-3">
            <label for="bulan">Bulan dan Tahun</label>
            <input type="month" name="bulan" class="form-control" required value="{{ old('bulan') }}">
>>>>>>> 0dc353bdb7868fa53612faccfcb2922d594ecb60
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
