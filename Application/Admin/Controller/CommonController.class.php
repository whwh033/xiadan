<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
    public function _initialize(){
        if(!i('session.GLY_USER') || !i('session.GLY_AID')){
			redirect(u('Login/index'));
		}
    }
}