<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    

    <link rel="stylesheet" type="text/css" href="/Public/admin/static/h-ui/css/H-ui.min.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/admin/static/h-ui.admin/css/H-ui.admin.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/admin/lib/Hui-iconfont/1.0.8/iconfont.css"/>

    <title>添加空间</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 空间服务 <span class="c-gray en">&gt;</span> 添加空间 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <form class="form form-horizontal" action="" method="post" onsubmit="return ac_from();"
          enctype="multipart/form-data">

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>空间名称：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <input type="text" class="input-text" placeholder="名称：" name="name" id="name" value="<?php echo ($course_data["name"]); ?>">
            </div>
        </div>
        
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>分店：</label>
            <div class="formControls col-xs-8 col-sm-3" id="add_course"><span class="select-box" style="margin-bottom:6px">
                <select name="chain_id" class="select" id="chain">
                    <option value="">请选择</option>
                    <?php if(is_array($chain_data)): $i = 0; $__LIST__ = $chain_data;if( count($__LIST__)==0 ) : echo "暂时没有数据" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>"
                            <?php if($v["id"] == $course_data['chain_id']): ?>selected="selected"<?php endif; ?>
                        ><?php echo ($v["ch_name"]); ?></option><?php endforeach; endif; else: echo "暂时没有数据" ;endif; ?>
                </select>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>类型：</label>
            <div class="formControls col-xs-8 col-sm-3"> <span class="select-box">
                <select name="category_id" class="select" id="category_id">
                    <option value="">请选择</option>
                    <?php if(is_array($category_data)): $i = 0; $__LIST__ = $category_data;if( count($__LIST__)==0 ) : echo "暂时没有数据" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>"
                        <?php if($v["id"] == $course_data['category_id']): ?>selected="selected"<?php endif; ?>
                    ><?php echo ($v["name"]); ?></option><?php endforeach; endif; else: echo "暂时没有数据" ;endif; ?>
                </select>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"></span>设备名称：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <input type="text" class="input-text" placeholder="名称：" name="device_name" id="device_name" value="<?php echo ($course_data["device_name"]); ?>">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"></span>地址：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <input type="text" class="input-text" placeholder="地址：" name="address" id="address" value="<?php echo ($course_data["address"]); ?>">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">描述：</label>
            <div class="formControls col-xs-8 col-sm-6">
                <textarea style="width:85%" name="description" class="textarea" placeholder="说点什么...最少输入10个字符" datatype="*10-100" dragonfly="true" nullmsg="备注不能为空！" onKeyUp="textarealength(this,200)" id="text_len"><?php echo ($course_data["description"]); ?></textarea>
                <p class="textarea-numberbar"><em class="textarea-length">0</em>/200</p>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"></span>人数上限：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <input type="text" class="input-text" placeholder="人数上限：" name="relationship" id="relationship" value="<?php echo ($course_data["relationship"]); ?>">
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input type="hidden" name="id" value="<?php echo ($course_data["sid"]); ?>">
                <input class="btn btn-primary radius" type="submit"  value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="/Public/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/Public/static/h-ui/js/H-ui.js"></script>
<script>
    //加载描述字数
    $(document).ready(function(){
        var text_len = $('#text_len').val().length;
        $('.textarea-length').text(text_len);
    })

    //验证表单空值
    function ac_from(){

        var name=document.getElementById('name').value;
        if(name.length<1){
            alert('空间名称不能为空');
            return false;
        }

        var chain_id=document.getElementById('chain_id').value;
        if(chain_id.length<1){
            alert('分店不能为空');
            return false;
        }

        var category_id=document.getElementById('category_id').value;
        if(category_id.length<1){
            alert('分类不能为空');
            return false;
        }
    }
</script>

</body>
</html>