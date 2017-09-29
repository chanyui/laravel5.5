<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * 注册页面
     * +-----------------------------------------------------------
     * @functionName : create
     * +-----------------------------------------------------------
     * @author yc
     * +-----------------------------------------------------------
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * 显示用户信息
     * +-----------------------------------------------------------
     * @functionName : show
     * +-----------------------------------------------------------
     * @param User $user 用户id
     * +-----------------------------------------------------------
     * @author yc
     * +-----------------------------------------------------------
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * 用户注册
     * +-----------------------------------------------------------
     * @functionName : store
     * +-----------------------------------------------------------
     * @param Request $request 接收提交过来的信息
     * +-----------------------------------------------------------
     * @author yc
     * +-----------------------------------------------------------
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        session()->flash('success', '欢迎，您将在这里开启一段新的旅程！');
        return redirect()->route('users.show', [$user]);
    }
}
