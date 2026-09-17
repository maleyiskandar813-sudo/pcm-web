<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(): View
    {
        return view('admin.messages.index', [
            'messages' => ContactMessage::latest()->paginate(15),
            'unreadCount' => ContactMessage::unread()->count(),
        ]);
    }

    public function markRead(Request $request, ContactMessage $message): RedirectResponse
    {
        if (! $message->read_at) {
            $message->markRead();
        }

        return back()->with('success', 'Pesan ditandai sudah dibaca.');
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return back()->with('success', 'Pesan dihapus.');
    }
}
