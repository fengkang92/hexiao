<?php

namespace Admin\Controller;

use Think\Controller;

class ExcelsController extends Controller
{

    public function exportExcel($expTitle,$expCellName,$expTableData)
    {
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName = $expTitle.'表';//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);

        vendor("PHPExcel.PHPExcel");
            
        $objPHPExcel = new \PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');

        //合并单元格
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'表');
        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]);
        }
        // Miscellaneous glyphs, UTF-8
        for($i=0;$i<$dataNum;$i++){
            for($j=0;$j<$cellNum;$j++){
                $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
            }
        }

        /*$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(100);*/
        foreach ($cellName as $k) {
            if ($k!='A') {
                $objPHPExcel->getActiveSheet()->getColumnDimension($k)->setWidth(15);
            }
        }

        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    //***********************************
    // 商品导出
    //**********************************
    public function expProduct()
    {

        $xlsName  = "商品导出";//导出的文件名
        //要导出的信息
        $xlsCell  = array(
            array('id','商品ID'),
            array('pname','商品名称'),
            array('cname','分类'),
            array('summary','类型'),
            array('describe','副标题'),
            array('price','原价'),
            array('discount_price','折扣价'),
            array('unit','计量单位'),
            array('tag','标签'),
            array('duration','有效时间'),
            array('hot','推荐'),
            array('discount','折扣'),
            array('del','状态'),
        );

        $category_id = I('get.category_id');
        $summary = I('get.summary');
        $hot = I('get.hot');
        $discount = I('get.discount');
        $del = I('get.del');
        $where = array();
        //商品类型
        if(($summary) != '' ){

            $where['summary'] = $summary;

        }
        //商品分类
        if ($category_id != '') {

            $where['category_id'] = $category_id;

        }

        //推荐
        if ($hot != '') {

            $where['hot'] = $hot;

        }

        //折扣
        if ($discount != '') {

            $where['discount'] = $discount;

        }

        //商品上下架
        if ($del != '') {

            $where['del'] = $del;

        }

        $xlsData = M('product as p')
            ->field('p.id,c.name as cname,p.name as pname,main_img_url,t.name as tname,detail,price,duration,address,describe,stock,p.from as pfrom,summary,del,content,hot,discount,discount_price,unit')
            ->join('category as c on p.category_id=c.id','left')
            ->join('product_tag as t on p.id=t.product_id','left')
            ->where($where)
            ->select();
        foreach ($xlsData as $key => $value) {
            $xlsData[$key]['tag'] = $xlsData[$key]['tname'] . ',' . $xlsData[$key]['detail'];
            $xlsData[$key]['summary']=$xlsData[$key]['summary']==1 ? "主题活动" : "传统商品";
            $xlsData[$key]['hot']=$xlsData[$key]['hot']==1 ? "是" : "否";
            $xlsData[$key]['discount']=$xlsData[$key]['discount']==1 ? "是" : "否";
            $xlsData[$key]['del']=$xlsData[$key]['del']==1 ? "是" : "否";
            unset($xlsData[$key]['tname']);
            unset($xlsData[$key]['detail']);
        }

        $this->exportExcel($xlsName,$xlsCell,$xlsData);

    }


    //***********************************
    // 用户导出
    //**********************************
    public function expWXuser()
    {

        $xlsName  = "用户导出";//导出的文件名
        //要导出的信息
        $xlsCell  = array(
            array('id','用户ID'),
            array('name','用户名'),
            array('gender','性别'),
            array('avatarurl','头像'),
            array('mobile','手机号'),
            array('province','收货地址'),
            array('create_time','创建时间'),
            array('update_time','登陆时间'),
        );

        $gender = I('get.gender');
        $create_time = I('get.create_time');
        $update_time = I('get.update_time');
        $type = I('get.type');
        $where = array();
        //搜索条件
        if(($gender) != '' ){
            $where['gender'] = $gender;
        }
        if(($create_time) != '' ){
            $where['create_time'] = array('egt',intval(strtotime($create_time)));
        }
        if(($update_time) != '' ){
            $where['update_time'] = array('egt',intval(strtotime($update_time)));
        }
        if(($type) != '' ){
            $where['type'] = $type;
        }

        $xlsData = M('user')->field('user.*,user_address.name,user_address.mobile,user_address.province,user_address.city,user_address.country,user_address.detail')->join('user_address on user.id = user_address.user_id', 'left')->where($where)->order('user.id desc')->select();
//        echo M('user')->getLastSql();die();
        foreach ($xlsData as $k => $v) {
            $xlsData[$k]['delete_time'] = date("Y-m-d H:i", $v['delete_time']);
            $xlsData[$k]['create_time'] = date("Y-m-d H:i", $v['create_time']);
            $xlsData[$k]['update_time'] = date("Y-m-d H:i", $v['update_time']);
            if($xlsData[$k]['gender'] ==1){
                $xlsData[$k]['gender'] = '男';
            }
            elseif($xlsData[$k]['gender'] ==2){
                $xlsData[$k]['gender'] = '女';
            }
            else{
                $xlsData[$k]['gender'] = '未填写';
            }
            $xlsData[$k]['province'] = $xlsData[$k]['province'].$xlsData[$k]['city'].$xlsData[$k]['country'].$xlsData[$k]['detail'];
        }

        $this->exportExcel($xlsName,$xlsCell,$xlsData);

    }

    //***********************************
    // 分店导出
    //**********************************
    public function expChain()
    {

        $xlsName  = "分店导出";//导出的文件名
        //要导出的信息
        $xlsCell  = array(
            array('id','分店ID'),
            array('ch_name','名称'),
            array('adress','地址'),
            array('create_time','创建时间'),
            array('status','状态'),
        );

        $status = I('get.status');
        $create_time = I('get.create_time');
        $where = array();
        //搜索条件
        if(($status) != '' ){
            $where['status'] = $status;
        }
        if(($create_time) != '' ){
            $where['create_time'] = array('egt',intval(strtotime($create_time)));
        }

        $xlsData = M('chain')->where($where)->select();
//        echo M('user')->getLastSql();die();
        foreach ($xlsData as $k => $v) {
            $xlsData[$k]['delete_time'] = date("Y-m-d H:i", $v['delete_time']);
            $xlsData[$k]['create_time'] = date("Y-m-d H:i", $v['create_time']);
            $xlsData[$k]['update_time'] = date("Y-m-d H:i", $v['update_time']);
            if($xlsData[$k]['status'] ==1){
                $xlsData[$k]['status'] = '正常';
            }
            elseif($xlsData[$k]['status'] ==2){
                $xlsData[$k]['status'] = '禁用';
            }
        }

        $this->exportExcel($xlsName,$xlsCell,$xlsData);

    }

    //***********************************
    // 空间服务导出
    //**********************************
    public function expCourse()
    {

        $xlsName  = "空间服务导出";//导出的文件名
        //要导出的信息
        $xlsCell  = array(
            array('sid','ID'),
            array('course_name','名称'),
            array('cate_name','分类'),
            array('address','地址'),
            array('device_name','设备名称'),
            array('relationship','上限'),
            array('status','状态'),
        );

        $category_id = I('get.category_id');
        $status = I('get.status');
        $where = array();
        //搜索条件
        if(($category_id) != '' ){
            $where['category_id'] = $category_id;
        }
        if(($status) != '' ){
            $where['status'] = $status;
        }

        $xlsData = M('box_course as course')
                    ->field('course.sid,course.name as course_name,cate.name as cate_name,address,device_name,relationship,status,category_id')
                    ->join('category as cate on course.category_id=cate.id')
                    ->where($where)
                    ->select();
//        echo M('user')->getLastSql();die();
        foreach ($xlsData as $k => $v) {
            $xlsData[$k]['delete_time'] = date("Y-m-d H:i", $v['delete_time']);
            $xlsData[$k]['create_time'] = date("Y-m-d H:i", $v['create_time']);
            $xlsData[$k]['update_time'] = date("Y-m-d H:i", $v['update_time']);
            if($xlsData[$k]['status'] ==1){
                $xlsData[$k]['status'] = '正常';
            }
            elseif($xlsData[$k]['status'] ==2){
                $xlsData[$k]['status'] = '禁用';
            }
        }

        $this->exportExcel($xlsName,$xlsCell,$xlsData);

    }

    //***********************************
    // 空间服务导出
    //**********************************
    public function expSupplier()
    {

        $xlsName  = "供应商导出";//导出的文件名
        //要导出的信息
        $xlsCell  = array(
            array('id','ID'),
            array('name','名称'),
            array('email','邮箱'),
            array('cate_name','分类'),
            array('description','简介'),
            array('status','状态'),
        );

        $category_id = I('get.category_id');
        $status = I('get.status');
        $where = array();
        //搜索条件
        if(($category_id) != '' ){
            $where['category_id'] = $category_id;
        }
        if(($status) != '' ){
            $where['status'] = $status;
        }

        $xlsData = M('box_supplier as s')
            ->field('s.id,s.su_name as name,s.su_email as email,s.category_id,cate.name as cate_name,s.description,cs.status,cs.check_info')
            ->join('box_course_supplier as cs on s.id=cs.suppiler_id')
            ->join('category as cate on s.category_id=cate.id')
            ->where($where)
            ->select();
//        echo M('user')->getLastSql();die();
        foreach ($xlsData as $k => $v) {
            $xlsData[$k]['delete_time'] = date("Y-m-d H:i", $v['delete_time']);
            $xlsData[$k]['create_time'] = date("Y-m-d H:i", $v['create_time']);
            $xlsData[$k]['update_time'] = date("Y-m-d H:i", $v['update_time']);
            if($xlsData[$k]['status'] ==1){
                $xlsData[$k]['status'] = '正常';
            }
            elseif($xlsData[$k]['status'] ==2){
                $xlsData[$k]['status'] = '待审核';
            }
        }

        $this->exportExcel($xlsName,$xlsCell,$xlsData);

    }

}