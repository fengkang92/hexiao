<?php

namespace Admin\Controller;

use Think\Controller;

class BookingController extends PublicController
{
    public function service()
    {
        $week_start = date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")-date("w")+1,date("Y")));  
        $week_end = date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y")));

        $where['start_time'] = array('GT',strtotime($week_start));
        $where['end_time'] = array('LT',strtotime($week_end));

        $arrange = M('box_service_time as st')
                 ->field('st.id,cp.server_name as course_plan_name,cs.server_name as course_service_name,tel,start_time,end_time,price,st.status')
//                 ->where($where)
                 ->join('box_course_service as cs on st.service_id=cs.id')
                 ->join('box_course_plan as cp on cs.course_plan_id=cp.id')
                 ->select();
        //print_r($arrange);die;

        foreach ($arrange as $key => $v) {
            $arrange[$key]['start_time'] = date('Y-m-d H:i:s',$v['start_time']);
            $arrange[$key]['end_time'] = date('Y-m-d H:i:s',$v['end_time']);
        }

        //=============
        //将变量输出
        //=============
        $this->assign('arrange', $arrange);
        $this->display();
    }

    public function add_time()
    {
        if (IS_POST) {
            try {
                $Model = M(); // 实例化一个空对象
                $Model->startTrans(); // 开启事务

                $data = I('post.');
                $data['initial_stock'] = $data['stock'];
                

                if (empty(($data['about_stime'][0]))) {
                    throw new \Exception('时间不能为空');
                    exit();
                }

                for ($i = 0; $i < count($data['about_stime']); $i++) {
                    if ($data['about_stime'][$i] > $data['about_etime'][$i]) {
                        throw new \Exception('结束时间必须大于开始时间,请重新添加');
                        exit();
                    }
                    $about_array[] = array('start_time' => strtotime($data['about_stime'][$i]), 'end_time' => strtotime($data['about_etime'][$i]), 'service_id' => $data['box_course_service'],'stock' => $data['stock'],'initial_stock' => $data['stock']);
                }
                
                

                if (intval($_POST['id'])) {
                    //修改
                    $about_array['update_time'] = time();
                    $result = M('box_service_time')->where('id=' . intval($_POST['id']))->save($data);

                }else{

                    $result = M('box_service_time')->addAll($about_array);

                }

                if ($result) {
                    $Model->commit(); // 成功则提交事务
                    $this->success('编辑成功', U('Admin/Booking/service'));
                }

            } catch (\Exception $e) {
                $Model->rollback(); // 否则将事务回滚
                $this->error($e->getMessage());
            }

        } else {
            if ($_GET['id']) {
                $id = $_GET['id'];

                $time_info = M('box_service_time')->where('id='.$_GET['id'])->find();
                if (empty($time_info)) {
                    $this->error('参数有误');
                }
                //print_r($time_info);die;
                $data = array();

                $service_data = M('box_course_service')->where('id='.$time_info['service_id'])->find();
                //print_r($service_data);die;
                //获取分店ID
                $chain = M('box_course')->field('chain_id')->where('sid='.$service_data['sid'])->find();
                
                //获取盒子
                $course_data = M('box_course')->field('sid,name')->where('chain_id='.$chain['chain_id'])->select();

                //获取供应商
                $suppiler_id = M('box_course_supplier')->where('sid=' . intval($service_data['sid']))->getField('suppiler_id',true);
                $suppiler_id = implode(',', $suppiler_id);
        
                $where['id'] = array('in',$suppiler_id);
                $supplier_data = M('box_supplier')->where($where)->field('id,su_name')->select();

                //获取课程
                $curr_data = M('box_course_plan')->field('id,server_name')->where('suppiler_id='.$service_data['supplier_id'])->select();

                //获取老师
                $teacher_where = array('course_plan_id'=>$service_data['course_plan_id'],'supplier_id'=>$service_data['supplier_id']);
                $teacher_data = M('box_course_service')->field('id,server_name')->where($teacher_where)->select();

                //预约信息
                $data = array('id'=>$id,'chain_id'=>$chain['chain_id'],'sid'=>$service_data['sid'],'supplier_id'=>$service_data['supplier_id'],'course_plan_id'=>$service_data['course_plan_id'],'service_id'=>$time_info['service_id'],'stock'=>$time_info['stock'],'start_time'=>date('Y-m-d H:i:s',$time_info['start_time']),'end_time'=>date('Y-m-d H:i:s',$time_info['end_time']));
                //print_r($data);die;
                $this->assign('course_data',$course_data);
                $this->assign('supplier_data',$supplier_data);
                $this->assign('curr_data',$curr_data);
                $this->assign('teacher_data',$teacher_data);

                $this->assign('data',$data);

            }
            //查询分店
            $chain = M('chain')->field('id,ch_name')->select();
            $this->assign('chain', $chain);
            $this->display();
        }
    }

