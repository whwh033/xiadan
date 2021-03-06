<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
	// 后台首页渲染
    public function index(){
    	$zuoTian = strtotime(date("Y-m-d",strtotime("-1 day")));
    	$jinTian = strtotime(date("Y-m-d"));
    	$qianTian = strtotime(date("Y-m-d",strtotime("-2 day")));
    	$mingTian = strtotime(date("Y-m-d",strtotime("+1 day")));
    	// 前天的总金额
    	$sql = "select sum(a.mnum*b.mprice) as total from xd_dingdan a,xd_yewu b where a.motype=b.Id and a.mcreate_time >=$qianTian and a.mcreate_time <= $zuoTian";
    	$Data1['price'] = m()->query($sql);
    	// 前天的总订单
    	$sql = "select count(Id) as total from xd_dingdan where mcreate_time >=$qianTian and mcreate_time <= $jinTian";
    	$Data1['count'] = m()->query($sql);

    	// 昨天的总金额
    	$sql = "select sum(a.mnum*b.mprice) as total from xd_dingdan a,xd_yewu b where a.motype=b.Id and a.mcreate_time >=$zuoTian and a.mcreate_time <= $jinTian";
    	$Data2['price'] = m()->query($sql);
    	// 昨天的总订单
    	$sql = "select count(Id) as total from xd_dingdan where mcreate_time >=$zuoTian and mcreate_time <= $jinTian";
    	$Data2['count'] = m()->query($sql);

    	// 今天的总金额
    	$sql = "select sum(a.mnum*b.mprice) as total from xd_dingdan a,xd_yewu b where a.motype=b.Id and a.mcreate_time >=$jinTian and a.mcreate_time <= $mingTian";
    	$Data3['price'] = m()->query($sql);
    	// 今天的总订单
    	$sql = "select count(Id) as total from xd_dingdan where mcreate_time >=$jinTian and mcreate_time <= $mingTian";
    	$Data3['count'] = m()->query($sql);


    	// 全部的总金额
    	$sql = "select count(Id) as total from xd_daili";
    	$Data4['user'] = m()->query($sql);
    	// 全部的总订单
    	$sql = "select count(Id) as total from xd_dingdan";
    	$Data4['count'] = m()->query($sql);


    	$this->Data1 = $Data1;
    	$this->Data2 = $Data2;
    	$this->Data3 = $Data3;
    	$this->Data4 = $Data4;
        $this->display('index');
    }
	//后台系统配置页渲染
	public function view_editWeb(){
		$m = m('web');
		$this->data = $m->where(array('Id'=>1))->find();
		$this->display('editweb');
	}
	//后台代理编辑页渲染
	public function view_editDaiLi(){
		$m = m('daili');
		$this->nowDaiLi = $m->where(array('Id'=>i('get.id')))->find();
		$this->display('editdaili');
	}
	// 订单编辑页面处理
	public function actEditDingdan(){
		if(IS_AJAX){
			$m = m('dingdan');
			if($m->save(i('post.'))){
				echo 1;
			} else {
				echo 0;
			}
		}
	}
	// 后台订单编辑/查看
	public function view_editorder(){
		$m = m('dingdan');
		$data = $m->where(array('Id'=>i('get.id')))->find();
		$this->user = m('daili')->field('muser')->where(array('Id'=>$data['muser']))->find();
		$y = m('yewu');
		$this->yewuls = layer($y->select());
		$this->nowYeWu = $data;
		$this->display('editdingdan');
	}
	// 后台代理列表渲染
	public function view_daili(){
		if(i('get.action') == 'ajax'){
			$m = M('daili'); // 实例化User对象
			$count      = $m->count();// 查询满足要求的总记录数
			$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			$show       = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$list = $m->order('mcreate_time')->limit($Page->firstRow.','.$Page->listRows)->select();
			$d = m('dingdan');
			foreach($list as $k=>$v){
				$list[$k]['mordernum'] = $d->where(array('muser'=>$v['id']))->count();
			}
			$id = i('get.p')*20-20;
			foreach($list as $v){
				$id++;
				$mlist .= '<tr>
					<td><input type="checkbox" /></td>
					<td>'.$id.'</td>
					<td><a class="am-u-sm-12" href="#">'.$v['muser'].'</a></td>
					<td>'.$v['mjifen'].'</td>
					<td class="am-hide-sm-only">'.$v['mordernum'].'</td>
					<td>
					  <div class="am-btn-toolbar">
						<div class="am-btn-group am-btn-group-xs">
						  <button href='.u('Index/view_editDaiLi',array('id'=>$v['id'])).' class="editYeWu am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span> 编辑</button>
						  <button href='.u('Index/view_delDaiLi',array('id'=>$v['id'])).' class="delYeWu am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
						</div>
					  </div>
					</td>
				  </tr>';
			}
			
			echo  json_encode(array('mlist'=>$mlist,'mshow'=>$show));
		} else {
			$m = M('daili'); // 实例化User对象
			$count      = $m->count();// 查询满足要求的总记录数
			$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			$show       = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$list = $m->order('mcreate_time')->limit($Page->firstRow.','.$Page->listRows)->select();
			$d = m('dingdan');
			foreach($list as $k=>$v){
				$list[$k]['mordernum'] = $d->where(array('muser'=>$v['id']))->count();
			}
			$this->assign('mlist',$list);// 赋值数据集
			$this->assign('mpage',$show);// 赋值分页输出
			$this->display('daili');
		}
	}
	// 后台添加代理页面渲染
	public function view_adduser(){
		$this->display('adduser');
	}
	// 后台业务列表页渲染
	public function view_yewu(){
		if(i('get.action') == 'ajax'){
			$m = M('yewu'); // 实例化User对象
			$d = M('dingdan');
			$count      = $m->count();// 查询满足要求的总记录数
			$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			$show       = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$list = $m->order('mcreate_time')->limit($Page->firstRow.','.$Page->listRows)->select();
			$arr = array();
			foreach($list as $v){
				if($v['mpid'] == 0){
					$v['pname'] = array('mname'=>'顶级栏目');
					$v['dnum'] = 0;
				} else {
					$v['pname'] = $m->where(array('Id'=>$v['mpid']))->find();
					$v['dnum'] = $d->where(array('motype'=>$v['id']))->count();
				}
				$arr[] = $v;
			}
			foreach($arr as $v){
				$mlist .= '
					<tr>
					<td><input type="checkbox" /></td>
					<td>'.$v['id'].'</td>
					<td><a class="am-u-sm-12" href="#">'.$v['mname'].'</a></td>
					<td>'.$v['pname']['mname'].'</td>
					<td class="am-hide-sm-only">'.$v['dnum'].'</td>
					<td>
					  <div class="am-btn-toolbar">
						<div class="am-btn-group am-btn-group-xs">
						  <button href='.u("Index/view_edityewu",array("id"=>$v["id"])).' class="editYeWu am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span> 编辑</button>
						  <button href='.u("Index/view_delyewu",array("id"=>$v["id"])).' class="delYeWu am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
						</div>
					  </div>
					</td>
				  </tr>
				';
			}
			
			echo  json_encode(array('mlist'=>$mlist,'mshow'=>$show));
		} else {
			$m = M('yewu'); // 实例化User对象
			$d = M('dingdan');
			$count      = $m->count();// 查询满足要求的总记录数
			$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			$show       = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$list = $m->order('mcreate_time')->limit($Page->firstRow.','.$Page->listRows)->select();
			$arr = array();
			foreach($list as $v){
				if($v['mpid'] == 0){
					$v['pname'] = array('mname'=>'顶级栏目');
					$v['dnum'] = 0;
				} else {
					$v['pname'] = $m->where(array('Id'=>$v['mpid']))->find();
					$v['dnum'] = $d->where(array('motype'=>$v['id']))->count();
				}
				$arr[] = $v;
			}
			$this->assign('mlist',$arr);// 赋值数据集
			$this->assign('mpage',$show);// 赋值分页输出
		$this->display('yewu');
		}
	}
	// 后台设置卡密使用状态
	public function actSetKamiState(){
		if(IS_AJAX){
			$m = m('kami');
			if($m->data(array('Id'=>i('get.id'),'mis_use'=>i('post.mis_use')))->save()){
				echo 1;
			} else {
				echo 0;
			}
		}
	}
	// 后台删除卡密处理
	public function actDelKami(){
		if(IS_AJAX){
			$m = m('kami');
			if($m->where(array('Id'=>i('get.id')))->delete()){
				echo 1;
			} else {
				echo 0;
			}
		}
	}
	// 后台删除订单处理
	public function actDelDingdan(){
		if(IS_AJAX){
			$m = m('dingdan');
			if($m->where(array('Id'=>i('post.id')))->delete()){
				echo 1;
			} else {
				echo 0;
			}
		}
	}
	// 后台删除代理处理
	public function view_delDaiLi(){
		if(IS_AJAX){
			$m = m('daili');
			if($m->where(array('Id'=>i('get.id')))->delete()){
				echo 1;
				
			} else {
				echo 0;
			}
		}
	}
	// 后台删除业务分类处理
	public function view_delyewu(){
		if(IS_AJAX){
			$m = m('yewu');
			if($m->where(array('Id'=>i('get.id')))->delete()){
				echo 1;
				
			} else {
				echo 0;
			}
		}
	}
	// 下单列表页面渲染
	public function view_dingdan(){
		if(i('get.action') == 'ajax'){
			if(i('get.mstate') != '') $state = 'd.mstate = '.i('get.mstate').' and';
			$m = M();
			$count      = $m->query('select count(a.mname) from xd_yewu a,xd_yewu b,xd_yewu c,xd_dingdan d,xd_daili e where '.$state.' a.id=b.mpid and b.id=c.mpid and c.id=d.motype and e.Id=d.muser');// 查询满足要求的总记录数
			$Page       = new \Think\Page($count[0]['count(a.mname)'],20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			$show       = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$list = $m->query("select a.mname as a,b.mname as b,c.mname as c,d.*,e.muser from xd_yewu a,xd_yewu b,xd_yewu c,xd_dingdan d,xd_daili e where ".$state."  a.id=b.mpid and b.id=c.mpid and c.id=d.motype and e.Id=d.muser order by mcreate_time desc limit $Page->firstRow,$Page->listRows");
			foreach($list as $v){
				if($v['mstate'] == 4) $if4 = 'selected';
				if($v['mstate'] == 3) $if3 = 'selected';
				if($v['mstate'] == 2) $if2 = 'selected';
				if($v['mstate'] == 1) $if1 = 'selected';
				if($v['mstate'] == 0) $if0 = 'selected';
				$mlist .= '
				<tr>
                <td><input type="checkbox" /></td>
                <td>'.$v['id'].'</td>
                <td><a href="#">'.$v['muser'].'</a></td>
                <td>'.$v['a'].'---'.$v['b'].'---'.$v['c'].'</td>
                <td class="am-hide-sm-only">'.$v['mczid'].'</td>
                <td class="am-hide-sm-only">'.$v['mnum'].'</td>
                <td>
					  <select dataId="'.$v['id'].'" class="czzt" name="mstate" data-am-selected="{btnSize: "sm"}">
						<option '.$if4.' value="4">补单</option>
						<option '.$if0.' value="0">未处理</option>
						<option '.$if1.' value="1">已完成</option>
						<option '.$if2.' value="2">取消订单</option>
						<option '.$if3.' value="3">正在处理</option>
					  </select>

					<div class="am-modal am-modal-prompt" tabindex="-1" id="my-prompt">
					  <div class="am-modal-dialog">
					    <div class="am-modal-hd">取消订单</div>
					    <div class="am-modal-bd">
					      请输入取消原因...
					      <input type="text" class="am-modal-prompt-input">
					    </div>
					    <div class="am-modal-footer">
					      <span class="am-modal-btn" data-am-modal-cancel>取消</span>
					      <span class="am-modal-btn" data-am-modal-confirm>提交</span>
					    </div>
					  </div>
					</div>
                </td>
              </tr>
              <tr>
                <td colspan="7">
                备注：'.$v['mbz'].'
                </td>
              </tr>
				';
				
			}
			echo  json_encode(array('mlist'=>$mlist,'mshow'=>$show));
		} else {
			if(i('get.mstate') != '') $state = 'd.mstate = '.i('get.mstate').' and';
			$m = M();
			$count      = $m->query('select count(a.mname) from xd_yewu a,xd_yewu b,xd_yewu c,xd_dingdan d,xd_daili e where '.$state.'  a.id=b.mpid and b.id=c.mpid and c.id=d.motype and e.Id=d.muser');// 查询满足要求的总记录数
			$Page       = new \Think\Page($count[0]['count(a.mname)'],20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			$show       = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$list = $m->query("select a.mname as a,b.mname as b,c.mname as c,d.*,e.muser from xd_yewu a,xd_yewu b,xd_yewu c,xd_dingdan d,xd_daili e where $state a.id=b.mpid and b.id=c.mpid and c.id=d.motype and e.Id=d.muser order by mcreate_time desc limit $Page->firstRow,$Page->listRows");
			$this->assign('mlist',$list);// 赋值数据集
			$this->assign('mpage',$show);// 赋值分页输出
			$this->display('dingdan');
		}
	}
	//后台业务编辑处理
	public function actEYewu(){
		if(IS_AJAX){
			$m = m('yewu');
			if($m->save(i('post.'))){
				echo 1;
			} else {
				echo 0;
			}
		}
	}
	//后台网站配置编辑处理
	public function actEditWeb(){
		if(IS_AJAX){
			$m = m('web');
			if($m->save(i('post.'))){
				echo 1;
			} else {
				echo 0;
			}
		}
	}
	// 后台编辑用户处理
	public function actEditUser(){
		if(IS_AJAX){
			$m = m('daili');
			$_POST['mcreate_time'] = time();
			if (i('post.mpass') != '***') {
				$_POST['mpass'] = md5($_POST['mpass']);
			} else {
				unset($_POST['mpass']);
			}
			if($m->save(i('post.'))){
				echo 1;
			} else {
				echo 0;
			}
		}
	}
	// 后台业务编辑页渲染
	public function view_edityewu(){
		$m = m('yewu');
		$this->yewuls = layer($m->where('Id != '.i('get.id'))->select());
		$this->nowYeWu = $m->where(array('Id'=>i('get.id')))->find();
		$this->display('edityewu');
	}
	// 后台业务添加页渲染
	public function view_addyewu(){
		$m = m('yewu');
		$this->yewuls = layer($m->select());
		$this->display('addyewu');
	}
	//后台卡密列表页渲染
	public function view_kamils(){
		if(i('get.action') == 'ajax'){
			$m = M('kami'); // 实例化User对象
			$count      = $m->count();// 查询满足要求的总记录数
			$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			$show       = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$list = $m->order('mcreate_time')->limit($Page->firstRow.','.$Page->listRows)->select();
			
			foreach($list as $v){
				if($v['mis_use']==1){
					$use = '已使用';
				} else {
					$use = '未使用';
				}
				$mlist .= '<tr>
					<td><input type="checkbox" /></td>
					<td>'.$v['id'].'</td>
					<td><span class="am-u-sm-12" href="#">'.$v['mcodeid'].'</span></td>
					<td>'.$use.'</td>
					<td>'.$v['mprice'].'</td>
					<td>
					  <div class="am-btn-toolbar">
						<div class="am-btn-group am-btn-group-xs">
						  <button href='.u("Index/actSetKamiState",array("id"=>$v["id"])).' class="setState am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span> <if condition="$v.mis_use eq 0">设为已使用<else/>设为未使用</if></button>
						  <button href='.u("Index/actDelKami",array("id"=>$v["id"])).' class="delKaMi am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
						</div>
					  </div>
					</td>
				  </tr>';
			}
			
			echo  json_encode(array('mlist'=>$mlist,'mshow'=>$show));
		} else {
			$m = M('kami'); // 实例化User对象
			$count      = $m->count();// 查询满足要求的总记录数
			$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			$show       = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$list = $m->order('mcreate_time')->limit($Page->firstRow.','.$Page->listRows)->select();
			$this->assign('mlist',$list);// 赋值数据集
			$this->assign('mpage',$show);// 赋值分页输出
		$this->display('kamils');
		}
	}
	//后台卡密新增页渲染
	public function view_addkami(){
		$this->display('addkami');
	}
	
	// 后台业务添加处理
	public function actYewu(){
		$m = m('yewu');
		$_POST['mcreate_time'] = time();
		if($m->data(i('post.'))->add()){
			echo 1;
		} else {
			echo 0;
		}
	}
	// 后台添加代理处理
	public function actUser(){
		$m = m('daili');
		$_POST['mcreate_time'] = time();
		$_POST['mpass'] = md5($_POST['mpass']);
		if($m->data(i('post.'))->add()){
			echo 1;
		} else {
			echo 0;
		}
	}
	// 后台添加卡密处理
	public function actAddKami(){
		if(IS_AJAX){
			$m = m('kami');
			do {
				$code = md5(getRandChar(10).rand(1,9));
				if(!$m->where(array('mCODEID'=>$code))->count()){
					break;
				}
			} while($m->where(array('mCODEID'=>$code))->count());
			if($m->data(array('mCODEID'=>$code,'mprice'=>i('post.mprice'),'mcreate_time'=>time()))->add()){
				echo json_encode(array('state'=>'ok','token'=>$code));
			} else {
				echo json_encode(array('state'=>'error','token'=>$code));
			}
		}
		
	}

	// 修改订单状态Api
	public function Api_Data(){
		if(IS_POST){
			if(i('post.act')=='saveOrderState'){
				echo m('dingdan')->save(i('post.'));
			}
		}
	}


	// 下单列表页面渲染
	public function new_dingdan(){

		$renwu_model = M('renwu');
		$where = array();

		$act = I('get.act');
		if($act == 'del' && I('get.id')){
			M('machine')->where(array('renwu_id' => I('get.id')))->save(array('status' => 2));
			$res = $renwu_model->where(array('id' => I('get.id')))->delete();
			if($res){
				$this->ajaxReturn(array('code' => 0, 'msg' => '删除成功!'));
			}
			$this->ajaxReturn(array('code' => -1, 'msg' => '删除失败!'));
		}
		if(I('get.status')){
			$staus = I('get.status');
			if($staus == -1){
				$staus = 0;
			}
			$where['status'] = $staus;
		}
		$count = $renwu_model->where($where)->count();
		$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出

		$list = $renwu_model->join("xd_daili ON xd_renwu.user_id = xd_daili.id")->field("xd_daili.muser, xd_renwu.*")->where($where)->order("add_time desc")->limit($Page->firstRow,$Page->listRows)->select();
		if($list){
			foreach($list as $v){
				$renwu_id[] = $v['id'];
				$lists[$v['id']] = $v;
			}
			$data = M('machine')->where(array('renwu_id' => array('IN', implode(',', $renwu_id))))->select();

			$member_count = array();
			foreach($data as $v){
				if($v['status'] == 1){
					$member_count[$v['renwu_id']] += $v['complete_num'];
				}
			}

			foreach($lists as $k => &$v){
				if(isset($member_count[$k])){
					$v['cur_numbers'] = $member_count[$k];
				}else{
					$v['cur_numbers'] = 0;
				}

			}
			$list = $lists;
		}
		if(I('get.action') == 'ajax'){
			$this->ajaxReturn(array('mlist' => $list, 'mpage' => $show));
		}
		$this->assign("mlist", $list);
		$this->assign('mpage',$show);// 赋值分页输出
		$this->display('newdingdan');
	}


	public function rboot(){

		$machine_model = M('machine');
		$where = array();

		if(I('get.status')){
			$staus = I('get.status');
			if($staus == -1){
				$staus = 0;
			}
			$where['status'] = $staus;
		}
		if(I('get.renwu_id')){
			$where['renwu_id'] = I('get.renwu_id');
		}

		$count = $machine_model->where($where)->count();
		$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出

		$list = $machine_model->where($where)->order("add_time desc")->limit($Page->firstRow,$Page->listRows)->select();
		if(I('get.action') == 'ajax'){
			$this->ajaxReturn(array('mlist' => $list, 'mpage' => $show));
		}
		$this->assign("mlist", $list);
		$this->assign('mpage',$show);// 赋值分页输出
		$this->display('rboot');
	}

	public function user_lists(){

		$users_model = M('users');
		if(I('get.act') == 'delAll'){
			$ret = $users_model->where(array('status' => 1))->delete();
			if($ret){
				$this->ajaxReturn(array('code' => 0, 'msg' => "删除成功"));
			}
			$this->ajaxReturn(array('code' => -1, 'msg' => "删除失败"));
		}

		$id = I('get.id');
		if(!empty($id)){
			$res = $users_model->where(array('id' => I('get.id')))->delete();
			if($res){
				$this->ajaxReturn(array('code' => 0, 'msg' => "删除成功"));
			}
			$this->ajaxReturn(array('code' => -1, 'msg' => "删除失败"));
		}
		$where = array();

		if(I('get.status')){
			$staus = I('get.status');
			if($staus == -1){
				$staus = 0;
			}
			$where['status'] = $staus;
		}

		$count = $users_model->where($where)->count();
		$Page       = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出

		$list = $users_model->where($where)->order("id desc")->limit($Page->firstRow,$Page->listRows)->select();
		if(I('get.action') == 'ajax'){
			$this->ajaxReturn(array('mlist' => $list, 'mpage' => $show));
		}
		$this->assign("mlist", $list);
		$this->assign('mpage',$show);// 赋值分页输出
		$this->display('users');
	}

	public function changeStatus(){
		$id = I('get.id');
		$m = M('renwu')->where(array('id' => $id))->save(array('end_time' => time()));
		if($m){
			$this->ajaxReturn(array('code' => 0, 'msg' => '修改成功,稍等一分钟'));
		}else{
			$this->ajaxReturn(array('code' => -1, 'msg' => '修改成功'));
		}
	}




}