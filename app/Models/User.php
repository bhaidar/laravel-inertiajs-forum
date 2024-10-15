<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted(): void
    {
        static::created(function ($user) {
            // We are creating a new User not UserMention record
            // Update scout index when a new User is created
            // Trigger users_mentions index to add the new user to users_mentions index
            $user->mention->searchable();
        });

        static::updated(function ($user) {
            // Update scout index when User data changes
            // Trigger users_mentions index to update
            $user->mention->searchable();
        });
    }

    public function mention(): HasOne
    {
        return $this->hasOne(UserMention::class, 'id');
    }

    public function avatarUrl(): string
    {
        return 'https://www.gravatar.com/avatar/'.md5($this->email).'.jpg';
    }
}
