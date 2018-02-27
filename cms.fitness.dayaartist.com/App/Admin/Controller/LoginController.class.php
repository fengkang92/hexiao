<?php

namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller
{
//创建验证码
    public function code()
    {
        $config = array(
            'fontSize' => 20,
            'length' => 4,
            'useNoise' => true,
            'imageW' => 150,
            'imageH' => 50);

        $Verify = new \Think\Verify($config);
        $Verify->codeSet = '0123456789';
        $Verify->useImgBg = true;
        $Verify->entry();
    }

    public function check_verify($code, $id = '')
    {
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }
    //********************
    //
    //********************
    public function index()
    {
        session('[start]');
        if (IS_POST) {
            $yzm = I('code');
            if ($this->check_verify($yzm)) {
                $username = $_POST['username'];
                $admininfo = M('adminuser')->where("name='$username' AND del=1")->find();
                //查询app表看使用该系统的客户时间
                if ($admininfo) {
                    if (MD5(MD5($_POST['pwd'])) == $admininfo['pwd']) {
                        $admin = array(
                            "id" => $admininfo["id"],
                            "name" => $admininfo["name"],
                            "shop_id" => $admininfo["shop_id"],
                            'supplier_id' => $admininfo['supplier_id']
                        );
                        unset($_SESSION['admininfo']);
                        $_SESSION['admininfo'] = $admin;
                        echo "<script>alert('登录成功');location.href='" . U('Index/index') . "'</script>";
                    } else {
                        $this->error('账号密码错误');
                    }
                } else {
                    $this->error('账号不存在或已注销');
                }
            } else {
                $this->error('验证码错误');
            }

        } else {
            $this->display();
        }
    }

    public function logout()
    {
        unset($_SESSION['admininfo']);
        unset($_SESSION['system']);
        echo "<script>alert('注销成功');location.href='" . U('Login/index') . "'</script>";
        exit;
    }
}