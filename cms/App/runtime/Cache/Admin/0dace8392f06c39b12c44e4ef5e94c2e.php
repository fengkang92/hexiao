<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="Bookmark" href="/favicon.ico">
    <link rel="Shortcut Icon" href="/favicon.ico"/>
    <link href="/Public/admin/css/main.css" rel="stylesheet" type="text/css"/>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/Public/admin/lib/html5shiv.js"></script>
    <script type="text/javascript" src="/Public/admin/lib/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/Public/admin/static/h-ui/css/H-ui.min.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/admin/static/h-ui.admin/css/H-ui.admin.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/admin/lib/Hui-iconfont/1.0.8/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/admin/static/h-ui.admin/skin/default/skin.css" id="skin"/>
    <link rel="stylesheet" type="text/css" href="/Public/admin/static/h-ui.admin/css/style.css"/>
    <!--[if IE 6]>
    <script type="text/javascript" src="/Public/admin/lib/DD_belatedPNG_0.0.8a-min.js"></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <script type="text/javascript" src="/Public/admin/js/jquery.js"></script>
    <script type="text/javascript" src="/Public/admin/js/action.js"></script>
    <script type="text/javascript" src="/Public/plugins/xheditor/xheditor-1.2.1.min.js"></script>
    <script type="text/javascript" src="/Public/plugins/xheditor/xheditor_lang/zh-cn.js"></script>
    <script type="text/javascript" src="/Public/admin/js/jCalendar.js"></script>

    <style>
        <
        ?
        php
            $ width

        =
        round
        (
        $
        img[

        'width'
        ]
        *

        0.6
        +
        6
        )
        ;
        $
        height

        =
        round
        (
        $
        width *$ img[

        'height'
        ]
        /
        $
        img[

        'width'
        ]
        )
        ;
        ?
        >

        li {
            list-style-type: none;
        }

        .dx1 {
            float: left;
            margin-left: 17px;
            margin-bottom: 10px;
        }

        .dx2 {
            color: #090;
            font-size: 16px;
            border-bottom: 1px solid #CCC;
            width: 100% !important;
            padding-bottom: 8px;
        }

        .dx3 {
            width: 120px;
            margin: 5px auto;
            border-radius: 2px;
            border: 1px solid #b9c9d6;
            display: block;
        }

        .dx4 {
            border-bottom: 1px solid #eee;
            padding-top: 5px;
            width: 100%;
        }

        .img-err {
            position: relative;
            top: 2px;
            left: 82%;
            color: white;
            font-size: 20px;
            border-radius: 16px;
            background: #c00;
            height: 21px;
            width: 21px;
            text-align: center;
            line-height: 20px;
            cursor: pointer;
        }

        .btn {
            height: 25px;
            width: 60px;
            line-height: 24px;
            padding: 0 8px;
            background: #24a49f;
            border: 1px #26bbdb solid;
            border-radius: 3px;
            color: #fff;
            display: inline-block;
            text-decoration: none;
            font-size: 13px;
            outline: none;
            -webkit-box-shadow: #666 0px 0px 6px;
            -moz-box-shadow: #666 0px 0px 6px;
        }

        .btn:hover {
            border: 1px #0080FF solid;
            background: #D2E9FF;
            color: red;
            -webkit-box-shadow: rgba(81, 203, 238, 1) 0px 0px 6px;
            -moz-box-shadow: rgba(81, 203, 238, 1) 0px 0px 6px;
        }

        .cls {
            background: #24a49f;
        }
    </style>

    <title>添加产品</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 视频管理 <span
        class="c-gray en">&gt;</span> 添加修改 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
                                              href="javascript:location.replace(location.href);" title="刷新"><i
        class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <form class="form form-horizontal" action="<?php echo U('Video/add');?>" method="post" onsubmit="return ac_from();"
          enctype="multipart/form-data">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>视频名称：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <input type="text" class="input-text" placeholder="视频名称" name="name" id="name" value="<?php echo ($video["name"]); ?>">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>简介：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <input type="text" class="input-text" placeholder="简介" name="describe" id="describe"
                       value="<?php echo ($video["describe"]); ?>">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>详情：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <input type="text" class="input-text" placeholder="详情" name="content" id="content"
                       value="<?php echo ($video["content"]); ?>">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>选择分类：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <select class="inp_1" name="category_id" id="category_id" onchange="getcid();"
                        style="width:150px;margin-right:5px;">
                    <!-- 遍历 -->
                    <option value="">视频分类</option>
                    <?php if(is_array($category)): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>"
                        <?php if($v["id"] == $video['category_id']): ?>selected="selected"<?php endif; ?>
                        >-- <?php echo ($v["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    <!-- 遍历 -->
                </select>
                <br>
                <span id="catedesc" style="color:red;font-size: 12px;">&nbsp;&nbsp; * 必选项</span>
            </div>
        </div>


        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>视频链接：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <input type="text" class="input-text" placeholder="视频链接：" name="main_video_url" id="main_video_url"
                       value="<?php echo ($video["main_video_url"]); ?>">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>时长：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <input type="text" class="input-text" placeholder="时长" name="duration" id="duration"
                       value="<?php echo ($video["duration"]); ?>">
            </div>
        </div>

        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>视频封面：</label>
            <div class="formControls col-xs-8 col-sm-3">
                <?php if ($video.main_img_url) { ?>
                <img src="https://api.joyfamliy.com/images_literature<?php echo ($video["main_img_url"]); ?>" width="250"
                     style="margin-bottom: 3px;"/>
                <br/>
                <?php } ?>
                <input type="file" name="file" id="file"/>
            </div>
        </div>

        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="submit" name="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                <input type="hidden" name="id" id='id' value="<?php echo ($ideo["id"]); ?>">
                <!--<input type="hidden" name="main_img_url" id='main_img_url' value="<?php echo ($ideo["main_img_url"]); ?>">-->
                <button onClick="javascript:history.back(-1);" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="/Public/admin/js/product.js"></script>

<!--_footer 作为公共模版分离出去-->


<script>
    //初始化编辑器
    $('#content').xheditor({
        skin: 'nostyle',
        upImgUrl: '<?php echo U("Upload/xheditor");?>'
    });

    function upadd(obj) {
        //alert('aaa');
        $('#imgs_add').append('<div>&nbsp;&nbsp;<input type="file" style="width:160px;" name="files[]" /><a onclick="$(this).parent().remove();" class="btn cls" style="background:#D0D0D0; width:40px; color:black;"">删除</a></div>');
        return false;
    }

    function getcid() {
        var cateid = $('#cateid').val();
        $.post('<?php echo U("getcid");?>', {cateid: cateid}, function (data) {
            if (data.catelist != '') {
                var htmls = '<option value="">二级分类</option>';
                var cate = data.catelist;
                for (var i = 0; i < cate.length; i++) {
                    htmls += '<option value="' + cate[i].id + '">-- ' + cate[i].name + '</option>';
                }
                $('#cid').html(htmls);
                $('#catedesc').html('&nbsp;&nbsp; * 必选项');
            } else {
                $('#cid').html('<option value="">二级分类</option>');
                $('#catedesc').html('&nbsp;&nbsp; * 该分类下还没有二级分类，请先添加');
            }
        }, "json");
    }

    //图片删除
    function del_img(img, obj) {
        var pro_id = $('#pro_id').val();
        if (confirm('是否确认删除？')) {
            $.post('<?php echo U("img_del");?>', {img_url: img, pro_id: pro_id}, function (data) {
                if (data.status == 1) {
                    $(obj).parent().remove();
                    return false;
                } else {
                    alert(data.err);
                    return false;
                }
            }, "json");
        }
        ;
    }

    function ac_from() {

        var name = document.getElementById('name').value;
        if (name.length < 1) {
            alert('产品名称不能为空');
            return false;
        }

        var cid = parseInt(document.getElementById("cid").value);
        if (!cid) {
            alert("请选择分类.");
            return false;
        }

        //  var pid=parseInt(document.getElementById("shop_id").value);
        // if(isNaN(pid) || pid<1){
        // 	alert("请选择所属商家");
        // 	return false;
        // }

    }


</script>

</body>
</html>