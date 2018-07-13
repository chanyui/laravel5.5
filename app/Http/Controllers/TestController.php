<?php

namespace App\Http\Controllers;

use App\Service\ToolFacade;
use App\Service\ToolInterface;
use Illuminate\Support\Facades\App;

/**
 * 测试服务提供者 自定义服务
 * Class TestController
 * @package App\Http\Controllers
 */
class TestController extends Controller
{
    protected $tool;

    //依赖注入
    public function __construct(ToolInterface $tool)
    {
        $this->tool = $tool;
    }

    /**
     * 服务提供者
     * Display a listing of the resource.
     *
     * @author LaravelAcademy.org
     */
    public function index()
    {
        echo ToolFacade::rule('name', '华盛顿放假了');
        echo PHP_EOL;
        $test = App::make('tool');
        echo $test->rule('name', '华盛顿放假了');
        echo PHP_EOL;
        echo $this->tool->rule('name', '华盛顿放假了');
    }
}
