<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(?string $category = null): View
    {
        $query = Post::published()->with('category');

        if ($category) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $category));
        }

        return view('public.posts.index', [
            'posts' => $query->latest('published_at')->paginate(12),
            'categories' => Category::withCount(['posts' => fn ($q) => $q->published()])->get(),
            'activeCategory' => $category,
        ]);
    }

    public function show(string $slug): View
    {
        $post = Post::published()->with('category', 'author')->where('slug', $slug)->firstOrFail();

        return view('public.posts.show', [
            'post' => $post,
            'related' => Post::published()
                ->whereKeyNot($post->id)
                ->when($post->category_id, fn ($q) => $q->where('category_id', $post->category_id))
                ->latest('published_at')
                ->take(3)
                ->get(),
        ]);
    }
}
