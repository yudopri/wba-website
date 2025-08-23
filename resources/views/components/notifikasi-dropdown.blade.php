@forelse($notifikasis as $notif)
    <a href="{{ route('rekap.index') }}" class="dropdown-item mark-as-read" data-id="{{ $notif->id }}">
        <i class="fas fa-envelope mr-2"></i> {{ $notif->judul }}
        <span class="float-right text-muted text-sm">{{ $notif->created_at->diffForHumans() }}</span>
    </a>
@empty
    <span class="dropdown-item">Tidak ada notifikasi baru</span>
@endforelse