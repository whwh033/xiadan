<?php if (!defined('THINK_PATH')) exit();?>	<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="<?php echo ($web["mweb_des"]); ?>">
  <meta name="keywords" content="<?php echo ($web["mweb_word"]); ?>">
  <meta name="viewport"
        content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
  <title><?php echo ($web["mweb_name"]); ?></title>

  <!-- Set render engine for 360 browser -->
  <meta name="renderer" content="webkit">

  <!-- No Baidu Siteapp-->
  <meta http-equiv="Cache-Control" content="no-siteapp"/>

  <link rel="icon" type="image/png" href="/xiadan/Public/assets/i/favicon.png">

  <!-- Add to homescreen for Chrome on Android -->
  <meta name="mobile-web-app-capable" content="yes">
  <link rel="icon" sizes="192x192" href="/xiadan/Public/assets/i/app-icon72x72@2x.png">

  <!-- Add to homescreen for Safari on iOS -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="apple-mobile-web-app-title" content="Amaze UI"/>
  <link rel="apple-touch-icon-precomposed" href="/xiadan/Public/assets/i/app-icon72x72@2x.png">

  <!-- Tile icon for Win8 (144x144 + tile color) -->
  <meta name="msapplication-TileImage" content="/xiadan/Public/assets/i/app-icon72x72@2x.png">
  <meta name="msapplication-TileColor" content="#0e90d2">

  <link rel="stylesheet" href="/xiadan/Public/assets/css/amazeui.min.css">
  <link rel="stylesheet" href="/xiadan/Public/assets/css/app.css">
</head>
<style>
	body{
		font-size:14px;
	}
</style>
<body>


<!--开始编写你的代码-->


<section class="am-panel am-panel-default">
  <main class="am-text-lg am-panel-bd am-text-danger am-text-center" style="color: #F80054;">
    <?php echo ($web["mfirstline"]); ?>
  </main>
  <footer class="am-panel-footer ">
	<link href="/xiadan/Public/assets/js/pluge-js/css/drag.css" rel="stylesheet" type="text/css"/>
	<style>
		.gt_cut_fullbg_slice {
			float: left;
			width: 13px;
			height: 58px;
			margin: 0 !important;
			border: 0px;
			padding: 0 !important;
			background-image: url("<?php echo ($pg_bg); ?>");
		}
		.xy_img_bord{
			-webkit-box-shadow:0 0 15px #0CC;
			-moz-box-shadow:0 0 15px #0CC;
			box-shadow:0 0 15px #0CC;
		}
		#xy_img{
			background-image: url(<?php echo ($ico_pic['url']); ?>);z-index: 999;width: <?php echo ($ico_pic['w']); ?>px;height:<?php echo ($ico_pic['h']); ?>px;position: relative;
		}
	</style>
  <form method="post" action="<?php echo u('Login/loginact');?>" class="am-form">
  <fieldset>
	<div class="am-g am-padding-vertical-xs am-margin-top-sm"  style="background: white;color:black;">
	 <a href="#" class="am-u-sm-12" data-am-modal="{target: '#my-alert'}"><?php echo ($web["mweb_news_title"]); ?></a>
	</div>
	<!--这里显示窗口内容-->
		<div class="am-modal am-modal-alert" tabindex="-1" id="my-alert">
		  <div class="am-modal-dialog">
		    <div class="am-modal-hd"><?php echo ($web["mweb_news_title"]); ?></div>
		    <div class="am-modal-bd">
		      <?php echo ($web["mweb_news_content"]); ?>
		    </div>
		    <div class="am-modal-footer">
		      <span class="am-modal-btn">确定</span>
		    </div>
		  </div>
		</div>
	<!--这里显示窗口内容-->
	
		<div class="am-form-group am-margin-top-sm">
		  <input type="text" class="" name="muser" id="doc-ipt-text-1" placeholder="登录账号">
		</div>
		<div class="am-form-group">
		  <input type="password" class="" name="mpass" id="doc-ipt-text-1" placeholder="登录密码">
		</div>

	  <div class="row put_val" style="padding-left: 189px;">
		  <div style="width: 260px;height: 116px;" id="Verification" >
			  <?php if(is_array($left_pic)): $i = 0; $__LIST__ = $left_pic;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; $left_symbol = $vo[0] == 0 ?'':'-'; $right_symbol = $vo[1] == 0 ?'':'-'; ?>
				  <div class="gt_cut_fullbg_slice" style="background-position:<?php echo ($left_symbol); echo ($vo[0]); ?>px <?php echo ($right_symbol); echo ($vo[1]); ?>px;"></div><?php endforeach; endif; else: echo "" ;endif; ?>


			  <?php if(is_array($right_pic)): $i = 0; $__LIST__ = $right_pic;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; $left_symbol = $vo[0] == 0 ?'':'-'; $right_symbol = $vo[1] == 0 ?'':'-'; ?>
				  <div  class="gt_cut_fullbg_slice" style="background-position:<?php echo ($left_symbol); echo ($vo[0]); ?>px  <?php echo ($right_symbol); echo ($vo[1]); ?>px;"></div><?php endforeach; endif; else: echo "" ;endif; ?>

			  <div style="top: <?php echo($y_point);?>px;left: 0px;display: none;border: 1px solid white" id="xy_img" class="xy_img_bord"></div>
		  </div>
		  <div id="drag" style="width: 260px;"></div>
	  </div>
  
	
	<p><button type="submit" class="am-btn am-btn-primary am-u-sm-12">点击登录</button></p>
	<p><a href="<?php echo u('Login/reg');?>" class="am-btn am-btn-primary am-u-sm-12 am-margin-top-sm">没有账号?点我注册</a></p>
	</fieldset>
	</form>
  
  </footer>
	<div style="position:fixed;bottom:0px;" class="am-btn-group am-btn-group-justify">
		<a href="<?php echo u('Index/showUser');?>" class="am-text-xs am-btn am-btn-default" role="button"><span class="am-icon-skyatlas  am-text-danger"> <br>会员中心</span></a>
		<a href="<?php echo u('Index/indexs');?>" class="am-text-xs am-btn am-btn-default" role="button"><span class="am-icon-paper-plane am-text-success"> <br>在线下单</span></a>
		<a href="<?php echo u('Index/showOrder');?>" class="am-text-xs am-btn am-btn-default" role="button"><span class="am-icon-shopping-cart am-text-secondary"> <br>订单记录</span></a>
	</div>
</section>


<!--开始编写你的代码-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="/xiadan/Public/assets/js/jquery.min.js"></script>
<!--<![endif]-->
<!--[if lte IE 8 ]>
<script src="http://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="/xiadan/Public/assets/js/amazeui.ie8polyfill.min.js"></script>

<![endif]-->
<script src="/xiadan/Public/assets/js/amazeui.min.js"></script>
<script src="/xiadan/Public/assets/js/pluge-js/js/drag.js" type="text/javascript"></script>
<script>
	$('#drag').drag();
</script>
</body>
</html>