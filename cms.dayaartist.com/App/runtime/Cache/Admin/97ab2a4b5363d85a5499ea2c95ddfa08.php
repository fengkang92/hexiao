<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>

    <link rel="stylesheet" type="text/css" href="/Public/static/h-ui/css/H-ui.min.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/static/h-ui.admin/css/H-ui.admin.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/lib/Hui-iconfont/1.0.7/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/lib/icheck/icheck.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/static/h-ui.admin/skin/default/skin.css" id="skin"/>
    <link rel="stylesheet" type="text/css" href="/Public/static/h-ui.admin/css/style.css"/>
    <link rel="stylesheet" href="/Public/lib/zTree/v3/css/zTreeStyle/zTreeStyle.css" type="text/css">

    <title>预约商品</title>
</head>
<body class="pos-r">

<div style="margin-left:0px;">
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 商品管理 <span class="c-gray en">&gt;</span>商品列表<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i
    class="Hui-iconfont">&#xe68f;</i></a></nav>
    
    <div class="cl pd-5 bg-1 bk-gray mt-20" style="margin-left: 20px"><span class="l" style="margin-right: 10px"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a class="btn btn-primary radius" href="<?php echo U('Shop/addGoods');?>"><i class="Hui-iconfont">&#xe600;</i> 添加商品</a></span><a href="<?php echo U('Excels/expProduct');?>?category_id=<?php echo ($category_id); ?>&summary=<?php echo ($summary); ?>&hot=<?php echo ($hot); ?>&discount=<?php echo ($discount); ?>&del=<?php echo ($del); ?>"><input class="btn btn-success radius" id="aaa" type="button" value="Excel导出" ></a></div>
    <div style="margin-left: 20px;margin-top: 20px">
        <form class="form form-horizontal" action="" method="post" onsubmit="return ac_from();">
            <select name="category_id" id="category_id" style="height: 30px;width: 80px;text-align: center;">
                <option value="">全部分类</option>
                <?php if(is_array($category_data)): $i = 0; $__LIST__ = $category_data;if( count($__LIST__)==0 ) : echo "暂时没有数据" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php if($v["id"] == $category_id): ?>selected="selected"<?php endif; ?>><?php echo ($v["name"]); ?></option><?php endforeach; endif; else: echo "暂时没有数据" ;endif; ?>
            </select>&nbsp;&nbsp;
            <select name="summary" id="summary" style="height: 30px;width: 80px;text-align: center;">
                <option value="">全部类型</option>
                <option value="2" <?php if(2 == $summary): ?>selected="selected"<?php endif; ?>>传统商品</option>
                <option value="1" <?php if(1 == $summary): ?>selected="selected"<?php endif; ?>>主题活动</option>
            </select>&nbsp;&nbsp;

            <select name="hot" id="hot" style="height: 30px;width: 80px;text-align: center;">
                <option value="" <?php if( '' == $hot): ?>selected="selected"<?php endif; ?>>推荐</option>
                <option value="1" <?php if(1 == $hot): ?>selected="selected"<?php endif; ?>>是</option>
                <option value="2" <?php if(2 == $hot): ?>selected="selected"<?php endif; ?>>否</option>
            </select>&nbsp;&nbsp;

            <select name="discount" id="discount" style="height: 30px;width: 80px;text-align: center;">
                <option value="">折扣</option>
                <option value="1" <?php if(1 == $discount): ?>selected="selected"<?php endif; ?>>是</option>
                <option value="2" <?php if(2 == $discount): ?>selected="selected"<?php endif; ?>>否</option>
            </select>&nbsp;&nbsp;

            <select name="del" id="del" style="height: 30px;width: 80px;text-align: center;">
                <option value="">上下架</option>
                <option value="1" <?php if(1 == $del): ?>selected="selected"<?php endif; ?>>上架</option>
                <option value="2" <?php if(2 == $del): ?>selected="selected"<?php endif; ?>>下架</option>
            </select>&nbsp;&nbsp;
            <input class="btn btn-success radius" type="submit" value="搜索">
            </form>
    </div>
    <div class="page-container">
        <div class="mt-20">
            <table class="table table-border table-bordered table-bg table-hover table-sort">
                <thead>
                <tr class="text-c" height="30">
                    <th width="25"><input name="" type="checkbox" value=""></th>
                    <th>ID</th>
                    <th>商品图</th>
                    <th>分类</th>
                    <th>类型</th>
                    <th width="150">产品名称</th>
                    <th>价格</th>
                    <th>库存</th>
                    <th>推荐</th>
                    <th>折扣</th>
                    <th>状态</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                <!-- 遍历 -->
                <?php if(is_array($product_data)): $i = 0; $__LIST__ = $product_data;if( count($__LIST__)==0 ) : echo "暂时没有数据" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr class="text-c va-m" height="55">
                        <td><input name="" type="checkbox" value=""></td>
                        <td width="25"><?php echo ($v["id"]); ?></td>
                        <td><img src="<?php echo ($v["main_img_url"]); ?>" width="80" height="40"></td>
                        <td><?php echo ($v["cname"]); ?></td>
                        <td>
                            <?php if($v["summary"] == 2): ?>传统商品
                            <?php else: ?>
                                主题活动<?php endif; ?>
                        </td>
                        <td><?php echo ($v["pname"]); ?></td>
                        <td><?php echo ($v["price"]); ?>元</td>
                        <td><?php echo ($v["stock"]); ?></td>
                        <td>
                            <?php if($v["hot"] == 1): ?><i class="Hui-iconfont">&#xe6a7;</i>
                            <?php else: ?>
                                <i class="Hui-iconfont">&#xe6a6;</i><?php endif; ?>
                        </td>
                        <td>
                            <?php if($v["discount"] == 1): ?><i class="Hui-iconfont">&#xe6a7;</i>
                            <?php else: ?>
                                <i class="Hui-iconfont">&#xe6a6;</i><?php endif; ?>
                        </td>
                        <td class="td-status">
                        <?php if($v["del"] == 1): ?><span class="label label-success radius" product_id="<?php echo ($v["id"]); ?>"><span class="del">上架</span></span>
                        <?php else: ?>
                            <span class="label label-defaunt radius" product_id="<?php echo ($v["id"]); ?>"><span class="del">下架</span></span><?php endif; ?>
                    </td>
                        <td class="td-manage" width="70">
                            <a href="<?php echo U('Shop/product_preview');?>?id=<?php echo ($v["id"]); ?>">预览</a> |
                            <a href="<?php echo U('Shop/product_edit');?>?id=<?php echo ($v["id"]); ?>">编辑</a> |
                            <a href="<?php echo U('Shop/product_discount');?>?id=<?php echo ($v["id"]); ?>">折扣</a>
                        </td>
                    </tr><?php endforeach; endif; else: echo "暂时没有数据" ;endif; ?>
                <!-- 遍历 -->
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
    /*$('#aaa').on('click',function(){
        $.ajax({
            url      : 'excels',
            type     : 'GET',
            success  : function(data){

            }
        })
    })*/
    //修改商品状态
    $(document).on('click','.del',function(){
        if (confirm('你确定要修改状态？')) {
            var _this = $(this);
            var product_id = _this.parent().attr('product_id');
            $.ajax({
                url      : 'del_status',
                type     : 'GET',
                data     : {product_id:product_id},
                dataType : 'text',
                success  : function(data){
                    if (data == 1) {
                        _this.html('上架');
                        _this.parent().attr('class','label label-success radius');
                    }else{
                        _this.html('下架');
                        _this.parent().attr('class','label label-defaunt radius');
                    }
                }
            })
        }
    })


    $('.table-sort').dataTable({
        "aaSorting": [[1, "asc"]],//默认第几个排序
        "bStateSave": true,//状态保存
        "aoColumnDefs": [
            {"orderable": false, "aTargets": [2,11]}// 制定列不参与排序
        ]
    });

    /*function ac_from(){
        var summary=document.getElementById('summary').value;
        
        var category_id=document.getElementById("category_id").value;

        var del=document.getElementById("del").value;

        var hot=document.getElementById("hot").value;

        var discount=document.getElementById("discount").value;
        if(category_id == '' && summary == '' && del == '' && hot == '' && discount == ''){
            alert("请选择搜索条件");
            return false;
        }
    }*/


</script>
</body>
</html>