<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
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
    <style>
        .inp button{
            height: 30px;
            width: 50px;
            border:solid 1px #ADADAD;
            background-color: #FFFFFF;
            border-radius:5px;
        }

        .page-container div{
            width: 500px;
            border: solid 1px #ADADAD;
            height: 37px;
            line-height:35px;
            margin-bottom: 5px;
            border-radius:5px;
        }

        .page-container div button{
            float: right;
            height: 30px;
            line-height:30px;
            width: 48px;
            background-color: #FFFFFF;
            border:solid 1px #ADADAD;
            text-align: center;
            margin-top: 4px;
            margin-right:5px;
            border-radius:5px;
        }
    </style>
    <title>预约商品</title>
</head>
<body class="pos-r">

<div style="margin-left:0px;">
    <nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 商品管理 <span class="c-gray en">&gt;</span>商品分类<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a></nav>
    
    <div style="margin-top: 30px;margin-left:30px;font-size: 18px;" class="inp">
        <input class="btn btn-success radius" type="button" value="添加" id="add">
        <span id="inpu" style="display: none">
            <input type="text" id="name" style="height: 27px;width: 150px; margin-left: 10px;border-radius:5px;border:solid 1px #ADADAD;">
            <button style="margin-right: 20px;margin-left: 20px;" id="deposit">保存</button><button id="cancel">取消</button>
        </span>
    </div>

    <div class="page-container" style="margin-left: 10px;margin-top: 20px">
        <?php if(is_array($category)): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "暂时没有数据" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div>
                &nbsp;&nbsp;·&nbsp;&nbsp;[ID:<?php echo ($v["id"]); ?>]<?php echo ($v["name"]); ?>
                <button>删 除</button>

            </div><?php endforeach; endif; else: echo "暂时没有数据" ;endif; ?>
    </div>
</div>
<script type="text/javascript" src="/Public/lib/jquery/1.9.1/jquery.min.js"></script>

<script type="text/javascript">
    $('#add').on('click',function(){
        $('#inpu').show();
    })

    $('#deposit').on('click',function(){
        var name = $('#name').val();
        if (name == '') {
            alert('请填写分类名');return;
        }
        var str = '';
        $.ajax({
            url     : 'category_add',
            type    : 'GET',
            data    : {name : name},
            dataType: 'json',
            success : function(data){
                if (data.code == 1) {
                    $('#inpu').hide();
                    str = '<div>&nbsp;&nbsp;·&nbsp;&nbsp;[ID:'+ data.value +']'+ name +'<button>删 除</button></div>';
                    $('.page-container').append(str);
                }else{
                    alert(data.msg);
                }
            }
        })
        
    })

    $('#cancel').on('click',function(){
        $('#inpu').hide();
    })

</script>
</body>
</html>