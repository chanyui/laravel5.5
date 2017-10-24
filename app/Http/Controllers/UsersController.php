<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use Mail;

class UsersController extends Controller
{
    /**
     * 中间件过滤未登录用户的操作权限
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index', 'confirmEmail']
        ]);

        //只让未登录用户访问注册页面
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    /**
     * 列出所有用户
     * +-----------------------------------------------------------
     * @functionName : index
     * +-----------------------------------------------------------
     * @author yc
     * +-----------------------------------------------------------
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::paginate(15);
        return view('users.index', compact('users'));
    }

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
     * @param User $user 用户信息(隐性路由模型绑定)
     * +-----------------------------------------------------------
     * @author yc
     * +-----------------------------------------------------------
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        //取出该用户的所有微博并进行排序分页
        $statuses = $user->statuses()->orderBy('created_at', 'desc')->paginate(15);

        return view('users.show', compact('user', 'statuses'));
    }

    /**
     * 用户注册操作
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

        //注册完成后自动登录
        /*Auth::login($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程！');*/

        //用户注册完在邮箱中激活账户
        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect('/');
    }

    /**
     * 编辑用户展示页面s
     * +-----------------------------------------------------------
     * @functionName : edit
     * +-----------------------------------------------------------
     * @param User $user 用户信息(隐性路由模型绑定)
     * +-----------------------------------------------------------
     * @author yc
     * +-----------------------------------------------------------
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    /**
     * 更新用户资料操作
     * +-----------------------------------------------------------
     * @functionName : update
     * +-----------------------------------------------------------
     * @param User $user 用户信息(隐性路由模型绑定)
     * @param Request $request 提交过来的信息
     * +-----------------------------------------------------------
     * @author yc
     * +-----------------------------------------------------------
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $this->authorize('update', $user);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = $request->password;
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');
        return redirect()->route('users.show', $user->id);
    }

    /**
     * 删除用户操作(权限在UserPolicy.php控制)
     * +-----------------------------------------------------------
     * @functionName : destroy
     * +-----------------------------------------------------------
     * @param User $user
     * +-----------------------------------------------------------
     * @author yc
     * +-----------------------------------------------------------
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '成功删除用户！');
        return back();
    }

    /**
     * 使用token来设置激活功能
     * +-----------------------------------------------------------
     * @functionName : confirmEmail
     * +-----------------------------------------------------------
     * @param $token
     * +-----------------------------------------------------------
     * @author yc
     * +-----------------------------------------------------------
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();
        $user->activated = true;
        $user->activation_token = null;
        $user->save();
        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功！');
        return redirect()->route('users.show', [$user]);
    }

    /**
     * 发送邮件功能
     * +-----------------------------------------------------------
     * @functionName : sendEmailConfirmationTo
     * +-----------------------------------------------------------
     * @param $user
     * +-----------------------------------------------------------
     * @author yc
     * +-----------------------------------------------------------
     */
    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'test@qq.com';
        $name = 'Aufree';
        $to = $user->email;
        $subject = "感谢注册 Sample 应用！请确认你的邮箱。";
        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }
}
