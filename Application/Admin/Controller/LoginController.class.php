<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
		$this->display('login');
	}
	public function loginact(){
		$m = m('admin');
		if(!$m->where(array('muser'=>i('post.muser')))->count()){
			$this->error('登录失败，该用户名不存在！',u('Login/index'));
		}
		$_POST['mpass'] = md5($_POST['mpass']);
		$user = $m->where(array('muser'=>i('muser'),'mpass'=>i('mpass')))->find();
		if($user){
			$_SESSION['GLY_USER'] = $user['muser'];
			$_SESSION['GLY_AID'] = $user['id'];
			$this->success('登录成功！',u('Index/index'));
		} else {
			$this->error('登录失败，密码不正确！',u('Login/index'));
		}
		
	}
	public function loginout(){
		session_destroy();
		redirect(u('Login/index'));
	}
}