<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
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

    public function scopeOrderByLastPost($query): void
    {
        /*
         * This adds a subquery to the main query in the order claude
         * It gets the latest post created_at for each discussion and sorts  by it
         * select *
         * from `discussions`
         * order by
         *    `pinned_at` asc,
         *	(select `created_at` from `posts` where `posts`.`discussion_id` = `discussions`.`id` order by `created_at` desc limit 1) desc
         * limit 10
         * offset 0
         */
        $query->orderBy(
            Post::select('created_at')
                ->whereColumn('posts.discussion_id', 'discussions.id')
                ->latest()
                ->take(1),
            'desc');
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

    public function latestPost(): HasOne
    {
        return $this->HasOne(Post::class)->latestOfMany();
    }

    public function participants(): HasManyThrough
    {
        return $this->hasManyThrough(
            User::class,
            Post::class,
            'discussion_id', // Foreign key on Post - How Discussion links to Post
            'id', // Foreign key on User - How User links to Post
            'id', //Local key on the
            'user_id'
        )->distinct();
    }
}
