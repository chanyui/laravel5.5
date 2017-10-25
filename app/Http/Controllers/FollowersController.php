<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

class FollowersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 用户关注操作
     * +-----------------------------------------------------------
     * @functionName : store
     * +-----------------------------------------------------------
     * @param User $user 被关注的用户
     * +-----------------------------------------------------------
     * @author yc
     * +-----------------------------------------------------------
     */
    public function store(User $user)
    {
        if (Auth::user()->id === $user->id) {
            return redirect('/');
        }

        if (!Auth::user()->isFollowing($user->id)) {
            Auth::user()->follow($user->id);
        }
        return redirect()->route('users.show', $user->id);
    }

    /**
     * 取消用户关注操作
     * +-----------------------------------------------------------
     * @functionName : destroy
     * +-----------------------------------------------------------
     * @param User $user 被取消关注的用户
     * +-----------------------------------------------------------
     * @author yc
     * +-----------------------------------------------------------
     */
    public function destroy(User $user)
    {
        if (Auth::user()->id === $user->id) {
            return redirect('/');
        }

        if (Auth::user()->isFollowing($user->id)) {
            Auth::user()->unfollow($user->id);
        }

        return redirect()->route('users.show', $user->id);
    }
}
