@extends('adminlte::page')

@section('title', 'Data Partner')

@section('content_header')
    <h1>Data Partner</h1>
@stop

@section('content')
    @if(auth()->user()->role === 'Admin' || auth()->user()->role === 'Manager')
        <div class="mb-3">
            <a href="{{ route('admin.partner.create') }}" class="btn btn-primary">Add New Partner</a>
        </div>

        @if(session('message'))
            <p class="alert alert-info">{{ session('message') }}</p>
        @endif

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-responsive">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th class="text-nowrap">Nama Perusahaan</th>
                            <th class="text-nowrap">Icon</th>
                            <th class="text-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($partners as $partner)
                            <tr>
                                <td>{{ $partner->name_partner }}</td>
                                <td>
                                    @if($partner->icon)
                                        <img src="{{ asset($partner->icon) }}" alt="Current Icon" width="100">
                                    @else
                                        <img src="{{ asset('images/default-icon.jpg') }}" alt="Default Icon" width="100">
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.partner.show', $partner->id) }}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('admin.partner.edit', $partner->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                    <form action="{{ route('admin.partner.destroy', $partner->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this partner?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
     @elseif(auth()->user()->role === 'Karyawan')
        <h3>Anda Tidak Memiliki Akses</h3>
    @endif
    <!-- Pagination -->
<div class="flex justify-center mt-4">
    <div class="inline-flex items-center space-x-2">
        <!-- Previous Page Link -->
        @if ($partners->onFirstPage())
            <span 
                class="px-4 py-2 text-black bg-gray-100 border border-gray-300 rounded cursor-not-allowed" 
                aria-disabled="true" 
                aria-label="@lang('pagination.previous')">
                <span class="sr-only">@lang('pagination.previous')</span>
                ←
            </span>
        @else
            <a 
                href="{{ $partners->previousPageUrl() . '&' . http_build_query(request()->except('page')) }}" 
                class="px-4 py-2 text-black bg-white border border-gray-300 rounded hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                rel="prev" 
                aria-label="@lang('pagination.previous')">
                ←
            </a>
        @endif

        <!-- Pagination Links -->
        @foreach ($partners->getUrlRange(1, $partners->lastPage()) as $page => $url)
            @if ($page == $partners->currentPage())
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
        @if ($partners->hasMorePages())
            <a 
                href="{{ $partners->nextPageUrl() . '&' . http_build_query(request()->except('page')) }}" 
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
@endsection
