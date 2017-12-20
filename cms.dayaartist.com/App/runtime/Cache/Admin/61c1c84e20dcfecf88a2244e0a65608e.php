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
    <script type="text/javascript" src="/Public/lib/html5.js"></script>
    <script type="text/javascript" src="/Public/lib/respond.min.js"></script>
    <script type="text/javascript" src="/Public/lib/PIE_IE678.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/Public/static/h-ui/css/H-ui.min.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/static/h-ui.admin/css/H-ui.admin.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/lib/Hui-iconfont/1.0.7/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/lib/icheck/icheck.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/static/h-ui.admin/skin/default/skin.css" id="skin"/>
    <link rel="stylesheet" type="text/css" href="/Public/static/h-ui.admin/css/style.css"/>
    <link rel="stylesheet" href="/Public/lib/zTree/v3/css/zTreeStyle/zTreeStyle.css" type="text/css">
    <!--[if IE 6]>
    <script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js"></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>视频管理</title>
</head>
<body class="pos-r">
<!-- <div class="pos-a" style="width:150px;left:0;top:0; bottom:0; height:100%; border-right:1px solid #e5e5e5; background-color:#f5f5f5">
	<ul id="treeDemo" class="ztree">
	</ul>
</div> -->
<div style="margin-left:0px;">
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 视频管理 <span
            class="c-gray en">&gt;</span> 视频列表 <a class="btn btn-success radius r"
                                                  style="line-height:1.6em;margin-top:3px"
                                                  href="javascript:location.replace(location.href);" title="刷新"><i
            class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
        <div class="cl pd-5 bg-1 bk-gray mt-20"><span class="l"><a class="btn btn-primary radius"
                                                                   onclick=""
                                                                   href="<?php echo U('Video/add');?>"><i
                class="Hui-iconfont">&#xe600;</i> 添加视频</a></span>
            <span class="r">共有数据：<strong><?php echo ($count); ?></strong> 条</span></div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-bg table-hover table-sort">
                <thead>
                <tr class="text-c">
                    <!-- 11111111 -->
                    <th width="40"><input name="" type="checkbox" value=""></th>
                    <!-- 222222222 -->
                    <th width="40">ID</th>
                    <!-- 4444444444 -->
                    <th width="60">视频封面</th>
                    <!-- 5555555555 -->
                    <th width="100">名称</th>
                    <th width="60">时长</th>
                    <!-- 6666666 -->
                    <th>描述</th>
                    <!-- aaaaaaaaaaa -->
                    <!-- cccccccccccc -->
                    <th width="120">创建时间</th>
                    <th width="60">状态</th>
                    <!-- dddddddddddd -->
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                <!-- 遍历 -->
                <?php if(is_array($userlist)): $i = 0; $__LIST__ = $userlist;if( count($__LIST__)==0 ) : echo "暂时没有数据" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr class="text-c va-m">
                        <!-- 11111111 -->
                        <td><input name="" type="checkbox" value=""></td>
                        <!-- 222222222 -->
                        <td><?php echo ($v["id"]); ?></td>
                        <!-- 33333333 -->
                        <td><img width="100" class="product-thumb"
                                 src="<?php echo ($v["main_img_url"]); ?>">
                        </td>
                        <!-- 444444444 -->
                        <td><?php echo ($v["name"]); ?></td>
                        <!-- 5555555555 -->
                        <td class="text-l"><?php echo ($v["duration"]); ?></td>
                        <!-- 666666666666 -->
                        <td><span class="price">
                            <?php echo ($v["describe"]); ?>
						<span></td>
                        <td><?php echo ($v["create_time"]); ?></td>
                        <td class="td-status">
                            <?php if($v["del"] == 1): ?><span class="label label-success radius">已启用</span>
                                <?php else: ?>
                                <span class="label label-defaunt radius">已禁用</span><?php endif; ?>
                        </td>
                        <!-- dddddddddddd -->
                        <td class="td-manage">
                            <a style="text-decoration:none" class="ml-5"
                               onClick="" href="<?php echo U('Video/add');?>?id=<?php echo ($v["id"]); ?>" title="编辑"><i
                                    class="Hui-iconfont">&#xe6df;</i></a>
                            <a onclick="del_id_url(<?php echo ($v["id"]); ?>)">
                                <?php if($v["del"] != 1): ?><i class="Hui-iconfont" title="启用">&#xe6e1;</i>
                                    <?php else: ?>
                                    <i class="Hui-iconfont" title="禁用">&#xe631;</i><?php endif; ?>

                            </a>
                        </td>
                    </tr><?php endforeach; endif; else: echo "暂时没有数据" ;endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript" src="/Public/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/Public/lib/layer/2.1/layer.js"></script>
