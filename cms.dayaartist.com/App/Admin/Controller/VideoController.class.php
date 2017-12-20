<?php

namespace Admin\Controller;

use Think\Controller;

class VideoController extends PublicController
{
    //***********************************
    // iframe式显示菜单和index页
    //**********************************
    public function video()
    {

        $count = M('video')->count();
        $userlist = M('video')->field('video.*,category.name as category')->join('category on video.category_id = category.id')->order('video.id desc')->select();
        foreach ($userlist as $k => $v) {
            $userlist[$k]['delete_time'] = date("Y-m-d H:i", $v['delete_time']);
            $userlist[$k]['create_time'] = date("Y-m-d", $v['create_time']);
            $userlist[$k]['update_time'] = date("Y-m-d H:i", $v['update_time']);
        }

        //=============
        //将变量输出
        //=============
        $this->assign('userlist', $userlist);
        $this->assign('count', $count);
//        var_dump($userlist);die;
        $this->display();
    }


    //    添加修改bnanner
    public function add()
    {
        if (IS_POST) {
            if (!empty($_FILES["file"]["tmp_name"])) {
                //文件上传
                $info = $this->upload_images($_FILES["file"], array('jpg', 'png', 'jpeg'), "Video/" . date(Ymd));
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
            $data['content'] = $data['editorValue'];
            if (intval($_POST['id'])) {
                $data['update_time'] = time();
                $result = M('video')->where('id=' . intval($_POST['id']))->save($data);
            } elseif ($image_id) {
                $data['main_img_url'] = $img_url;
                $data['create_time'] = time();
                $data['img_id'] = $image_id;
                $result = M('video')->add($data);
            }
            if ($result) {
                $this->success('编辑导航成功', U('Admin/Video/video'), 0);
            } else {
                $this->error('编辑失败');
            }

        } elseif ($_GET['id']) {
//        查询要编辑视频信息
            $id = $_GET['id'];
            $video = M('video')->where('id=' . $id)->find();
            $this->assign('video', $video);
//        var_dump($video);
//        die;

//        查询视频分类
            $category = M('category')->select();
            $this->assign('category', $category);

            $this->display();
        } else {
//        查询视频分类
            $category = M('category')->select();
            $this->assign('category', $category);
            $this->display();
        }
    }

//    启用禁用状态修改
    public function del()
    {
        $id = $_GET['id'];
        $info = M('video')->where('id=' . intval($id))->find();
        if (!$info) {
            $this->error('信息错误.' . __LINE__);
            exit();
        }

        $data = array();
        $data['del'] = $info['del'] == '1' ? 0 : 1;
        $up = M('video')->where('id=' . intval($id))->save($data);
        if ($up) {
            $this->redirect('Video/video');
            exit();
        } else {
            $this->error('操作失败.');
            exit();
        }
    }
}