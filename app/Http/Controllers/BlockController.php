<?php

namespace App\Http\Controllers;

use App\Models\Blocker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Block;

class BlockController extends Controller
{
    /**
     * ブロックする
     */
    public function block(User $user)
    {
        if (Auth::id() !== $user->id && !Auth::user()->isBlocking($user->id)) {
            Blocker::create([
                'blocking_id' => Auth::id(),
                'blocked_id' => $user->id,
            ]);
        }

        return redirect()->back();
    }

    /**
     * ブロック解除する
     */
    public function unblock(User $user)
    {
        Blocker::where('blocking_id', Auth::id())
            ->where('blocked_id', $user->id)
            ->delete();

        return redirect()->back();
    }
}