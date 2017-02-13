<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js fixed-layout">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>自助下单系统后台管理</title>
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="viewport"
        content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp" />
  <link rel="icon" type="image/png" href="/xiadan/Public/assets/i/favicon.png">
  <link rel="apple-touch-icon-precomposed" href="/xiadan/Public/assets/i/app-icon72x72@2x.png">
  <meta name="apple-mobile-web-app-title" content="Amaze UI" />
  <link rel="stylesheet" href="/xiadan/Public/assets/css/amazeui.min.css"/>
  <link rel="stylesheet" href="/xiadan/Public/assets/css/admin.css">
</head>
<body>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，Amaze UI 暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
  以获得更好的体验！</p>
<![endif]-->

<header class="am-topbar am-topbar-inverse admin-header">
  <div class="am-topbar-brand">
    <strong>自助下单系统</strong> <small>后台管理</small>
  </div>

  <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

  <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

    <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
      <li class="am-dropdown" data-am-dropdown>
        <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
          <span class="am-icon-users"></span> 管理员 <span class="am-icon-caret-down"></span>
        </a>
        <ul class="am-dropdown-content">
          <li><a href="<?php echo u('Login/loginout');?>"><span class="am-icon-power-off"></span> 退出</a></li>
        </ul>
      </li>
      <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
    </ul>
  </div>
</header>

<div class="am-cf admin-main">
  <!-- sidebar start -->
  <div class="admin-sidebar am-offcanvas" id="admin-offcanvas">
    <div class="am-offcanvas-bar admin-offcanvas-bar">
      <ul class="am-list admin-sidebar-list" id="memu_lists">
        <li><a href="<?php echo u('Index/index');?>"><span class="am-icon-home"></span> 首页</a></li>
        <!--<li class="admin-parent">-->
          <!--<a class="am-cf" data-am-collapse="{target: '#collapse-nav'}"><span class="am-icon-file"></span> 代理列表 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>-->
          <!--<ul class="am-list am-collapse admin-sidebar-sub" id="collapse-nav">-->
            <!--<li><a href="javascript:void(0);" url="<?php echo u('Index/view_daili');?>" class="am-cf menu_class"><span class="am-icon-check"></span> 代理列表<span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span></a></li>-->
          <!--</ul>-->
        <!--</li>-->
        <!--<li class="admin-parent">-->
          <!--<a class="am-cf" data-am-collapse="{target: '#collapse-yewu'}"><span class="am-icon-file"></span> 业务分类 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>-->
          <!--<ul class="am-list am-collapse admin-sidebar-sub" id="collapse-yewu">-->
            <!--<li><a href="javascript:void(0);" url="<?php echo u('Index/view_yewu');?>" class="am-cf menu_class"><span class="am-icon-check"></span> 全部分类<span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span></a></li>-->
          <!--</ul>-->
        <!--</li>-->
        <li class="admin-parent">
          <a class="am-cf" data-am-collapse="{target: '#collapse-dingdan'}"><span class="am-icon-file"></span> 订单列表 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
          <ul class="am-list am-collapse admin-sidebar-sub" id="collapse-dingdan">
            <!--<li><a href="javascript:void(0);" url="<?php echo u('Index/view_dingdan');?>" class="am-cf menu_class"><span class="am-icon-check"></span> 订单列表<span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span></a></li>-->
            <li><a href="javascript:void(0);" url="<?php echo u('Index/new_dingdan');?>" class="am-cf menu_class"><span class="am-icon-check"></span>新订单列表<span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span></a></li>
            <li><a href="javascript:void(0);" url="<?php echo u('Index/rboot');?>" class="am-cf menu_class"><span class="am-icon-check"></span>机器列表<span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span></a></li>
            <li><a href="javascript:void(0);" url="<?php echo u('Index/user_lists');?>" class="am-cf menu_class"><span class="am-icon-check"></span>帐号列表<span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span></a></li>
          </ul>
        </li>
        <!--<li class="admin-parent">-->
          <!--<a class="am-cf" data-am-collapse="{target: '#collapse-chongzhika'}"><span class="am-icon-file"></span> 充值卡管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>-->
          <!--<ul class="am-list am-collapse admin-sidebar-sub" id="collapse-chongzhika">-->
            <!--<li><a href="javascript:void(0);" url="<?php echo u('Index/view_kamils');?>" class="am-cf menu_class"><span class="am-icon-check"></span> 卡密列表<span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span></a></li>-->
            <!--<li><a href="javascript:void(0);" url="<?php echo u('Index/view_addkami');?>" class="am-cf menu_class"><span class="am-icon-check"></span> 卡密新增<span class="am-icon-star am-fr am-margin-right admin-icon-yellow"></span></a></li>-->
          <!--</ul>-->
        <!--</li>-->
        <li><a href="javascript:void(0);" url="<?php echo u('Index/view_editWeb');?>" class="menu_class" ><span class="am-icon-sign-out"></span> 系统配置</a></li>
        <li><a href="<?php echo u('Login/loginout');?>"><span class="am-icon-sign-out"></span> 注销</a></li>
      </ul>

      <div class="am-panel am-panel-default admin-sidebar-panel">
        <div class="am-panel-bd">
          <p><span class="am-icon-tag"></span> wiki</p>
          <p>Welcome to the Amaze UI wiki!</p>
        </div>
      </div>
    </div>
  </div>
  <!-- sidebar end -->

  <!-- content start -->
  <div class="admin-content">
    <div class="admin-content-body">

