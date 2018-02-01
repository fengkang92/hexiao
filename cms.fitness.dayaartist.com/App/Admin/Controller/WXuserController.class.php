<?php

namespace Admin\Controller;

use Think\Controller;

class WXuserController extends PublicController
{
    //***********************************
    // iframe式显示菜单和index页
    //**********************************
    public function index()
    {
        //构建搜索条件
        $where = '1=1 AND del=1';
//        搜索商品用户
        $where .= ' AND type = 1';
        if (IS_POST) {
            //搜索
            $gender = trim($_REQUEST['gender']);
            $create_time = intval(strtotime($_REQUEST['create_time']));
            $update_time = intval(strtotime($_REQUEST['update_time']));
//            print_r($gender);die();
            //根据性别搜索
            if ($gender) {
                $where .= ' AND gender=' . $gender;
                $this->assign('gender',$gender);
            }
            //根据创建时间搜索
            if ($create_time) {
                $where .= ' AND create_time>' . $create_time;
                $this->assign('create_time',date('Y-m-d',$create_time));
            }
            //根据登录时间搜索
            if ($update_time) {
                $where .= ' AND user.update_time>' . $update_time;
                $this->assign('update_time',date('Y-m-d',$update_time));
            }
        }

//        查询输出
        $userlist = M('user')->field('user.*,user_address.name,user_address.mobile,user_address.province,user_address.city,user_address.country,user_address.detail')->join('user_address on user.id = user_address.user_id', 'left')->where($where)->order('user.id desc')->select();
        foreach ($userlist as $k => $v) {
            $userlist[$k]['delete_time'] = date("Y-m-d H:i", $v['delete_time']);
            $userlist[$k]['create_time'] = date("Y-m-d H:i", $v['create_time']);
            $userlist[$k]['update_time'] = date("Y-m-d H:i", $v['update_time']);
        }
        //=============
        //将变量输出
        //=============
//        print_r($userlist);die();
        $this->assign('userlist', $userlist);
        $this->display();
    }

    /**
     * 显示预约用户信息
     */
    public function user()
    {
        //构建搜索条件
        $where = '1=1 AND del=1';
//        搜索商品用户
        $where .= ' AND type = 2';
        if (IS_POST) {
            //搜索
            $gender = trim($_REQUEST['gender']);
            $create_time = intval(strtotime($_REQUEST['create_time']));
            $update_time = intval(strtotime($_REQUEST['update_time']));
//            print_r($gender);die();
            //根据性别搜索
            if ($gender) {
                $where .= ' AND gender=' . $gender;
                $this->assign('gender',$gender);
            }
            //根据创建时间搜索
            if ($create_time) {
                $where .= ' AND create_time>' . $create_time;
                $this->assign('create_time',date('Y-m-d',$create_time));
            }
            //根据登录时间搜索
            if ($update_time) {
                $where .= ' AND user.update_time>' . $update_time;
                $this->assign('update_time',date('Y-m-d',$update_time));
            }
        }
//        查询输出
        $userlist = M('user')->where($where)->order('user.id desc')->select();
        foreach ($userlist as $k => $v) {
            $userlist[$k]['delete_time'] = date("Y-m-d H:i", $v['delete_time']);
            $userlist[$k]['create_time'] = date("Y-m-d H:i", $v['create_time']);
            $userlist[$k]['update_time'] = date("Y-m-d H:i", $v['update_time']);
        }

        //=============
        //将变量输出
        //=============
//        print_r($userlist);die();
        $this->assign('userlist', $userlist);
        $this->display();
    }

//    启用禁用状态修改
    public function del()
    {
        $id = $_GET['ids'];
        $info = M('user')->where('id=' . intval($id))->find();
        if (!$info) {
            $this->error('会员信息错误.' . __LINE__);
            exit();
        }

        $data = array();
        $data['del'] = $info['del'] == '1' ? 0 : 1;
        $up = M('user')->where('id=' . intval($id))->save($data);
        if ($up) {
            echo $data['del'];
        } else {
            $this->error('操作失败.');
            exit();
        }
    }

//更改消费状态
    public function status()
    {
        $id = $_GET['id'];
        $info = M('box_member_service')->where('id=' . intval($id))->find();
        if (!$info) {
            $this->error('信息错误.' . __LINE__);
            exit();
        }

        $data = array();
        $data['status'] = $info['status'] == '0' ? 1 : 0;
        $up = M('box_member_service')->where('id=' . intval($id))->save($data);
        if ($up) {
            $this->redirect('WXuser/user');
            exit();
        } else {
            $this->error('操作失败.');
            exit();
        }
    }

}