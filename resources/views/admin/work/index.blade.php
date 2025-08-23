@extends('adminlte::page')

@section('title', 'Data Lokasi Kerja')

@section('content_header')
    <h1>Data Lokasi Kerja</h1>
@stop

@section('content')
    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif
    <!-- Form Filter -->
<form action="{{ route('admin.work.index') }}" method="GET" class="mb-3 row g-2">

    <!-- Filter Nama Perusahaan -->
    <div class="col-md-4">
        <input type="text" name="nama_perusahaan" class="form-control"
               placeholder="Cari nama perusahaan"
               value="{{ request('nama_perusahaan') }}">
    </div>

    <!-- Tombol Status -->
    <div class="col-md-4 d-flex gap-2">
        <a href="{{ route('admin.work.index', array_merge(request()->except('status'), ['status' => 'aktif'])) }}"
           class="btn {{ request('status') == 'aktif' ? 'btn-success' : 'btn-outline-success' }}">
           Aktif
        </a>
        <a href="{{ route('admin.work.index', array_merge(request()->except('status'), ['status' => 'nonaktif'])) }}"
           class="btn {{ request('status') == 'nonaktif' ? 'btn-danger' : 'btn-outline-danger' }}">
           Nonaktif
        </a>
        <a href="{{ route('admin.work.index', request()->except('status')) }}"
           class="btn {{ request('status') == '' ? 'btn-secondary' : 'btn-outline-secondary' }}">
           Semua
        </a>
    </div>

    <!-- Tombol Cari & Reset -->
    <div class="col-md-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary">Cari</button>
        <a href="{{ route('admin.work.index') }}" class="btn btn-warning">Reset</a>
    </div>
</form>



    @if(auth()->user()->role === 'Admin' || auth()->user()->role === 'Manager')
    <!-- Tombol Tambah -->
    <a href="{{ route('admin.work.create') }}" class="btn btn-primary mb-3">Tambah Lokasi Kerja</a>
    <div class="card">
    <div class="card-body">
    <!-- Tabel Departemen -->
    <table class="table table-bordered table-responsive">
    <thead class="thead-dark">
        <tr class="text-center">
                <th class="text-nowrap">No</th>
                <th class="text-nowrap">Nama Lokasi Kerja</th>
                <th class="text-nowrap">Masa Berlaku Kontrak</th>
                <th class="text-nowrap">Dokumen Kontrak</th>
                <th class="text-nowrap">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($works as $index => $work)
                <tr>
                    <td>{{ ($works->currentPage() - 1) * $works->perPage() + $loop->iteration }}</td>

                    <td>{{ $work->name }}</td>
                    <td class="align-middle text-center text-nowrap"
                                style="
                                    @if(is_null($work->berlaku) || $work->berlaku == '0000-00-00')
                                        background-color: white;
                                    @elseif(\Carbon\Carbon::parse($work->berlaku)->isPast())
                                        background-color: #f8d7da;
                                    @elseif(\Carbon\Carbon::parse($work->berlaku)->greaterThan(now()) && \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($work->berlaku)) <= 30)
                                        background-color: #fff3cd;
                                    @else
                                        background-color: white;
                                    @endif
                                ">
                                {{ $work->berlaku === '0000-00-00' || !$work->berlaku ? '-' : \Carbon\Carbon::parse($work->berlaku)->translatedFormat('d F Y') }}
                    </td>

                    <!-- Kolom Dokumen Kontrak -->
                        <td class="text-center">
    @php
        $dokumenList = [
            $work->pict_dokumen,
            $work->pict_dokumen1,
            $work->pict_dokumen2,
        ];
        $dokumenList = array_filter($dokumenList); // Buang yang null
    @endphp

    @if(count($dokumenList))
        <div class="dropdown">
            <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                Lihat Dokumen
            </button>
            <ul class="dropdown-menu">
                @foreach($dokumenList as $index => $file)
                    <li>
                        <a class="dropdown-item" href="{{ asset($file) }}" target="_blank">
                            Dokumen {{ $loop->iteration }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <span class="tex
t-muted">Tidak ada dokumen</span>
    @endif
                    </td>
                    <!-- Kolom Aksi -->
                    <td>
                        <a href="{{ route('admin.work.edit', $work->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.work.destroy', $work->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                        @if(auth()->user()->role === 'Admin' || auth()->user()->role === 'Manager')
                                 @if($work->status == 'aktif' && $work->status != 'blacklist')
                <!-- Non Aktifkan Button -->
                <form action="{{ route('admin.work.nonaktif', $work->id) }}" method="POST" style="margin: 0; display: inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-secondary btn-sm" style="text-align: center; font-size: 10px;" onclick="return confirm('Yakin ingin nonaktifkan karyawan?')">
                        <i class="fas fa-ban"></i> Non Aktifkan
                    </button>
                </form>

            @elseif($work->status = 'nonaktif')
                <!-- Aktifkan Button -->
                <form action="{{ route('admin.work.aktif', $work->id) }}" method="POST" style="margin: 0; display: inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success btn-sm" style="text-align: center; font-size: 10px;" onclick="return confirm('Yakin ingin aktifkan karyawan?')">
                        <i class="fas fa-check-circle"></i> Aktifkan
                    </button>
                </form>
            @endif
             @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
   @elseif(auth()->user()->role === 'Karyawan')
        <h3>Anda Tidak Memiliki Akses</h3>
    @endif

</div>

</div>
 <div class="flex justify-center mt-4">
    <div class="inline-flex items-center space-x-2">
        <!-- Previous Page Link -->
        @if ($works->onFirstPage())
            <span
                class="px-4 py-2 text-black bg-gray-100 border border-gray-300 rounded cursor-not-allowed"
                aria-disabled="true"
                aria-label="@lang('pagination.previous')">
                <span class="sr-only">@lang('pagination.previous')</span>
                ←
            </span>
        @else
            <a
                href="{{ $works->previousPageUrl() . '&' . http_build_query(request()->except('page')) }}"
                class="px-4 py-2 text-black bg-white border border-gray-300 rounded hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                rel="prev"
                aria-label="@lang('pagination.previous')">
                ←
            </a>
        @endif

        <!-- Pagination Links -->
        @foreach ($works->getUrlRange(1, $works->lastPage()) as $page => $url)
            @if ($page == $works->currentPage())
                <span
                    class="px-4 py-2 text-black bg-blue-500 border border-blue-500 rounded cursor-default"
                    aria-current="page">
                    {{ $page }}
                </span>
            @else
                <a
                    href="{{ $url . '&' . http_build_query(request()->except('page')) }}"
                    class="px-4 py-2 text-black bg-white border border-gray-300 rounded hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    {{ $page }}
                </a>
            @endif
        @endforeach

        <!-- Next Page Link -->
        @if ($works->hasMorePages())
            <a
                href="{{ $works->nextPageUrl() . '&' . http_build_query(request()->except('page')) }}"
                class="px-4 py-2 text-black bg-white border border-gray-300 rounded hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                rel="next"
                aria-label="@lang('pagination.next')">
                →
            </a>
        @else
            <span
                class="px-4 py-2 text-black bg-gray-100 border border-gray-300 rounded cursor-not-allowed"
                aria-disabled="true"
                aria-label="@lang('pagination.next')">
                →
            </span>
        @endif

    </div>
</div>
<!-- Bootstrap 5 JS Bundle (wajib agar dropdown berfungsi) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stop
