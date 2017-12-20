<?php

namespace Admin\Controller;

use Think\Controller;

class ListController extends PublicController
{
    //***********************************
    // iframe式显示菜单和index页
    //**********************************
    public function list()
    {
        //搜索
        $where = "1=1";
        $name != '' ? $where .= " and name like '%$name%'" : null;
        $tel != '' ? $where .= " and tel like '%$tel%'" : null;

//        define('rows', 20);
        $count = M('order')->where($where)->count();
        define('rows', $count);
        $rows = ceil($count / rows);

        $page = (int)$_GET['page'];
        $page < 0 ? $page = 0 : '';
        $limit = $page * rows;
        $userlist = M('order')->where($where)->order('order.id desc')->limit($limit, rows)->select();
        $page_index = $this->page_index($count, $rows, $page);
        foreach ($userlist as $k => $v) {
            $userlist[$k]['delete_time'] = date("Y-m-d H:i", $v['delete_time']);
            $userlist[$k]['create_time'] = date("Y-m-d H:i", $v['create_time']);
            $userlist[$k]['update_time'] = date("Y-m-d H:i", $v['update_time']);
        }
        //====================
        // 将GET到的参数输出
        //=====================
        $this->assign('name', $name);
        $this->assign('tel', $tel);

        //=============
        //将变量输出
        //=============
        $this->assign('count',$count);
        $this->assign('page_index', $page_index);
        $this->assign('page', $page);
        $this->assign('userlist', $userlist);
//        var_dump($userlist);die;
        $this->display();
    }

}