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
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
