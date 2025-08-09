<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotificationUser;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        
        $notif = NotificationUser::where('user_id', Auth::id())->findOrFail($id);
        $notif->update(['sudah_dibaca' => true]);

        return back();
    }
     public function show()
{
    // View untuk tampilan dropdown (pertama kali diklik)
    $notifikasis = NotificationUser::where('user_id', Auth::id())
        ->latest()
        ->take(5)
        ->get();

    return view('components.notifikasi-dropdown', compact('notifikasis'));
}

public function get()
{
    // Untuk update otomatis via JS AdminLTE
    $notifikasis = NotificationUser::where('user_id', Auth::id())
        ->where('sudah_dibaca', false)
        ->latest()
        ->take(5)
        ->get();

    return response()->json([
        'label' => $notifikasis->count(),
        'label_color' => 'danger',
        'icon_color' => 'warning',
        'dropdown' => view('components.notifikasi-dropdown', compact('notifikasis'))->render(),
    ]);
}
}
