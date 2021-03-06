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
                        <a url="<?php echo u('',array('status'=>-1));?>" href="javascript:void(0);"
                           class="menu_class am-btn-default am-btn"><span class="am-icon-plus"></span> 待机</a>
                    </div>

                    <div class="am-form-group">
                        <a url="<?php echo u('',array('status'=>1));?>" href="javascript:void(0);"
                           class="menu_class am-btn-default am-btn"><span class="am-icon-plus"></span> 工作</a>
                    </div>

                    <div class="am-form-group">
                        <a url="<?php echo u('',array('status'=>2));?>" href="javascript:void(0);"
                           class="menu_class am-btn-default am-btn"><span class="am-icon-plus"></span> 完成</a>
                    </div>
                    <div class="am-form-group">
                        <a url="<?php echo u('',array('status'=>3));?>" href="javascript:void(0);"
                           class="menu_class am-btn-default am-btn"><span class="am-icon-plus"></span> 异常</a>
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
                <th class="table-ids">机器IP</th>
                <th class="table-title">code</th>
                <th class="table-type">房间号</th>
                <th class="table-author am-hide-sm-only">应上人气数</th>
                <th class="table-author am-hide-sm-only">已上人气数</th>
                <th class="table-set">操作</th>
            </tr>
            </thead>
            <tbody id="list_container">
            <?php if(is_array($mlist)): foreach($mlist as $key=>$v): ?><tr>
                    <td><input type="checkbox"/></td>
                    <td><?php echo ($v["ip"]); ?></td>
                    <td><?php echo ($v['code']); ?></td>
                    <td><?php echo ($v["room_num"]); ?></td>
                    <td class="am-hide-sm-only"><?php echo ($v["get_num"]); ?></td>
                    <td class="am-hide-sm-only"><?php echo ($v["complete_num"]); ?></td>
                    <td>
                        <?php switch($v["status"]): case "0": ?>待机中<?php break;?>
                            <?php case "1": ?>任务中<?php break;?>
                            <?php case "2": ?>已完成<?php break;?>
                            <?php case "3": ?><span style="color: red">异常</span><?php break;?>
                            <?php default: ?>default<?php endswitch;?>
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
                                msg = "待机中";
                            }else if(val.status == 1){
                                msg = "任务中";
                            }else if(val.status == 2){
                                msg = "已完成";
                            }else if(val.status == 3){
                                msg ='<span style="color: red">异常</span>';
                            }else{}
                            mlist +='<tr>'+
                                        '<td><input type="checkbox"/></td>'+
                                        '<td>'+val.ip+'</td>'+
                                        '<td>'+val.code+'</a></td>'+
                                        '<td>'+val.room_num+'</td>'+
                                        '<td class="am-hide-sm-only">'+val.get_num+'</td>'+
                                        '<td class="am-hide-sm-only">'+val.complete_num+'</td>'+
                                        '<td>'+msg+'</td>'+
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