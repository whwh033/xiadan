<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
	public $users_data;

    public function _initialize(){
//		$m = m('web');
//		$this->web = $m->where(array('Id'=>1))->find();
//        if(!i('session.muser')){
//			redirect(u('Login/login'));
//		}
		if(!I('session.site')){
			$this->redirect('login/index');
		}else{
			$user_id = I('session.site')['user_id'];
			$this->users_data = M('site_user')->where(array('id' => $user_id))->find();
			$this->assign('users_data', $this->users_data);
		}
    }


	function check_login(&$where){
		if(I('session.site.id') != 1){
			$where['user_id'] = I('session.site.id');
		}
	}
}