    /*
    * 获取分店盒子
    */
    public function getCourse()
    {
        $chid = I('get.chid');
        $course = M('box_course')->field('sid,name')->where('chain_id='.$chid)->select();
        echo json_encode($course);
    }

    /*
    * 获取盒子供应商
    */
    public function getsid()
    {
        $data = array('code'=>'','message'=>'','value'=>'');
        $sid = intval($_REQUEST['sid']);
        $suppiler_id = M('box_course_supplier')->where('sid=' . intval($sid))->getField('suppiler_id',true);
        if (empty($suppiler_id)) {
            $data['code'] = -1;
            $data['message'] = '该分类下没有供应商，请先添加';
            echo json_encode($data);die;
        }

        $suppiler_id = implode(',', $suppiler_id);
        
        $where['id'] = array('in',$suppiler_id);
        $supplier_data = M('box_supplier')->where($where)->field('id,su_name')->select();
        $data = array('code'=>1,'message'=>'成功','value'=>$supplier_data);
        echo json_encode($data);
    }

    /*
    * 获取供应商课程
    */
    public function getpid()
    {
        $supplier_id = intval($_REQUEST['supplier_id']);
        $course_plan = M('box_course_plan')->where('suppiler_id=' . intval($supplier_id))->field('id,server_name')->select();
        echo json_encode(array('course_plan' => $course_plan));
        exit();
    }

    /*
    * 获取课程老师
    */
    public function getTeacher()
    {
        $course_plan_id = intval($_REQUEST['course_plan_id']);
        $supplier_id = intval($_REQUEST['supplier_id']);
        $where = array('course_plan_id'=>intval($course_plan_id),'supplier_id'=>$supplier_id);
        $course_service = M('box_course_service')->where($where)->field('id,server_name')->select();
        echo json_encode(array('course_service' => $course_service));
        exit();
    }

    /*
    * 预览课程详情
    */
    public function service_preview()
    {
        $id = I('get.id');
        //课程信息
        $curr_data = M('box_service_time st')
                   ->field('st.id,cs.sid,cp.server_name as course_plan_name,cs.server_name as course_service_name,tel,start_time,end_time,price,st.status,initial_stock')
                   ->where('st.id='.$id)
                   ->join('box_course_service as cs on st.service_id=cs.id')
                   ->join('box_course_plan as cp on cs.course_plan_id=cp.id')
                   ->find();
        //print_r($curr_data);die;
        $address = M('box_course')->where('sid='.$curr_data['sid'])->getField('address');
        $curr_data['address'] = $address;

        $curr_data['start_time'] = date('Y-m-d H:i:s',$curr_data['start_time']);
        $curr_data['end_time'] = date('Y-m-d H:i:s',$curr_data['end_time']);
       
        //学生信息
        $member_info = M('box_member_service')->where('service_time_id='.$id)->select();

        //已预约人数
        $total = count($member_info);
        $curr_data['num'] = $total;

        //实到人数
        $where = array('service_time_id'=>$id,'status'=>1);
        $arrive_num = M('box_member_service')->where($where)->count();
        $curr_data['arrive_num'] = $arrive_num;

        //print_r($member_info);die;
        
        $this->assign('curr_data',$curr_data);
        $this->assign('member_info',$member_info);
        $this->display();
    }
}