<?php

namespace app\admin\validate;

use think\Validate;

class Category extends Validate
{
    protected $rule = [
        ['name', 'require|max:10 ', '分类名必须传递|分类名不超过10个字符'],
        ['parent_id', 'number'],
        ['id', 'number'],
        ['listorder', 'number'],
        ['status', 'number|in:-1,0,1'],
    ];

    protected $scene = [
        'add' => ['name', 'parent_id', 'id'],
        'listorder' => ['id', 'listorder'],
        'status' => ['id', 'status'],

    ];

}