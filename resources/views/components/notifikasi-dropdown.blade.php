@forelse ($notifikasis as $notif)
    <a href="#" class="dropdown-item">
        <i class="fas fa-info-circle mr-2 text-{{ $notif->tipe }}"></i>
        {{ Str::limit($notif->pesan, 50) }}
        <span class="float-right text-muted text-sm">{{ $notif->created_at->diffForHumans() }}</span>
    </a>
@empty
    <span class="dropdown-item text-center text-muted">Tidak ada notifikasi</span>
@endforelse
