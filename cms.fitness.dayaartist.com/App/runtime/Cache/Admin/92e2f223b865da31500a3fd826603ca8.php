<?php if (!defined('THINK_PATH')) exit();?><!--_meta 作为公共模版分离出去-->
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <LINK rel="Bookmark" href="/Public/favicon.ico">
    <LINK rel="Shortcut Icon" href="/Public/favicon.ico"/>
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
    <!--/meta 作为公共模版分离出去-->

    <link href="/Public/lib/webuploader/0.1.5/webuploader.css" rel="stylesheet" type="text/css"/>
    <style type="text/css">
    </style>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 服务产品 <span class="c-gray en">&gt;</span> 课程添加 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新"><i
        class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <form action="" method="post" class="form form-horizontal" id="form-article-add" enctype="multipart/form-data">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">分店：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:90%">
                <select class="select" name="chain_id" id="chain_id" onchange="getchid();">
                    <option value="">请选择</option>
                    <?php if(is_array($chain)): $i = 0; $__LIST__ = $chain;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["ch_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">空间服务：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:90%">
                <select class="select" name="sid" id="sid" onchange="getsid();">
                    <option value="">请选择</option>
                </select>
                <span id="coursedesc" style="color:red;font-size: 12px;"></span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">供应商：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:90%">
                <select class="select" name="suppiler_id" id="suppiler_id" onchange="getpid();">
                    <option value="">请选择</option>
                </select>
                <span id="supplierdesc" style="color:red;font-size: 12px;"></span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">课程名：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="server_name" class="input-text" style="width:90%">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">简介：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="discribe" class="input-text" style="width:90%">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">标签：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="tag" placeholder="多个关键字用英文逗号隔开，限10个关键字" value="" class="input-text"
                       style="width:90%">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">详细内容：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <script id="editor" type="text/plain" style="width:100%;height:400px;"></script>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">课程图片：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="file" name="file" id="file" value="">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">热推产品：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="radio" name="hot" value="1" id="yes" /> 是  &nbsp;
                <input type="radio" name="hot" value="0" checked="checked" id="no" /> 否
            </div>
        </div>
        <div class="row cl" style="display: none" id="home">
            <label class="form-label col-xs-4 col-sm-2">首页展示图片：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="file" name="file_home" id="file_hpme" value="">
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
                <button onClick="" class="btn btn-primary radius" type="submit"><i
                        class="Hui-iconfont">&#xe632;</i> 保存并提交审核
                </button>
                <button onClick="layer_close();" class="btn btn-default radius" type="button">
                    &nbsp;&nbsp;取消&nbsp;&nbsp;
                </button>
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
<!--/_footer /作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/Public/lib/webuploader/0.1.5/webuploader.min.js"></script>
<script type="text/javascript" src="/Public/lib/ueditor/1.4.3/ueditor.config.js"></script>
<script type="text/javascript" src="/Public/lib/ueditor/1.4.3/ueditor.all.min.js"></script>
<script type="text/javascript" src="/Public/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" src="/Public/lib/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript">
    $(function(){
        var ue = UE.getEditor('editor');
    });
    //显示首页图片
    $('#yes').on('click',function(){
        $('#home').show();
    })
    //隐藏首页图片
    $('#no').on('click',function(){
        $('#home').hide();
    })

    //添加预约时间
    document.getElementsByClassName('add_about')[0].onclick = function (argument) {
        var cNode = document.getElementsByClassName('addData')[0].cloneNode(true);
        cNode.children[0].value = "";
        cNode.children[1].value = "";
        document.getElementById('wrap').appendChild(cNode);
    }
    //选择分店相应的盒子
    function getchid()
    {
        var chid = $('#chain_id').val();
        if (chid == '') {
            $('#sid').html('<option value="">请选择</option>');
            $('#suppiler_id').html('<option value="">请选择</option>');
            $('#box_course_plan').html('<option value="">请选择</option>');
            $('#box_course_service').html('<option value="">请选择</option>');
            $('#coursedesc').html('');
            $('#supplierdesc').html('');
            $('#courseplandesc').html('');
            $('#servicendesc').html('');
            return;
        }
        var str = '';
        $.ajax({
            url : '<?php echo U("Booking/getCourse");?>',
            type : 'GET',
            data : {chid:chid},
            dataType: 'json',
            success : function(data){
                if (data != '') {
                    $.each(data,function(j,v){
                        str += '<option value="' + v.sid + '">-- ' + v.name + '</option>';
                    })
                    $('#sid').html('<option value="">请选择</option>');
                    $('#sid').append(str);
                    $('#supplierdesc').html('');
                }else{
                    $('#coursedesc').html('&nbsp;&nbsp; * 该分类下没有空间服务，请先添加');
                }
            }
        })
    }

    //选择盒子相应供应商
    function getsid() {
        var sid = $('#sid').val();
        if (sid == '') {
            $('#suppiler_id').html('<option value="">请选择</option>');
            $('#box_course_plan').html('<option value="">请选择</option>');
            $('#box_course_service').html('<option value="">请选择</option>');
            $('#courseplandesc').html('');
            $('#servicendesc').html('');
            $('#coursedesc').html('');
            return;
        }
        var htmls = '';
        $.post('<?php echo U("Booking/getsid");?>', {sid: sid}, function (data) {
            if (data.code == 1) {
                var supplier = data.value;
                for (var i = 0; i < supplier.length; i++) {
                    htmls += '<option value="' + supplier[i].id + '">-- ' + supplier[i].su_name + '</option>';
                }
                $('#suppiler_id').html('<option value="">请选择</option>');
                $('#suppiler_id').append(htmls);
                $('#supplierdesc').html('');
            } else {
                $('#supplierdesc').html('&nbsp;&nbsp; * '+ data.message);
            }
        }, "json");
    }

    
</script>
</body>
</html>