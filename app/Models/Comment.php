<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'post_id',
        'description',
    ];

    /**
     * コメントの投稿者とのリレーション
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * コメントが紐づく投稿とのリレーション
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}






