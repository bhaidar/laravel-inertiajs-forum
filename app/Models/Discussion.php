<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Discussion extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'pinned_at',
    ];

    public function scopeOrderByPinned($query): void
    {
        $query->orderBy('pinned_at', 'asc');
    }

    public function isPinned(): bool
    {
        return ! is_null($this->pinned_at);
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    /**
     *  All posts of this discussion
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class)->chaperone('discussion');
    }

    /**
     * First post of this discussion
     */
    public function post(): HasOne
    {
        return $this->HasOne(Post::class)
            ->whereNull('parent_id');
    }
}
