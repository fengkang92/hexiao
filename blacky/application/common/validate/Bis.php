<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 04/10/2017
 * Time: 4:18 PM
 */

namespace app\common\validate;

use think\Validate;

class Bis extends Validate
{
    protected $ruel = [
        'name' => 'require|max:25',
        'email' => 'email',
        'logo' => 'logo',
    ];

    protected $scence = [
        'add' => ['name', 'email', 'logo'],
    ];
}