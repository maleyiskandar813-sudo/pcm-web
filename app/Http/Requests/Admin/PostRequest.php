<?php

namespace App\Http\Requests\Admin;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() || $this->user()?->isSuperAdmin();
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $imageRules = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'];

        return [
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'cover_image' => $imageRules,
            'status' => ['required', 'in:'.Post::STATUS_DRAFT.','.Post::STATUS_PUBLISHED],
            'needs_approval' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'needs_approval' => $this->boolean('needs_approval'),
        ]);
    }

    public function uniqueSlug(?Post $post = null): string
    {
        $base = Str::slug($this->input('title', 'berita'));
        $slug = $base;
        $i = 2;

        while (Post::where('slug', $slug)->when($post, fn ($q) => $q->whereKeyNot($post->id))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
