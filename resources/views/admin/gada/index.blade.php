@extends('adminlte::page')

@section('title', 'Daftar Sertifikasi')

@section('content_header')
    <h1>Daftar Sertifikasi</h1>
@stop

@section('content')
    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif
    @if(auth()->user()->role === 'Admin' || auth()->user()->role === 'Manager')
    <!-- Tombol untuk menambah GADA -->
    <div class="mb-3">
        <a href="{{ route('admin.gada.create') }}" class="btn btn-primary">Tambah Sertifikasi</a>
    </div>

    <!-- Tabel Daftar GADA -->
    <div class="card">
        <div class="card-body">
        <table class="table table-bordered table-responsive">
    <thead class="thead-dark">
        <tr class="text-center">
                        <th class="text-nowrap">No</th>
                        <th class="text-nowrap">Nama Sertifikasi</th>
                        <th class="text-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gadas as $index => $gada)
                        <tr>
                            <td>{{ ($gadas->currentPage() - 1) * $gadas->perPage() + $loop->iteration }}</td>
                            <td>{{ $gada->name }}</td>
                            <td>
                                <!-- Tombol Edit -->
                                <a href="{{ route('admin.gada.edit', $gada->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                <!-- Form Hapus -->
                                <form action="{{ route('admin.gada.destroy', $gada->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus Sertifikasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data Sertifikasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
   <div class="flex justify-center mt-4">
    <div class="inline-flex items-center space-x-2">
        <!-- Previous Page Link -->
        @if ($gadas->onFirstPage())
            <span 
                class="px-4 py-2 text-black bg-gray-100 border border-gray-300 rounded cursor-not-allowed" 
                aria-disabled="true" 
                aria-label="@lang('pagination.previous')">
                <span class="sr-only">@lang('pagination.previous')</span>
                ←
            </span>
        @else
            <a 
                href="{{ $gadas->previousPageUrl() . '&' . http_build_query(request()->except('page')) }}" 
                class="px-4 py-2 text-black bg-white border border-gray-300 rounded hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                rel="prev" 
                aria-label="@lang('pagination.previous')">
                ←
            </a>
        @endif

        <!-- Pagination Links -->
        @foreach ($gadas->getUrlRange(1, $gadas->lastPage()) as $page => $url)
            @if ($page == $gadas->currentPage())
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
        @if ($gadas->hasMorePages())
            <a 
                href="{{ $gadas->nextPageUrl() . '&' . http_build_query(request()->except('page')) }}" 
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
  @elseif(auth()->user()->role === 'Karyawan')
        <h3>Anda Tidak Memiliki Akses</h3>
    @endif
@stop
