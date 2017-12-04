<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 03/10/2017
 * Time: 9:15 PM
 */

namespace app\bis\controller;

use think\Controller;


class Register extends Controller
{
    public function index()
    {
        $citys = model('City')->getNormalCitysByParentId();
        return $this->fetch('', [
            'citys' => $citys,
        ]);
    }

    public function add()
    {
//        return 'blacky';exit();
        if (!request()->isPost()) {
            $this->error('请求错误');
        }
        $data = input('post.');
//        print_r($data);exit();
        $validate = validate('Bis');
        if (!$validate->scene('add')->check($data)) {
            $this->error($validate->getError());
        }
    }
}