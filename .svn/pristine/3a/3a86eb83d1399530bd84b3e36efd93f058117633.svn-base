<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;

class ApisController extends Controller {

	private $params = "";

	public function __construct() {
		parent::__construct();
		$this->params = I('post.params');
		if(!$this->params){
			$this->ajaxReturn(array('statusCode' => -1, 'msg' => '缺少参数!'));
		}
	}


	//注册
	public function reg(){
		$data = encode_params(authcode($this->params));
		if(!isset($data['username']) || !isset($data['password'])  || !isset($data['email'])){
			$this->ajaxReturn(array('statusCode' => -1, 'msg' => '参数错误!'));
		}
		$check = M('check_users')->where(array('username' => $data['username']))->field("id")->find();
		if($check){
			$this->ajaxReturn(array('statusCode' => -1, 'msg' => '帐号已经存在!'));
		}
		$data['add_time'] = time();
		$data['password'] = md5($data['password']);
		$ret = M('check_users')->add($data);
		if($ret){
			$this->ajaxReturn(array('statusCode' => 0, 'msg' => '注册成功!'));
		}
		$this->ajaxReturn(array('statusCode' => -1, 'msg' => '注册失败!'));
	}

    //登陆
	public function login(){
		$data = encode_params(authcode($this->params));
		if(!isset($data['username']) || !isset($data['password']) || !isset($data['key'])){
			$this->ajaxReturn(array('statusCode' => -1, 'msg' => '参数错误!'));
		}
		$check = M('check_users')->where(array('username' => $data['username']))->find();
		if(!$check){
			$this->ajaxReturn(array('statusCode' => -1, 'msg' => '用户不存在!'));
		}
		if(md5($data['password']) != $check['password']){
			$this->ajaxReturn(array('statusCode' => -1, 'msg' => '用户或密码错误!'));
		}
		if($check['status'] == 1){
			$this->ajaxReturn(array('statusCode' => -1, 'msg' => '用户已被冻结!'));
		}
		$cur_time = time();
		if($check['end_time'] <= $cur_time){
            $this->ajaxReturn(array('statusCode' => -1, 'msg' => '使用时间已到期!'.date('Y-m-d H:i:s', $data['end_time'])));
        }
		if($check['group_id'] <= 0){
            $this->ajaxReturn(array('statusCode' => -1, 'msg' => '用户还不能使用本软件!需要由管理激活软件!'));
        }
		$keys = M('check_software')->where(array('key' => $data['key']))->find();
		if(!$keys){
            $this->ajaxReturn(array('statusCode' => -1, 'msg' => '软件key不存在!'));
        }
        $groups = M('check_group')->where(array('id' => $check['group_id']))->find();
		if(!$groups){
            $this->ajaxReturn(array('statusCode' => -1, 'msg' => '用户分组不存在!'));
        }
        $notice = json_decode($groups['notice_id'], true);
        if(!in_array($keys['id'], $notice)){
            $this->ajaxReturn(array('statusCode' => -1, 'msg' => '对不起，您没有权限使用本软件！'));
        }
        $online['user_id']  = $check['id'];
        $counts = M('check_online')->where(array('user_id' => $online['user_id'], 'software_id' => $keys['id']))->count();
        if($counts >= $keys['open_num']){
            $this->ajaxReturn(array('statusCode' => -1, 'msg' => '对不起，软件已达到多开最大次数！'));
        }

        $online['software_id'] = $keys['id'];
        $online['update_time'] = $cur_time;
        $online['heard_data'] = create_unique(false);
        M('check_online')->add($online);
        $online['end_time'] = $check['end_time'];
        unset($online['update_time']);
        unset($online['software_id']);
		$online['notice'] = $keys['notice'];
        $ret_data = decode_params($online);
		$this->ajaxReturn(array('statusCode' => 0, 'msg' => '正确', 'users' => authcode($ret_data,"ENCODE")));
	}

