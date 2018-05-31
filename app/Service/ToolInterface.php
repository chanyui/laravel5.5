<?php
/**
 * Created by PhpStorm.
 * User: yc
 * Date: 2018/5/31
 * Time: 15:21
 */

namespace App\Service;

interface ToolInterface
{
    /**
     * 定义工具类接口
     */
    public function rule($type, $value);
}