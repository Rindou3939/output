<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'monster_id',
        'title',
        'description',
        'recruitment_target',
        'recruitment_count',
    ];

    public function monster()
    {
        return $this->belongsTo(Monster::class, 'monster_id');
    }

     /**
     * 投稿に紐づくコメントを取得
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * 投稿の所有者 (ユーザー) とのリレーション
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

