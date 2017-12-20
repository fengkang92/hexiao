<?php

namespace Admin\Controller;

use Think\Controller;

class ShopController extends PublicController
{
    //***********************************
    // 商品列表
    //**********************************
    public function product()
    {
        if (IS_POST) {
            $data = I('post.');

            if (!empty($data)) {
                //商品类型
                if(($data['summary']) != '' ){

                    $where['summary'] = $data['summary']; 

                    $this->assign('summary',$data['summary']);
                }
                //商品分类
                if (!empty($data['category_id'])) {

                    $where['category_id'] = $data['category_id'];

                    $this->assign('category_id',$data['category_id']);
                }

                //推荐
                if ($data['hot'] != '') {

                    $where['hot'] = $data['hot'];

                    $this->assign('hot',$data['hot']);
                }

                //折扣
                if ($data['discount'] != '') {

                    $where['discount'] = $data['discount'];

                    $this->assign('discount',$data['discount']);
                }

                //商品上下架
                if ($data['del'] != '') {

                    $where['del'] = $data['del'];

                    $this->assign('del',$data['del']);
                }
            }
            //print_r($where);die;
        }
        
        //print_r($where);die;
        $product_data = M('product as p')
            ->field('p.id,c.name as cname,p.name as pname,main_img_url,t.name as tname,detail,price,duration,address,describe,stock,p.from as pfrom,summary,del,content,hot,discount')
            ->join('category as c on p.category_id=c.id','left')
            ->join('product_tag as t on p.id=t.product_id','left')
            ->where($where)
            ->select();
        foreach ($product_data as $key => $value) {
            $product_data[$key]['tag'] = $product_data[$key]['tname'] . ',' . $product_data[$key]['detail'];
            unset($product_data[$key]['tname']);
            unset($product_data[$key]['detail']);
        }

        //分类
        $category_data = M('category')->field('id,name')->select();

        //print_r($product_data);die;
        //=============
        //将变量输出
        //=============
        $this->assign('category_data', $category_data);
        $this->assign('product_data', $product_data);

        $this->display();
    }

