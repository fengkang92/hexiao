/**
 * Created by shuning on 2017/2/28.
 */
var mobile   = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent);
var touchstart = mobile ? "touchstart" : "mousedown";
var touchend = mobile ? "touchend" : "mouseup";
var touchmove = mobile ? "touchmove" : "mousemove";

function sequence(opt,getBack){
    this.pagemax = opt.saveUrl.length - 1;
    this.speed = [opt.speedAgo,opt.speedRear];
    this.nature = {x: opt.x, y:opt.y, width:opt.width, height:opt.height};
    this.fruit = getBack;
    this.init(opt);
}

sequence.prototype = {
    sequence_state:0, // 0 不执行  1向前  -1向后
    pagemax:0, // 最大帧
    sequence_page:0, // 序列帧控制器
    imageDom:[],
    init: function(opt){
        // 获取元素
        for (var i=0;i<opt.saveUrl.length;i++)
        {
            var img = new Image();
            img.src = opt.saveUrl[i].src;
            this.imageDom[i] = img;
        }
        this.btn(opt,opt.saveBtn);
    },
    btn: function(opt){
        var me = this;
        var c=document.getElementById('b-canvas');
        var ctx=c.getContext("2d");
        execute();
        function execute(){
            me.sequence_page ++;
            var speed = me.speed[0];
            ctx.clearRect(0,0,640,1039);
            console.log(me.pagemax);
            ctx.drawImage(me.imageDom[me.sequence_page],me.nature.x,me.nature.y,me.nature.width,me.nature.height);

            if(me.sequence_page < me.pagemax){
                setTimeout(function(){
                    execute();
                },30);
            }else if(me.sequence_page == me.pagemax){
                me.fruit();
            }
        }
    }
}