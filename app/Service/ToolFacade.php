<?php
/**
 * Created by PhpStorm.
 * User: yc
 * Date: 2018/5/31
 * Time: 15:36
 */

namespace App\Service;

use Illuminate\Support\Facades\Facade;

class ToolFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'App\Service\Tool';
    }
}