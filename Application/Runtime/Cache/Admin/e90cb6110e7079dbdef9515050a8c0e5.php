<?php if (!defined('THINK_PATH')) exit();?><div class="am-cf am-padding">
	<div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">订单列表</strong> / <small>全部订单</small></div>
</div>
  <hr>
      <div class="am-g">
        <div class="am-u-sm-12 am-u-md-6">
          <div class="am-btn-toolbar">
            <div class="am-u-sm-12 am-btn-group am-btn-group-xs">
              
			<form class="am-u-sm-12 am-form-inline" role="form">

				<div class="am-form-group">
					<a href="<?php echo u('Index/view_dingdan',array('mstate'=>0));?>" class="menu_class am-btn-default am-btn"><span class="am-icon-plus"></span> 未处理</a>		
				</div>

				<div class="am-form-group">
					<a href="<?php echo u('Index/view_dingdan',array('mstate'=>1));?>" class="menu_class am-btn-default am-btn"><span class="am-icon-plus"></span> 已完成</a>
				</div>

				<div class="am-form-group">
					<a href="<?php echo u('Index/view_dingdan',array('mstate'=>2));?>" class="menu_class am-btn-default am-btn"><span class="am-icon-plus"></span> 取消订单</a>
				</div>

				<div class="am-form-group">
					<a href="<?php echo u('Index/view_dingdan',array('mstate'=>3));?>" class="menu_class am-btn-default am-btn"><span class="am-icon-plus"></span> 正在处理</a>
				</div>

				<div class="am-form-group">
					<a href="<?php echo u('Index/view_dingdan',array('mstate'=>4));?>" class="menu_class am-btn-default am-btn"><span class="am-icon-plus"></span> 补单</a>
				</div>

				</form>
			  
			  
            </div>
          </div>
        </div>
      </div>

      <div class="am-g">
        <div class="am-u-sm-12">
            <table class="am-table am-table-striped am-table-hover table-main">
              <thead>
              <tr>
                <th class="table-check"><input type="checkbox" /></th><th class="table-ids">订单号</th><th class="table-title">下单者</th><th class="table-type">任务内容</th><th class="table-author am-hide-sm-only">操作ID</th><th class="table-author am-hide-sm-only">件数</th><th class="table-set">操作</th>
              </tr>
              </thead>
              <tbody id="list_container">
			  <?php if(is_array($mlist)): foreach($mlist as $key=>$v): ?><tr>
                <td><input type="checkbox" /></td>
                <td><?php echo ($v["id"]); ?></td>
                <td><a href="#"><?php echo ($v['muser']); ?></a></td>
                <td><?php echo ($v["a"]); ?>---<?php echo ($v["b"]); ?>---<?php echo ($v["c"]); ?></td>
                <td class="am-hide-sm-only"><?php echo ($v["mczid"]); ?></td>
                <td class="am-hide-sm-only"><?php echo ($v["mnum"]); ?></td>
                <td>
					  <select dataId="<?php echo ($v["id"]); ?>" class="czzt" name="mstate" data-am-selected="{btnSize: 'sm'}">
						<option <?php if($v["mstate"] == 4): ?>selected<?php endif; ?> value="4">补单</option>
						<option <?php if($v["mstate"] == 0): ?>selected<?php endif; ?> value="0">未处理</option>
						<option <?php if($v["mstate"] == 1): ?>selected<?php endif; ?> value="1">已完成</option>
						<option <?php if($v["mstate"] == 2): ?>selected<?php endif; ?> value="2">取消订单</option>
						<option <?php if($v["mstate"] == 3): ?>selected<?php endif; ?> value="3">正在处理</option>
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
                备注：<?php echo ($v["mbz"]); ?>
                </td>
              </tr><?php endforeach; endif; ?>
              </tbody>
            </table>
            <div class="am-cf">
              <div id="mpage" class="am-fr am-margin-bottom">
				<?php echo ($mpage); ?>
              </div><style>
					.current{
						color:white;
						text-align:center;
						width:42px;
						line-height:37px;
						display:inline-table;
						background-color: #0e90d2;
						border-color: #0e90d2;
						margin-right:5px;
					}
					.num,.next,.prev{
						color:#0e90d2;
						text-align:center;
						width:42px;
						line-height:37px;
						display:inline-table;
						background-color: #fff;
						border: 1px solid #ddd;
						margin-right:5px;
					}
			  </style>
            </div>
        </div>
<script type="text/javascript">
$('.menu_class').click(function(){
		$('.admin-content-body').load($(this).attr('href'));
		return false;
	});
		$('#list_container').on('change','.czzt',function(){
			var id = $(this).attr('dataId');
			if($(this).find('option:selected').html()=='取消订单'){
				$('#my-prompt').modal({
			      relatedTarget: this,
			      onConfirm: function(e) {
			      	$.post({
			      		url:'<?php echo u("Index/Api_Data");?>',
			      		data:{act:'saveOrderState',Id:id,mstate:2,mbz:e.data},
			      		success:function(data){
			      			
			      		}
			      	});
			      },
			      onCancel: function(e) {
			        alert('操作失败!');
			      }
			    });
			} else if($(this).find('option:selected').text()=='未处理'){
				var mstate = 0;
				$.post({
		      		url:'<?php echo u("Index/Api_Data");?>',
		      		data:{Id:id,act:'saveOrderState',mstate:mstate},
		      		success:function(data){

		      		}
		      	});
			} else if($(this).find('option:selected').text()=='已完成'){
				var mstate = 1;
				$.post({
		      		url:'<?php echo u("Index/Api_Data");?>',
		      		data:{Id:id,act:'saveOrderState',mstate:mstate},
		      		success:function(data){

		      		}
		      	});
			} else if($(this).find('option:selected').text()=='正在处理'){
				var mstate = 3;
				$.post({
		      		url:'<?php echo u("Index/Api_Data");?>',
		      		data:{Id:id,act:'saveOrderState',mstate:mstate},
		      		success:function(data){

		      		}
		      	});
			} else if($(this).find('option:selected').text()=='补单'){
				var mstate = 4;
				$.post({
		      		url:'<?php echo u("Index/Api_Data");?>',
		      		data:{Id:id,act:'saveOrderState',mstate:mstate},
		      		success:function(data){

		      		}
		      	});
			}
		});
		$('#list_container').on('click','.editYeWu',function(){
			$('.admin-content-body').load($(this).attr('href'));
			return ;
		});
		
		$('#addUser').click(function(){
			$('.admin-content-body').load('<?php echo u("Index/view_adduser");?>');
		});
		$('#mpage').on('click','a',function(){
			var url = $(this).attr('href');
			$.get({
					url:url,
					data:{action:'ajax'},
					dataType: "json", 
					success:function(data){
						$('#list_container').html("");
						$('#list_container').html(data.mlist);
						$('#mpage').html("");
						$('#mpage').html(data.mshow);
					}
				});
			return false;
		});
	  </script>
      </div>