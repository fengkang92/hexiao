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
    <form action="<?php echo U('add_time');?>" method="post" class="form form-horizontal" id="form-article-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">分店：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="inp_1 inp_6" name="chain_id" id="chain_id" onchange="getchid();" style="width:150px;">
                    <option value="">请选择</option>
                    <?php if(is_array($chain)): $i = 0; $__LIST__ = $chain;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["ch_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">空间服务：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="inp_1 inp_6" name="box_course" id="box_course" onchange="getsid();"
                        style="width:150px;">
                    <option value="">请选择</option>
                </select>
                <span id="coursedesc" style="color:red;font-size: 12px;"></span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">供应商：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="inp_1" name="box_supplier" id="box_supplier" style="width:150px;"
                        onchange="getpid();">
                    <option value="">请选择</option>
                </select>
                <span id="supplierdesc" style="color:red;font-size: 12px;"></span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">课程：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="inp_1" name="box_course_plan" id="box_course_plan" style="width:150px;" onchange="getTeacher();">
                    <option value="">请选择</option>
                </select>
                <span id="courseplandesc" style="color:red;font-size: 12px;"></span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">老师：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <select class="inp_1" name="box_course_service" id="box_course_service" style="width:150px;">
                    <option value="">请选择</option>
                </select>
                <span id="servicendesc" style="color:red;font-size: 12px;"></span>
            </div>
        </div>
        <div class="row cl" id="abouts">
            <label class="form-label col-xs-4 col-sm-2">可预约时间：</label>
            <div id="wrap" class="formControls col-xs-8 col-sm-9">
                <div class="col-sm-6 col-xs-6 addData" style="margin-bottom: 5px;margin-left: -15px;">
                    <input type="text" name="about_stime[]" placeholder="开始时间" class="input-text" style=" width:45%"
                           onclick="WdatePicker({minDate:'%y-%M-%d 00:00',dateFmt:'yyyy-MM-dd HH:mm',alwaysUseStartDate:true})">
                    -
                    <input type="text" name="about_etime[]" placeholder="结束时间" class="input-text" style=" width:45%"
                           onclick="WdatePicker({minDate:'%y-%M-%d 00:00',dateFmt:'yyyy-MM-dd HH:mm',alwaysUseStartDate:true})">
                </div>
            </div>
            <span class="add_about"><i class="Hui-iconfont">&#xe647;</i></span>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">库存：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="stock" class="input-text" style="width: 150px;">
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
<script type="text/javascript" src="/Public/static/h-ui.admin/js/comment.js"></script>
<script type="text/javascript" src="/Public/lib/My97DatePicker/WdatePicker.js"></script>
<!--/_footer /作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/Public/lib/webuploader/0.1.5/webuploader.min.js"></script>
<script type="text/javascript" src="/Public/lib/ueditor/1.4.3/ueditor.config.js"></script>
<script type="text/javascript" src="/Public/lib/ueditor/1.4.3/ueditor.all.min.js"></script>
<script type="text/javascript" src="/Public/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
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
            $('#box_course').html('<option value="">请选择</option>');
            $('#box_supplier').html('<option value="">请选择</option>');
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
            url : 'getCourse',
            type : 'GET',
            data : {chid:chid},
            dataType: 'json',
            success : function(data){
                if (data != '') {
                    $.each(data,function(j,v){
                        str += '<option value="' + v.sid + '">-- ' + v.name + '</option>';
                    })
                    $('#box_course').html('<option value="">请选择</option>');
                    $('#box_course').append(str);
                    $('#supplierdesc').html('');
                }else{
                    $('#coursedesc').html('&nbsp;&nbsp; * 该分类下没有空间服务，请先添加');
                }
            }
        })
    }

    //选择盒子相应供应商
    function getsid() {
        var sid = $('#box_course').val();
        if (sid == '') {
            $('#box_supplier').html('<option value="">请选择</option>');
            $('#box_course_plan').html('<option value="">请选择</option>');
            $('#box_course_service').html('<option value="">请选择</option>');
            $('#courseplandesc').html('');
            $('#servicendesc').html('');
            $('#coursedesc').html('');
            return;
        }
        var htmls = '';
        $.post('<?php echo U("getsid");?>', {sid: sid}, function (data) {
            if (data.code == 1) {
                var supplier = data.value;
                for (var i = 0; i < supplier.length; i++) {
                    htmls += '<option value="' + supplier[i].id + '">-- ' + supplier[i].su_name + '</option>';
                }
                $('#box_supplier').html('<option value="">请选择</option>');
                $('#box_supplier').append(htmls);
                $('#supplierdesc').html('');
            } else {
                $('#supplierdesc').html('&nbsp;&nbsp; * '+ data.message);
            }
        }, "json");
    }

    //选择供应商下课程
    function getpid() {
        var supplier_id = $('#box_supplier').val();
        if (supplier_id == '') {
            $('#box_course_plan').html('<option value="">请选择</option>');
            $('#box_course_service').html('<option value="">请选择</option>');
            $('#courseplandesc').html('');
            $('#servicendesc').html('');
            return;
        }
        var htmls = '';
        $.post('<?php echo U("getpid");?>', {supplier_id: supplier_id}, function (data) {
            if (data.course_plan != '') {
                var cate = data.course_plan;
                for (var i = 0; i < cate.length; i++) {
                    htmls += '<option value="' + cate[i].id + '">-- ' + cate[i].server_name + '</option>';
                }
                $('#box_course_plan').html('<option value="">请选择</option>');
                $('#box_course_plan').append(htmls);
                $('#courseplandesc').html('');
            } else {
                $('#courseplandesc').html('&nbsp;&nbsp; * 该供应商下没有课程，请先添加');
            }
        }, "json");
    }

    //选择课程下老师
    function getTeacher() {
        var course_plan_id = $('#box_course_plan').val();
        if (course_plan_id == '') {
            $('#box_course_service').html('<option value="">请选择</option>');
            return;
        }
        var htmls = '';
        $.post('<?php echo U("getTeacher");?>', {course_plan_id: course_plan_id}, function (data) {
            if (data.course_service != '') {
                var cate = data.course_service;
                for (var i = 0; i < cate.length; i++) {
                    htmls += '<option value="' + cate[i].id + '">-- ' + cate[i].server_name + '</option>';
                }
                $('#box_course_service').html('<option value="">请选择</option>');
                $('#box_course_service').append(htmls);
                $('#servicendesc').html('');
            } else {
                $('#servicendesc').html('&nbsp;&nbsp; * 该课程下没有老师，请先添加');
            }
        }, "json");
    }

</script>
</body>
</html>