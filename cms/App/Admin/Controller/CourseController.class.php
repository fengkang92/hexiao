<?php

namespace Admin\Controller;

use Think\Controller;

class CourseController extends PublicController
{
    //***********************************
    // 分店列表
    //**********************************
    public function index()
    {
//        查询分类信息
        $category = M('category')->field('id,name')->select();
        $this->assign('category',$category);
        //构建搜索条件
        $where = '1=1';
        if (IS_POST) {
            //搜索
            $category_id = trim($_REQUEST['category_id']);
            $status = trim($_REQUEST['status']);
            //根据分类搜索
            if ($category_id) {
                $where .= ' AND category_id=' . $category_id;
                $this->assign('category_id',$category_id);
            }
            //根据状态搜索
            if ($status) {
                $where .= ' AND status=' . $status;
                $this->assign('status',$status);
            }
        }

//        查询输出信息
        $course_data = M('box_course as course')
                     ->field('course.sid,course.name as course_name,cate.name as cate_name,address,device_name,relationship,status,category_id')
                     ->join('category as cate on course.category_id=cate.id')
                     ->where($where)
                     ->select();
        $chain_num = count($course_data);
        $this->assign('num',$chain_num);
        $this->assign('course_data',$course_data);
        $this->display();
    }
    //***********************************
    // 修改状态
    //**********************************
    public function check_status()
    {
        try {
            $id = intval($_REQUEST['course_id']);
            $info = M('box_course')->where('sid=' . intval($id))->find();
            if (!$info) {
                throw new \Exception('空间信息错误');
                exit();
            }

            $data = array();
            $data['status'] = $info['status'] == '1' ? 0 : 1;
            $up = M('box_course')->where('sid=' . intval($id))->save($data);
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
                //print_r($data);die;
                $data = array_filter($data);
                //修改
                $data['update_time'] = time();
                $result = M('box_course')->where('sid=' . intval($_POST['id']))->save($data);

            } else {
                //添加
                unset($data['id']);
                $data['create_time'] = time();
                $result = M('box_course')->add($data);
            }

            if ($result) {
                $this->success('编辑成功', U('index'), 0);
            } else {
                $this->error('编辑失败');
            }
        } else {

            if ($_GET['id']) {
                $course_data = M('box_course')->where('sid='.$_GET['id'])->find();
                if (empty($course_data)) {
                    $this->error('空间不存在');die;
                }
                $this->assign('course_data',$course_data);
            }

            $chain_data = M('chain')->select();
            $category_data = M('category')->select();
            $this->assign('chain_data',$chain_data);
            $this->assign('category_data',$category_data);
            $this->display();
        }
    }
}