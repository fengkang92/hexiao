<?php

namespace Admin\Controller;

use Think\Controller;

class VenueController extends PublicController
{
    //***********************************
    // 场馆列表
    //**********************************
    public function venue_index()
    {
        $venue = M('ty_venue as venue')->field('venue.*,img.img_url')->join('ty_img as img on venue.logo_id=img.id')->select();
        $this->assign('venue',$venue);
        $this->display();
    }

	//***********************************
    // 添加场馆
    //**********************************
    public function add_venue()
    {
    	if (IS_POST) {
    		$data = I('post.');
    		$data['create_time'] = time();
    		$supplier_id = M('box_supplier')->add($data);

    		$cs_data = array('sid'=>(int)$data['sid'],'supplier_id'=>$supplier_id,'create_time'=>time());
    		$cs_id = M('box_course_supplier')->add($cs_data);

    		if ($supplier && $cs_id) {
    			$this->success('编辑成功', U('Admin/Supplier/index'));
    		}else{
    			$this->error('添加失败，请重新添加');
    		}
    	}else{
    		/*//分店信息
    		$chain_data = M('chain')->select();
    		//分类信息
    		$category_data = M('category')->select();
	    	$this->assign('chain_data',$chain_data);
	    	$this->assign('category_data',$category_data);*/
	    	$this->display();
    	}
    }

    //***********************************
    // 分店盒子
    //**********************************
   	public function chain_box()
   	{
   		$chain_id = (int)I('get.chain_id');
   		$cours_name = M('box_course')->field('sid,name')->where('chain_id='.$chain_id)->select();
   		if ($cours_name) {
   			echo json_encode($cours_name);
   		}else{
   			echo 0;
   		}
   	}

    //***********************************
    // 供应商修改
    //**********************************
    public function update()
    {
    	if (IS_POST) {
    		try{
    			$data = I('post.');
    			$supplier_info = M('box_supplier')->where('id='.$data['supplier_id'])->find();
		    	if (!$supplier_info) {
		    		throw new \Exception('没有该供应商');die;
		    	}
		    	//修改供应商信息
		    	$supplier_array = array(
		    						'su_name' => $data['su_name'],
		    						'su_email' => $data['su_email'],
		    						'category_id' => $data['category_id'],
		    						'description' => $data['description'],
		    						'su_adress' => $data['su_adress'],
		    						'update_time' => time()
		    						);

		    	$supplier_res = M('box_supplier')->where('id='.$data['supplier_id'])->save($supplier_array);

		    	//修改供应商与空间服务的关系
		    	$cs_array = array('sid' => $data['sid'],'update_time'=>time());
		    	$cs_res = M('box_course_supplier')->where('suppiler_id='.$data['supplier_id'])->save($cs_array);

		    	$this->success('编辑成功', U('Admin/Supplier/index'));

			}catch (\Exception $e) {

	            $this->error($e->getMessage());
	        }

    	}else{
    		try{
	    		$id = (int)I('get.id');
		    	$supplier_info = M('box_supplier')->where('id='.$id)->find();
		    	if (!$supplier_info) {
		    		throw new \Exception('没有该供应商');
		    	}
		    	//空间服务ID
		    	$sid = M('box_course_supplier')->where('suppiler_id='.$id)->getField('sid');
		    	//分店ID
		    	$chain_id = M('box_course as c')
		    	       ->join('chain as ch on c.chain_id=ch.id')
		    	       ->where('c.sid='.$sid)
		    	       ->getField('ch.id');
		    	$supplier_info['chain_id'] = $chain_id;
		    	$supplier_info['sid'] = $sid;

		    	//该分店下的空间服务
		    	$cours_data = M('box_course')->field('sid,name')->where('chain_id='.$chain_id)->select();

		    	//分店信息
	    		$chain_data = M('chain')->select();
	    		//分类信息
	    		$category_data = M('category')->select();
		    	$this->assign('chain_data',$chain_data);
		    	$this->assign('cours_data',$cours_data);
		    	$this->assign('category_data',$category_data);
		    	$this->assign('supplier_info',$supplier_info);
		    	$this->display();
	    	}catch (\Exception $e) {
	            $this->error($e->getMessage());
	        }
    	}
    }

    //***********************************
    // 修改供应商状态
    //**********************************
    public function up_status()
    {
    	$data = I('get.');
    	$cs_array = array('status'=>$data['status'],'check_info'=>$data['check_info']);
    	$res = M('box_course_supplier')->where('suppiler_id='.$data['supplier_id'])->save($cs_array);
    	if ($res) {
    		echo json_encode(array('status'=>$data['status'],'check_info'=>$data['check_info']));
    	}else{
    		echo 0;
    	}
    }

    //***********************************
    // 课程列表
    //**********************************
    public function curr()
    {
        $course_data = M('box_course_plan as pl')
                     ->field('pl.id,main_img_url,course.name as course_name,su_name,server_name,discribe,tag,pl.status')
                     ->join('box_course as course on pl.sid=course.sid')
                     ->join('box_supplier as su on pl.suppiler_id=su.id','left')
                     ->select();
        $this->assign('course_data',$course_data);
        $this->display();
    }

    //***********************************
    // 修改课程状态
    //**********************************
    public function up_course_status()
    {
        $id = intval($_REQUEST['course_plan_id']);
            $info = M('box_course_plan')->where('id=' . intval($id))->find();
            if (!$info) {
                throw new \Exception('课程信息错误');
                exit();
            }

            $data = array();
            $data['status'] = $info['status'] == '1' ? 0 : 1;
            $up = M('box_course_plan')->where('id=' . intval($id))->save($data);
            if ($up) {
                echo $data['status'];
            }else{
                echo -1;
            }
    }


