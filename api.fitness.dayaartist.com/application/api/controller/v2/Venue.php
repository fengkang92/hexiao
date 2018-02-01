<?php
/**
 * Created by 七月.
 * Author: 七月
 * 微信公号：小楼昨夜又秋风
 * 知乎ID: 七月在夏天
 * Date: 2017/2/26
 * Time: 14:15
 */

namespace app\api\controller\v1;

use app\api\validate\IDMustBePositiveInt;
use think\Controller;
use app\api\model\Ty_venue as VenueModel;

class Venue extends Controller
{    
    public function getVenueList()
    {

        VenueModel::VenueList();
    }

}