    //***********************************
    // 商品添加
    //**********************************
    public function addGoods()
    {
        if (IS_POST) {
            try {
                //print_r(I('post.'));die;
                $Model = M(); // 实例化一个空对象  
                $Model->startTrans(); // 开启事务

                //上传商品图片
                //print_r(I('post.'));die;
                //上传产品小图
                if (!empty($_FILES["file"]["tmp_name"])) {
                    //文件上传
                    $info = $this->upload_images($_FILES["file"], array('jpg', 'png', 'jpeg'), "product/" . date(Ymd));
                    if (!is_array($info)) {// 上传错误提示错误信息
                        throw new \Exception('图片上传失败.');
                    } else {// 上传成功 获取上传文件信息
                        $img_url = '/Data/UploadFiles/' . $info['savepath'] . $info['savename'];
                    }
                }
                //上传产品首页展示图
                if (!empty($_FILES["file_home"]["tmp_name"])) {
                    //文件上传
                    $info = $this->upload_images($_FILES["file_home"], array('jpg', 'png', 'jpeg'), "product/" . date(Ymd));
                    if (!is_array($info)) {// 上传错误提示错误信息
                        throw new \Exception('图片上传失败.');
                    } else {// 上传成功 获取上传文件信息
                        $img_url_home = '/Data/UploadFiles/' . $info['savepath'] . $info['savename'];

                    }
                }
                //商品详情添加
                if ($img_url) {
                    $data = I('post.');
                    //print_r($data);die;
                    $pro_array = array();
                    if ($data['summary'] == 1) {
                        if ($data['start_time'] > $data['end_time']) {
                            throw new \Exception('开始时间必须大于结束时间');
                        }

                        $start_time = str_replace('-', '.', $data['start_time']);
                        $end_time = str_replace('-', '.', $data['end_time']);
                        $pro_array['duration'] = $start_time.'-'.$end_time;
                        $pro_array['address'] = $data['address'];
                    }
                    //print_r($pro_array);die;
                    $pro_array['name'] = $data['name'];
                    $pro_array['describe'] = $data['describe'];
                    $pro_array['unit'] = $data['unit'];
                    $pro_array['price'] = $data['price'];
                    $pro_array['stock'] = $data['stock'];
                    $pro_array['category_id'] = $data['category_id'];
                    $pro_array['main_img_url'] = $img_url;
                    $pro_array['home_img_url'] = $img_url_home;
                    $pro_array['create_time'] = time();
                    $pro_array['summary'] = $data['summary'];
                    $pro_array['content'] = $data['editorValue'];
                    $pro_array['hot'] = $data['hot'];

                    //print_r($pro_array);die;
                    $product_id = M('product')->add($pro_array);

                    if ($product_id) {

                        if ($data['summary'] == 1) {
                            //添加预约时间
                            if (!empty(($data['about_stime'][0]))) {
                                for ($i = 0; $i < count($data['about_stime']); $i++) {
                                    $about_array[] = array('start_time' => $data['about_stime'][$i], 'end_time' => $data['about_etime'][$i], 'product_id' => $product_id);
                                }
                                $product_time = M('product_time')->addAll($about_array);
                            }
                        }
                        

                        //添加产品参数
                        for ($i = 0; $i < count($data['parameter']); $i++) {
                            $parameter_info = explode('：', $data['parameter'][$i]);
                            $parameter_arr[] = array('name' => $parameter_info[0], 'detail' => $parameter_info[1], 'product_id' => $product_id);
                        }
                        $product_feature = M('product_property')->addAll($parameter_arr);
                        
                        //添加商品规格
                        //判断几个规格
                        if (!empty($data['feature'])) {
                            if (strpos($data['feature'], '|') == false) {
                                $feature_array[] = array('feature' => $data['feature'], 'product_id' => $product_id);
                            } else {
                                $feature_info = explode('|', $data['feature']);
                                for ($i = 0; $i < count($feature_info); $i++) {
                                    $feature_array[] = array('feature' => $feature_info[$i], 'product_id' => $product_id);
                                }
                            }
                            $product_feature = M('product_feature')->addAll($feature_array);
                        }

                        //添加商品标签
                        //判断几个标签
                        if (strpos($data['label'], '|') == false) {
                            $label_array = array('name' => $data['label'], 'product_id' => $product_id);
                        } else {
                            $label_info = explode('|', $data['label']);
                            $label_array = array('name' => $label_info[0], 'detail' => $label_info[1], 'product_id' => $product_id);
                        }
                        $product_tag = M('product_tag')->add($label_array);

                    }
                }

                if ($img_url && $product_id && $product_tag) {

                    $Model->commit(); // 成功则提交事务
                    $this->success('编辑成功', U('Admin/Shop/product'));

                } else {

                    throw new \Exception('编辑失败,请重新编辑');

                }


            } catch (\Exception $e) {
                // 否则将事务回滚
                $Model->rollback();
                $this->error($e->getMessage());
            }

        } else {
            $category_data = M('category')->select();
            $this->assign('category_data',$category_data);
            $this->display();
        }
    }