<div class="am-cf am-padding">
  <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">后台首页</strong> / <small>首页</small></div>
</div>
  <hr>
         <div class="am-g">
            <div class="am-u-md-12">
              <div class="am-panel am-panel-default">
                <div class="am-panel-hd am-cf" data-am-collapse="{target: '#collapse-panel-1'}">今日统计<span class="am-icon-chevron-down am-fr" ></span></div>
                <div class="am-list am-panel-bd am-collapse am-in" id="collapse-panel-1">
                    <ul class="am-avg-sm-1 am-avg-md-4 am-margin am-padding am-text-center am-list admin-content-task ">
                      <li><a href="#" class="am-text-success"><span class="am-icon-btn am-icon-file-text"></span><br/>下单金额<br/><?php echo ($Data3['price'][0]['total']+0); ?></a></li>
                      <li><a href="#" class="am-text-warning"><span class="am-icon-btn am-icon-briefcase"></span><br/>成交订单<br/><?php echo ($Data3["count"]["0"]["total"]); ?></a></li>
                      <li><a href="#" class="am-text-danger"><span class="am-icon-btn am-icon-recycle"></span><br/>订单总数<br/><?php echo ($Data4['count'][0]['total']+0); ?></a></li>
                      <li><a href="#" class="am-text-secondary"><span class="am-icon-btn am-icon-user-md"></span><br/>用户总数<br/><?php echo ($Data4['user'][0]['total']+0); ?></a></li>
                    </ul>
                </div>
              </div>
            </div>
          </div>
         <div class="am-g">
            <div class="am-u-md-6">
              <div class="am-panel am-panel-default">
                <div class="am-panel-hd am-cf" data-am-collapse="{target: '#collapse-panel-2'}">昨日统计<span class="am-icon-chevron-down am-fr" ></span></div>
                <div class="am-list am-panel-bd am-collapse am-in" id="collapse-panel-2">
                    <ul class="am-avg-sm-1 am-avg-md-2 am-margin am-padding am-text-center admin-content-list ">
                      <li><a href="#" class="am-text-success"><span class="am-icon-btn am-icon-file-text"></span><br/>下单金额<br/><?php echo ($Data2['price'][0]['total']+0); ?></a></li>
                      <li><a href="#" class="am-text-warning"><span class="am-icon-btn am-icon-briefcase"></span><br/>成交订单<br/><?php echo ($Data2['count'][0]['total']+0); ?></a></li>
                    </ul>
                </div>
              </div>
            </div>
            <div class="am-u-md-6">
              <div class="am-panel am-panel-default">
                <div class="am-panel-hd am-cf" data-am-collapse="{target: '#collapse-panel-3'}">前日<span class="am-icon-chevron-down am-fr" ></span></div>
                <div class="am-list am-panel-bd am-collapse am-in" id="collapse-panel-3">
                    <ul class="am-avg-sm-1 am-avg-md-2 am-margin am-padding am-text-center admin-content-list ">
                      <li><a href="#" class="am-text-success"><span class="am-icon-btn am-icon-file-text"></span><br/>下单金额<br/><?php echo ($Data1['price'][0]['total']+0); ?></a></li>
                      <li><a href="#" class="am-text-warning"><span class="am-icon-btn am-icon-briefcase"></span><br/>成交订单<br/><?php echo ($Data1['count'][0]['total']+0); ?></a></li>
                    </ul>
                </div>
              </div>
            </div>
          </div>

      
    </div>

    <footer class="admin-content-footer">
      <hr>
      <p class="am-padding-left">© 2014 AllMobilize, Inc. Licensed under MIT license.</p>
    </footer>
  </div>
  <!-- content end -->

