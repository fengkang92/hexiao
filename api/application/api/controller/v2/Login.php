<?php

namespace app\api\controller\v2;

use think\Controller;
use app\api\model\Adminuser;

class Login extends Controller
{
    /**
     * 登陆
     */
    public function login($name, $pwd)
    {
        $admininfo = Adminuser::checkUser($name);
        //查询app表看使用该系统的客户时间
        if (!empty($admininfo)) {
            $admininfo = $admininfo->toarray();
            if (MD5(MD5($pwd)) == $admininfo['pwd']) {
                return [
                    'code' => 200,
                    'msg' => '登陆成功',
                    'data' => [
                        'id' => $admininfo['id']
                    ]
                ];
            } else {
                return [
                    'code' => -1,
                    'msg' => '账号密码有误'
                ];
            }
        } else {
            return [
                'code' => 0,
                'msg' => '账号不存在'
            ];
        }
    }
}