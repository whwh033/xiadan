<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;

class ApiController extends Controller {

	private static $num = 50;

	/**
	 * 上传账号
	 */
	public function up_user_data(){
		$msg = isset($_POST['msg'])?$_POST['msg']:'';
		if(!$msg){
			$this->ajaxReturn(array('code' => -1, 'msg' => '上传失败'));
		}
		$msg = json_decode($msg, true);
		if(!is_array($msg)){
			$this->ajaxReturn(array('code' => -1, 'msg' => '上传数据错误'));
		}
		$show_id = M('users')->field("user_id")->select();
		$user_id = array();
		if($show_id){
			foreach($show_id as $k=>$v){
				$user_id[] = $v['user_id'];
			}
			$user_id = array_unique($user_id);
		}
		$data = array();
		foreach($msg as $k => &$v){
			if(!isset($v['email']) || !isset($v['pass']) || !isset($v['cookie']) || !isset($v['user_id']) || !isset($v['show_id']) || !isset($v['nick_name']) || !isset($v['authcookie'])  || !isset($v['authcookie']) ){
				$this->ajaxReturn(array('code' => -1, 'msg' => '参数错误..'));
			}
			$v['add_time'] = time();
			if(in_array($v['user_id'], $user_id)){
				continue;
			}
			array_push($data, $v);
			if(($k+1) % 100 == 0){
				M('users')->addAll($data);
				$data = array();
			}
		}
		echo "success";
		//$users = M('users')->addAll($msg);
//		if($users){
//			$this->ajaxReturn(array('code' => 0, 'msg' => '添加成功'));
//		}
//		$this->ajaxReturn(array('code' => -1, 'msg' => '添加失败'));
	}

	/**
	 * 获取帐号
	 */
	public function get_user_data(){
		$nums = isset($_POST['nums'])?$_POST['nums']:self::$num;
		$users = M('users')->where(array('status' => 0))->order("num asc")->limit($nums)->select();
		if($users){
			foreach($users as $v){
				$id[] = $v['id'];
			}
			$where['id'] = array('IN', implode(',',$id));
			M('users')->where($where)->setInc('num');
		}
		$this->ajaxReturn(array('code' => 0, 'user_list' => $users));
	}

	public function cheng_users_status(){
		$user_id = I('post.user_id');
		if(!$user_id){
			$this->ajaxReturn(array('code' => -1, 'msg' => "请求参数错误"));
		}
		$ret = M("users")->where(array('user_id' => $user_id))->save(array('status' => 1));
		if($ret){
			$this->ajaxReturn(array('code' => 0, 'msg' => "修改成功"));
		}else{
			$this->ajaxReturn(array('code' => -1, 'msg' => "修改失败"));
		}
	}


	/**
	 * 检查更新
	 */
	public function check_update(){
		$ret = M('version')->order("id desc")->find();
		$this->ajaxReturn(array('code' => 0, 'version' => $ret));
	}


	/**
	 * 获取唯一机器号
	 */
	public function get_card_id(){
		$client_ip = get_client_ip();
		$where['ip'] = array('like', "%$client_ip%");
		$machine = M("machine")->order("id desc")->where($where)->find();
		$data = array(
			'ip' => $client_ip,
			'add_time' => time(),
			'update_time' => time(),
		);
		if($machine){
			$pix_arr = explode('-',$machine['ip']);
			$pic = isset($pix_arr[1])?$pix_arr[1]+1:2;
			$data['ip'] = $data['ip']."-".$pic;
		}
		$data['code'] = md5($data['ip'].time());
		M("machine")->add($data);
		$this->ajaxReturn(array('code' => 0, 'machine_code' => $data['code']));
	}

