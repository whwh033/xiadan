<?php
namespace Home\Controller;
use Think\Controller;
class OrderController extends CommonController {

    public function index(){
		$this->display('index');
    }

	public function show_type(){
		switch(I('get.type')){
			case 1:
				$this->display('show1');
				break;
			case 2:
				break;
			default:
				$this->display('show');
		}
	}



}