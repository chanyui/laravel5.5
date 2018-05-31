<?php

namespace App\Providers;

use App\Service\Tool;
use Illuminate\Support\ServiceProvider;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //使用singleton绑定单例
        $this->app->singleton('tool', function () {
            return new Tool();
        });

        //使用bind绑定实例到接口以便依赖注入
        /*$this->app->bind('App\Services\ToolInterface', function () {
            return new Tool();
        });*/
    }
}
