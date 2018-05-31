<?php
/**
 * Created by PhpStorm.
 * User: yc
 * Date: 2018/5/31
 * Time: 15:20
 */

namespace App\Service;

class Tool implements ToolInterface
{
    /**
     * 规则检查
     * @param $type
     * @param $val
     * @return bool|int
     */
    public function rule($type, $val)
    {
        switch ($type) {
            case 'password':
                //验证登陆密码，允许英文和数字_,5-20位，不允许以_开头
                return preg_match('/^[a-zA-Z0-9][a-zA-Z0-9_]{5,20}$/', $val);
                break;
            case 'mobile':
                //验证手机号码
                return preg_match('/^1[34578]{1}\d{9}$/', $val);
                break;
            case 'telephone':
                //验证固定电话，区号-座机号-分机号，分机号可不填
                return preg_match('/^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$/', $val);
                break;
            case 'username':
                //验证用户名，只含有数字、字母、下划线不能以下划线开头和结尾,6-16位
                return preg_match('/^(?!_)(?!.*?_$)[a-zA-Z0-9_]{6,16}$/', $val);
                break;
            case 'nickname':
                //验证昵称，只含有中文、字母、数字,1-16位
                return preg_match('/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]{1,16}$/u', $val);
                break;
            case 'msg_code':
                //验证短信验证码
                return preg_match('/^([0-9]){6}$/', $val);
                break;
            case 'md5':
                //验证md5格式
                return preg_match('/^([a-zA-Z0-9]){32}$/', $val);
                break;
            case 'address_code':
                //验证地址
                return preg_match('/^([0-9]){6}$/', $val);
                break;
            case 'name':
                //验证真实姓名
                return preg_match('/^[\x{4e00}-\x{9fa5}a-zA-Z]{2,16}$/u', $val);
                break;//只含有中文、字母,2-16位
            case 'path':
                //验证文件路径
                return preg_match('/[a-zA-Z]:(\\[0-9a-zA-Z_.]+)+|\/([0-9a-zA-Z_.]+)/', $val);
                break;//验证文件的路径
            case 'shop_name':
                //验证店铺名称，只含有中文、字母、数字,1-20位
                return preg_match('/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]{1,20}$/u', $val);
                break;
            case 'money':
                //验证金额，9位整数位，2位小数，可以为0，不能为负
                return preg_match('/(^[1-9]([0-9]{0,8})?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/', $val);
                break;
            case 'time_ymd':
                //验证时间格式YYYY-MM-DD，YYYY/MM/DD，YYYY_MM_DD，YYYY.MM.DD,包含闰年
                return preg_match('/(([0-9]{3}[1-9]|[0-9]{2}[1-9][0-9]{1}|[0-9]{1}[1-9][0-9]{2}|[1-9][0-9]{3})([-\/\._])(((0[13578]|1[02])([-\/\._])(0[1-9]|[12][0-9]|3[01]))|((0[469]|11)([-\/\._])(0[1-9]|[12][0-9]|30))|(02([-\/\._])(0[1-9]|[1][0-9]|2[0-8]))))|((([0-9]{2})(0[48]|[2468][048]|[13579][26])|((0[48]|[2468][048]|[3579][26])00))([-\/\._])02([-\/\._])29)/', $val);
                break;
            case 'good_name':
                //验证商品名称，只含有中文、字母，数字,1-60位
                return preg_match('/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]{1,60}$/u', $val);
                break;
            case 'email':
                //验证邮箱
                return preg_match('/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i', $val);
                break;
            case 'url':
                //验证URl
                return preg_match('/^((ht|f)tps?):\/\/[\w\-]+(\.[\w\-]+)+([\w\-\.,@?^=%&:\/~\+#]*[\w\-\@?^=%&\/~\+#])?$/', $val);
                break;
            case 'positiveInt':
                //验证正整数
                return preg_match('/^[1-9]\d*$/', $val);
                break;
            case 'ip':
                return preg_match('/^(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])$/', $val);
                break;
            case 'gold_num':
                //验证金币数量，只含有数字,不能0开头,不能超过10000金币
                return preg_match('/^[1-9][0-9]{0,3}$|^10000$/', $val);
                break;
            case 'csrf_token':
                //验证token
                return $val === csrf_token();
                break;
            case 'goods_serial':
                //验证商品货号，只含有字母，数字,1-30位
                return preg_match('/^[a-zA-Z0-9]{1,30}$/u', $val);
                break;
            case 'address':
                //验证地址，只含有中文，字母，数字,1-60位
                return preg_match('/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]{1,60}$/u', $val);
                break;
            case 'company':
                //验证公司名称，只含有中文，字母，数字,1-60位
                return preg_match('/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]{1,30}$/u', $val);
                break;
            default:
                return false;
        }
    }

    /**
     * 异步返回方法
     */
    public function returnModel($code = 404, $msg = '服务端出错啦！', $data = [])
    {
        return response()->json(['code' => $code, 'msg' => $msg, 'data' => $data]);
    }

}