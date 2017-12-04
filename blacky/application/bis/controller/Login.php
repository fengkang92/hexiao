<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 03/10/2017
 * Time: 9:15 PM
 */

namespace app\bis\controller;

use think\Controller;


class Login extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
}