</div>

<a href="#" class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu" data-am-offcanvas="{target: '#admin-offcanvas'}"></a>

<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="/xiadan/Public/assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="/xiadan/Public/assets/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="/xiadan/Public/assets/js/amazeui.min.js"></script>
<script src="/xiadan/Public/assets/js/app.js"></script>
<script type="text/javascript">
	$('body').on("click", ".menu_class",function(){
      $.ajax({
          "type" : "GET",
          url: $(this).attr('url'),
          beforeSend:function(){
            $.AMUI.progress.start();
          },
          success:function(data){
            $('.admin-content-body').html(data);
            $.AMUI.progress.done();
          }
      });
		//$('.admin-content-body').load($(this).attr('url'));
		return false;
	});

    (function($) {
      $.extend({
        myTime: {
          /**
           * 当前时间戳
           * @return <int>    unix时间戳(秒)
           */
          CurTime: function(){
            return Date.parse(new Date())/1000;
          },
          /**
           * 日期 转换为 Unix时间戳
           * @param <string> 2014-01-01 20:20:20 日期格式
           * @return <int>    unix时间戳(秒)
           */
          DateToUnix: function(string) {
            var f = string.split(' ', 2);
            var d = (f[0] ? f[0] : '').split('-', 3);
            var t = (f[1] ? f[1] : '').split(':', 3);
            return (new Date(
                            parseInt(d[0], 10) || null,
                            (parseInt(d[1], 10) || 1) - 1,
                            parseInt(d[2], 10) || null,
                            parseInt(t[0], 10) || null,
                            parseInt(t[1], 10) || null,
                            parseInt(t[2], 10) || null
                    )).getTime() / 1000;
          },
          /**
           * 时间戳转换日期
           * @param <int> unixTime  待时间戳(秒)
           * @param <bool> isFull  返回完整时间(Y-m-d 或者 Y-m-d H:i:s)
           * @param <int> timeZone  时区
           */
          UnixToDate: function(unixTime, isFull, timeZone) {
            if (typeof (timeZone) == 'number')
            {
              unixTime = parseInt(unixTime) + parseInt(timeZone) * 60 * 60;
            }
            var time = new Date(unixTime * 1000);
            var ymdhis = "";
            ymdhis += time.getUTCFullYear() + "-";
            ymdhis += (time.getUTCMonth()+1) + "-";
            ymdhis += time.getUTCDate();
            if (isFull === true)
            {
              ymdhis += " " + time.getUTCHours() + ":";
              ymdhis += time.getUTCMinutes() + ":";
              ymdhis += time.getUTCSeconds();
            }
            return ymdhis;
          }
        }
      });
    })(jQuery);
</script>
</body>
</html>