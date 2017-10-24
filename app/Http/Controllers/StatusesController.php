<?php

namespace App\Http\Controllers;

use App\Policies\StatusPolicy;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Status;
use Auth;

class StatusesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 创建微博操作
     * +-----------------------------------------------------------
     * @functionName : store
     * +-----------------------------------------------------------
     * @param Request $request 提交过来的信息
     * +-----------------------------------------------------------
     * @author yc
     * +-----------------------------------------------------------
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:140'
        ]);

        Auth::user()->statuses()->create([
            'content' => $request->content
        ]);
        return redirect()->back();
    }

    /**
     * 删除微博
     * 隐性路由模型绑定』功能，Laravel 会自动查找并注入对应 ID 的实例对象 $status
     * +-----------------------------------------------------------
     * @functionName : destroy
     * +-----------------------------------------------------------
     * @param Status $status
     * +-----------------------------------------------------------
     * @author yc
     * +-----------------------------------------------------------
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Status $status)
    {
        $this->authorize('destroy', $status);
        $status->delete();
        session()->flash('success', '微博已被成功删除！');
        return redirect()->back();
    }
}
