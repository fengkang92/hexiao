<?php 
namespace app\api\controller\v2;
use think\Loader;
use think\Controller;

Loader::import('Share.jssdk', EXTEND_PATH, '.php');	
class Wxshare extends Controller 
{
	/**
     * 微信分享
     */
    public function share($url)
    {
        $data = \jssdk::GetSignPackage($url);
        return $data;
    }

}