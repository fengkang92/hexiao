<?php
namespace Admin\Controller;
use Think\Controller;
class AdminuserController extends PublicController{
	//*************************
	// 管理员的管理
	//*************************
	public function adminuser(){
		$id=(int)$_GET['id'];

		$count=M('adminuser')->count();

		$userlist=M('adminuser as a')->field('a.id,a.name,a.addtime,role_name')->join('rbac_role as r on a.role_id=r.id')->select();
		//print_r($userlist);die;
		foreach ($userlist as $k => $v) {
			$userlist[$k]['addtime']=date("Y-m-d H:i",$v['addtime']);
		}

		//=============
		//将变量输出
		//=============
		$this->assign('count',$count);
		$this->assign('userlist',$userlist);
		$this->display();	
	}

	//*************************
	// 管理员&商家会员的添加
	//*************************
	public function add(){
		//==================
		// GET到的参数集合
		//==================
		$id=(int)$_GET['id'];
		if($_POST['submit']==true){
			if (!$_POST['name']) {
				$this->error('请输入登录账号.'.__LINE__);
				exit();
			}

		    $array = array(
		        'name' => trim($_POST['name']),
				'pwd' => MD5(MD5($_POST['password'])),
				'role_id' => (int)($_POST['role_id']),
				'suppiler_id'=>(int)($_POST['supplier_id']),
		    );
			if(intval($_POST['admin_id'])>0){
				//更新
			    //密码为空则去掉unset，防止空置原密码
				if(!$_POST['password']) {unset($array['pwd']);}
				$sql= M('adminuser')->where("id=".intval($_POST['admin_id']))->save($array);
			}else{
				//添加
				/*$check = M('adminuser')->where('name="'.$array['name'].'" AND del=0 AND (qx=5 or qx=4)')->getField('id');*/
				$check = M('adminuser')->where('name="'.$array['name'].'"')->getField('id');
				if ($check) {
					$this->error('账号已存在！');
					exit();
				}
				$array['addtime'] = time();
				$sql= M('adminuser')->add($array);
				$id= $sql;
			}
			
			if($sql){  
				$this->success('保存成功！',U('adminuser/adminuser'));
				exit();
			}else{
				$this->error('保存失败！');
				exit();
			}
		}
		//id>0则为编辑状态
		$adminuserinfo = $id>0 ? M('adminuser')->where("id=$id")->find():""; 
		$supplier = M('box_supplier')->select();
		//=============
		//将变量输出
		//=============
		$this->assign('id',$id);
		$this->assign('supplier',$supplier);
		$this->assign('adminuserinfo',$adminuserinfo);
		$this->display();
	}

	public function del()
	{
		$id = intval($_REQUEST['did']);
		$info = M('adminuser')->where('id='.intval($id))->find();
		if (!$info) {
			$this->error('参数错误.'.__LINE__);
			exit();
		}

		if (intval($info['qx'])==4) {
			$this->error('该账号不能删除.'.__LINE__);
			exit();
		}

		if ($info['del']==1) {
			$this->redirect('Adminuser/adminuser',array('page'=>intval($_REQUEST['page'])));
			exit();
		}

		$data=array();
		$data['del'] = 1;
		$up = M('adminuser')->where('id='.intval($id))->save($data);
		if ($up) {
			$this->redirect('Adminuser/adminuser',array('page'=>intval($_REQUEST['page'])));
			exit();
		}else{
			$this->error('操作失败.');
			exit();
		}
	}

	//*************************
	// 角色权限
	//*************************
	public function role_auth()
	{
		$this->display();
	}

	//*************************
	// 分配角色权限
	//*************************
	public function branch_role()
	{
		if (IS_POST) {
			try{
				if ($_POST['submit']==true) {

					$data = I('post.');
					//查看一级权限
					$auth_info = M('rbac_auth')->where('id='.$data['auth_id'])->find();

					$auth_one = M('rbac_role_auth')->where('role_id='.$data['role_id'].' AND auth_id='.$auth_info['auth_pid'])->find();

					if (!$auth_one) {  //是否添加过一级权限
						$auth_array = array('role_id'=>$data['role_id'],'auth_id'=>$auth_info['auth_pid']);
						$auth_one_res = M('rbac_role_auth')->add($auth_array);

						if (!$auth_one_res) {
							throw new \Exception('添加一级权限失败');
						}
					}

					$res = M('rbac_role_auth')->add($data);
					
					if ($res) {
						$this->success('保存成功！',U('adminuser/role_auth'));
					}else{

						throw new \Exception('保存失败！');
					}
				}else{

					throw new \Exception('请填写完信息');

				}	
			}catch (\Exception $e) {
                $this->error($e->getMessage());
            }
			
		}else{

			$auth = M('rbac_auth')->where('auth_pid=0')->select();
			$this->assign('auth',$auth);
			$this->display();

		}
	}

	//*************************
	// 二级权限
	//*************************
	public function two_auth(){
		$auth_pid = I('get.auth_pid');
		$data = array('data'=>'','message'=>'','status'=>'');
		$auth = M('rbac_auth')->where('auth_pid='.$auth_pid)->select();
		if ($auth) {
			$data = array('data'=>$auth,'message'=>'成功','status'=>1);
		}else{
			$data = array('data'=>'','message'=>'查询失败','status'=>0);
		}
		echo json_encode($data);
	}
}