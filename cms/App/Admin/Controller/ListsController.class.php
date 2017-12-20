<?php

namespace Admin\Controller;

use Think\Controller;

class ListsController extends PublicController
{
    //***********************************
    // iframe式显示菜单和index页
    //**********************************
    public function lists()
    {
        $userlist = M('order')->where($where)->order('order.id desc')->select();
        foreach ($userlist as $k => $v) {
            $userlist[$k]['delete_time'] = date("Y-m-d H:i", $v['delete_time']);
            $userlist[$k]['create_time'] = date("Y-m-d H:i", $v['create_time']);
            $userlist[$k]['update_time'] = date("Y-m-d H:i", $v['update_time']);
        }
        //=============
        //将变量输出
        //=============
        $this->assign('count', $count);
        $this->assign('userlist', $userlist);
//        var_dump($userlist);die;
        $this->display();
    }

//    更改发货状态
    public function express()
    {
        $id = $_GET['id'];
        $info = M('order')->where('id=' . intval($id))->find();
        if (!$info) {
            $this->error('信息错误.' . __LINE__);
            exit();
        }

        $data = array();
        $data['status'] = $info['status'] == '2' ? 4 : 2;
        $up = M('order')->where('id=' . intval($id))->save($data);
        if ($up) {
            $this->redirect('Lists/lists');
            exit();
        } else {
            $this->error('操作失败.');
            exit();
        }
    }

//更改消费状态
    public function order()
    {
        $id = $_GET['id'];
        $info = M('order')->where('id=' . intval($id))->find();
        if (!$info) {
            $this->error('信息错误.' . __LINE__);
            exit();
        }

        $data = array();
        $data['status'] = $info['status'] == '2' ? 3 : 2;
        $up = M('order')->where('id=' . intval($id))->save($data);
        if ($up) {
            $this->redirect('Lists/lists');
            exit();
        } else {
            $this->error('操作失败.');
            exit();
        }
    }

    /*
*
* 构造函数，用于导入外部文件和公共方法
*/
    public function _initialize()
    {
        $this->order = M('Order');
    }


    /*
    *
    * 获取、查询所有订单数据
    */
    public function index()
    {
//	    查询盒子分类
        $box_course = M('box_course')->field('sid,name')->select();
        $this->assign('box_course', $box_course);
        //搜索
        $sid = trim($_REQUEST['box_course']);//盒子类型
        $supplier_id = trim($_REQUEST['box_course_plan']);//供应商
        $service_id = trim($_REQUEST['box_course_service']);//服务类型
        $start_time = intval(strtotime($_REQUEST['start_time'])); //订单状态
        $end_time = intval(strtotime($_REQUEST['end_time'])); //订单状态
        //构建搜索条件
        $condition = array();
        $condition['del'] = 1;
        $where = '1=1 AND del=1';
        //根据盒子类型搜索
        if ($sid) {
            $condition['sid'] = $sid;
            $where .= ' AND sid=' . $sid;
        }
        //根据供应商类型搜索
        if ($supplier_id) {
            $condition['supplier_id'] = $supplier_id;
            $where .= ' AND supplier_id=' . $supplier_id;
        }
        //根据服务类型搜索
        if ($service_id) {
            $condition['service_id'] = $service_id;
            $where .= ' AND service_id=' . $service_id;
        }
        //根据下单时间搜索
        if ($start_time) {
            $condition['create_time'] = array('gt', $start_time);
            $where .= ' AND create_time>' . $start_time;
            //搜索内容输出
            $this->assign('start_time', date("Y-m-d", $start_time));
        }
        //根据下单时间搜索
        if ($end_time) {
            $condition['create_time'] = array('lt', $end_time);
            $where .= ' AND create_time<' . $end_time;
            //搜索内容输出
            $this->assign('end_time', date("Y-m-d", $end_time));
        }

        $order_list = $this->order->where($where)->order('id desc')->select();
        //echo $where;
        foreach ($order_list as $k => $v) {
            $order_list[$k]['delete_time'] = date("Y-m-d H:i", $v['delete_time']);
            $order_list[$k]['create_time'] = date("Y-m-d H:i", $v['create_time']);
            $order_list[$k]['update_time'] = date("Y-m-d H:i", $v['update_time']);
        }
        $this->assign('order_list', $order_list);// 赋值数据集
        $this->display(); // 输出模板

    }

    /*
    * 商品获取plan分类
    */
    public function getsid()
    {
        $sid = intval($_REQUEST['sid']);
        $planlist = M('box_course_plan')->where('sid=' . intval($sid))->field('id,server_name')->select();
        echo json_encode(array('planlist' => $planlist));
        exit();
    }

    /*
    * 商品获取service分类
    */
    public function getpid()
    {
        $pid = intval($_REQUEST['pid']);
        $servicelist = M('box_course_service')->where('course_plan_id=' . intval($pid))->field('id,server_name')->select();
//        $servicelist = array_unique($servicelist);
//        $servicelist = array_flip(array_flip($servicelist));
        echo json_encode(array('servicelist' => $servicelist));
        exit();
    }

}