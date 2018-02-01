<?php

namespace Admin\Controller;

use Think\Controller;

class AdminController extends Controller
{
    //***********************************
    // iframe式显示菜单和index页
    //**********************************
    public function index()
    {
        //echo "v1";die;
        $this->display();
    }
}