	/**
	 * 分配任务
	 */
	public function task_allcation(){
		set_time_limit(0);
		ini_set('default_socket_timeout', -1);

		$cur_time = time();
		$model = new Model();
		M('machine')->where(array('status' => 2, 'add_time' => array('ELT', $cur_time - 24*3600)))->delete();

		// 判断 任务是否到期，然后结束任务 start
		$renwu_where = "(status = 1 or status = 0) AND (end_time !=0 AND end_time <= $cur_time)";
		$renwu_ret = M("renwu")->where($renwu_where)->field("id")->select();
		if($renwu_ret){
			foreach($renwu_ret as $v){
				$ret_id[] = $v['id'];
			}
			$ret_id = implode(',', $ret_id);
			M("renwu")->where(array('id' => array('IN', $ret_id )))->save(array('status' => 2));
			M("machine")->where(array('renwu_id' => array('IN', $ret_id)))->save(array('status' => 2));
		}
		// 判断 任务是否到期，然后结束任务 end

		// 判断 机器是否在正常工作  start
		$update_time = time() - 60*5;
		$wheres = "update_time < $update_time AND status NOT IN (2,3)";
		M('machine')->where($wheres)->save(array('status' => 3, 'complete_num' => 0));
		// 判断 机器是否在正常工作  end

		// 先检查所有任务 是否有 任务中的
		$renwu_list = M('renwu')->where(array('status' => 1))->field("id,number, room_num,close_time")->select();
		if($renwu_list){
			$cur_online = $is_close_id = $close_id = array();
			foreach($renwu_list as $k => $v){
				if($v['close_time'] > 0 && $cur_time - $v['close_time'] >= 5*60 ){
					$is_close_id[] = $v;  //关播超过5分钟，就判断关播，等待下次开启
				}else{
					$ret = file_get_contents("http://x.pps.tv/room/".$v['room_num']);
					preg_match("/data-onmic-is-anchor=\"(.*?)\"/",$ret,$result1);
					if($v['close_time'] == 0 && $result1[1] == 0){
						$close_id[] = $v;
					}else if($result1[1] == 1){
						preg_match_all("/<span class=\"num\">(.*?)<\/span>/",$ret,$result2);
						if(isset($result2[1][1]) && !empty($result2[1][1])){
							$v['cur_number'] = $result2[1][1];
						}else{
							$v['cur_number'] = send_post($v['room_num']);
						}
						$cur_online[] = $v;
					}else{}
				}
			}

			$sql = "";
			if($is_close_id){
				foreach($is_close_id as $k=>$v){
					$sql .= "UPDATE xd_machine SET status = 2 WHERE renwu_id = {$v['id']} AND status = 1;UPDATE xd_renwu SET status = 0, complete_number = {$v['number']},close_time = 0 WHERE id = {$v['id']}; ";
				}
			}

			if($close_id){
				foreach($close_id as $k => $v){
					$sql .= "UPDATE xd_renwu SET close_time = {$cur_time} WHERE id = {$v['id']};";
				}
			}
			if($cur_online){
				foreach($cur_online as $k=>$v){
					$sql .= "UPDATE xd_renwu SET cur_number = {$v['cur_number']} WHERE id = {$v['id']};";
				}
			}
			if($sql != ""){
				$model->execute($sql);
			}
		}


		// 判断 房间是否正常工作
		$check = M("renwu")->where(array('status' => 0))->field("id, room_num,number")->select();
		if($check){
			foreach($check as $k => $v){
				$ret = file_get_contents("http://x.pps.tv/room/".$v['room_num']);
				preg_match("/data-onmic-is-anchor=\"(.*?)\"/",$ret,$result);
				if($result[1] == 1){
					$rem[$v['id']] = $v['number'];
				}
			}
			if($rem){
				$sql = "";
				
				foreach($rem as $k => $v){
					$sql .= "UPDATE xd_renwu SET status = 1, complete_number = {$v} WHERE id = {$k};";
				}
				$model->execute($sql);
			}
		}

		$machine_list = M('machine')->where(array('status' => 0))->select();
		if(!$machine_list){
			exit("暂无空闲机器");
		}
		$renwu_list = M('renwu')->where(array('status' => 1, 'complete_number' => array('gt', 0)))->select();
		if(!$renwu_list){
			exit("暂无任务");
		}
		$nums = self::$num;
		foreach($renwu_list as $k=>$v) {
			$check_room[] = $v;
			$counts = M('machine')->where(array('renwu_id' => $v['renwu_id'], 'status' => 1))->field("sum(get_num) counts")->find();
			$counts = $counts['counts']?$counts['counts']:0;
			while ($v['complete_number'] > 0 && $counts <= $v['number']) {
				$where = " status = 0";
				$machine_lists = M('machine')->where(array('renwu_id' => $v['renwu_id'], 'status' => 1))->field("ip")->select();
				if ($machine_lists) {
					foreach ($machine_lists as $key => $val) {
						$where .= " AND ip NOT LIKE '%{$val['ip']}%'";
					}
				}
				$machine = M('machine')->where($where)->find();
				if ($machine) {
					if ($v['complete_number'] - $nums >= 0) {
						$update['get_num'] = $nums;
						$v['complete_number'] -= $nums;
					} else {
						$update['get_num'] = $v['complete_number'];
						$v['complete_number'] = 0;
					}
					$update['room_num'] = $v['room_num'];
					$update['status'] = 1;
					$update['renwu_id'] = $v['id'];
					M('machine')->where(array('id' => $machine['id']))->save($update);
					M('renwu')->where(array('id' => $v['id']))->save(array('complete_number' => $v['complete_number']));
				} else {
					break;
				}
			}
		}
	}


