@extends('adminlte::page')

@section('title', 'Daftar Karyawan')

@section('content_header')
    <h1>Daftar Karyawan</h1>
@stop

@section('content')
    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif
@if ($errors->has('error'))\
        <div class="alert alert-danger">
            {{ $errors->first('error') }}
        </div>
@endif
@if(auth()->user()->role === 'Admin' || auth()->user()->role === 'Manager')
    <!-- Form Filter -->
    <form action="{{ route('admin.employee.index') }}" method="GET" enctype="multipart/form-data" class="form-inline w-100 mb-2 d-flex flex-wrap align-items-center" id="filterForm">
        <!-- Elemen Filter -->
        <div class="form-group mb-2 mr-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama atau NIK" value="{{ request('search') }}">
        </div>
        <div class="form-group mb-2 mr-2">
            <select name="departemen_id" class="form-control form-control-sm">
                <option value="">-- Semua Departemen --</option>
                @foreach($departemens as $departemen)
                    <option value="{{ $departemen->id }}" {{ request('departemen_id') == $departemen->id ? 'selected' : '' }}>
                        {{ $departemen->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-2 mr-2">
            <select name="jabatan_id" class="form-control form-control-sm">
                <option value="">-- Semua Jabatan --</option>
                @foreach($jabatans as $jabatan)
                    <option value="{{ $jabatan->id }}" {{ request('jabatan_id') == $jabatan->id ? 'selected' : '' }}>
                        {{ $jabatan->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-2 mr-2">
            <select name="gada" class="form-control form-control-sm">
                <option value="">-- Semua Sertifikasi --</option>
                @foreach($gadas as $gada)
                    <option value="{{ $gada->id }}" {{ request('gada') == $gada->id ? 'selected' : '' }}>
                        {{ $gada->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-2 mr-2">
            <select name="lokasikerja" class="form-control form-control-sm">
                <option value="">-- Semua Lokasi Kerja --</option>
                @foreach($works as $work)
                    <option value="{{ $work->name }}" {{ request('lokasikerja') == $work->name ? 'selected' : '' }}>
                        {{ $work->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-2 mr-2">
            <select name="status_kepegawaian" class="form-control form-control-sm">
                <option value="">-- Semua Status Kepegawaian --</option>
                <option value="Karyawan Tetap" {{ old('status_kepegawaian', isset($employee) ? $employee->status_kepegawaian : '') === 'Karyawan Tetap' ? 'selected' : '' }}>Karyawan Tetap</option>
                <option value="Karyawan Tidak Tetap" {{ old('status_kepegawaian', isset($employee) ? $employee->status_kepegawaian : '') === 'Karyawan Tidak Tetap' ? 'selected' : '' }}>Karyawan Tidak Tetap</option>
                <option value="Karyawan Magang" {{ old('status_kepegawaian', isset($employee) ? $employee->status_kepegawaian : '') === 'Karyawan Magang' ? 'selected' : '' }}>Karyawan Magang</option>
                <option value="Karyawan Temporal" {{ old('status_kepegawaian', isset($employee) ? $employee->status_kepegawaian : '') === 'Karyawan Temporal' ? 'selected' : '' }}>Karyawan Temporal</option>
                <option value="Karyawan PKL" {{ old('status_kepegawaian', isset($employee) ? $employee->status_kepegawaian : '') === 'Karyawan PKL' ? 'selected' : '' }}>Karyawan PKL</option>
            </select>
        </div>
        <div class="form-group mb-2 mr-2">
            <select name="status" class="form-control form-control-sm">
                <option value="">-- Semua Aktif / NonAktif --</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                <option value="blacklist" {{ request('status') == 'blacklist' ? 'selected' : '' }}>Blacklist</option>
            </select>
        </div>

        <!-- Tombol Filter -->
        <button type="submit" class="btn btn-primary btn-sm mr-2" id="filterButton">Filter</button>

        <!-- Tombol Reset -->
        <button type="button" class="btn btn-secondary btn-sm mr-2" id="resetButton">Reset</button>

        <!-- Tombol Import -->
        <label for="file" class="btn btn-success btn-sm mr-2">Import Excel</label>
        <input type="file" name="file" id="file" class="d-none">

        <!-- Tombol Export -->
        <button type="button" class="btn btn-info btn-sm" id="exportButton">Export Excel</button>
    </form>
@endif

@if(auth()->user()->role === 'Karyawan')
    @if($employees->isEmpty())
        <!-- Tambah Data Diri -->
        <a href="{{ route('admin.employee.create') }}" class="btn btn-primary btn-sm mb-3">
            <i class="fas fa-edit"></i> Tambah Data Diri
        </a>
    @else
        @foreach($employees as $employee)
            <a href="{{ route('admin.employee.edit', $employee->id) }}" class="btn btn-warning btn-sm mb-3">
                <i class="fas fa-edit"></i> Update Data Diri
            </a>
        @endforeach
    @endif
@elseif(auth()->user()->role === 'Admin' || auth()->user()->role === 'Manager')
    <!-- Tambah Data -->
    <a href="{{ route('admin.employee.create') }}" class="btn btn-primary btn-sm mb-3">
        <i class="fas fa-plus-circle"></i> Tambah Data
    </a>
@endif


   <!-- Tabel Daftar Karyawan -->
<div class="card">
    <div class="card-body" style="padding: 10px;">
        <div class="table-responsive" style="overflow-x: auto; overflow-y: auto;">
            <table class="table table-bordered" style="font-size: 14px; min-width: 1000px;">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th class="align-middle text-nowrap">Nama</th>
                        <th class="align-middle text-nowrap">NIK KTP</th>
                        <th class="align-middle text-nowrap">NIK Karyawan</th>
                        <th class="align-middle text-nowrap">No KTA</th>
                        <th class="align-middle text-nowrap">No NPWP</th>
                        <th class="align-middle">No BPJS Ketenagakerjaan</th>
                        <th class="align-middle">No BPJS Kesehatan</th>
                        <th class="align-middle text-nowrap">Email</th>
                        <th class="align-middle text-nowrap">Departemen</th>
                        <th class="align-middle text-nowrap">Jabatan</th>
                        <th class="align-middle text-nowrap">Sertifikasi</th>
                        <th class="align-middle text-nowrap">Pendidikan</th>
                        <th class="align-middle text-nowrap">Lokasi Kerja</th>
                        <th class="align-middle">Status Kepegawaian</th>
                        <th class="align-middle">Masa Berlaku PKWT</th>
                        <th class="align-middle">Aktif / Nonaktif</th>
                        <th class="align-middle text-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr>
                            <td class="align-middle text-nowrap">{{ $employee->name }}</td>
                            <td class="align-middle text-nowrap">{{ $employee->nik_ktp ? Crypt::decryptString($employee->nik_ktp) : '-' }}</td>
                            <td class="align-middle text-nowrap">{{ $employee->nik ? Crypt::decryptString($employee->nik) : '-' }}</td>
                            <td class="align-middle text-nowrap">{{ $employee->no_regkta ? Crypt::decryptString($employee->no_regkta) : '-' }}</td>
                            <td class="align-middle text-nowrap">{{ $employee->no_npwp ? Crypt::decryptString($employee->no_npwp) : '-' }}</td>
                            <td class="align-middle text-nowrap">{{ $employee->bpjsket ? Crypt::decryptString($employee->bpjsket) : '-' }}</td>
                            <td class="align-middle text-nowrap">{{ $employee->bpjskes ? Crypt::decryptString($employee->bpjskes) : '-' }}</td>
                            <td class="align-middle text-nowrap">{{ $employee->email }}</td>
                            <td class="align-middle text-nowrap">{{ $employee->departemen->name ?? '-' }}</td>
                            <td class="align-middle text-nowrap">{{ $employee->jabatan->name ?? '-' }}</td>
                            <td class="align-middle text-nowrap">
                                @if ($employee->gadadetail->isEmpty())
                                    Tidak Ada
                                @else
                                    @foreach ($employee->gadadetail as $detail)
                                        {{ $detail->gada->name ?? 'Tidak Ada' }}@if (!$loop->last), @endif
                                    @endforeach
                                @endif
                            </td>
                            <td class="align-middle text-nowrap">{{ $employee->pendidikan }}</td>
                            <td class="align-middle text-nowrap">{{ $employee->lokasikerja ?? '-' }}</td>
                            <td class="align-middle text-nowrap">{{ $employee->status_kepegawaian ?? '-' }}</td>
                            <td class="align-middle text-center text-nowrap"
                                style="
                                    @if(is_null($employee->berlaku) || $employee->berlaku == '0000-00-00')
                                        background-color: white; /* Warna default untuk tanggal tidak valid */
                                    @elseif(\Carbon\Carbon::parse($employee->berlaku)->isPast())
                                        background-color: #f8d7da; /* Merah untuk tanggal kadaluarsa */
                                    @elseif(\Carbon\Carbon::parse($employee->berlaku)->greaterThan(now()) && \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($employee->berlaku)) <= 30)
                                        background-color: #fff3cd; /* Kuning untuk kurang dari atau sama dengan 30 hari */
                                    @else
                                        background-color: white; /* Putih untuk lebih dari 30 hari */
                                    @endif
                                ">
                                 {{ $employee->berlaku === '0000-00-00' || !$employee->berlaku ? '-' : \Carbon\Carbon::parse($employee->berlaku)->translatedFormat('d F Y') }}
                            </td>
                            <td class="text-center align-middle text-nowrap">
                                @if($employee->status_kerja == 'aktif')
                                    <i class="fas fa-check-circle" style="color: green;" title="Aktif"></i>
                                @elseif($employee->status_kerja == 'nonaktif')
                                    <i class="fas fa-times-circle" style="color: red;" title="Nonaktif"></i>
                                @elseif($employee->status_kerja == 'blacklist')
                                    <i class="fas fa-ban" style="color: gray;" title="Blacklist"></i>
                                @else
                                    <i class="fas fa-question-circle" style="color: orange;" title="Status Unknown"></i>
                                @endif
                            </td>
                            <td class="align-middle text-nowrap" style="font-size: 8px;">
                                <a href="{{ route('admin.employee.show', $employee->id) }}" class="btn btn-primary btn-sm" style="font-size: 10px;">
                                    Detail
                                </a>
                                @if(auth()->user()->role === 'Admin')
                                    <a href="{{ route('admin.employee.edit', $employee->id) }}" class="btn btn-warning btn-sm" style="font-size: 10px;">
                                        Update
                                    </a>
                                @elseif(auth()->user()->role === 'Manager')
                                <a href="{{ route('admin.employee.edit', $employee->id) }}" class="btn btn-warning btn-sm" style="font-size: 10px;">
                                        Update
                                    </a>
                                    <form action="{{ route('admin.employee.destroy', $employee->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus karyawan ini?')" style="font-size: 10px;">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                                @if(auth()->user()->role === 'Admin' || auth()->user()->role === 'Manager')
                                 @if($employee->status_kerja == 'aktif' && $employee->status_kerja != 'blacklist')
                <!-- Non Aktifkan Button -->
                <form action="{{ route('admin.employee.nonaktif', $employee->id) }}" method="POST" style="margin: 0; display: inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-secondary btn-sm" style="text-align: center; font-size: 10px;" onclick="return confirm('Yakin ingin nonaktifkan karyawan?')">
                        <i class="fas fa-ban"></i> Non Aktifkan
                    </button>
                </form>

                <!-- Blacklist Button -->
               <form action="{{ route('admin.employee.blacklist', $employee->id) }}" method="POST" style="margin: 0; display: inline;">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-dark btn-sm" style="text-align: center; background-color: black; border-color: black; font-size: 10px;" onclick="return confirm('Yakin ingin blacklist karyawan?')">
                        <i class="fas fa-user-slash"></i> Blacklist
                    </button>
                </form>

            @elseif($employee->status_kerja != 'blacklist')
                <!-- Aktifkan Button -->
                <form action="{{ route('admin.employee.aktif', $employee->id) }}" method="POST" style="margin: 0; display: inline;">
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
                    @empty
                        <tr>
                            <td colspan="15" class="text-center">Tidak ada data karyawan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Pagination -->
<div class="flex justify-center mt-4">
    <div class="inline-flex items-center space-x-2">
        <!-- Previous Page Link -->
        @if ($employees->onFirstPage())
            <span 
                class="px-4 py-2 text-black bg-gray-100 border border-gray-300 rounded cursor-not-allowed" 
                aria-disabled="true" 
                aria-label="@lang('pagination.previous')">
                <span class="sr-only">@lang('pagination.previous')</span>
                ←
            </span>
        @else
            <a 
                href="{{ $employees->previousPageUrl() . '&' . http_build_query(request()->except('page')) }}" 
                class="px-4 py-2 text-black bg-white border border-gray-300 rounded hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                rel="prev" 
                aria-label="@lang('pagination.previous')">
                ←
            </a>
        @endif

        <!-- Pagination Links -->
        @foreach ($employees->getUrlRange(1, $employees->lastPage()) as $page => $url)
            @if ($page == $employees->currentPage())
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
        @if ($employees->hasMorePages())
            <a 
                href="{{ $employees->nextPageUrl() . '&' . http_build_query(request()->except('page')) }}" 
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

        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Tombol Reset
        document.getElementById('resetButton').addEventListener('click', function () {
            // Arahkan ke URL utama tanpa parameter
            window.location.href = "{{ route('admin.employee.index') }}";
        });

        document.getElementById('file').addEventListener('change', function () {
    const file = this.files[0];
    if (
        file &&
        (file.type === 'application/vnd.ms-excel' || file.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
    ) {
        // Ambil CSRF token dari meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Ambil elemen form
        const form = document.getElementById('filterForm');

        // Buat input hidden untuk token CSRF
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);

        // Atur properti form
        form.action = "{{ route('admin.employee.import') }}";
        form.method = "POST";
        form.enctype = "multipart/form-data";

        // Submit form
        form.submit();
    } else {
        alert('Silakan unggah file Excel dengan format .xlsx atau .xls.');
        this.value = ''; // Reset file input
    }
});



        // Tombol Export
        document.getElementById('exportButton').addEventListener('click', function () {
            // Arahkan ke URL export
            window.location.href = "{{ route('admin.employee.export') }}";
        });

        // Tombol Filter
        document.getElementById('filterButton').addEventListener('click', function () {
            // Kembalikan ke default filter action
            const form = document.getElementById('filterForm');
            form.action = "{{ route('admin.employee.index') }}";
            form.method = "GET";
            form.enctype = "application/x-www-form-urlencoded";
        });
    });
</script>
@stop
