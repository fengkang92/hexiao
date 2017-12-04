<?php
/**
 * Created by PhpStorm.
 * User: Blacky
 * Date: 2017/10/13
 * Time: 19:16
 */

namespace app\api\model;


class BoxCourseSupplier extends BaseModel
{
    protected $autoWriteTimestamp = true;
    protected $hidden = ['delete_time', 'create_time', 'update_time'];

    public static function getSupplierStatus($supplier_id)
    {
    	$where = array('suppiler_id'=>$supplier_id);
        $supplierStatus = self::where($where)->field('sid,status')->find();
        return $supplierStatus;
	}
}