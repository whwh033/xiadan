<?php if (!defined('THINK_PATH')) exit();?><div class="am-cf am-padding">
	<div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">业务分类</strong> / <small>全部分类</small></div>
</div>
  <hr>
      <div class="am-g">
        <div class="am-u-sm-12 am-u-md-6">
          <div class="am-btn-toolbar">
            <div class="am-btn-group am-btn-group-xs">
              <button type="button" id="addYewu" class="am-btn am-btn-default"><span class="am-icon-plus"></span> 新增</button>
            </div>
          </div>
        </div>
      </div>

      <div class="am-g">
        <div class="am-u-sm-12">
            <table class="am-table am-table-striped am-table-hover table-main">
              <thead>
              <tr>
                <th class="table-check"><input type="checkbox" /></th><th class="table-id">ID</th><th class="table-title">业务名称</th><th class="table-type">上级分类</th><th class="table-author am-hide-sm-only">订单数</th><th class="table-set">操作</th>
              </tr>
              </thead>
              <tbody id="list_container">
			  <?php if(is_array($mlist)): foreach($mlist as $key=>$v): ?><tr>
					<td><input type="checkbox" /></td>
					<td><?php echo ($v["id"]); ?></td>
					<td><a class="am-u-sm-12" href="#"><?php echo ($v["mname"]); ?></a></td>
					<td><?php echo ($v['pname']['mname']); ?></td>
					<td class="am-hide-sm-only"><?php echo ($v["dnum"]); ?></td>
					<td>
					  <div class="am-btn-toolbar">
						<div class="am-btn-group am-btn-group-xs">
						  <button href="<?php echo u('Index/view_edityewu',array('id'=>$v['id']));?>" class="editYeWu am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span> 编辑</button>
						  <button href="<?php echo u('Index/view_delyewu',array('id'=>$v['id']));?>" class="delYeWu am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
						</div>
					  </div>
					</td>
				  </tr><?php endforeach; endif; ?>
              </tbody>
            </table>
            <div class="am-cf">
              
              <div id="mpage" class="am-fr am-margin-bottom">
				<?php echo ($mpage); ?>
              </div>
			  <style>
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

      </div>
	  <script type="text/javascript">
		$('#list_container').on('click','.delYeWu',function(){
			var url = $(this).attr('href');
			$this = $(this).parent().parent().parent().parent();
			$.get({
					url:url,
					success:function(data){
						if(data){
							alert('删除成功！');
							$this.remove();
						} else {
							alert('删除失败！');
						}
					}
				});
			return ;
		});
		$('#list_container').on('click','.editYeWu',function(){
			$('.admin-content-body').load($(this).attr('href'));
			return ;
		});
		$('#addYewu').click(function(){
			$('.admin-content-body').load('<?php echo u("Index/view_addyewu");?>');
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