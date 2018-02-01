<?php

namespace Admin\Controller;

use Think\Controller;

class StatisticsController extends PublicController
{
    //***********************************
    // 财务统计
    //**********************************
    public function comment()
    {
        //查询所有老师
        $service_data = M('box_course_service as s')->field('id,sid,supplier_id,server_name,price,discount,tel')->select();

        foreach ($service_data as $k => $v) {
            $where = '1=1';
            $where .= ' AND service_id='.$v['id'];
            if (!empty($data['beginMonth']) && !empty($data['endMonth'])) {

                $where .= ' AND start_time>'.$data['beginMonth'].' AND start_time<'.$data['endMonth'];

            }else if(!empty($data['beginMonth']) && empty($data['endMonth'])){

                $where .= ' AND start_time>'.$data['beginMonth'];

            }else if(empty($data['beginMonth']) && !empty($data['endMonth'])){

                $where .= ' AND start_time<'.$data['endMonth'];

            }else if(empty($data['beginMonth']) && empty($data['endMonth'])){

                $beginMonth=mktime(0,0,0,date('m'),1,date('Y'));
                $endMonth=mktime(23,59,59,date('m'),date('t'),date('Y'));
                $where .= ' AND start_time>'.$beginMonth.' AND start_time<'.$endMonth;

            }
            //统计总价
            $count = M('box_service_time')->where($where)->count();
            $service_data[$k]['total'] = (int)$service_data[$k]['discount'] * (int)$count;

            //供应商名称
            $supplier_name = M('box_supplier')->where('id='.$v['supplier_id'])->getField('su_name');
            $service_data[$k]['supplier_name'] = $supplier_name;

            //空间服务名称
            $course_info = M('box_course')->field('name,chain_id')->where('sid='.$v['sid'])->find();
            $service_data[$k]['course_name'] = $course_info['name'];

            //分店名称
            $chain_name = M('chain')->where('id='.$course_info['chain_id'])->getField('ch_name');
            $service_data[$k]['chain_name'] = $chain_name;

        }
        return $service_data;
    }
    //***********************************
    // 个人财务统计
    //**********************************
    public function index()
    {
        //所有老师课程财务
        $service_data = $this->comment();
        //print_r($service_data);die;
        //同一老师工资合并
        $item=array();
        foreach($service_data as $k=>$v){
            if(!isset($item[$v['tel']])){
                $item[$v['tel']]=$v;
            }else{
                $item[$v['tel']]['total']+=$v['total'];
            }
        }
        //rint_r($item);die;
        $this->assign('service_data',$item);
        $this->display();
    }

    //财务总计
    public function total(){
        //所有老师课程财务
        $service_data = $this->comment();
        
        $this->display();
    }
}