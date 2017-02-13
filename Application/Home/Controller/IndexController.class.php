<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
	// 下单页面渲染
    public function index(){
		$this->redirect('site/index');
		$m = m('yewu');
		$this->mlist1 = $m->where(array('mpid'=>0))->select();
		$this->mlist2 = $m->where(array('mpid'=>$this->mlist1[0]['id']))->select();
		$this->mlist3 = $m->where(array('mpid'=>$this->mlist2[0]['id']))->select();
        $this->display('index');
    }
    // 用户信息页面渲染
	public function showUser(){
		$m = m('daili');
		$user = $m->where(array('muser'=>i('session.muser')))->find();
		$user['count'] = m('dingdan')->where(array('muser'=>$user['id']))->count();
		$this->assign('user',$user);
		$this->display('user');
	}
	// 订单页面渲染
	public function showOrder(){
		$User = M(); // 实例化User对象
		$count      = $User->query("select count(a.muser) from xd_daili a,xd_dingdan b,xd_yewu c where a.Id=".i('session.uid')." and a.Id=b.muser and c.Id=b.motype");//查询满足要求的总记录数
		$Page       = new \Think\Page($count[0]['count(a.muser)'],15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $User->query("select b.*,a.muser,c.mname from xd_daili a,xd_dingdan b,xd_yewu c where a.Id=".i('session.uid')." and a.Id=b.muser and c.Id=b.motype order by b.mcreate_time desc limit $Page->firstRow,$Page->listRows");
		// $list = $User->where('status=1')->order('create_time')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		// print_r($orderls);
		$this->display('order');
	}
	// 消费页面渲染
	public function showXf(){
		$User = M(); // 实例化User对象
		$count      = $User->query("select count(a.muser) from xd_daili a,xd_xfjl b where a.Id=".i('session.uid')." and a.Id=b.muser");//查询满足要求的总记录数
		$Page       = new \Think\Page($count[0]['count(a.muser)'],15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $User->query("select b.*,a.muser from xd_daili a,xd_xfjl b where a.Id=".i('session.uid')." and a.Id=b.muser order by b.mtime desc limit $Page->firstRow,$Page->listRows");
		// $list = $User->where('status=1')->order('create_time')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		// print_r($orderls);
		$this->display('xf');
	}
	// 充值处理函数
	public function actCz(){
		if(IS_POST){
			$data = m('daili')->field('mstate')->where(array('Id'=>i('session.uid')))->find();
			if(!$data['mstate'])
				$this->error('充值失败，账号未激活！');
			if (!i('post.mcodeid')) 
				$this->error('充值失败，非法字段，请重试！');
			$k = m('kami');
			$data = $k->where(array('mCODEID'=>i('post.mcodeid')))->find();
			if($data){
				if($data['mis_use'] == 1){
					$this->error('充值失败，卡密已被使用！');
				}
				$jifen = $data['mprice'] * 100;
				if(m('daili')->where(array('Id'=>i('session.uid')))->setInc('mjifen',$jifen)){
					m('daili')->where(array('Id'=>i('session.uid')))->setInc('mptotal',$jifen);
					if($k->save(array('Id'=>$data['id'],'mis_use'=>1))){
						m('xfjl')->add(array('mtype'=>0,'mmoney'=>$jifen,'muser'=>i('session.uid'),'mtime'=>time()));
						$this->success('充值成功！');
					} else {
						$this->error('充值失败，请联系管理员！');
					}
				}
			} else {
				$this->error('充值失败，卡密不存在！');
			}
		}
	}
	// 业务JSON查找
	public function showNav(){
		$m = m('yewu');
			if(i('post.type')==3){
				$item = $m->where(array('Id'=>i('post.pid')))->find();
				echo json_encode(array('mitem'=>$item));
				return ;
			}
			$mlist1 = $m->where(array('mpid'=>i('post.pid')))->select();
			foreach($mlist1 as $v){
				$str1 .= '<option value='.$v['id'].'>'.$v['mname'].'</option>';
			}
			$mlist2 = $m->where(array('mpid'=>$mlist1[0]['id']))->select();
			foreach($mlist2 as $v){
				$str2 .= '<option value='.$v['id'].'>'.$v['mname'].'</option>';
			}
			if(i('post.type')==1){
				$item = $m->where(array('Id'=>$mlist1[0]['id']))->find();
			} else if(i('post.type')==2){
				$item = $m->where(array('Id'=>$mlist2[0]['id']))->find();
			}
			echo json_encode(array('mlist'=>array('mlist1'=>$str1,'mlist2'=>$str2),'mitem'=>$item));
		
	}

	public function indexs(){
		if(IS_POST){
			$data = I('post.');
			$cur_time = time();
			$where['room_num'] = $data['room_num'];
			$where['status'] = array('neq', 2);
			$renwu = M('renwu')->where($where)->find();
			if($renwu){
				$this->error("房间号：".$data['room_num']."任务已经存在，在未完成前不允许添加");return;
			}

			$data['user_id'] = I("session.uid");
			$data['start_time'] = $data['add_time'] = $cur_time;
			$data['order_num'] = date('YmdHis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

			if(I('post.types') == 'day'){
				$data['type'] = 2;
				$add_time = $data['when_long'] * 3600 *  24;
			}else if(I('post.types')  == 'hours'){
				$data['type'] = 1;
				$add_time = $data['when_long'] * 3600;
			}else{
				exit("参数错误!!");
			}
			$data['end_time'] = $data['add_time'] + $add_time;

			$ret = file_get_contents("http://x.pps.tv/room/".$data['room_num']);
			preg_match("/data-onmic-is-anchor=\"(.*?)\"/",$ret,$result);
			if($result[1] == 1){
				$data['status'] = 1;
				$data['complete_number'] = $data['number'];
			}

			$id = M('renwu')->add($data);
			if($id){
				$this->success("添加成功");
			}else{
				$this->error("添加成功");
			}
		}else{
			$this->display('indexs');
		}
	}



	// 下单处理函数
	public function actSubmit(){
		if(IS_POST){
			$data = m('daili')->field('mstate')->where(array('Id'=>i('session.uid')))->find();
			if(!$data['mstate'])
				$this->error('充值失败，账号未激活！');
			if (!i('post.motype') || !i('post.mnum') || !i('post.mczID') || !i('post.mbz')) 
				$this->error('下单失败，非法字段，请重试！');
			$user = i('session.muser');
			$data = i('post.');
			$u = m('daili');
			$m = m('dingdan');
			$y = m('yewu');
			$user = $u->where(array('muser'=>$user))->find();
			$yewu = $y->where(array('Id'=>$data['motype']))->find();
			$price = $user['mjifen'];
			// 计算需要积分多少
			$jifen = $data['mnum'] * $yewu['mprice'];
			if($jifen > $user['mjifen']) $this->error('下单失败，积分不足！');
			$data['mcreate_time'] = time();
			$data['muser'] = i('session.uid');
			if($m->data($data)->add()){
				if(m('daili')->where(array('Id'=>i('session.uid')))->setDec('mjifen',$jifen)){
					echo m('xfjl')->add(array('mtype'=>1,'mmoney'=>$jifen,'muser'=>i('session.uid'),'mtime'=>time()));
					$this->success('下单成功！');
				}
			} else {
				$this->error('下单失败，请检查字段！');
			}
		}
	}


}