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
    <title>用户管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户管理 <span
        class="c-gray en">&gt;</span> 商品用户 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
                                              href="javascript:location.replace(location.href);" title="刷新"><i
        class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="cl pd-5 bg-1 bk-gray mt-20" style="margin-left: 20px"><span class="l" style="margin-right: 10px"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a></span><a href="<?php echo U('Excels/expWXuser');?>?gender=<?php echo ($gender); ?>&create_time=<?php echo ($create_time); ?>&update_time=<?php echo ($update_time); ?>&type=1"><input class="btn btn-success radius" id="aaa" type="button" value="Excel导出" ></a></div>
<div style="margin-left: 20px;margin-top: 20px">
    <form class="form form-horizontal" action="<?php echo U('index');?>" method="post">
        <select name="gender" style="height: 30px;width: 80px;text-align: center;">
            <option value="">性别</option>
            <option value="1" <?php if($gender == 1): ?>selected="selected"<?php endif; ?> >男</option>
            <option value="2" <?php if($gender == 2): ?>selected="selected"<?php endif; ?> >女</option>
        </select>
        <input style="width:6%" placeholder="创建时间" class="input-text" name="create_time" type="text" onclick="WdatePicker()" value="<?php echo ($create_time); ?>"/>
        <input style="width:6%" placeholder="登录时间" class="input-text" name="update_time" type="text" onclick="WdatePicker()" value="<?php echo ($update_time); ?>"/>&nbsp;&nbsp;
        <input class="btn btn-success radius" type="submit" value="搜索">
    </form>
</div>
<div class="page-container">
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="25">ID</th>
                <th>用户名</th>
                <th>性别</th>
                <th>头像</th>
                <th>手机号</th>
                <th>收货地址</th>
                <th>创建时间</th>
                <th>登陆时间</th>
            </tr>
            </thead>
            <tbody>
            <!-- 遍历 -->
            <?php if(is_array($userlist)): $i = 0; $__LIST__ = $userlist;if( count($__LIST__)==0 ) : echo "暂时没有数据" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr data-id="<?php echo ($v["id"]); ?>" data-name="<?php echo ($v["name"]); ?>" class="text-c">
                    <td><input type="checkbox" value="1" name=""></td>
                    <td><?php echo ($v["id"]); ?></td>
                    <td>
                        <?php if($v["name"] != null): echo ($v["name"]); ?>
                            <?php else: ?>
                            未填写<?php endif; ?>
                    </td>
                    <td>
                        <?php if($v["gender"] == 1): ?><span>男</span>
                            <?php elseif($v["gender"] == 2): ?>
                            <span>女</span>
                            <?php else: ?>
                            <span>未填写</span><?php endif; ?>
                    </td>
                    <td>
                        <?php if($v["avatarurl"] != null): ?><img src="<?php echo ($v["avatarurl"]); ?>" width="50">
                            <?php else: ?>
                            未授权<?php endif; ?>
                    </td>
                    <td>
                        <?php if($v["mobile"] != null): echo ($v["mobile"]); ?>
                            <?php else: ?>
                            未填写<?php endif; ?>
                    </td>
                    <td class="text-l">
                        <?php if($v["province"] != null): echo ($v["province"]); echo ($v["city"]); echo ($v["country"]); echo ($v["detail"]); ?>
                            <?php else: ?>
                            未授权<?php endif; ?>
                    </td>
                    <td><?php echo ($v["create_time"]); ?></td>
                    <td><?php echo ($v["update_time"]); ?></td>
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


    $(document).on('click', '.del_id_urls', function () {
        if (confirm('你确定要执行此操作吗？')) {
            var _this = $(this);
            var ids = _this.attr('ids');
            $.ajax({
                url: 'del',
                type: 'GET',
                data: {ids: ids},
                dataTpye: 'text',
                success: function (data) {
                    //alert(data);
                    if (data == 1) {
                        _this.find('i').html('&#xe631;');
                        _this.find('i').attr('style', '');
                        _this.find('i').attr('title', '下架');
                        _this.parent().prev().find('span').html('已启用');
                        _this.parent().prev().find('span').attr('class', 'label label-success radius');
                    } else {
                        _this.find('i').html('&#xe6e1;');
                        _this.find('i').attr('style', 'color:green;');
                        _this.find('i').attr('title', '上架');
                        _this.parent().prev().find('span').html('已禁用');
                        _this.parent().prev().find('span').attr('class', 'label label-defaunt radius');
                    }
                }
            })
        }
    })
</script>
</body>
</html>