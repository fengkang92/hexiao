<?php

namespace Admin\Controller;

use Think\Controller;

class ServiceController extends PublicController
{
    //***********************************
    // iframe式显示菜单和index页
    //**********************************
    public function index()
    {
        $menu = "";
        $index = "";
        $menu = "<include File='Page/adminusermenu'/>";
        $index = "<iframe src='" . U('Page/adminindex') . "' id='iframe' name='iframe'></iframe>";


        $this->assign('menu', $menu);
        $this->assign('index', $index);
        $this->display();
    }

    public function lists()
    {
        $service_info = M('box_course_service as service')
            ->join('box_course as course on course.sid=service.sid', left)
            ->field('service.*,course.name')
            ->select();
        $count = count($service_info);
//        print_r($count);die;
        $this->assign('count', $count);
        $this->assign('service_info', $service_info);
        $this->display();
    }

    public function add()
    {
        if (IS_POST) {
            //上传老师图片
            if (!empty($_FILES["file"]["tmp_name"])) {
                //文件上传
                $info = $this->upload_images($_FILES["file"], array('jpg', 'png', 'jpeg'), "Service/" . date(Ymd));
                if (!is_array($info)) {// 上传错误提示错误信息
                    throw new \Exception('图片上传失败.');
                } else {// 上传成功 获取上传文件信息
                    $main_img_url = '/Data/UploadFiles/' . $info['savepath'] . $info['savename'];
                }
            }
            $data = I('post.');
//            print_r($data);die();

            if (intval($_POST['id'])) {
//                print_r($data);die;

                //修改
                $data['course_plan_id'] = $data['box_course_plan'];
                $data['sid'] = $data['box_course'];
                $data['supplier_id'] = $data['box_supplier'];
                $data['main_img_url'] = $main_img_url;
                $data['introduce'] = $data['editorValue'];
                $data['create_time'] = time();
                $data = array_filter($data);
                $data['update_time'] = time();
//                print_r($data);die();
                $result = M('box_course_service')->where('id=' . intval($_POST['id']))->save($data);

            } else {
                //添加
                unset($data['id']);
                $data['course_plan_id'] = $data['box_course_plan'];
                $data['sid'] = $data['box_course'];
                $data['supplier_id'] = $data['box_supplier'];
                $data['main_img_url'] = $main_img_url;
                $data['introduce'] = $data['editorValue'];
                $data['create_time'] = time();
                $data = array_filter($data);
//                print_r($data);die();
                $result = M('box_course_service')->add($data);
            }

            if ($result) {
                $this->success('编辑成功', U('Service/lists'), 0);
            } else {
                $this->error('编辑失败');
            }

        } else {
            if ($_GET['id']) {
                $courseService = M('box_course_service as service')
                    ->join('box_course as course on course.sid = service.sid', 'left')
                    ->where('service.id = ' . $_GET['id'])
                    ->find();
//                print_r($courseService);die();
                $chain_id = M('chain')->where('id='.$courseService['chain_id'])->find();
                $course_id = M('box_course')->where('sid='.$courseService['sid'])->find();
                $supplier_id = M('box_supplier')->where('id='.$courseService['supplier_id'])->find();
                $plan_id = M('box_course_plan')->where('id='.$courseService['course_plan_id'])->find();
                $this->assign('courseService', $courseService);
                $this->assign('chain_id', $chain_id);
                $this->assign('course_id', $course_id);
                $this->assign('supplier_id', $supplier_id);
                $this->assign('plan_id', $plan_id);
            }
            //	    查询分店
            $chain = M('chain')->field('id,ch_name')->select();
            $this->assign('chain', $chain);
            $this->display();
        }
    }

    /*
    * 商品获取盒子分类
    */
    public function getcid()
    {
        $id = intval($_REQUEST['id']);
        $courselist = M('box_course')->where('chain_id=' . intval($id))->field('sid,name')->select();
        echo json_encode(array('courselist' => $courselist));
        exit();
    }

    /*
    * 商品获取供应商分类
    */
    public function getsid()
    {
        $sid = intval($_REQUEST['sid']);
        $supplierlist = M('box_supplier')->where('sid=' . intval($sid))->field('id,su_name')->select();
        echo json_encode(array('supplierlist' => $supplierlist));
        exit();
    }

    /*
    * 商品获取service分类
    */
    public function getpid()
    {
        $suid = intval($_REQUEST['suid']);
        $planlist = M('box_course_plan')->where('suppiler_id=' . intval($suid))->field('id,server_name')->select();
        echo json_encode(array('planlist' => $planlist));
        exit();
    }

}