<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="lib/html5.js"></script>
    <script type="text/javascript" src="lib/respond.min.js"></script>
    <script type="text/javascript" src="lib/PIE_IE678.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/Public/static/h-ui/css/H-ui.min.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/static/h-ui.admin/css/H-ui.admin.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/lib/Hui-iconfont/1.0.7/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/lib/icheck/icheck.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/static/h-ui.admin/skin/default/skin.css" id="skin"/>
    <link rel="stylesheet" type="text/css" href="/Public/static/h-ui.admin/css/style.css"/>
    <!--[if IE 6]>
    <script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js"></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>课程安排</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 供应商管理 <span class="c-gray en">&gt;</span> 课程安排 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i
        class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20"><span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a class="btn btn-primary radius" onclick="" href="<?php echo U('Booking/add_time');?>"><i class="Hui-iconfont">&#xe600;</i> 添加服务</a></span></div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th>ID</th>
                <th>课程</th>
                <th>教师</th>
                <th>手机</th>
                <th>上课时间</th>
                <th>价钱</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <!-- 遍历 -->
            <?php if(is_array($userlist)): $i = 0; $__LIST__ = $userlist;if( count($__LIST__)==0 ) : echo "暂时没有数据" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr data-id="<?php echo ($v["id"]); ?>" data-name="<?php echo ($v["name"]); ?>" class="text-c">
                    <td><input type="checkbox" value="1" name=""></td>
                    <td><?php echo ($v["id"]); ?></td>
                    <td><?php echo ($v["yname"]); ?></td>
                    <td><?php echo ($v["ytel"]); ?></td>
                    <td><?php echo ($v["pname"]); ?></td>
                    <td><?php echo ($v["sname"]); ?></td>
                    <td><?php echo ($v["start_time"]); ?></td>
                    <td class="td-status">
                        <?php if($v["status"] == 0): ?><span class="label label-success radius">已支付</span>
                            <?php else: ?>
                            <span class="label label-defaunt radius">已使用</span><?php endif; ?>
                    </td>
                    <td class="td-manage">
                        <a class="del_id_urls" ids="<?php echo ($v["id"]); ?>" style="text-decoration:none">
                            <?php if($v["del"] == 1): ?><i class="Hui-iconfont" title="下架">&#xe631;</i>
                                <?php else: ?>
                                <i class="Hui-iconfont" title="上架" style="color:green;">&#xe6e1;</i><?php endif; ?>
                        </a>
                    </td>
                </tr><?php endforeach; endif; else: echo "暂时没有数据" ;endif; ?>
            <!-- 遍历 -->
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript" src="/Public/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/Public/lib/layer/2.1/layer.js"></script>
<script type="text/javascript" src="/Public/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript" src="/Public/lib/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/Public/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/Public/static/h-ui/js/H-ui.js"></script>
<script type="text/javascript" src="/Public/static/h-ui.admin/js/H-ui.admin.js"></script>
<script type="text/javascript">
    //分页
    function product_option(page) {
        var obj = {
            "name": $("#name").val(),
            "tel": $("#tel").val(),
        }
        var url = '?page=' + page;
        $.each(obj, function (a, b) {
            url += '&' + a + '=' + b;
        });
        location = url;
    }
    $(function () {
        $('.table-sort').dataTable({
            "aaSorting": [[1, "desc"]],//默认第几个排序
            "bStateSave": true,//状态保存
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable": false, "aTargets": [0, 8]}// 制定列不参与排序
            ]
        });
        $('.table-sort tbody').on('click', 'tr', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
    });
    /*用户-添加*/
    function member_add(title, url, w, h) {
        layer_show(title, url, w, h);
    }
    /*用户-查看*/
    function member_show(title, url, id, w, h) {
        layer_show(title, url, w, h);
    }
    /*用户-停用*/
    function member_stop(obj, id) {
        layer.confirm('确认要停用吗？', function (index) {
            $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="member_start(this,id)" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe6e1;</i></a>');
            $(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已停用</span>');
            $(obj).remove();
            layer.msg('已停用!', {icon: 5, time: 1000});
        });
    }

    /*用户-启用*/
    function member_start(obj, id) {
        layer.confirm('确认要启用吗？', function (index) {
            $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="member_stop(this,id)" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a>');
            $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
            $(obj).remove();
            layer.msg('已启用!', {icon: 6, time: 1000});
        });
    }
    /*用户-编辑*/
    function member_edit(title, url, id, w, h) {
        layer_show(title, url, w, h);
    }
    /*密码-修改*/
    function change_password(title, url, id, w, h) {
        layer_show(title, url, w, h);
    }
    /*用户-删除*/
    function member_del(obj, id) {
        layer.confirm('确认要删除吗？', function (index) {
            $(obj).parents("tr").remove();
            layer.msg('已删除!', {icon: 1, time: 1000});
        });
    }


    $(document).on('click','.del_id_urls',function(){
        if (confirm('你确定要执行此操作吗？')) {
            var _this = $(this);
            var ids = _this.attr('ids');
            $.ajax({
                url      : 'del',
                type     : 'GET',
                data     : {ids:ids},
                dataTpye : 'text',
                success  : function(data){
                    //alert(data);
                    if (data == 1) {
                        _this.find('i').html('&#xe631;');
                        _this.find('i').attr('style','');
                        _this.find('i').attr('title','下架');
                        _this.parent().prev().find('span').html('已启用');
                        _this.parent().prev().find('span').attr('class','label label-success radius');
                    }else{
                        _this.find('i').html('&#xe6e1;');
                        _this.find('i').attr('style','color:green;');
                        _this.find('i').attr('title','上架');
                        _this.parent().prev().find('span').html('已禁用');
                        _this.parent().prev().find('span').attr('class','label label-defaunt radius');
                    }
                }
            })
        }
    })
</script>
</body>
</html>