    //***********************************
    // 商品修改
    //**********************************
    public function product_edit()
    {
        if (IS_POST) {
            try {
                $data = I('post.');

                $Model = M(); // 实例化一个空对象  
                $Model->startTrans(); // 开启事务

                //上传商品图片
                //print_r(I('post.'));die;
                //上传产品小图
                if (!empty($_FILES["file"]["tmp_name"])) {
                    //文件上传
                    $info = $this->upload_images($_FILES["file"], array('jpg', 'png', 'jpeg'), "product/" . date(Ymd));
                    if (!is_array($info)) {// 上传错误提示错误信息
                        throw new \Exception('图片上传失败.');
                    } else {// 上传成功 获取上传文件信息
                        $img_url = '/Data/UploadFiles/' . $info['savepath'] . $info['savename'];
                        $img_array = array(
                            'url' => $img_url,
                            'create_time' => time()
                        );
                        
                        $imgage_id = M('image')->add($img_array);
                    }
                }

                //上传产品首页展示图
                if (!empty($_FILES["file_home"]["tmp_name"])) {
                    //文件上传
                    $info = $this->upload_images($_FILES["file_home"], array('jpg', 'png', 'jpeg'), "product/" . date(Ymd));
                    if (!is_array($info)) {// 上传错误提示错误信息
                        throw new \Exception('图片上传失败.');
                    } else {// 上传成功 获取上传文件信息
                        $img_url_home = '/Data/UploadFiles/' . $info['savepath'] . $info['savename'];
                    }
                }

                //商品详情修改
                $start_time = str_replace('-', '.', $data['start_time']);
                $end_time = str_replace('-', '.', $data['end_time']);
                $pro_array = array(
                    'name' => $data['name'],
                    'describe' => $data['describe'],
                    'content' => $data['editorValue'],
                    'duration' => $start_time . '-' . $end_time,
                    'address' => $data['address'],
                    'price' => (float)$data['price'],
                    'stock' => $data['stock'],
                    'category_id' => (int)$data['category_id'],
                    'main_img_url' => $img_url,
                    'home_img_url' => $img_url_home,
                    'create_time' => time(),
                    'img_id' => $imgage_id,
                    'hot' => $data['hot'],
                    'unit' => $data['unit']
                );

                $pro_array = array_filter($pro_array);
                $pro_array['summary'] = $data['summary'];
                $pro_array['stock'] = $data['stock'];
                //print_r($pro_array);die;
                $pro_res = M('product')->where('id=' . $data['product_id'])->save($pro_array);

                //添加预约时间
                if (!empty(($data['about_stime'][0]))) {
                    for ($i = 0; $i < count($data['about_stime']); $i++) {
                        $about_array[] = array('start_time' => $data['about_stime'][$i], 'end_time' => $data['about_etime'][$i], 'product_id' => $data['product_id']);
                    }
                    $time_res = M('product_time')->addAll($about_array);
                }

                if (!empty($data['feature'])) {
                    //添加商品规格
                    //判断几个规格
                    if (strpos($data['feature'], '|') == false) {
                        $feature_array[] = array('feature' => $data['feature'], 'product_id' => $data['product_id']);
                    } else {
                        $feature_info = explode('，', $data['feature']);
                        for ($i = 0; $i < count($feature_info); $i++) {
                            $feature_array[] = array('feature' => $feature_info[$i], 'product_id' => $data['product_id']);
                        }
                    }
                    M('product_feature')->where('product_id=' . $data['product_id'])->delete();
                    $feature_res = M('product_feature')->addAll($feature_array);
                }

                //修改商品标签
                //判断几个标签
                if (strpos($data['label'], '|') == false) {
                    $label_array = array('name' => $data['label'], 'detail' => '', 'product_id' => $data['product_id']);
                    $tag_res = M('product_tag')->where('product_id=' . $data['product_id'])->save($label_array);
                } else {
                    $label_info = explode('|', $data['label']);
                    $label_array = array('name' => $label_info[0], 'detail' => $label_info[1], 'product_id' => $data['product_id']);
                    $tag_res = M('product_tag')->where('product_id=' . $data['product_id'])->save($label_array);
                }

                //修改产品参数
                for ($i = 0; $i < count($data['parameter']); $i++) {
                    $parameter_info = explode('：', $data['parameter'][$i]);
                    $parameter_arr[] = array('name' => $parameter_info[0], 'detail' => $parameter_info[1], 'product_id' => $data['product_id']);
                }


                M('product_property')->where('product_id=' . $data['product_id'])->delete();
                $product_property = M('product_property')->addAll($parameter_arr);

                if ($pro_res || $tag_res || $product_property) {
                    $Model->commit(); // 成功则提交事务
                    $this->success('编辑成功', U('Admin/Shop/product'));
                } else {    

                    throw new \Exception('编辑失败，请重新编辑');
                }

            } catch (\Exception $e) {
                $Model->rollback(); // 否则将事务回滚
                $this->error($e->getMessage());
            }

        } else {
            $product_id = I('get.id');
            $product_data = M('product as p')
                ->field('p.id as pid,c.id as cid,c.name as cname,p.name as pname,main_img_url,home_img_url,hot,t.name as tname,detail,price,duration,address,describe,stock,p.from as pfrom,summary,content,unit')
                ->join('category as c on p.category_id=c.id')
                ->join('product_tag as t on p.id=t.product_id')
                ->where('p.id=' . $product_id)
                ->find();


            $product_feature = M('product_feature')->where('product_id=' . $product_id)->select();
            if ($product_feature) {
                if (count($product_feature) > 1) {
                    foreach ($product_feature as $key => $value) {
                        $feature .= '|' . $product_feature[$key]['feature'];
                    }
                    
                    $product_data['feature'] = mb_substr($feature,1);
                }else{
                    $product_data['feature'] = $product_feature[0]['feature'];
                }
            }
            

            $product_data['start_time'] = trim(substr($product_data['duration'], 0, 10));
            $product_data['end_time'] = trim(substr($product_data['duration'], -10));
            $product_data['start_time'] = str_replace('.', '-', $product_data['start_time']);
            $product_data['end_time'] = str_replace('.', '-', $product_data['end_time']);
            unset($product_data['duration']);
            if (empty($product_data['detail'])) {
                $product_data['tag'] = $product_data['tname'];
            }else{
                $product_data['tag'] = $product_data['tname'] . '|' . $product_data['detail'];
            }
            unset($product_data['tname']);
            unset($product_data['detail']);
            
            //商品参数
            $property_info = M('product_property')->field('name,detail')->where('product_id=' . $product_id)->select();
            
            $property_count = count($property_info);
            for ($i=0; $i < $property_count; $i++) { 
                $property_array[] = $property_info[$i]['name'].'：'.$property_info[$i]['detail'];
            }
            $product_data['property'] = $property_array;

            //主题活动时间
            $product_time_data = M('product_time')->where('product_id='.$product_id)->select();

            $product_time_count = count($product_time_data);
            $product_data['product_time_data'] = $product_time_data;
            

            //print_r($product_data);die;
            $category_data = M('category')->select();

            
            $this->assign('product_time_count',$product_time_count);
            $this->assign('property_count',$property_count);
            $this->assign('category_data', $category_data);
            $this->assign('product_data', $product_data);
            $this->display();
        }
    }

