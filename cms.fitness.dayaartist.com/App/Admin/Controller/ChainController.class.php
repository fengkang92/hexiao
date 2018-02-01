<?php

namespace Admin\Controller;

use Think\Controller;

class ChainController extends PublicController
{
    //***********************************
    // 分店列表
    //**********************************
    public function index()
    {
        //构建搜索条件
        $where = '1=1';
        if (IS_POST) {
            //搜索
            $status = trim($_REQUEST['status']);
            $create_time = intval(strtotime($_REQUEST['create_time']));
            //根据状态搜索
            if ($status) {
                $where .= ' AND status=' . $status;
                $this->assign('status',$status);
            }
            //根据创建时间搜索
            if ($create_time) {
                $where .= ' AND create_time>' . $create_time;
                $this->assign('create_time',date('Y-m-d',$create_time));
            }
        }

//        查询输出分店信息
        $chain_data = M('chain')->where($where)->select();
        foreach ($chain_data as $key => $v) {
            $chain_data[$key]['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
        }
        $chain_num = count($chain_data);
        $this->assign('num',$chain_num);
        $this->assign('chain_data',$chain_data);
        $this->display();
    }
    //***********************************
    // 修改状态
    //**********************************
    public function check_status()
    {
        try {
            $id = intval($_REQUEST['chain_id']);
            $info = M('chain')->where('id=' . intval($id))->find();
            if (!$info) {
                throw new \Exception('分店信息错误');
                exit();
            }

            $data = array();
            $data['status'] = $info['status'] == '1' ? 0 : 1;
            $up = M('chain')->where('id=' . intval($id))->save($data);
            if ($up) {
                echo $data['status'];
            } else {
                $e->getMessage();
                exit();
            }
        } catch (\Exception $e) {
            $this->error('编辑失败');
        }
    }
    //***********************************
    // 增 修改分店
    //**********************************
    public function operation()
    {
        if (IS_POST) {
            $data = I('post.');

            if (intval($_POST['id'])) {
                //修改
                $data['update_time'] = time();
                $result = M('chain')->where('id=' . intval($_POST['id']))->save($data);

            } else {
                //添加
                unset($data['id']);
                $data['create_time'] = time();
                $result = M('chain')->add($data);
            }

            if ($result) {
                $this->success('编辑成功', U('index'), 0);
            } else {
                $this->error('编辑失败');
            }
        } else {
            
            if ($_GET['id']) {
                $chain_data = M('chain')->where('id='.$_GET['id'])->find();
                $this->assign('chain_data',$chain_data);
            }

            $this->display();
        }
    }
}