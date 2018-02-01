<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="Bookmark" href="/Public/admin/images/favicon.ico">
    <link rel="Shortcut Icon" href="/Public/admin/images/favicon.ico"/>
    <script type="text/javascript" src="/Public/admin/js/action.js"></script>
    <script type="text/javascript" src="/Public/admin/js/jquery.js"></script>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/Public/admin/lib/html5shiv.js"></script>
    <script type="text/javascript" src="/Public/admin/lib/respond.min.js"></script>

    <![endif]-->

    <link rel="stylesheet" type="text/css" href="/Public/admin/static/h-ui/css/H-ui.min.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/admin/static/h-ui.admin/css/H-ui.admin.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/admin/lib/Hui-iconfont/1.0.8/iconfont.css"/>
    <link rel="stylesheet" type="text/css" href="/Public/admin/static/h-ui.admin/skin/default/skin.css" id="skin"/>
    <link rel="stylesheet" type="text/css" href="/Public/admin/static/h-ui.admin/css/style.css"/>
    <link href="/Public/admin/css/main.css" rel="stylesheet" type="text/css"/>

    <!--[if IE 6]>
    <script type="text/javascript" src="/Public/admin/lib/DD_belatedPNG_0.0.8a-min.js"></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->

    <script type="text/css">
        .Hui-article-box {
            position: absolute;
            top: 10px;
            right: 0;
            bottom: 0;
            left: 199px;
            overflow: hidden;
            z-index: 1;
            background-color: #fff;
        }
    </script>
    <title>文艺社小程序商城后台管理系统 V1.0</title>
</head>
<body>
<header class="navbar-wrapper">
    <div class="navbar navbar-fixed-top">
        <div class="container-fluid cl"><a class="logo navbar-logo f-l mr-10 hidden-xs" href="#">文艺社小程序商城后台管理系统 V1.0</a>
            <a class="logo navbar-logo-m f-l mr-10 visible-xs" href="/aboutHui.shtml">H-ui</a>


            <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                <ul class="cl">
                    <li><?php echo $_SESSION['admininfo']['name']; ?></li>
                    <li><a href="<?php echo U('Login/logout');?>">退出</a></li>


                </ul>
            </nav>
        </div>
    </div>
</header>

