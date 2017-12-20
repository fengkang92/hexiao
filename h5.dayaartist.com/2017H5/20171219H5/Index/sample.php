<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wxb82513088d39bc00", "867066531f0c8fd887b34014ad7ab413");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title class="title">Lights Photo — Let’ s Photo</title>
    <link rel="stylesheet" href="../Public/css/main.css">
    <script type="text/javascript" src="../Public/js/setviewport.js"></script>
    <script type="text/javascript" src="../Public/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="../Public/js/TweenMax.min.js"></script>
    <script src="http://cdn.gbtags.com/EaselJS/0.7.1/easeljs.min.js"></script>
    <script src="http://cdn.gbtags.com/PreloadJS/0.4.1/preloadjs.min.js"></script>
    <script src="http://cdn.gbtags.com/SoundJS/0.5.2/soundjs.min.js"></script>
    <script type="text/javascript" src="../Public/js/wScratchPad.min.js"></script>
    <script type="text/javascript" src="../Public/js/main.js"></script>
</head>
<body>
<div class="loading">
    <div class="loadingicon"></div>
    <div class="loadingtxt">0%</div>
</div>
<div class="main hide">
    <div class="page" id="page">
        <div class="page1">
            <div class="p1-1"><img src="../Public/images/p1-3.png" alt=""></div>
            <div class="p1-2"><img src="../Public/images/p1-4.png" alt=""></div>
            <div class="p1-3"><img src="../Public/images/p1-5.png" alt=""></div>
            <div class="p1-4"><img src="../Public/images/p1-6.png" alt=""></div>
            <div class="p1-5"><img src="../Public/images/p1-7.png" alt=""></div>
            <div class="p1-6"><img src="../Public/images/p1-8.png" alt=""></div>
            <div class="p1-7"><img src="../Public/images/p1-9.png" alt=""></div>
            <div class="p1-8"><img src="../Public/images/p1-10.png" alt=""></div>
            <div class="p1-9"><img src="../Public/images/p1-11.png" alt=""></div>
            <div class="p1-10"><img src="../Public/images/p1-1.png" alt=""></div>
            <div class="input">
                <input id="input" type="text" placeholder="请输入12位票号">
            </div>
            <div class="sure"><img src="../Public/images/sure.png" alt=""></div>

        </div>
        <div class="page2 hide">
            <div class="bg2"></div>
            <div class="p2-1"><img src="../Public/images/p2-1.png" alt=""></div>
            <div class="p2-2"><img src="../Public/images/p2-2.png" alt=""></div>
            <div class="p2-3"><img src="../Public/images/p2-3.png" alt=""></div>
            <div class="qrcode"><img id="qrcode" src="" alt=""></div>
            <div class="code">000000000000</div>
        </div>
    </div>
    <audio src="../Public/images/bg.mp3" loop id="media" autoplay="autoplay"></audio>
</div>
</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.config({
    debug: false,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
      'checkJsApi',
      'onMenuShareTimeline',//
      'onMenuShareAppMessage',
      'onMenuShareQQ',
      'onMenuShareWeibo'
    ]
  });
  window.share_config = {
     "share": {
        "imgUrl": "http://apilab.dayaartist.com/2017H5/20171219H5/Index/icon.png",//分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
        "desc" : "独享VIP通道！“作”孽的健康夜生活，亮！瞎！眼！",//摘要,如果分享到朋友圈的话，不显示摘要。
        "title" : '五棵松LIVE 华熙灯光节',//分享卡片标题
        "link": "http://apilab.dayaartist.com/2017H5/20171219H5/Index/sample.php",//分享出去后的链接，这里可以将链接设置为另一个页面。
        "success":function(){//分享成功后的回调函数
        },
        'cancel': function () {
            // 用户取消分享后执行的回调函数
        }
    }
};
    wx.ready(function () {
    wx.onMenuShareAppMessage(share_config.share);//分享给好友
    wx.onMenuShareTimeline(share_config.share);//分享到朋友圈
    wx.onMenuShareQQ(share_config.share);//分享给手机QQ
});
</script>
</html>
