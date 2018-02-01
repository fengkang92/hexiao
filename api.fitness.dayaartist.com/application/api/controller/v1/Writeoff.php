<?php

namespace app\api\controller\v1;

use think\Controller;


class Writeoff extends Controller
{
    /**
     * 二维码核销
     * @param int $user_id 用户id号
     * @param int $time_id 时间id号
     * @param int $device_name 门锁名称
     * @return \think\Paginator
     * @throws ThemeException
     */
    public function qrcode()
    {//http://dayaartist.com/index.php/api/v1/writeoff/qrcode
        $save_path = isset($_GET['save_path']) ? $_GET['save_path'] : BASE_PATH . 'qrcode/';  //图片存储的绝对路径
        //echo $save_path;die;
        $web_path = 'http://' . $_SERVER['HTTP_HOST'] . '/qrcode/';        //图片在网页上显示的路径

        $qr_data = isset($_GET['qr_data']) ? $_GET['qr_data'] : 'sb250';

        $qr_level = isset($_GET['qr_level']) ? $_GET['qr_level'] : 'H';

        $qr_size = isset($_GET['qr_size']) ? $_GET['qr_size'] : '10';

        $save_prefix = isset($_GET['save_prefix']) ? $_GET['save_prefix'] : 'ZETA';

        if ($filename = createQRcode($save_path, $qr_data, $qr_level, $qr_size, $save_prefix)) {

            $pic = $web_path . $filename;

        }
        $img_path = '/qrcode/' . $filename;
        echo $img_path;die;
        //die;
        echo "<img src='" . $pic . "'>";
    }

}