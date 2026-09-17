<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    protected $fillable = [
        'category_id',
        'author_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'cover_image',
        'status',
        'needs_approval',
        'is_approved',
        'approved_at',
        'rejection_note',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'needs_approval' => 'boolean',
            'is_approved' => 'boolean',
            'approved_at' => 'datetime',
            'published_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Post yang boleh tampil publik: published, sudah approval (jika perlu), dan sudah terjadwal.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', self::STATUS_PUBLISHED)
            ->where(fn (Builder $q) => $q->where('needs_approval', false)->orWhere('is_approved', true))
            ->where('published_at', '<=', now());
    }
}
