<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 两个 id 相同时，则代表两个用户是相同用户，用户通过授权，可以接着进行下一个操作
     * +-----------------------------------------------------------
     * @functionName : update
     * +-----------------------------------------------------------
     * @param User $currentUser 当前登录用户实例
     * @param User $user 要进行授权的用户实例
     * +-----------------------------------------------------------
     * @author yc
     * +-----------------------------------------------------------
     * @return bool
     */
    public function update(User $currentUser,User $user)
    {
        return $currentUser->id === $user->id;
    }

    /**
     * 当前用户为管理员，并且两个用户不是相同用户，用户通过授权，
     * 可以接着进行下一个操作（自己不能删除自己）
     * +-----------------------------------------------------------
     * @functionName : destroy
     * +-----------------------------------------------------------
     * @param User $currentUser 当前登录用户实例
     * @param User $user 要进行授权的用户实例
     * +-----------------------------------------------------------
     * @author yc
     * +-----------------------------------------------------------
     * @return bool
     */
    public function destroy(User $currentUser,User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
