@extends('adminlte::page')

@section('content')

<div class="container mt-4">
    <h1 class="mb-4">Detail Invoice</h1>

    @php
        $statusList = [
            ['label' => 'Menunggu', 'icon' => 'fas fa-file-alt', 'date' => $invoice->created_at],
            ['label' => 'Lunas', 'icon' => 'fas fa-check-circle', 'date' => $invoice->date_pay ?? null]
        ];
        $currentStatus = $invoice->status ?? 'pending';
    @endphp

    <!-- Progress Status -->
    <div class="mb-4">
        <div class="progress" style="height: 3px;">
            <div class="progress-bar
                @if($currentStatus == 'pending') bg-warning @else bg-success @endif"
                role="progressbar" style="width: {{ $currentStatus == 'pending' ? '50%' : '100%' }};">
            </div>
        </div>
        <div class="d-flex justify-content-between mt-2">
            @foreach ($statusList as $status)
                <div class="text-center">
                    <div class="rounded-circle border p-3
                        @if($currentStatus == $status['label']) border-success text-success @else border-secondary text-secondary @endif">
                        <i class="{{ $status['icon'] }} fa-2x"></i>
                    </div>
                    <small class="d-block mt-1
                        @if($currentStatus == $status['label']) text-success font-weight-bold @else text-secondary @endif">
                        {{ ucfirst($status['label']) }}
                    </small>
                    @if($status['date'])
                        <p class="text-muted small mt-1">
                            {{ \Carbon\Carbon::parse($status['date'])->format('d M Y H:i') }}
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Bukti Pembayaran sebagai Button -->
    @if($invoice->status == 'paid' && $invoice->foto_bukti)
        <div class="mb-4">
            <h5>Bukti Pembayaran</h5>
            <a href="{{ asset($invoice->foto_bukti) }}"
               target="_blank"
               class="btn btn-success">
               Lihat Bukti Pembayaran
            </a>
        </div>
    @endif

    <!-- Timeline -->
    <div class="mb-4">
        <h5>Riwayat Invoice</h5>
        <ul class="list-group">
            {{-- Pending --}}
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="fw-bold">Menunggu</div>
                    <div>Person: {{ $invoice->user->name }}</div>
                    <div>{{ $invoice->lokasi_kerja }}</div>
                </div>
                <span class="badge bg-warning rounded-pill">
                    {{ \Carbon\Carbon::parse($invoice->created_at)->format('d M Y H:i') }}
                </span>
            </li>

            {{-- Paid --}}
            @if($invoice->status == 'paid' && $invoice->date_pay)
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="fw-bold">Lunas</div>
                    <div>Person: {{ $invoice->user->name }}</div>
                    <div>{{ $invoice->lokasi_kerja }}</div>
                </div>
                <span class="badge bg-success rounded-pill">
                    {{ \Carbon\Carbon::parse($invoice->tanggal_paid)->format('d M Y H:i') }}
                </span>
            </li>
            @endif
        </ul>
    </div>

    <!-- Tombol Kembali -->
    <div class="text-center">
        <a href="{{ route('admin.invoice.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>
</div>

@endsection
