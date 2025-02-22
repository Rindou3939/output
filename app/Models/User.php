<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * 自分がフォローしているユーザー（フォロー中）
     */
    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'followed_id')
                    ->withTimestamps();
    }

    /**
     * 自分をフォローしているユーザー（フォロワー）
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'followed_id', 'following_id')
                    ->withTimestamps();
    }

    /**
     * 指定したユーザーをフォローしているか確認
     */
    public function isFollowing($userId)
    {
        return $this->following()->where('followed_id', $userId)->exists();
    }

    /**
     * 指定したユーザーにフォローされているか確認
     */
    public function isFollowedBy($userId)
    {
        return $this->followers()->where('following_id', $userId)->exists();
    }

    /**
     * 自分がブロックしているユーザー（フォロー中）
     */
    public function blocking()
    {
        return $this->belongsToMany(User::class, 'blockers', 'blocking_id', 'blocking_id')
                    ->withTimestamps();
    }

    /**
     * 自分をブロックしているユーザー（フォロワー）
     */
    public function blockers()
    {
        return $this->belongsToMany(User::class, 'blockers', 'blocked_id', 'blocking_id')
                    ->withTimestamps();
    }

    /**
     * 指定したユーザーをブロックしているか確認
     */
    public function isBlocking($userId)
    {
        return $this->blocking()->where('blocked_id', $userId)->exists();
    }

    /**
     * 指定したユーザーにブロックされているか確認
     */
    public function isBlockedBy($userId)
    {
        return $this->blockers()->where('blocking_id', $userId)->exists();
    }
}
