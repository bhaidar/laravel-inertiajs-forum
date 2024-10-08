<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
    ];

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
}