	//充值
	public function recharge(){
        $data = encode_params(authcode($this->params));
        if(!isset($data['username'])  || !isset($data['card'])){
            $this->ajaxReturn(array('statusCode' => -1, 'msg' => '参数错误!'));
        }
        $card = M('check_card')->where(array('card' => $data['card']))->find();
        if(!$card){
            $this->ajaxReturn(array('statusCode' => -1, 'msg' => '卡密不存在！'));
        }
        if($card['status'] == 1){
            $this->ajaxReturn(array('statusCode' => -1, 'msg' => '卡密已被使用！'));
        }
        $users = M('check_users')->where(array('username' => $data['username']))->find();
        if(!$users){
            $this->ajaxReturn(array('statusCode' => -1, 'msg' => '充值用户不存在！'));
        }
        $cur_time = time();
        if($users['end_time'] <= $cur_time){
            $users['end_time'] = $cur_time;
        }
        $user_update_time = $users['end_time'] + $card['day'] * 3600 * 24;
        $update_data = array('username' => $data['username'], 'status' => 1, 'use_time' => $cur_time);
        $ret_users = M('check_users')->where(array('id' => $users['id']))->save(array('end_time' => $user_update_time));
        $ret_card = M('check_card')->where(array('id' => $card['id']))->save($update_data);
        if($ret_users && $ret_card){
            $this->ajaxReturn(array('statusCode' => 0, 'msg' => '充值成功，到期时间:'.date('Y-m-d H:i:s', $user_update_time)));
        }
        $this->ajaxReturn(array('statusCode' => -1, 'msg' => '充值失败！'));
    }

    //心跳
    public function heard_check(){
        $data = encode_params(authcode($this->params));
        if(!isset($data['user_id']) || !isset($data['heard_data'])){
            $this->ajaxReturn(array('statusCode' => -1, 'msg' => '参数错误!'));
        }
        $ret = M('check_online')->where($data)->save(array('update_time' => time()));
        if($ret){
            $ret = M('check_users')->where(array('id' => $data['user_id']))->field("end_time")->find();
            $data['end_time'] = $ret['end_time'];
            $data = decode_params($data);
            $this->ajaxReturn(array('statusCode' => 0, 'msg' => '心跳成功!', 'users' => authcode($data, "ENCODE")));
        }
        $this->ajaxReturn(array('statusCode' => -1, 'msg' => '心跳失败!'));
    }

	//返回用户额外数据
	public function ret_user_other_data(){
		$data = encode_params(authcode($this->params));
		if(!isset($data['username']) || !isset($data['password'])){
			$this->ajaxReturn(array('statusCode' => -1, 'msg' => '参数错误!'));
		}
		$check = M('check_users')->where(array('username' => $data['username']))->find();
		if(!$check){
			$this->ajaxReturn(array('statusCode' => -1, 'msg' => '用户不存在!'));
		}
		if(md5($data['password']) != $check['password']){
			$this->ajaxReturn(array('statusCode' => -1, 'msg' => '用户或密码错误!'));
		}
		if($check['status'] == 1){
			$this->ajaxReturn(array('statusCode' => -1, 'msg' => '用户已被冻结!'));
		}
		$cur_time = time();
		if($check['end_time'] <= $cur_time){
			$this->ajaxReturn(array('statusCode' => -1, 'msg' => '使用时间已到期!'.date('Y-m-d H:i:s', $data['end_time'])));
		}
		$this->ajaxReturn(array('statusCode' => 0, 'msg' => "获取成功！", 'check_data' => authcode($check['check_data'], "ENCODE")));
	}

	//软件额外信息
	public function ret_software_other_data(){
		$data = encode_params(authcode($this->params));
		if(!isset($data['key'])){
			$this->ajaxReturn(array('statusCode' => -1, 'msg' => '参数错误!'));
		}
		$keys = M('check_software')->where(array('key' => $data['key']))->find();
		if(!$keys){
			$this->ajaxReturn(array('statusCode' => -1, 'msg' => '软件key不存在!'));
		}
		$this->ajaxReturn(array('statusCode' => 0, 'msg' => "获取成功！", 'check_data' => authcode($keys['check_data'], "ENCODE")));
	}

	function checkParams(){
		$params = $this->params;
		echo authcode($params,"ENCODE");

	}

}