	/**
	 * 心跳
	 */
	public function heart_beat(){
		$machine_code = I('post.machine_code');
		$complete_num = I('post.complete_num');

		if(!$machine_code){
			$this->ajaxReturn(array('code' => -1, 'msg' => '缺少参数！'));
		}
		$machine = M('machine')->where(array('code' => $machine_code))->find();
		if(!$machine){
			$this->ajaxReturn(array('code' => -2, 'msg' => '机器不存在！'));
		}

		$renwu_data['renwu']  = array();
		$renwu_data['renwu']['status'] = 0;
		$renwu_data['renwu']['sleep'] = 3000;
		$renwu_data['renwu']['restart'] = $machine['restart'];
		
		$update = array('update_time' => time());
		if($machine['get_num'] > 0 ){
			$renwu_data['renwu']['room_num'] = $machine['room_num'];
			$renwu_data['renwu']['get_num'] = $machine['get_num'];
			$renwu_data['renwu']['complete_num'] = $machine['complete_num'];
			$renwu_status = M('renwu')->where(array('id' => $machine['renwu_id']))->field("status")->find();
			if($renwu_status){
				$renwu_data['renwu']['status'] = $renwu_status['status'];
			}
			if($machine['status'] == 3){
				if($renwu_status['status'] == 0){
					$renwu_data['renwu']['status'] = 2;
					$update['status'] = 2;
				}else if($renwu_status['status'] == 1){
					$renwu_data['renwu']['status'] = 1;
					$update['status'] = 1;
				}else if($renwu_status['status'] == 2){
					$renwu_data['renwu']['status'] = 2;
					$update['status'] = 2;
				}
			}
		}else{
			if($machine['status'] == 3){
				$update['status'] = 0;
			}
		}
		$renwu_data['version'] = M('version')->order("id desc")->find();

		if($complete_num){
			$update['complete_num'] = $complete_num;
		}
		M('machine')->where(array('id' => $machine['id']))->save($update);
		$renwu_data['code'] = 0;
		$this->ajaxReturn($renwu_data);
	}


	/**
	 * 重启成功
	 */
	public function restart_success(){
		$machine_code = I('post.machine_code');
		if(!$machine_code){
			$this->ajaxReturn(array('code' => -1, 'msg' => '缺少参数！'));
		}
		$machine = M('machine')->where(array('code' => $machine_code))->find();
		if(!$machine){
			$this->ajaxReturn(array('code' => -2, 'msg' => '机器不存在！'));
		}

		M('machine')->where(array('id' => $machine_code['id']))->save(array('restart' => 0));
		$data = array('code' => 0, 'msg' => '重启成功');
		$this->ajaxReturn($data);
	}


	public function curl(){
		$url = "http://x.pps.tv/room/getFansUserList";
		$post_data = array ("room_id" => "123456","page" => 1, 'page_size' => 10);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 4);
		curl_setopt($ch, CURLOPT_ENCODING, ""); //必须解压缩防止乱码
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1; zh-CN) AppleWebKit/535.12 (KHTML, like Gecko) Chrome/22.0.1229.79 Safari/535.12");
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);

		$output = curl_exec($ch);
		curl_close($ch);

		print_r($output);


	}




}