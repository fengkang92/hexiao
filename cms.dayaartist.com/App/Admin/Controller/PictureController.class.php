<?php

namespace Admin\Controller;

use Think\Controller;

class PictureController extends PublicController
{


    //***********************************
    // iframe式显示菜单和index页
    //**********************************
    public function banner()
    {
        $count = M('banner_item')->join('image on image.id = banner_item.img_id')->count();
        $userlist = M('banner_item')->Field('banner_item.id as bid,image.url,banner_item.*')->join('image on image.id = banner_item.img_id')->where($where)->order('banner_item.id asc')->select();
        foreach ($userlist as $k => $v) {
            $userlist[$k]['delete_time'] = date("Y-m-d H:i", $v['delete_time']);
            $userlist[$k]['create_time'] = date("Y-m-d H:i", $v['create_time']);
            $userlist[$k]['update_time'] = date("Y-m-d", $v['update_time']);
        }
        //=============
        //将变量输出
        //=============
        $this->assign('userlist', $userlist);
//        var_dump($userlist);die;
        $this->display();
    }

    public function top()
    {
        $userlist = M('Theme')->field('theme.*,image.url as shop_img_id')->join('image on image.id = theme.shop_img_id')->order('theme.id asc')->select();
        foreach ($userlist as $k => $v) {
            $userlist[$k]['delete_time'] = date("Y-m-d H:i", $v['delete_time']);
            $userlist[$k]['create_time'] = date("Y-m-d H:i", $v['create_time']);
            $userlist[$k]['update_time'] = date("Y-m-d", $v['update_time']);
        }
        //=============
        //将变量输出
        //=============
        $this->assign('userlist', $userlist);
//        var_dump($userlist);die;
        $this->display();
    }

//    添加修改bnanner
    public function add()
    {
        if (IS_POST) {
            if (!empty($_FILES["file"]["tmp_name"])) {
                //文件上传
                $info = $this->upload_images($_FILES["file"], array('jpg', 'png', 'jpeg'), "Picture/" . date(Ymd));
                if (!is_array($info)) {// 上传错误提示错误信息
                    $this->error($info);
                    throw new \Exception('图片上传失败.');

                } else {// 上传成功 获取上传文件信息
                    $img_url = '/Data/UploadFiles/' . $info['savepath'] . $info['savename'];
                    $img_array = array(
                        'url' => $img_url,
                        'create_time' => time()
                    );
                    $image_id = M('image')->add($img_array);
                }
            }

            $data = I('post.');

            if (intval($_POST['id'])) {
                if (empty($image_id)) {
                    unset($data['img_id']);
                } else {
                    $data['img_id'] = $image_id;
                }
                $result = M('banner_item')->where('id=' . intval($_POST['id']))->save($data);

            } elseif ($image_id) {
                unset($data['id']);
                $data['img_id'] = $image_id;
                $result = M('banner_item')->add($data);
            }

            if ($result) {
                $this->success('编辑成功', U('Admin/Picture/banner'), 0);
            } else {
                $this->error('编辑失败');
            }

        } elseif ($_GET['id']) {
            //查询要编辑banner信息
            $id = $_GET['id'];
            $banner = M('banner_item')->where('id=' . $id)->find();
            $this->assign('banner', $banner);
            //查询图片url
            $image = M('image')->where('id=' . $banner[img_id])->find();
            $this->assign('image', $image);
            $this->display();
        } else {
            $this->display();
        }
    }

    //    修改category图片
    public function category_add()
    {
        if (IS_POST) {
            if (!empty($_FILES["file"]["tmp_name"])) {
                //文件上传
                $info = $this->upload_images($_FILES["file"], array('jpg', 'png', 'jpeg'), "Picture/" . date(Ymd));
                if (!is_array($info)) {// 上传错误提示错误信息
                    $this->error($info);
                    throw new \Exception('图片上传失败.');

                } else {// 上传成功 获取上传文件信息
                    $img_url = '/Data/UploadFiles/' . $info['savepath'] . $info['savename'];
                    $img_array = array(
                        'url' => $img_url,
                        'create_time' => time()
                    );
                    $image_id = M('image')->add($img_array);
                }
            }
            if ($image_id) {
                $data = I('post.');
                $data['shop_img_id'] = $image_id;
                if (intval($_POST['id'])) {
                    $result = M('theme')->where('id=' . intval($_POST['id']))->save($data);
                } else {
                    $result = M('theme')->add($data);
                }

                if ($result) {
                    $this->success('编辑成功', U('Admin/Picture/top'), 0);
                } else {
                    $this->error('编辑失败');
                }

            } else {
                $this->error('编辑失败');
            }

        } elseif ($_GET['id']) {
            //        查询要编辑图片信息
            $id = $_GET['id'];
            $theme = M('theme')->where('id=' . $id)->find();
            $this->assign('theme', $theme);
//        var_dump($banner);
//        die;

//        查询图片url
            $image = M('image')->where('id=' . $theme[shop_img_id])->find();
            $this->assign('image', $image);
//        var_dump($image);
//        die;
            $this->display();
        } else {
            $this->display();
        }

    }

    //    更改轮播图状态
    public function banner_del()
    {
        $id = $_GET['id'];
        $info = M('banner_item')->where('id=' . intval($id))->find();
        if (!$info) {
            $this->error('信息错误.' . __LINE__);
            exit();
        }

        $data = array();
        $data['del'] = $info['del'] == '1' ? 0 : 1;
        $up = M('banner_item')->where('id=' . intval($id))->save($data);
        if ($up) {
            $this->redirect('Picture/banner');
            exit();
        } else {
            $this->error('操作失败.');
            exit();
        }
    }

    //    更改分类图状态
    public function category_del()
    {
        $id = $_GET['id'];
        $info = M('theme')->where('id=' . intval($id))->find();
        if (!$info) {
            $this->error('信息错误.' . __LINE__);
            exit();
        }

        $data = array();
        $data['del'] = $info['del'] == '1' ? 0 : 1;
        $up = M('theme')->where('id=' . intval($id))->save($data);
        if ($up) {
            $this->redirect('Picture/top');
            exit();
        } else {
            $this->error('操作失败.');
            exit();
        }
    }
}