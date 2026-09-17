<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Services\ImageOptimizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $query = Post::with('category', 'author')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        return view('admin.posts.index', [
            'posts' => $query->paginate(15),
            'activeStatus' => $request->input('status'),
        ]);
    }

    public function create(): View
    {
        return view('admin.posts.create', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $data = $this->payload($request);
        $data['slug'] = $request->uniqueSlug();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = ImageOptimizer::optimize($request->file('cover_image'), 'posts');
        }

        $post = Post::create($data);

        $flash = $post->needs_approval
            ? 'Berita dibuat dan menunggu persetujuan Ketua.'
            : 'Berita berhasil dibuat.';

        return redirect()->route('admin.posts.index')->with('success', $flash);
    }

    public function edit(Post $post): View
    {
        return view('admin.posts.edit', [
            'post' => $post,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        $data = $this->payload($request);
        $data['slug'] = $request->uniqueSlug($post);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = ImageOptimizer::optimize($request->file('cover_image'), 'posts');
        }

        $post->update($data);

        $flash = $post->needs_approval && ! $post->is_approved
            ? 'Berita diperbarui dan kembali menunggu persetujuan Ketua.'
            : 'Berita berhasil diperbarui.';

        return redirect()->route('admin.posts.index')->with('success', $flash);
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Berita dihapus (soft delete).');
    }

    /**
     * Susun payload data dari request valid.
     *
     * @return array<string, mixed>
     */
    private function payload(PostRequest $request): array
    {
        $data = [
            'author_id' => $request->user()->id,
            'title' => $request->input('title'),
            'category_id' => $request->input('category_id'),
            'excerpt' => $request->input('excerpt'),
            'body' => $request->input('body'),
            'status' => $request->input('status'),
            'needs_approval' => $request->boolean('needs_approval'),
            'is_approved' => $request->boolean('needs_approval') ? false : true,
            'approved_at' => $request->boolean('needs_approval') ? null : now(),
            'rejection_note' => null,
            'published_at' => $request->input('published_at') ?? now(),
        ];

        return $data;
    }
}
