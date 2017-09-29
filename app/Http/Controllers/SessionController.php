<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

class SessionController extends Controller
{
    /**
     * 用户登录页面
     * +-----------------------------------------------------------
     * @functionName : create
     * +-----------------------------------------------------------
     * @author yc
     * +-----------------------------------------------------------
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('sessions.create');
    }

    /**
     * 用户登录操作
     * +-----------------------------------------------------------
     * @functionName : store
     * +-----------------------------------------------------------
     * @param Request $request 表单提交过来的信息
     * +-----------------------------------------------------------
     * @author yc
     * +-----------------------------------------------------------
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials, $request->has('remember'))) {
            session()->flash('success', '欢迎回来！');
            return redirect()->route('users.show', [Auth::user()]);
        } else {
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back();
        }
    }

    /**
     * 退出操作
     * +-----------------------------------------------------------
     * @functionName : destroy
     * +-----------------------------------------------------------
     * @author yc
     * +-----------------------------------------------------------
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }
}