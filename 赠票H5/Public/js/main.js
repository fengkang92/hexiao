$(function(){
    var mobile   = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent);
    var touchstart = mobile ? "touchstart" : "mousedown";
    var touchend = mobile ? "touchend" : "mouseup";
    var touchmove = mobile ? "touchmove" : "mousemove";

    //阻止屏幕滑动
    $('html,body').on(touchmove,function(e){
        e.preventDefault()
    })
    var stageW=$(window).width();
    var stageH=$(window).height();
    var allowMove=true;
    var musicFirst=true;
    var firstClassName=$('.page>div:first-of-type').attr('class');
    var finalClassName=$('.page>div:last-of-type').attr('class');
    var allowUserMove=true;//滑动开关
    var nextPageClassName='';


    //可调节的参数
    var isLoop=false;//页面是否可以循环滑动
    var pageMoveTimer=0.8;//页面滑动时间，不建议修改
    var BackTimer=0.3;//内容动画开始倒退的时间,不建议修改
    var loadingPath='../Public/images/';
    // var musicPath='';//是否含有背景音乐，有就传路径，没有就为'';
    var musicPath=loadingPath+'bg.mp3';//是否含有背景音乐，有就传路径，没有就为'';
    function setupManifest() {
        manifest=[
            {src:loadingPath+'bg1.png'},
            {src:loadingPath+'bg2.png'},
            {src:loadingPath+'bg2.gif'},
            {src:loadingPath+'logo.png'},
            {src:loadingPath+'music.png'},
            {src:loadingPath+'p1-1.png'},
            {src:loadingPath+'p1-2.png'},
            {src:loadingPath+'p1-3.png'},
            {src:loadingPath+'p1-4.png'},
            {src:loadingPath+'p1-5.png'},
            {src:loadingPath+'p1-6.png'},
            {src:loadingPath+'p1-7.png'},
            {src:loadingPath+'p1-8.png'},
            {src:loadingPath+'p1-9.png'},
            {src:loadingPath+'p1-10.png'},
            {src:loadingPath+'p1-11.png'},
            {src:loadingPath+'p2-1.png'},
            {src:loadingPath+'p2-2.png'},
            {src:loadingPath+'p2-3.png'},
    ]
}
    //可调节的参数
    //定义时间动画，取决于页面的多少，动态增加，不用管
    var p1=new TimelineMax();

    //初始化阻止屏幕双击，当有表单页的时候，要关闭阻止事件，否则不能输入文字了，请传入false值，再次运行即可
    initPreventPageDobuleTap(false);
    //loading
    var audio=document.getElementById('media');
    audio.src=musicPath;
    audio.play();
    //初始化音乐
    initMusic();

    var preload;
    function startPreload() {
        preload = new createjs.LoadQueue(false);
        //注意加载音频文件需要调用如下代码行
        preload.installPlugin(createjs.Sound);
        preload.on("fileload", handleFileLoad);
        preload.on("progress", handleFileProgress);
        preload.on("complete", loadComplete);
        preload.on("error", loadError);
        preload.loadManifest(manifest);

    }
    //处理单个文件加载
    function handleFileLoad(event) {
        console.log("文件类型: " + event.item.type);
        if(event.item.id == "logo"){
            console.log("logo图片已成功加载");
        }
    }
    //处理加载错误：大家可以修改成错误的文件地址，可在控制台看到此方法调用
    function loadError(evt) {
        console.log("加载出错！",evt.text);
    }
    //已加载完毕进度
    function handleFileProgress(event) {
        $('.loadingtxt').text(Math.ceil(event.loaded*100)+"%");
    }
    function loadComplete(event) {
        $('.loading').remove();
        page1();
        $('.main').fadeIn(500,function(){
            reset();
            p1.play();
        })
    }
   setupManifest();
   startPreload();
       ////loading
    $('.musicicon').on(touchstart,function(){
        if($(this).hasClass('musicrotate')){
            audio.pause();
            $(this).removeClass('musicrotate');
        }else{
            audio.play();
            $(this).addClass('musicrotate');
        }
    });
    //////////////////////////////////////////////////////////////////////////////////////////////////
    //首屏
    function page1() {
        p1.add(TweenMax.from('.p1-10',.8, { alpha: 0,scale:4,ease:Expo.easeOut}));
        p1.add(TweenMax.from('.input,.sure',.8, { alpha: 0,scale:0,ease:Back.easeOut}));
        p1.pause();
    }
    function reset(){
        TweenMax.to('.p1-1',3, { rotation:360,repeat:-1,ease:Linear.easeIn,onStart:function () {
        }});
        TweenMax.to('.p1-2',2, { rotation:360,repeat:-1,ease:Linear.easeIn});
        TweenMax.to('.p1-3',4, { rotation:-360,repeat:-1,ease:Linear.easeIn});
        TweenMax.to('.p1-4',.3, { alpha:0,repeat:-1,yoyo:true,ease:Back.easeIn,onStart:function () {
        }});
        TweenMax.to('.p1-5',.5, { alpha:0,repeat:-1,yoyo:true,ease:Back.easeIn,onStart:function () {
            TweenMax.to('.p1-5',4, { rotation:-360,repeat:-1,ease:Linear.easeIn});
        }});
        TweenMax.to('.p1-6',.7, { alpha:0,repeat:-1,yoyo:true,ease:Back.easeIn,onStart:function () {
            TweenMax.to('.p1-6',2, { rotation:360,repeat:-1,ease:Linear.easeIn});
        }});
        TweenMax.to('.p1-7',.8, { alpha:0,repeat:-1,yoyo:true,ease:Back.easeIn,onStart:function () {
            TweenMax.to('.p1-7',5, { rotation:-360,repeat:-1,ease:Linear.easeIn});
        }});
        TweenMax.to('.p1-8',3, { rotation:-360,repeat:-1,ease:Linear.easeIn});
        TweenMax.to('.p1-9',3, { rotation:360,repeat:-1,ease:Linear.easeIn});
    };
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    //确定
    $('.sure').on(touchstart,function () {
        var code=$('#input').val();
        if(code.length==12){
            $.ajax({
                url:'https://apilab.dayaartist.com/index.php/api/v2/order/by_checker/'+code,
                type:"GET",
                dataType:"json",
                success:function (res) {
                    console.log(res);
                    if(res.code==200){
                        initPreventPageDobuleTap(false);
                        $('#qrcode').attr('src',res.data.code_img);
                        $('.code').text(res.data.order_no);
                        $('.page1').hide();
                        $('.page2').fadeIn();
                    }else{
                        alert(res.msg);
                        return;
                    }
                },
                fail:function (res) {
                    alert(res.msg);
                    return;
                }

            })
        }else{
            alert("票号长度为12位！")
        }

    });

    //是否允许用户滑动页面
    function initAllowUserMove(isMove){
        allowUserMove=isMove;
        if(allowUserMove){
            $('.guideTop').show();
        }
        else{
            $('.guideTop').hide();
        }
    }
    //是否允许用户滑动页面

    //阻止屏幕双击以后向上位移
    //当有表单页的时候，要关闭阻止事件，否则不能输入文字了
    function initPreventPageDobuleTap(isPreventPageDobuleTap){
        if(isPreventPageDobuleTap){
            $('.page').on(touchstart,function(e){
                e.preventDefault()
            })
        }else{
            $('.page').off(touchstart);
        }
    }
    //阻止屏幕双击以后向上位移

    //初始化音乐，如果musicPath=''，相当于什么都没做
    function initMusic(){
        if(musicPath!=''){
            $('.main').append('<div class="musicicon musicrotate"></div>');
        }
    }
    //初始化音乐，如果musicPath=''，相当于什么都没做

})