    //***********************************
    // 添加课程
    //**********************************
    public function add_curr()
    {
        if (IS_POST) {
            //上传课程图片
            if (!empty($_FILES["file"]["tmp_name"])) {
                //文件上传
                $info = $this->upload_images($_FILES["file"], array('jpg', 'png', 'jpeg'), "product/" . date(Ymd));
                if (!is_array($info)) {// 上传错误提示错误信息
                    throw new \Exception('图片上传失败.');
                } else {// 上传成功 获取上传文件信息
                    $img_url = '/Data/UploadFiles/' . $info['savepath'] . $info['savename'];
                   /*$img_array = array(
                       'url' => $img_url,
                       'create_time' => time()
                   );
                   $imgage_id = M('image')->add($img_array);*/
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
            $data = I('post.');
            //print_r($_POST['id']);die();
            if (intval($_POST['id'])) {
                //print_r($data);die;
                
                //修改
                $data['main_img_url'] = $img_url;
                $data['home_img_url'] = $img_url_home;
                $data = array_filter($data);
                $data['update_time'] = time();
                if (!empty($data['start_time']) && !empty($data['end_time'])) {
                    $data['section'] = $data['start_time'].'-'.$data['end_time'];
                }
                $data['content'] = $data['editorValue'];
                $result = M('box_course_plan')->where('id=' . intval($_POST['id']))->save($data);

                /*//修改课程参数
                for ($i = 0; $i < count($data['parameter']); $i++) {
                    $parameter_info = explode('：', $data['parameter'][$i]);
                    $parameter_arr[] = array('name' => $parameter_info[0], 'detail' => $parameter_info[1], 'course_plan_id' => $data['id']);
                }

                M('product_property')->where('course_plan_id=' . $data['id'])->delete();
                $course_property = M('product_property')->addAll($parameter_arr);*/

                if ($result) {
                    $this->success('编辑成功', U('Supplier/curr'), 0);
                } else {
                    $this->error('编辑失败');
                }

            } else {
                if (empty($img_url)) {
                    throw new \Exception('请上传课程图片');die;
                }

                //添加
                unset($data['id']);
                $data['main_img_url'] = $img_url;
                $data['home_img_url'] = $img_url_home == '' ? '' : $img_url_home;
                $data['content'] = $data['editorValue'];
                $data['create_time'] = time();
                $data['initial_stock'] = $data['stock'];
                if (!empty($data['start_time']) && !empty($data['end_time'])) { 
                    $data['section'] = $data['start_time'].'-'.$data['end_time'];
                }
                
                $course_plan_id = M('box_course_plan')->add($data);

                /*if ($course_plan_id) {
                    
                    //添加产品参数
                    for ($i = 0; $i < count($data['parameter']); $i++) {
                        $parameter_info = explode('：', $data['parameter'][$i]);
                        $parameter_arr[] = array('name' => $parameter_info[0], 'detail' => $parameter_info[1], 'course_plan_id' => $course_plan_id);
                    }

                    $product_feature = M('product_property')->addAll($parameter_arr);
                }*/

                if ($course_plan_id) {
                    $this->success('编辑成功', U('Supplier/curr'), 0);
                } else {
                    $this->error('编辑失败');
                }
                
            }

        }else{

            if ($_GET['id']) {
                $course_plan_data = M('box_course_plan as ap')
                                  ->field('ap.id,chain_id,ap.sid,suppiler_id,server_name,discribe,tag,content,main_img_url,home_img_url,su_name,name,unit,hot,section,types,advance,cost,prompt')
                                  ->join('box_course as co on ap.sid=co.sid','left')
                                  ->join('box_supplier as su on ap.suppiler_id=su.id','left')
                                  ->where('ap.id='.$_GET['id'])
                                  ->find();
                //print_r($course_plan_data);die();
                if (empty($course_plan_data)) {
                    $this->error('课程不存在');die;
                }
                $chain = M('chain')->field('id,ch_name')->where('id',$course_plan_data['chain_id'])->find();
                if (!empty($course_plan_data['section'])) {
                    $course_plan_data['start_time'] = trim(substr($course_plan_data['section'], 0, 10));
                    $course_plan_data['end_time'] = trim(substr($course_plan_data['section'], -10));
                }
                
                //print_r($course_plan_data);die;
                //获取盒子
                $course_data = M('box_course')->field('sid,name')->where('chain_id='.$course_plan_data['chain_id'])->select();

                //获取供应商
                $suppiler_id = M('box_course_supplier')->where('sid=' . intval($course_plan_data['sid']))->getField('suppiler_id',true);
                $suppiler_id = implode(',', $suppiler_id);
        
                $where['id'] = array('in',$suppiler_id);
                $supplier_data = M('box_supplier')->where($where)->field('id,su_name')->select();

                //获取参数
                $property_info = M('product_property')->field('name,detail')->where('course_plan_id=' . $course_plan_data['id'])->select();
                
                $property_count = count($property_info);
                for ($i=0; $i < $property_count; $i++) { 
                    $property_array[] = $property_info[$i]['name'].'：'.$property_info[$i]['detail'];
                }

                $course_plan_data['property'] = $property_array;

                $course_plan_data['ch_name'] = $chain['ch_name'];

                $this->assign('property_count',$property_count);
                $this->assign('course_plan_data',$course_plan_data);
                $this->assign('course_data',$course_data);
                $this->assign('supplier_data',$supplier_data);
            }

            //print_r($course_plan_data);die;
            $chain = M('chain')->field('id,ch_name')->select();
            $this->assign('chain', $chain);
            $this->display();
        }
    }
}