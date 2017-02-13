<?php if (!defined('THINK_PATH')) exit();?><div class="am-cf am-padding">
	<div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">系统管理</strong> / <small>网站配置</small></div>
</div>
  <hr>
  <div class="am-tabs am-margin" data-am-tabs>
      <ul class="am-tabs-nav am-nav am-nav-tabs">
        <li class="am-active"><a href="#tab1">网站信息</a></li>
      </ul>
          <form id="formUser" class="am-form">

					<input type="hidden" name="Id" value="<?php echo ($data["id"]); ?>" class="am-input-sm">
      <div class="am-tabs-bd">
        <div class="am-tab-panel am-fade am-in am-active" id="tab1">
          <div class="am-g am-margin-top">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">网站标题</div>
            <div class="am-u-sm-8 am-u-md-10">
				<div class="am-u-sm-8 am-u-md-8">
					<input type="text" name="mweb_name" value="<?php echo ($data["mweb_name"]); ?>" class="am-input-sm">
				</div>
            </div>
          </div>
          <div class="am-g am-margin-top">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">网站关键词</div>
            <div class="am-u-sm-8 am-u-md-10">
				<div class="am-u-sm-8 am-u-md-8">
					<textarea class="" name="mweb_word" rows="5" id="doc-ta-1"><?php echo ($data["mweb_word"]); ?></textarea>
				</div>
            </div>
          </div>
          <div class="am-g am-margin-top">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">网站描述</div>
            <div class="am-u-sm-8 am-u-md-10">
				<div class="am-u-sm-8 am-u-md-8">
					<textarea class="" name="mweb_des" rows="5" id="doc-ta-1"><?php echo ($data["mweb_des"]); ?></textarea>
				</div>
            </div>
          </div>
          <div class="am-g am-margin-top">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">首页公告</div>
            <div class="am-u-sm-8 am-u-md-10">
        <div class="am-u-sm-8 am-u-md-8">
          <input type="text" name="mweb_news_title" value="<?php echo ($data["mweb_news_title"]); ?>" class="am-input-sm">
        </div>
            </div>
          </div>
          <div class="am-g am-margin-top">
            <div class="am-u-sm-4 am-u-md-2 am-text-right">首页第一行</div>
            <div class="am-u-sm-8 am-u-md-10">
				<div class="am-u-sm-8 am-u-md-8">
					<input type="text" name="mfirstLine" value="<?php echo ($data["mfirstline"]); ?>" class="am-input-sm">
				</div>
            </div>
          </div>
          <div class="am-g am-margin-top">
            <div class="am-u-sm-4 am-u-md-2 am-text-right"></div>
            <div class="am-u-sm-8 am-u-md-10">
				<div class="am-u-sm-8 am-u-md-8">
					<textarea class="" name="mweb_news_content" rows="5" id="doc-ta-1"><?php echo ($data["mweb_news_content"]); ?></textarea>
				</div>
            </div>
          </div>


        </div>

      </div>
		<button id="saveUser" type="submit" class="am-margin-top am-btn am-btn-primary am-btn-xs">提交保存</button>
          </form>
    </div>

    <div class="am-margin">
    </div>
<script>
	$('#formUser').submit(function(){
		var subData = $('#formUser').serialize();
		$.post({
			url:'<?php echo u("Index/actEditWeb");?>',
			data:subData,
			success:function(data){
				if(data){
					alert('保存成功！');
				} else {
					alert('保存失败！');
				}
			}
		});
		return false;
	});
</script>