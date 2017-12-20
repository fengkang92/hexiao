<?php 
namespace app\api\controller\v2;

Loader::import('Share.jssdk', EXTEND_PATH, '.php');	
class Wxshare extends Controller 
{
	/**
     * 微信分享
     */
    public function share()
    {
        $data = \jssdk::GetSignPackage();
        return $data;
        echo $_GET['callback']."(".json_encode($signPackage).")";
    }

}