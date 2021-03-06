<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('/help', 'StaticPagesController@help')->name('help');
Route::get('/about', 'StaticPagesController@about')->name('about');

//用户注册
Route::get('signup', 'UsersController@create')->name('signup');
Route::resource('users', 'UsersController');

//用户登录
Route::get('login', 'SessionController@create')->name('login');
Route::post('login', 'SessionController@store')->name('login');
Route::delete('logout', 'SessionController@destroy')->name('logout');

//激活账户#
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');

//重置密码
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

//微博RESTful架构
Route::resource('statuses', 'StatusesController', ['only' => ['store', 'destroy']]);

//微博关注和粉丝
//显示用户的关注人列表页
Route::get('/users/{user}/followings', 'UsersController@followings')->name('users.followings');
//显示用户的粉丝列表页
Route::get('/users/{user}/followers', 'UsersController@followers')->name('users.followers');
//关注操作
Route::post('/users/followers/{user}', 'FollowersController@store')->name('followers.store');
//取消关注操作
Route::delete('/users/followers/{user}', 'FollowersController@destroy')->name('followers.destroy');

Route::resource('tool', 'TestController');

// test route
Route::get('/hello/laravel/academy/{id}', ['as' => 'academy', function ($id) {
    return 'Hello LaravelAcademy , id eq ' . $id . '！';
}]);

Route::group(['as' => 'admin::'], function () {
    Route::get('/testDashboard', ['as' => 'dashboard', function () {
        return redirect()->route('academy', ['id' => '1863']);  //地址跳转
    }]);
});

Route::get('/test', function () {
    return redirect()->route('admin::dashboard');  //地址跳转
});

Route::group(['middleware' => 'adult'], function () {
    Route::get('/write/academy', function () {
        //使用adult中间件
    });
    Route::get('/update/academy', function () {
        //使用adult中间件
    });
});

Route::get('/age/refuse', ['as' => 'refuse', function () {
    return "未成年人禁止入内！";
}]);

Route::group(['prefix' => 'laravelacademy'], function () {
    Route::get('write', function () {
        return "Write LaravelAcademy";
    });
    Route::get('update', function () {
        return 'Update LaravelAcademy';
     });
});

//设置cookie
Route::get('cookie/add', function () {
    return response('欢迎来到 Laravel 学院')->cookie('cookieName', '学院', 60);
});
//获取cookie
Route::get('cookie/get', function (\Illuminate\Http\Request $request) {
    $cookie = $request->cookie('cookieName');
    dd($cookie);
});
//删除cookie
Route::get('cookie/del', function () {
    $cookie = \Illuminate\Support\Facades\Cookie::forget('cookieName');
    // 这里我们返回的时候要使用 withCookie ！
    //return response('删除cookie')->withCookie($cookie);
    \Illuminate\Support\Facades\Cookie::queue($cookie);
});