<aside class="Hui-aside">
    <div class="menu_dropdown bk_2">
        <dl id="menu-article">
            <dt><i class="Hui-iconfont">&#xe62c;</i> 用户管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li>
                        <a data-title="用户列表" data-href="<?php echo U('WXuser/index');?>" href="<?php echo U('WXuser/index');?>"
                           target="iframe">商品用户</a>
                    </li>
                    <li>
                        <a data-title="用户列表" data-href="<?php echo U('WXuser/user');?>" href="<?php echo U('WXuser/user');?>"
                           target="iframe">预约用户</a>
                    </li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-picture">
            <dt><i class="Hui-iconfont">&#xe620;</i> 商品管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li>
                        <a data-title="全部商品" data-href="<?php echo U('Shop/product');?>" href="<?php echo U('Shop/product');?>" target="iframe">全部商品</a>
                    </li>
                    <li>
                        <a data-title="商品分类" data-href="<?php echo U('Shop/category');?>" href="<?php echo U('Shop/category');?>" target="iframe">商品分类</a>
                    </li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-picture">
            <dt><i class="Hui-iconfont">&#xe620;</i> 服务产品<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li>
                        <a data-title="分店管理" data-href="<?php echo U('Chain/index');?>" href="<?php echo U('Chain/index');?>"
                           target="iframe">分店管理</a>
                    </li>
                    <li>
                        <a data-title="空间服务" data-href="<?php echo U('Course/index');?>" href="<?php echo U('Course/index');?>"
                           target="iframe">空间服务</a>
                    </li>
                    <li>
                        <a data-title="视频列表" data-href="<?php echo U('Supplier/index');?>" href="<?php echo U('Supplier/index');?>" target="iframe">供应商列表</a>
                    </li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-product">
            <dt><i class="Hui-iconfont">&#xe643;</i> 课程管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li>
                        <a data-title="课程安排" data-href="<?php echo U('Supplier/curr');?>" href="<?php echo U('Supplier/curr');?>" target="iframe">课程安排</a>
                    </li>
                    <li>
                        <a data-title="老师安排" data-href="<?php echo U('Service/lists');?>" href="<?php echo U('Service/lists');?>" target="iframe">老师安排</a>
                    </li>
                    <li>
                        <a data-title="时间安排" data-href="<?php echo U('Booking/service');?>" href="<?php echo U('Booking/service');?>"
                           target="iframe">时间安排</a>
                    </li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-product">
            <dt><i class="Hui-iconfont">&#xe650;</i> 视频管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li>
                        <a data-title="添加视频" data-href="<?php echo U('Video/add');?>" href="<?php echo U('Video/add');?>" target="iframe">添加视频</a>
                    </li>
                    <li>
                        <a data-title="视频列表" data-href="<?php echo U('Video/video');?>" href="<?php echo U('Video/video');?>" target="iframe">视频列表</a>
                    </li>
                </ul>
            </dd>
        </dl>

        <dl id="menu-member">
            <dt><i class="Hui-iconfont">&#xe627;</i> 订单管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="<?php echo U('Lists/lists');?>" data-title="商品订单" href="<?php echo U('Lists/lists');?>"
                           target="iframe">商品订单</a>
                    </li>
                    <li><a data-href="<?php echo U('Lists/index');?>" data-title="预约订单" href="<?php echo U('Lists/index');?>"
                           target="iframe">预约订单</a>
                    </li>
                </ul>
            </dd>
        </dl>

        <dl id="menu-admin">
            <dt><i class="Hui-iconfont">&#xe685;</i> 图片管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="<?php echo U('Picture/banner');?>" data-title="幻灯片管理" href="<?php echo U('Picture/banner');?>"
                           target="iframe">轮播图管理</a></li>
                    <li><a data-href="<?php echo U('Picture/top');?>" data-title="盒子展示图" href="<?php echo U('Picture/top');?>"
                           target="iframe">盒子展示图</a>
                    </li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-article">
            <dt><i class="Hui-iconfont">&#xe621;</i> 财务统计<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li>
                        <a data-title="个人财务统计" data-href="<?php echo U('Statistics/index');?>" href="<?php echo U('Statistics/index');?>"
                           target="iframe">个人财务统计</a>
                    </li>
                    <li>
                        <a data-title="财务统计" data-href="<?php echo U('Statistics/total');?>" href="<?php echo U('Statistics/total');?>"
                           target="iframe">财务总计</a>
                    </li>
                    <li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-admin">
            <dt><i class="Hui-iconfont">&#xe653;</i> 权限管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="<?php echo U('Adminuser/adminuser');?>" data-title="管理员列表" href="<?php echo U('Adminuser/adminuser');?>" target="iframe">管理员列表</a></li>
                    <li><a data-href="<?php echo U('Adminuser/role_auth');?>" data-title="角色管理" href="<?php echo U('Adminuser/role_auth');?>" target="iframe">角色管理</a></li>
                    <li><a data-href="<?php echo U('Adminuser/adminuser');?>" data-title="权限管理" href="<?php echo U('Adminuser/adminuser');?>" target="iframe">权限管理</a></li>       
                </ul>
            </dd>
        </dl>

    </div>

</aside>


<section class="Hui-article-box">

    <div id="iframe_box" class="Hui-article">
        <div class="show_iframe">
            <iframe src='<?php echo U("Page/adminindex");?>' id='iframe' name='iframe'></iframe>
        </div>
    </div>
</section>


<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/Public/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/Public/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/Public/admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/Public/admin/static/h-ui.admin/js/H-ui.admin.js"></script>
<!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/Public/admin/lib/jquery.contextmenu/jquery.contextmenu.r2.js"></script>
<script type="text/javascript">
    $(function () {
        /*$("#min_title_list li").contextMenu('Huiadminmenu', {
         bindings: {
         'closethis': function(t) {
         console.log(t);
         if(t.find("i")){
         t.find("i").trigger("click");
         }
         },
         'closeall': function(t) {
         alert('Trigger was '+t.id+'\nAction was Email');
         },
         }
         });*/
    });


</script>

</body>
</html>