<script type="text/javascript" src="/Public/lib/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/Public/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/Public/lib/zTree/v3/js/jquery.ztree.all-3.5.min.js"></script>
<script type="text/javascript" src="/Public/static/h-ui/js/H-ui.js"></script>
<script type="text/javascript" src="/Public/static/h-ui.admin/js/H-ui.admin.js"></script>
<script type="text/javascript">
    var setting = {
        view: {
            dblClickExpand: false,
            showLine: false,
            selectedMulti: false
        },
        data: {
            simpleData: {
                enable: true,
                idKey: "id",
                pIdKey: "pId",
                rootPId: ""
            }
        },
        callback: {
            beforeClick: function (treeId, treeNode) {
                var zTree = $.fn.zTree.getZTreeObj("tree");
                if (treeNode.isParent) {
                    zTree.expandNode(treeNode);
                    return false;
                } else {
                    demoIframe.attr("src", treeNode.file + ".html");
                    return true;
                }
            }
        }
    };

    var zNodes = [
        {id: 1, pId: 0, name: "一级分类", open: true},
        {id: 11, pId: 1, name: "二级分类"},
        {id: 111, pId: 11, name: "三级分类"},
        {id: 112, pId: 11, name: "三级分类"},
        {id: 113, pId: 11, name: "三级分类"},
        {id: 114, pId: 11, name: "三级分类"},
        {id: 115, pId: 11, name: "三级分类"},
        {id: 12, pId: 1, name: "二级分类 1-2"},
        {id: 121, pId: 12, name: "三级分类 1-2-1"},
        {id: 122, pId: 12, name: "三级分类 1-2-2"},
    ];

    var code;

    function showCode(str) {
        if (!code) code = $("#code");
        code.empty();
        code.append("<li>" + str + "</li>");
    }

    $(document).ready(function () {
        var t = $("#treeDemo");
        t = $.fn.zTree.init(t, setting, zNodes);
        demoIframe = $("#testIframe");
        demoIframe.bind("load", loadReady);
        var zTree = $.fn.zTree.getZTreeObj("tree");
        zTree.selectNode(zTree.getNodeByParam("id", '11'));
    });

    $('.table-sort').dataTable({
        "aaSorting": [[1, "desc"]],//默认第几个排序
        "bStateSave": true,//状态保存
        "aoColumnDefs": [
            {"orderable": false, "aTargets": [0, 7]}// 制定列不参与排序
        ]
    });
    /*图片-添加*/
    function product_add(title, url) {
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    /*图片-查看*/
    function product_show(title, url, id) {
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    /*图片-审核*/
    function product_shenhe(obj, id) {
        layer.confirm('审核文章？', {
                btn: ['通过', '不通过'],
                shade: false
            },
            function () {
                $(obj).parents("tr").find(".td-manage").prepend('<a class="c-primary" onClick="product_start(this,id)" href="javascript:;" title="申请上线">申请上线</a>');
                $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已发布</span>');
                $(obj).remove();
                layer.msg('已发布', {icon: 6, time: 1000});
            },
            function () {
                $(obj).parents("tr").find(".td-manage").prepend('<a class="c-primary" onClick="product_shenqing(this,id)" href="javascript:;" title="申请上线">申请上线</a>');
                $(obj).parents("tr").find(".td-status").html('<span class="label label-danger radius">未通过</span>');
                $(obj).remove();
                layer.msg('未通过', {icon: 5, time: 1000});
            });
    }
    /*图片-下架*/
    function product_stop(obj, id) {
        layer.confirm('确认要下架吗？', function (index) {
            $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="product_start(this,id)" href="javascript:;" title="发布"><i class="Hui-iconfont">&#xe603;</i></a>');
            $(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已下架</span>');
            $(obj).remove();
            layer.msg('已下架!', {icon: 5, time: 1000});
        });
    }

    /*图片-发布*/
    function product_start(obj, id) {
        layer.confirm('确认要发布吗？', function (index) {
            $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="product_stop(this,id)" href="javascript:;" title="下架"><i class="Hui-iconfont">&#xe6de;</i></a>');
            $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已发布</span>');
            $(obj).remove();
            layer.msg('已发布!', {icon: 6, time: 1000});
        });
    }
    /*图片-申请上线*/
    function product_shenqing(obj, id) {
        $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">待审核</span>');
        $(obj).parents("tr").find(".td-manage").html("");
        layer.msg('已提交申请，耐心等待审核!', {icon: 1, time: 2000});
    }
    /*图片-编辑*/
    function product_edit(title, url, id) {
        var index = layer.open({
            type: 2,
            title: title,
            content: url
        });
        layer.full(index);
    }
    /*图片-删除*/
    function product_del(obj, id) {
        layer.confirm('确认要删除吗？', function (index) {
            $(obj).parents("tr").remove();
            layer.msg('已删除!', {icon: 1, time: 1000});
        });
    }

    function del_id_url(id) {
        if (confirm("你确定要执行此操作吗？")) {
            location.href = '<?php echo U("del");?>?id=' + id;
        }
    }
</script>
</body>
</html>