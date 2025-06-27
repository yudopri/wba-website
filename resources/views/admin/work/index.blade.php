@extends('adminlte::page')

@section('title', 'Data Lokasi Kerja')

@section('content_header')
    <h1>Data Lokasi Kerja</h1>
@stop

@section('content')
    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif
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
                                        background-color: white; /* Warna default untuk tanggal tidak valid */
                                    @elseif(\Carbon\Carbon::parse($work->berlaku)->isPast())
                                        background-color: #f8d7da; /* Merah untuk tanggal kadaluarsa */
                                    @elseif(\Carbon\Carbon::parse($work->berlaku)->greaterThan(now()) && \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($work->berlaku)) <= 30)
                                        background-color: #fff3cd; /* Kuning untuk kurang dari atau sama dengan 30 hari */
                                    @else
                                        background-color: white; /* Putih untuk lebih dari 30 hari */
                                    @endif
                                ">
                                {{ $work->berlaku === '0000-00-00' || !$work->berlaku ? '-' : \Carbon\Carbon::parse($work->berlaku)->translatedFormat('d F Y') }}

                            </td>
                    <td>
                        <a href="{{ route('admin.work.edit', $work->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.work.destroy', $work->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
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
@stop
