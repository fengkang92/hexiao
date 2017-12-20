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
    <style>
    	body{
			z-index:2;
    	}
    	#zindex{
    		background-color: #F0F0F0;
    		width: 300px;
    		height:250px;
    		position: absolute;
    		left: 35%;
    		top:25%;
    		border-radius:10px;
    		z-index:1;
    		opacity:0.9;
    		display: none;
		}
    </style>
    <title>供应商列表</title>
</head>
<body class="pos-r">

<div style="margin-left:0px;">
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 供应商管理 <span class="c-gray en">&gt;</span> 供应商列表<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    <div class="page-container">
    	<div class="cl pd-5 bg-1 bk-gray mt-20"><span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a class="btn btn-primary radius" href="<?php echo U('Supplier/add');?>"><i class="Hui-iconfont">&#xe600;</i> 添加供应商</a></span></div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-bg table-hover table-sort">
                <thead>
                <tr class="text-c">
                    <th width="40"><input name="" type="checkbox" value=""></th>
	                <th width="40">ID</th>
	                <th>名称</th>
	                <th>邮箱</th>
	                <th>分类</th>
	                <th>简介</th>
	                <th>状态</th>
	                <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <!-- 遍历 -->
                <?php if(is_array($supplier_info)): $i = 0; $__LIST__ = $supplier_info;if( count($__LIST__)==0 ) : echo "暂时没有数据" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr class="text-c va-m">
                        <td><input name="" type="checkbox" value=""></td>
	                    <td><?php echo ($v["id"]); ?></td>
	                    <td><?php echo ($v["name"]); ?></td>
	                    <td><?php echo ($v["email"]); ?></td>
	                    <td><?php echo ($v["cate_name"]); ?></td>
	                    <td><?php echo ($v["description"]); ?></td>
	                    <td class="td-status">
	                        <?php if($v["su_status"] == 1): ?><span class="label label-success radius">正常</span>
	                        <?php elseif($v["su_status"] == 2): ?>
	                            <span class="label label-secondary radius">待审核</span>
	                        <?php elseif($v["su_status"] == -1): ?>
	                            <span class="label label-warning radius">审核不通过</span>
	                        <?php else: ?>
	                            <span class="label label-danger radius">已禁用</span><?php endif; ?>
	                    </td>
	                    <td class="td-manage">
	                        <a style="text-decoration:none" class="ml-5" title="修改状态" id="up_status" status="<?php echo ($v["su_status"]); ?>" check_info="<?php echo ($v["check_info"]); ?>"><i class="Hui-iconfont">&#xe61d;</i></a>
	                        <a style="text-decoration:none" class="ml-5" onClick=""
	                           href="<?php echo U('Supplier/update');?>?id=<?php echo ($v["id"]); ?>" title="修改"><i class="Hui-iconfont">&#xe6df;</i></a>
                           <div id="zindex">
								<p class="text-c" style="font-size:18px ">修改供应商状态</p>
								<p style="margin-left:20px">正常  <input type="radio" name="status" value="1" class="appear" <?php if($v["su_status"] == 1): ?>checked="checked"<?php endif; ?>>  待审核  <input type="radio" name="status" value="2" class="appear" <?php if($v["su_status"] == 2): ?>checked="checked"<?php endif; ?>>  审核不通过  <input type="radio" name="status" value="-1" id="not" <?php if($v["su_status"] == -1): ?>checked="checked"<?php endif; ?>>  禁用  <input type="radio" name="status" value="3" class="appear" <?php if($v["su_status"] == 3): ?>checked="checked"<?php endif; ?>><br>
								<center><textarea name="check_info" id="check_info" cols="30" rows="5" style="margin-top: 10px;display: none;"></textarea><br><button style="margin-top: 15px;width: 50px;height:27px;font-size: 15px" id="butt" ids="<?php echo ($v["id"]); ?>">提交</button></center>
							</div>
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
	$('.table-sort').dataTable({
	    "aaSorting": [[1, "desc"]],//默认第几个排序
	    "bStateSave": true,//状态保存
	    "aoColumnDefs": [
	        {"orderable": false, "aTargets": [0, 7]}// 制定列不参与排序
	    ]
	});
	//显示修改状态
	$('#up_status').on('click',function(){
		var status = $(this).attr('status');
		if (status == -1) {
			var check_info = $(this).attr('check_info');
			$('#check_info').show();
			$('#check_info').val(check_info);
		}
		$('#zindex').fadeIn();
	})
	//隐藏修改状态
	$('#butt').on('click',function(){
		var _this = $(this);
		var status = $('input[name="status"]:checked ').val();
		var supplier_id = $(this).attr('ids');
		var check_info = '';
		var str = '';
		if (status == -1) {
			var check_info = $('#check_info').val();
		}
		$.ajax({
			url 	 : 'up_status',
			type 	 : 'GET',
			data 	 : {status:status,check_info:check_info,supplier_id:supplier_id},
			dataType : 'json',
			success  : function(data){
				if (data != 0) {
					if (data.status != -1) {
						if (data.status == 1) {
							str = '<span class="label label-success radius">正常</span>';
							$('input[name="status"]:eq(0)').attr('checked', 'checked');
						}else if(data.status == 2){
							str = '<span class="label label-secondary radius">待审核</span>';
							$('input[name="status"]:eq(1)').attr('checked', 'checked');
						}else if (data.status == 3){
							str = '<span class="label label-danger radius">已禁用</span>';
							$('input[name="status"]:eq(3)').attr('checked', 'checked');
						}
					}else{
						str = '<span class="label label-warning radius">审核不通过</span>';
						$('input[name="status"]:eq(2)').attr('checked', 'checked');
						$('#check_info').val(data.check_info);
					}
					_this.parent().parent().parent().prev().html(str);
				}else{
					alert('修改失败');
				}
			}
		})
		$('#zindex').fadeOut();
	})
	//隐藏不通过文本
	$('.appear').on('click',function(){
		$('#check_info').hide();
	})
	//显示不同通过文本
	$('#not').on('click',function(){
		$('#check_info').show();
	})
</script>
</body>
</html>