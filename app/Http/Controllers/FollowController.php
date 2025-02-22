<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    /**
     * フォローする
     */
    public function follow(User $user)
    {
        if (Auth::id() !== $user->id && !Auth::user()->isFollowing($user->id)) {
            Follower::create([
                'following_id' => Auth::id(),
                'followed_id' => $user->id,
            ]);
        }

        return redirect()->back();
    }

    /**
     * フォロー解除する
     */
    public function unfollow(User $user)
    {
        Follower::where('following_id', Auth::id())
            ->where('followed_id', $user->id)
            ->delete();

        return redirect()->back();
    }
}












