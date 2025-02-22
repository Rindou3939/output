<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * ユーザー詳細ページを表示
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function index()
    {
        $authUser = Auth::user();

        return view('user.index', compact('authUser'));
    }
}