    //***********************************
    // 状态修改
    //**********************************
    public function del_status()
    {
        try {
            $id = intval($_REQUEST['product_id']);
            $info = M('product')->where('id=' . intval($id))->find();
            if (!$info) {
                throw new \Exception('商品信息错误');
                exit();
            }

            $data = array();
            $data['del'] = $info['del'] == '1' ? 2 : 1;
            $up = M('product')->where('id=' . intval($id))->save($data);
            if ($up) {
                echo $data['del'];
            } else {
                $e->getMessage();
                exit();
            }
        } catch (\Exception $e) {
            $this->error('编辑失败');
        }
    }

    //***********************************
    // 添加预约时间
    //**********************************
    public function product_time()
    {
        if (IS_POST) {
            try {
                $Model = M(); // 实例化一个空对象  
                $Model->startTrans(); // 开启事务

                $data = I('post.');

                if (empty(($data['about_stime'][0]))) {
                    throw new \Exception('可预约时间不能为空');
                    exit();
                }

                for ($i = 0; $i < count($data['about_stime']); $i++) {
                    if (strtotime($data['about_stime'][$i]) > strtotime($data['end_time']) || strtotime($data['about_etime'][$i]) > strtotime($data['end_time'])) {
                        throw new \Exception('不在预约范围内,请重新添加');
                        exit();
                    }

                    if ($data['about_stime'][$i] > $data['about_etime'][$i]) {
                        throw new \Exception('开始时间必须大于结束时间,请重新添加');
                        exit();
                    }
                    $about_array[] = array('start_time' => $data['about_stime'][$i], 'end_time' => $data['about_etime'][$i], 'product_id' => $data['product_id']);
                }

                $product_info = M('product')->where('id=' . $data['product_id'])->find();
                if (!$product_info) {
                    throw new \Exception('商品不存在');
                    exit();
                }

                $data['start_time'] = str_replace('-', '.', $data['start_time']);
                $data['end_time'] = str_replace('-', '.', $data['end_time']);

                $duration = $data['start_time'] . '-' . $data['end_time'];
                $up_pro = array('address' => $data['address'], 'duration' => $duration, 'price' => $data['price'], 'original_price' => $data['original_price']);
                $res = M('product')->where('id=' . intval($data['product_id']))->save($up_pro);
                //echo M('product')->getLastSql();die;
                if (!$res) {
                    throw new \Exception('修改失败');
                    exit();
                }

                $product_time = M('product_time')->addAll($about_array);

                if ($res && $product_time) {
                    $Model->commit(); // 成功则提交事务
                    $this->success('编辑成功', U('Admin/Shop/product'));
                }

            } catch (\Exception $e) {
                $Model->rollback(); // 否则将事务回滚
                $this->error($e->getMessage());
            }

        } else {
            $id = I('get.id');
            $this->assign('product_id', $id);
            $this->display();
        }
    }

