<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'postal_code',
        'address1',
        'address2',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function comments()
    {
        $this->hasMany(Comment::class);
    }

    public function getAvatarPath($avatarPath)
    {
        if (!$avatarPath) {
            return asset('images/avatar/no_avatar.webp');
        }

        if (file_exists(public_path('images/avatar/' . $avatarPath))) {
            return asset('images/avatar/' . $avatarPath);
        }

        if (file_exists(storage_path('app/public/' . $avatarPath))) {
            return asset('storage/' . $avatarPath);
        }
    }
}
