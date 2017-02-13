<?php
namespace Home\Controller;
use Think\Controller;

class LoginController extends Controller {
    public function login(){
		Vendor("Code.XSVerification");
		$XSVerification = new  \XSVerification();
		$data = $XSVerification->getOkPng();
		$temp = array_chunk($data['data'],20);
		$this->assign('left_pic',$temp[0]);
		$this->assign('right_pic',$temp[1]);
		$this->assign('pg_bg',$data['bg_pic']);
		$this->assign('ico_pic',$data['ico_pic']);
		$this->assign('y_point',$data['y_point']);
		session("XSVer_VAL_SUM",1);
		$this->display('login');
	}
    public function reg(){
		$this->display('reg');
	}
	public function regact(){
		$m = m('daili');
		if($m->where(array('muser'=>i('post.muser')))->count()){
			$this->error('注册失败，该用户名已经存在！',u('Login/reg'));
		}
		$_POST['mcreat_time'] = time();
		$_POST['mpass'] = md5($_POST['mpass']);
		if($m->data(i('post.'))->add()){
			$this->success('注册成功！',u('Login/login'));
		} else {
			$this->error('注册失败！',u('Login/reg'));
		}
		
	}
	public function loginact(){
		$m = m('daili');
		if(!$m->where(array('muser'=>i('post.muser')))->count()){
			$this->error('登录失败，该用户名不存在！',u('Login/login'));
		}
		$_POST['mpass'] = md5($_POST['mpass']);
		$user = $m->where(array('muser'=>i('muser'),'mpass'=>i('mpass')))->find();
		if($user){
			$_SESSION['muser'] = $user['muser'];
			$_SESSION['uid'] = $user['id'];
			$_SESSION['mstate'] = $user['mstate'];
			$this->success('登录成功！',u('Index/indexs'));
		} else {
			$this->error('登录失败，密码不正确！',u('Login/login'));
		}
		
	}
	//校验
	public function XSValidation(){

		Vendor("Code.XSVerification");
		static $v_num=1;
		$ret =  \XSVerification::checkData(I('post.point'),session('XSVer'));
		$v_num +=  session("XSVer_VAL_SUM");
		if( $v_num > 6 ) {
			session("XSVer_SUM",null);
			exit(json_encode(array('state'=>4603,'data'=>'验证码失效')));
		} else {
			session("XSVer_VAL_SUM",$v_num);
		}
		if( $ret['state'] == 0 ) {
			session("XSVer_VAL_SUM",0x111);
			exit(json_encode(array('state'=>0,'data'=>session('XSVer'))));
		} else {
			session("XSVer_VAL_SUM",null);
			exit(json_encode(array('state'=>603,'data'=>'错误'.$v_num)));
		}
	}



	public function index(){

		$this->display('index');
	}

	public function do_loing(){
		if(IS_AJAX){
			$username = I('get.user');
			$password = I('get.pass');
			if(!$username || !$password){
				$this->ajaxReturn(array('statusCode' => -1, 'msg' => '请输入用户名和密码..'));
			}
			$users = M('site_user')->where(array('username' => $username))->find();
			if(!$users || $users['password'] != $password){
				$this->ajaxReturn(array('statusCode' => -1, 'msg' => '用户名或密码错误..'));
			}
			if($users['status'] != 0){
				$this->ajaxReturn(array('statusCode' => -1, 'msg' => '帐号已被冻结..'));
			}
			$_SESSION['site']['user_id'] = $users['id'];
			$this->ajaxReturn(array('statusCode' => 0, 'msg' => '登陆成功..'));
		}
		$this->ajaxReturn(array('statusCode' => -1, 'msg' => '请求错误..'));
	}

	public function do_logout(){
		session(null);
		$this->redirect('login/index');
	}

}