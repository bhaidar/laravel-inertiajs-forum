<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
    ];

    protected static function booted(): void
    {
        static::created(function (Post $post) {
            // Find the mentions
            preg_match_all('/@(?P<username>[\w-]+)/', $post->body, $mentions, PREG_SET_ORDER);

            // Get the users
            $userIds = User::whereIn('username', array_column($mentions, 'username'))->pluck('id');

            // Sync users and posts
            $post->mentions()->sync($userIds);
        });

        //        static::updated(function (Post $post) {
        //
        //        });
    }

    public function discussion(): BelongsTo
    {
        return $this->BelongsTo(Discussion::class);
    }

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->BelongsTo(Post::class, 'parent_id');
    }

    public function mentions(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'mentions', 'post_id', 'user_id')
            ->withTimestamps();
    }
}
