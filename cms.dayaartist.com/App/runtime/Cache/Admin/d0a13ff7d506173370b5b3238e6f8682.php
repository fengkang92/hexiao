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
    <title>供应商管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 供应商管理 <span class="c-gray en">&gt;</span> 课程列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i
        class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20"><span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a class="btn btn-primary radius" href="<?php echo U('Supplier/add_curr');?>"><i class="Hui-iconfont">&#xe600;</i> 添加课程</a></span></div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="80">ID</th>
                <th>图片</th>
                <th>盒子</th>
                <th>供应商</th>
                <th>课程名称</th>
                <th>副标题</th>
                <th>标签</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <!-- 遍历 -->
            <?php if(is_array($course_data)): $i = 0; $__LIST__ = $course_data;if( count($__LIST__)==0 ) : echo "暂时没有数据" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr data-id="<?php echo ($v["id"]); ?>" data-name="<?php echo ($v["name"]); ?>" class="text-c">
                    <td><input type="checkbox" value="1" name=""></td>
                    <td><?php echo ($v["id"]); ?></td>
                    <td><img src="<?php echo ($v["main_img_url"]); ?>" width="50"></td>
                    <td><?php echo ($v["course_name"]); ?></td>
                    <td><?php echo ($v["su_name"]); ?></td>
                    <td><?php echo ($v["server_name"]); ?></td>
                    <td><?php echo ($v["discribe"]); ?></td>
                    <td><?php echo ($v["tag"]); ?></td>
                    <td class="td-status">
                        <?php if($v["status"] == 1): ?><span class="label label-success radius">正常</span>
                            <?php else: ?>
                            <span class="label label-defaunt radius">禁用</span><?php endif; ?>
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