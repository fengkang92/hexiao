<?php
/**
 * Created by 七月.
 * Author: 七月
 * 微信公号：小楼昨夜又秋风
 * 知乎ID: 七月在夏天
 * Date: 2017/2/26
 * Time: 14:15
 */

namespace app\api\controller\v2;

use app\api\validate\IDMustBePositiveInt;
use think\Controller;
use app\api\service\Token;

class Search extends Controller
{   
    /**
     * 
     * @param int info 搜索内容
     * @param int typer 类型 1课程 2
     * @return \think\Paginator
     * @throws ThemeException
     */
    public function getSearchInfo($id)
    {
        
    }
}