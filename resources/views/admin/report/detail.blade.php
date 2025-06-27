@extends('adminlte::page')

@section('content')

<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Detail Pengaduan</h1>

    @php
    $pengaduan = 'Diajukan'; // Status saat ini
    $statusList = [
        ['label' => 'Diajukan', 'icon' => 'fas fa-file-alt'],
        ['label' => 'Diproses', 'icon' => 'fas fa-cogs'],
        ['label' => 'Disetujui', 'icon' => 'fas fa-check-circle'],
    ];
    @endphp

<!-- Progress Bar -->
<div class="relative col-3 w-full max-w-4xl mx-auto mb-12">
    <!-- Garis Penghubung -->
    <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-300 -z-10"></div>

    <!-- Container Icon -->
    <div class="relative flex items-center justify-center gap-12 md:gap-24 mb-20 py-12">

    <div class="flex rounded-full items-center justify-center border-4">
        @foreach ($statusList as $index => $status)
                <!-- Icon Status -->

                    <i class="{{ $status['icon'] }} text-2xl px-3 text-center
                        {{ $pengaduan == $status['label'] ? 'text-green-700' : 'text-gray-500' }}">
                        <p class="text-sm mt-2 text-center
                    {{ $pengaduan == $status['label'] ? 'text-green-800 font-semibold' : 'text-gray-600' }}">
                    {{ $status['label'] }}
                </p></i>

                <!-- Label -->

        @endforeach
        </div>
    </div>
</div>


    <!-- Timeline -->
    <div class="w-3/4 mx-auto">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Riwayat Pengaduan</h2>
        <div class="border-l-4 border-gray-300 pl-6 space-y-6">
            @php
            $history = [
                ['date' => '2020-03-31 20:35:37', 'Keterangan' => 'Kehilangan', 'person' => 'Fajar', 'Deskripsi' => 'Shipment to Atasan'],
                ['date' => '2020-03-31 19:56:18', 'Keterangan' => 'Kehilangan', 'person' => 'Joko', 'Deskripsi' => 'Arrived'],
                ['date' => '2020-03-31 16:49:00', 'Keterangan' => 'Kehilangan', 'person' => 'Manager', 'Deskripsi' => 'Approval'],
            ];
            @endphp

            @foreach ($history as $item)
                <div class="relative p-6 bg-white shadow-md rounded-lg">
                    <div class="absolute -left-2 top-2 w-4 h-4 bg-green-500 rounded-full"></div>
                    <p class="text-sm text-gray-600">{{ $item['date'] }}</p>
                    <p class="font-semibold">{{ $item['Keterangan'] }}</p>
                    <p class="text-gray-700">Person: {{ $item['person'] }}</p>
                    <p class="text-gray-700">{{ $item['Deskripsi'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Tombol Kembali -->
    <div class="text-center mt-6">
        <a href="/laporanmasalah"
            class="px-6 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-700 transition">
            Kembali
        </a>
    </div>
</div>

@endsection
