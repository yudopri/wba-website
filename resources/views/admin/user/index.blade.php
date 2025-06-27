@extends('adminlte::page')

@section('title', 'Data User')

@section('content_header')
    <h1>Data User</h1>
@stop

@section('content')
 @if(auth()->user()->role === 'Admin' || auth()->user()->role === 'Manager')
  <form action="{{ route('admin.user.index') }}" method="GET" enctype="multipart/form-data" class="w-100 mb-2 d-flex flex-wrap align-items-center">
    <!-- Elemen Filter -->
    <div class="form-group mb-2 mr-2 w-50">
        <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama atau email" value="{{ request('search') }}">
    </div>

    <!-- Tombol Filter -->
    <button type="submit" class="btn btn-primary btn-sm mb-2 mr-2">Filter</button>

    <!-- Tombol Reset -->
    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary btn-sm mb-2">Reset</a>
</form>


        <a href="{{ route('admin.user.create') }}" class="btn btn-primary mb-3">Add New User</a>
 @endif
        @if(session('success'))
            <p class="alert alert-info">{{ session('success') }}</p>
        @endif
       
        <div class="card">
        <div class="card-body">
        <table class="table table-bordered table-responsive">
    <thead class="thead-dark">
        <tr class="text-center">
                    <th class="text-nowrap">Name</th>
                    <th class="text-nowrap">Email</th>
                    <th class="text-nowrap">Profile Picture</th>
                    <!-- <th>Verification Status</th> -->
                    <th class="text-nowrap">Level</th>
                    <th class="text-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->profile_picture)
                                <img src="{{ asset($user->profile_picture) }}" alt="Profile Picture" width="100">
                            @else
                                <img src="{{ asset('images/default-image.jpg') }}" alt="Default Image" width="100">
                            @endif
                        </td>
                        <!-- <td>{{ $user->verifikasi ? 'Verified' : 'Not Verified' }}</td> -->
                        
                        <td>{{ $user->role }}</td>
                       
                     <td>
    @php
        // Tentukan level prioritas peran
        $roleHierarchy = ['Manager' => 3, 'Admin' => 2, 'Karyawan' => 1];

        // Dapatkan level pengguna yang sedang login dan target
        $currentUserRoleLevel = $roleHierarchy[auth()->user()->role];
        $targetUserRoleLevel = $roleHierarchy[$user->role];

        // Logika izin
        $canEdit = $currentUserRoleLevel > $targetUserRoleLevel || auth()->user()->id === $user->id; // Bisa mengedit akun sendiri atau pengguna di bawah levelnya
        $canDelete = auth()->user()->role === 'Manager'; // Hanya Manager yang dapat menghapus
    @endphp

    <!-- Edit User -->
    @if ($canEdit)
        <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
    @endif

    <!-- Delete User -->
    @if ($canDelete)
        <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
        </form>
    @endif
</td>


                    </tr>
                @endforeach
            </tbody>
        </table>
</div>
</div>
   <div class="flex justify-center mt-4">
    <div class="inline-flex items-center space-x-2">
        <!-- Previous Page Link -->
        @if ($users->onFirstPage())
            <span 
                class="px-4 py-2 text-black bg-gray-100 border border-gray-300 rounded cursor-not-allowed" 
                aria-disabled="true" 
                aria-label="@lang('pagination.previous')">
                <span class="sr-only">@lang('pagination.previous')</span>
                ←
            </span>
        @else
            <a 
                href="{{ $users->previousPageUrl() . '&' . http_build_query(request()->except('page')) }}" 
                class="px-4 py-2 text-black bg-white border border-gray-300 rounded hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                rel="prev" 
                aria-label="@lang('pagination.previous')">
                ←
            </a>
        @endif

        <!-- Pagination Links -->
        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
            @if ($page == $users->currentPage())
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
        @if ($users->hasMorePages())
            <a 
                href="{{ $users->nextPageUrl() . '&' . http_build_query(request()->except('page')) }}" 
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
