<?php if (!defined('THINK_PATH')) exit();?><div class="am-cf am-padding">
    <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">订单列表</strong> /
        <small>帐号列表</small>
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
                           class="menu_class am-btn-default am-btn click-a"><span class="am-icon-plus"></span> 可用</a>
                    </div>

                    <div class="am-form-group">
                        <a url="<?php echo u('',array('status'=>1));?>" href="javascript:void(0);"
                           class="menu_class am-btn-default am-btn click-a"><span class="am-icon-plus"></span> 异常</a>
                    </div>

                    <div class="am-form-group">
                        <a href="javascript:void(0);" url="<?php echo u('',array('act'=>'delAll'));?>"
                           class="delYeWus am-btn-default am-btn"><span class="am-icon-plus"></span>删除所有异常账号</a>
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
                <th class="table-ids">user_id</th>
                <th class="table-title">show_id</th>
                <th class="table-type">昵称</th>
                <th class="table-author am-hide-sm-only">状态</th>
                <th class="table-set">操作</th>
            </tr>
            </thead>
            <tbody id="list_container">
            <?php if(is_array($mlist)): foreach($mlist as $key=>$v): ?><tr>
                    <td><input type="checkbox"/></td>
                    <td><?php echo ($v["user_id"]); ?></td>
                    <td><?php echo ($v["show_id"]); ?></td>
                    <td><?php echo ($v["nick_name"]); ?></td>
                    <td>
                        <?php switch($v["status"]): case "0": ?>正常<?php break;?>
                            <?php case "1": ?><span style="color: red">异常</span><?php break;?>
                            <?php default: ?>default<?php endswitch;?>
                    </td>
                    <td>
                        <div class="am-btn-toolbar">
                            <div class="am-btn-group am-btn-group-xs">
                                <button href="<?php echo u('',array('id'=>$v['id']));?>" class="delYeWu am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</button>
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
        $('#list_container').on('click',".delYeWu",function(){
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
        $('.delYeWus').on('click',function(){
            var url = $(this).attr('url');
            $.get({
                url:url,
                success:function(data){
                    alert(data.msg);
                    $('.admin-content-body').load("<?php echo U('index/user_lists');?>");
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
                                msg = "正常";
                            }else if(val.status == 1){
                                msg ='<span style="color: red">异常</span>';
                            }else{}
                            mlist +='<tr>'+
                                        '<td><input type="checkbox"/></td>'+
                                        '<td>'+val.user_id+'</td>'+
                                        '<td>'+val.show_id+'</a></td>'+
                                        '<td>'+val.nick_name+'</td>'+
                                        '<td>'+msg+'</td>'+
                                        "<td> <div class=\"am-btn-toolbar\"> <div class=\"am-btn-group am-btn-group-xs\"><button href=\"<?php echo U('');?>?id="+val.id+"\" class=\"delYeWu am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only\"><span class=\"am-icon-trash-o\"></span> 删除</button> </div> </div> </td>"+
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