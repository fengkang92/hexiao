<?php
/**
 * Created by 七月.
 * User: 七月
 * Date: 2017/2/15
 * Time: 1:00
 */

namespace app\api\controller\v2;

use app\api\validate\IDMustBePositiveInt;
use app\api\validate\PagingParameter;
use think\Controller;
use app\lib\exception\BaseException;

class Other extends Controller
{
    /**
     * 添加第三方上课成员
     * @param int $id 盒子id号
     * @return \think\Paginator
     * @throws ThemeException
     */
    public function addOtheMember($AppKey,$page = 1, $size = 15)
    {
        (new IDMustBePositiveInt())->goCheck();
        (new PagingParameter())->goCheck();
        
        //课程下最低价格
        $data = BoxCourseService::getByCourseMinPrice($data);

        return [
            'current_page' => $curriculumData->currentPage(),
            'data' => $data
        ];
    }
}