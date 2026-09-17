<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApprovalController extends Controller
{
    public function index(Request $request): View
    {
        $query = Post::with('author', 'category')
            ->where('needs_approval', true)
            ->where('is_approved', false)
            ->latest();

        if ($request->boolean('rejected')) {
            $query = Post::with('author', 'category')
                ->where('needs_approval', true)
                ->whereNotNull('rejection_note')
                ->latest();
        }

        return view('admin.approvals.index', [
            'posts' => $query->paginate(15),
            'showRejected' => $request->boolean('rejected'),
        ]);
    }

    public function approve(Post $post): RedirectResponse
    {
        $post->update([
            'is_approved' => true,
            'approved_at' => now(),
            'rejection_note' => null,
        ]);

        return back()->with('success', 'Berita disetujui dan kini tampil di publik.');
    }

    public function reject(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_note' => ['required', 'string', 'max:255'],
        ]);

        $post->update([
            'is_approved' => false,
            'approved_at' => null,
            'rejection_note' => $validated['rejection_note'],
        ]);

        return back()->with('success', 'Berita ditolak. Penulis menerima catatan dari Ketua.');
    }
}
