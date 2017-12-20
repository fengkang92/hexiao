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
        .item {
            width: 100%;
            border-bottom: dashed 1px #ccc;
            text-align: center;
            padding: 30px 0
        }

        .item > textarea {
            width: 100%;

        }

        .item .pre-img {
            width: 400px;
            margin: auto;
            height: auto;
        }

        .item .item-file {
            /*font-size: 20px;
            font-weight: bold;*/
            /*opacity: 0;*/
        }

        .item-add {
            width: 200px;
            height: 40px;
            line-height: 4 0px;
            border-radius: 8px;
            color: #fff;
            background: #00b7ee;
            margin: 30px auto;
            border: none;
            outline: none;
            display: block;
            font-size: 16px;
            text-align: center;
            line-height: 40px;

        }
    </style>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 商品管理 <span
        class="c-gray en">&gt;</span> 添加商品 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px"
                                              href="javascript:location.replace(location.href);" title="刷新"><i
        class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <form action="" method="post" class="form form-horizontal" id="form-article-add" enctype="multipart/form-data">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">
                <input type="radio" name="summary" value="0" id="abouts_none" checked="checked">传统
                &nbsp;&nbsp;&nbsp;<input type="radio" name="summary" value="1" id="abouts_block">预约
            </label>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>产品名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" style="width:90%" value="" name="name" placeholder="请输入信息 . . .">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>类型：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:90%">
                <select name="category_id" class="select" id="category_id">
                    <option value="">请选择</option>
                    <?php if(is_array($category_data)): $i = 0; $__LIST__ = $category_data;if( count($__LIST__)==0 ) : echo "暂时没有数据" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; else: echo "暂时没有数据" ;endif; ?>
                </select>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">商品地址：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="address" class="input-text" style="width:90%" placeholder="请输入信息 . . .">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">现价：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="price" class="input-text" style="width:90%" placeholder="请输入信息 . . .">
                元
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">原价：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="original_price" class="input-text" style="width:90%" placeholder="请输入信息 . . .">
                元
            </div>
        </div>
        <script type="text/javascript" src="/Public/admin/js/mydate.js"></script>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">活动时间：</label>
            <div class="formControls col-xs-8 col-sm-9">
                 <input style="width:13%" class="input-text" id="start_time" name="start_time" type="text" onclick="WdatePicker({minDate:'%y-%M-{%d}'})"/> - <input style="width:13%" class="input-text" id="end_time" name="end_time" type="text" onclick="WdatePicker({minDate:'%y-%M-{%d}'})"/>
            </div>
        </div>
        <div class="row cl" style="display: none" id="abouts">
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
            <label class="form-label col-xs-4 col-sm-2">标签：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="label" placeholder="多个关键字用中文逗号隔开，限10个关键字" value="" class="input-text"
                       style="width:90%">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">参数：</label>
            <div class="formControls col-xs-8 col-sm-9" id="par">
                <input type="text" name="parameter[]" placeholder="参数名和参数用中文冒号：隔开" class="input-text" style="width:90%;margin-bottom: 8px">
            </div>
            <span class="add_parameter"><i class="Hui-iconfont">&#xe647;</i></span>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">库存：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="stock" class="input-text" style="width:90%" placeholder="请输入信息 . . .">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">描述：</label>
            <div class="formControls col-xs-8 col-sm-9">
				<textarea style="width:90%" name="describe" cols="" rows="" class="textarea" placeholder="说点什么...最少输入10个字符"
                          datatype="*10-100" dragonfly="true" nullmsg="备注不能为空！" onKeyUp="textarealength(this,200)"></textarea>
                <p class="textarea-numberbar"><em class="textarea-length">0</em>/200</p>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">详细内容：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <script id="editor" type="text/plain" style="width:100%;height:400px;"></script>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">商品规格：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" name="feature" placeholder="多个关键字用中文逗号隔开" class="input-text" style="width:90%">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-2">商品图片：</label>
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
                <button onClick="article_save_submit();" class="btn btn-primary radius" type="submit"><i
                        class="Hui-iconfont">&#xe632;</i> 保存提交
                </button>
                <button onClick="javascript:history.back(-1);" class="btn btn-default radius" type="button">
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
    $('.add_parameter').on('click',function(){
        $('#par').append('<input type="text" name="parameter[]" placeholder="参数名和参数用中文冒号：隔开" class="input-text" style="width:90%;margin-bottom: 8px">');
    })
    document.getElementsByClassName('add_about')[0].onclick=function(argument) {
        var cNode = document.getElementsByClassName('addData')[0].cloneNode(true);
        cNode.children[0].value="";
        cNode.children[1].value="";
        document.getElementById('wrap').appendChild(cNode);
    }

    //隐藏预约时间
    $('#abouts_none').on('click', function () {
        $('#abouts').hide();
    })
    //显示预约时间
    $('#abouts_block').on('click', function () {
        $('#abouts').show();
    })

    //显示首页图片
    $('#yes').on('click',function(){
        $('#home').show();
    })
    //隐藏首页图片
    $('#no').on('click',function(){
        $('#home').hide ();
    })
</script>
</body>
</html>