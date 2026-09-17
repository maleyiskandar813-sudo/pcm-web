<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Aum;
use App\Models\ContactMessage;
use App\Models\Document;
use App\Models\Post;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = auth()->user();
        $isSuper = $user->isSuperAdmin();

        return view('admin.dashboard', [
            'stats' => [
                'posts' => Post::count(),
                'pendingApproval' => $isSuper ? Post::where('needs_approval', true)->where('is_approved', false)->count() : null,
                'agenda' => Agenda::where('starts_at', '>=', now())->count(),
                'aum' => Aum::count(),
                'documents' => Document::count(),
                'unreadMessages' => ContactMessage::whereNull('read_at')->count(),
                'users' => $isSuper ? User::count() : null,
            ],
            'recentPosts' => Post::with('author')->latest()->limit(5)->get(),
            'pendingQueue' => $isSuper
                ? Post::with('author')->where('needs_approval', true)->where('is_approved', false)->latest()->limit(5)->get()
                : collect(),
            'recentMessages' => ContactMessage::latest()->limit(5)->get(),
        ]);
    }
}
