<?php if (!defined('THINK_PATH')) exit();?><div class="am-cf am-padding">
    <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">订单列表</strong> /
        <small>全部订单</small>
    </div>
</div>
<hr>
<div class="am-g">
    <div class="am-u-sm-12 am-u-md-6">
        <div class="am-btn-toolbar">
            <div class="am-u-sm-12 am-btn-group am-btn-group-xs">

                <form class="am-u-sm-12 am-form-inline" role="form">

                    <div class="am-form-group">
                        <a url="<?php echo u('Index/new_dingdan',array('status'=>-1));?>" href="javascript:void(0);" class="menu_class am-btn-default am-btn click-a"><span class="am-icon-plus"></span> 等待处理</a>
                    </div>

                    <div class="am-form-group">
                        <a url="<?php echo u('Index/new_dingdan',array('status'=>1));?>" href="javascript:void(0);"  class="menu_class am-btn-default am-btn click-a"><span class="am-icon-plus"></span> 正在处理</a>
                    </div>

                    <div class="am-form-group">
                        <a url="<?php echo u('Index/new_dingdan',array('status'=>2));?>" href="javascript:void(0);"  class="menu_class am-btn-default am-btn click-a"><span class="am-icon-plus"></span> 已经完成</a>
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
                <th class="table-check"><input type="checkbox"/></th>
                <th class="table-ids">订单号</th>
                <th class="table-title">下单者</th>
                <th class="table-type">房间号</th>
                <th class="table-author">总人气数</th>
                <th class="table-author">当前人气数</th>
                <th class="table-type">房间总人数</th>
                <th class="table-type">开始时间</th>
                <th class="table-type">结束时间</th>
                <th class="table-set">状态</th>
                <th class="table-set am-hide-sm-only">操作</th>
            </tr>
            </thead>
            <tbody id="list_container">
            <?php if(is_array($mlist)): foreach($mlist as $key=>$v): ?><tr>
                    <td><input type="checkbox"/></td>
                    <td><a class="menu_class" href="javascript:void(0);" url="<?php echo u('Index/rboot',array('renwu_id'=>$v['id']));?>" ><?php echo ($v["order_num"]); ?></a></td>
                    <td><?php echo ($v["muser"]); ?></td>
                    <td><?php echo ($v["room_num"]); ?></td>
                    <td class="am-hide-sm-only"><?php echo ($v["number"]); ?></td>
                    <td class="am-hide-sm-only"><?php echo ($v["cur_numbers"]); ?></td>
                    <td class="am-hide-sm-only"><?php echo ($v["cur_number"]); ?></td>
                    <td class="am-hide-sm-only"><?php echo (date("Y-m-d H:i:s",$v["start_time"])); ?></td>
                    <td class="am-hide-sm-only"><?php echo (date("Y-m-d H:i:s",$v["end_time"])); ?></td>
                    <td id="status<?php echo ($v["id"]); ?>">
                        <?php switch($v["status"]): case "0": ?><select onchange="change(<?php echo ($v['id']); ?>)"><option checked value="0">等待处理</option><option value="2">已完成</option></select><?php break;?>
                            <?php case "1": ?><select onchange="change(<?php echo ($v['id']); ?>)"><option checked value="1">正在处理</option><option value="2">已完成</option></select><?php break;?>
                            <?php case "2": ?>已经完成<?php break;?>
                            <?php default: ?>default<?php endswitch;?>
                    </td>
                    <td>
                        <div class="am-btn-toolbar">
                            <div class="am-btn-group am-btn-group-xs">
                                <button href="<?php echo u('',array('id'=>$v['id'], 'act' => 'del'));?>" class="delYeWu am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
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
                .current {
                    color: white;
                    text-align: center;
                    width: 42px;
                    line-height: 37px;
                    display: inline-table;
                    background-color: #0e90d2;
                    border-color: #0e90d2;
                    margin-right: 5px;
                }

                .num, .next, .prev {
                    color: #0e90d2;
                    text-align: center;
                    width: 42px;
                    line-height: 37px;
                    display: inline-table;
                    background-color: #fff;
                    border: 1px solid #ddd;
                    margin-right: 5px;
                }
            </style>
        </div>
    </div>
    <script type="text/javascript">
	
        function change(i){
            $.get("<?php echo U('index/changeStatus');?>","id="+i,function(data){
                alert(data.msg);
                if(data.code == 0){
                    $("#status"+i).html("已经完成");
                }
            },"JSON");

        }

//        $('.click-a').on('click', function () {
//            $('.admin-content-body').load($(this).attr('href'));
//            return false;
//        });

        $('#list_container').on('click','.delYeWu',function(){
            var url = $(this).attr('href');
            $this = $(this).parent().parent().parent().parent();
            $.get({
                url:url,
                success:function(data){
                    alert(data.msg);
                    if(data.code == 0){
                        $this.remove();
                    }
                }
            },"JSON");
            return ;
        });
        $('#mpage').on('click', 'a', function () {
            var url = $(this).attr('href');
            $.ajax({
                type:"GET",
                url: url,
                data: {action: 'ajax'},
                dataType: "json",
                beforeSend:function(){
                    $.AMUI.progress.start();
                },
                success: function (data) {
                    var mlist = "";
                    if(data.mlist != ""){
                        var msg = "";
                        $.each(data.mlist, function(index,val){
                            if(val.status == 0){
                                msg ="<select onchange='change("+val.id+")' ><option checked value='0'>等待处理</option><option value='2'>已完成</option></select>";
                            }else if(val.status == 1){
                                msg ="<select onchange='change("+val.id+")' ><option checked value='1'>正在处理</option><option value='2'>已完成</option></select>";
                            }else if(val.status == 2){
                                msg ="已经完成";
                            }else{
                                msg ="";
                            }
                            mlist +='<tr>'+
                                        '<td><input type="checkbox"/></td>'+
                                        "<td><a class=\"menu_class\" url=\"<?php echo u('Index/rboot');?>?renwu_id="+val.id+"\" href=\"javascript:void(0);\" >"+val.order_num+"</a></td>"+
                                        '<td>'+val.muser+'</td>'+
                                        '<td>'+val.room_num+'</td>'+
                                        '<td class="am-hide-sm-only">'+val.number+'</td>'+
                                        '<td class="am-hide-sm-only">'+val.cur_numbers+'</td>'+
                                        '<td class="am-hide-sm-only">'+val.cur_number+'</th>'+
                                        '<td class="am-hide-sm-only">'+$.myTime.UnixToDate(val.start_time, true)+'</th>'+
                                        '<td class="am-hide-sm-only">'+$.myTime.UnixToDate(val.end_time,true)+'</th>'+
                                        '<td id="'+val.id+'">'+msg+'</td>'+
                                        "<td> <div class=\"am-btn-toolbar\"> <div class=\"am-btn-group am-btn-group-xs\"><button href=\"<?php echo U('');?>?id="+val.id+"&act=del\" class=\"delYeWu am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only\"><span class=\"am-icon-trash-o\"></span> 删除</button> </div> </div> </td>"+
                                    '</tr>';
                        });
                    }
                    $('#list_container').html(mlist);
                    $('#mpage').html(data.mpage);
                    $.AMUI.progress.done();
                }
            });
            return false;
        });
    </script>
</div>