    //***********************************
    // 商品预览
    //**********************************
    public function product_preview()
    {
        $id = I('get.id');
        $product_data = M('product as p')
                      ->field('p.id,c.name as cname,p.name as pname,main_img_url,t.name as tname,detail,price,duration,address,describe,stock,p.from as pfrom,summary,del,content,hot,discount,unit,main_img_url,home_img_url,discount_price')
                      ->join('category as c on p.category_id=c.id','left')
                      ->join('product_tag as t on p.id=t.product_id','left')
                      ->where('p.id='.$id)
                      ->find();
        //print_r($product_data);die;
        //商品参数
        $product_property = M('product_property')->where('product_id='.$id)->select();
        $product_data['product_property'] = $product_property;
        //商品规格
        $product_feature = M('product_feature')->where('product_id='.$id)->select();
        foreach ($product_feature as $key => $v) {
            $feature .= ' , '.$v['feature'];
        }
        $feature = mb_substr($feature,2);
        //预约时间
        if ($product_data['summary'] == 2) {
            $time_data = M('product_time')->where('product_id='.$id)->select();
            foreach ($time_data as $key => $v) {
                $time_data[$key]['start_time'] = date('Y-m-d H:i:s',$v['start_time']);
                $time_data[$key]['end_time'] = date('Y-m-d H:i:s',$v['end_time']);
            }
            $product_data['time_data'] = $time_data;
        }

        $product_data['product_feature'] = $feature;

        $this->assign('product_data',$product_data);
        $this->display();
    }

    //***********************************
    // 商品折扣
    //**********************************
    public function product_discount()
    {
        if (IS_POST) {
            $data = I('post.');
            $duration = $data['start_time'].'-'.$data['end_time'];
            $array = array('duration'=>$duration,'discount_price'=>$data['discount_price'],'discount'=>$data['is_discount']);
            //print_r($array);die;
            $res = M('product')->where('id='.$data['id'])->save($array);
            if ($res) {
                $this->success('编辑成功', U('Admin/Shop/product'));
            }else{
                $this->error();
            }
        }else{
            $id = I('get.id');
            $product = M('product')->field('id,discount,price,discount_price,duration')->where('id='.$id)->find();
            $start_time = substr($product['duration'],0,10);
            $end_time = substr($product['duration'],11);
            $start_time = str_replace('.','-',$start_time);
            $end_time = str_replace('.','-',$end_time);
            $product['start_time'] = $start_time;
            $product['end_time'] = $end_time;
            
            $this->assign('product',$product);
            $this->display();
        }
    }

    //***********************************
    // 商品分类
    //**********************************
    public function category()
    {
        $category = M('category')->select();
        $this->assign('category',$category);
        $this->display();
    }

    //***********************************
    // 商品分类添加
    //**********************************
    public function category_add()
    {
        $name = I('get.name');
        $where['name'] = $name;

        $result = array();
        $res = M('category')->where($where)->find();
        if ($res) {
            $result = array('code'=>-1,'msg'=>'分类已存在','value'=>'');
        }else{
            $res = M('category')->add($where);
            if ($res) {
                $result = array('code'=>1,'msg'=>'添加成功','value'=>$res);
            }else{
                $result = array('code'=>2,'msg'=>'添加失败','value'=>'');
            }
        }
        echo json_encode($result);
    }
}