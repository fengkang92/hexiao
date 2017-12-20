<?php if (!defined('THINK_PATH')) exit();?><!--_meta 作为公共模版分离出去-->
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<LINK rel="Bookmark" href="/Public/favicon.ico" >
<LINK rel="Shortcut Icon" href="/Public/favicon.ico" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<script type="text/javascript" src="lib/PIE_IE678.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="/Public/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/Public/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/Public/lib/Hui-iconfont/1.0.7/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/Public/lib/icheck/icheck.css" />
<link rel="stylesheet" type="text/css" href="/Public/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/Public/static/h-ui.admin/css/style.css" />
<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<!--/meta 作为公共模版分离出去-->

<link href="/Public/lib/webuploader/0.1.5/webuploader.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	.item{
		width: 100%;
		border-bottom: dashed 1px #ccc;
		text-align: center;
		padding: 30px 0
	}
	.item>textarea{
		width: 100%;

	}
	.item .pre-img{
		width: 400px;
		margin: auto;
		height: auto;
	}
	.item .item-file{
		/*font-size: 20px;
		font-weight: bold;*/
		/*opacity: 0;*/
	}
	.item-add{
		width: 200px;
		height: 40px;
		line-height: 4 0px;
		border-radius: 8px;
		color: #fff;
		background: #00b7ee;
		margin: 30px auto;
		border:none;
		outline: none;
		display: block;
		font-size: 16px;
		text-align: center;
		line-height: 40px;

	}
</style>
</head>
<body>
<div class="page-container">
	<form action="" method="post" class="form form-horizontal" id="form-article-add">
		<div class="row cl">
			<input type="hidden" name="product_id" value="<?php echo ($product_id); ?>">
			<label class="form-label col-xs-4 col-sm-2">预约地点：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" name="address" placeholder="请输入预约地点" value="" class="input-text" style=" width:50%">
			</div>
		</div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">活动时间：</label>
            <div class="formControls col-xs-8 col-sm-9">
                 <input style="width:13%" class="input-text" id="start_time" name="start_time" type="text" onclick="WdatePicker({minDate:'%y-%M-{%d}'})" value="<?php echo ($product_data["start_time"]); ?>" /> - <input style="width:13%" class="input-text" id="end_time" name="end_time" type="text"  value="<?php echo ($product_data["end_time"]); ?>" onclick="WdatePicker({minDate:'%y-%M-{%d}'})"/>
            </div>
        </div>
		<div class="row cl" id="abouts">
            <label class="form-label col-xs-4 col-sm-2">可预约时间：</label>
            <div id="wrap" class="formControls col-xs-8 col-sm-9">
                <div class="col-sm-6 col-xs-6 addData" style="margin-bottom: 5px">
                    <input type="text" name="about_stime[]" placeholder="开始时间" class="input-text" style=" width:45%" onclick="WdatePicker({minDate:'%y-%M-%d 00:00',dateFmt:'yyyy-MM-dd HH:mm',alwaysUseStartDate:true})">
                     - 
                    <input type="text" name="about_etime[]" placeholder="结束时间" class="input-text" style=" width:45%" onclick="WdatePicker({minDate:'%y-%M-%d 00:00',dateFmt:'yyyy-MM-dd HH:mm',alwaysUseStartDate:true})"> 
                </div>
            </div>
            <span class="add_about"><i class="Hui-iconfont">&#xe647;</i></span>
        </div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">现价：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" name="price" class="input-text" style="width:90%">
				元</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-2">原价：</label>
			<div class="formControls col-xs-8 col-sm-9">
				<input type="text" name="original_price" class="input-text" style="width:90%">
				元</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
				<button onClick="article_save_submit();" class="btn btn-primary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存并提交审核</button>
				<button onClick="layer_close();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
			</div>
		</div>
	</form>
</div>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/Public/lib/jquery/1.9.1/jquery.min.js"></script> 
<script type="text/javascript" src="/Public/lib/layer/2.1/layer.js"></script> 
<script type="text/javascript" src="/Public/lib/icheck/jquery.icheck.min.js"></script> 
<script type="text/javascript" src="/Public/lib/jquery.validation/1.14.0/jquery.validate.min.js"></script> 
<script type="text/javascript" src="/Public/lib/jquery.validation/1.14.0/validate-methods.js"></script> 
<script type="text/javascript" src="/Public/lib/jquery.validation/1.14.0/messages_zh.min.js"></script> 
<script type="text/javascript" src="/Public/static/h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="/Public/static/h-ui.admin/js/H-ui.admin.js"></script> 
<script type="text/javascript" src="/Public/static/h-ui.admin/js/comment.js"></script>
<script type="text/javascript" src="/Public/lib/My97DatePicker/WdatePicker.js"></script>
<!--/_footer /作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/Public/lib/webuploader/0.1.5/webuploader.min.js"></script> 
<script type="text/javascript" src="/Public/lib/ueditor/1.4.3/ueditor.config.js"></script>
<script type="text/javascript" src="/Public/lib/ueditor/1.4.3/ueditor.all.min.js"> </script>
<script type="text/javascript" src="/Public/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
//添加预约时间
document.getElementsByClassName('add_about')[0].onclick=function(argument) {
        var cNode = document.getElementsByClassName('addData')[0].cloneNode(true);
        cNode.children[0].value="";
        cNode.children[1].value="";
        document.getElementById('wrap').appendChild(cNode);
    }
</script>
</body>
</html>