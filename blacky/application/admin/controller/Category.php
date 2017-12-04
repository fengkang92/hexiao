<?php

namespace app\admin\controller;

use think\Controller;

class Category extends Controller
{
    private $obj;

    public function _initialize()
    {
        $this->obj = model('category');
    }

    public function index()
    {
        $parentId = input('get.parent_id', '0', 'intval');
        $categorys = $this->obj->getFirstCategorys($parentId);
        return $this->fetch('', [
            'categorys' => $categorys,
        ]);
    }

    public function add()
    {
        $categorys = $this->obj->getNormalFirstCategory();
        return $this->fetch('', [
            'categorys' => $categorys,
        ]);
    }

    public function save()
    {
        /*
         *  做严格判断
         */
        if (!request()->isPost()) {
            $this->error("请求失败");
        }
//        print_r($_POST);
//        print_r(input('post.'));
//        print_r(request()->post());
        $data = input('post.');
//        $data['status'] = 10;
        $validate = Validate('Category');
        if (!$validate->scene('add')->check($data)) {
            $this->error($validate->geterror());
        }
        if (!empty($data['id'])) {
            return $this->update($data);
        }
        $res = $this->obj->add($data);
        if ($res) {
            $this->success('新增成功');
        } else {
            $this->error('新增失败');
        }
    }

    public function edit($id = 0)
    {
//        echo input('get.id');
        if (intval($id) < 1) {
            $this->error('参数不合法');
        }
        $category = $this->obj->get($id);
        $categorys = $this->obj->getNormalFirstCategory();
        return $this->fetch('', [
            'categorys' => $categorys,
            'category' => $category,
        ]);
    }

    public function update($data)
    {
        $res = $this->obj->save($data, ['id' => intval($data['id'])]);
        if ($res) {
            $this->success("更新成功");
        } else {
            $this->error("更新失败");
        }
    }

    public function listorder($id, $listorder)
    {
        $res = $this->obj->save(['listorder' => $listorder], ['id' => $id]);
        if ($res) {
            $this->result($_SERVER['HTTP_REFERER'], 1, 'sucess');
        } else {
            $this->result($_SERVER['HTTP_REFERER'], 0, 'failed');
        }
    }

    public function status()
    {
        $data = input('get.');
        $validate = Validate('Category');
        if (!$validate->scene('status')->check($data)) {
            $this->error($validate->geterror());
        }
        $res = $this->obj->save(['status' => $data['status']], ['id' => $data['id']]);
        if ($res) {
            $this->success('success');
        } else {
            $this->error('failed');
        }
    }

}
