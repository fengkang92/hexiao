// JavaScript Document
window.onload = function(){
    var mySwiper = new Swiper('.swiper-container',{
        speed:400,
        mode : 'vertical',
        resistance:'100%',
        loop:true,
        mousewheelControl : true,
        grabCursor: true,
        pagination: '.pagination',
        paginationClickable: true,
        onSlideChangeEnd: function(swiper){
            var index=swiper.activeLoopIndex;
            console.log(index);
            switch (index){
                case 0:
                    page0();
                    break;
                case 1:
                    page1();
                    break;
                case 2:
                    page2();
                    break;
                case 3:
                    page3();
                    break;
                case 4:
                    page4();
                    break;
                default:
                    break;
            }
        },
        onSlideChangeStart: function(swiper){
            reset();
        }
    });
    reset();
    page0();

    // 点击
    // $('.topbar>span').on("click",function () {
    //     var index=$(this).attr('data-id');
    //     console.log(index);
    //     $('.pagination span').eq(index).trigger('click');
    // })

    function reset() {
        TweenMax.to('.home2-2', 0, {width:0, ease: Expo.easeIn});
        TweenMax.to('.home3-1-wrapper', 0, {width:0, ease: Expo.easeIn});
        TweenMax.to('.home2-1', 0, {height:0, ease: Linear.easeIn});

        TweenMax.to('.case3-5,.case3-4', 0, {width:0, ease: Expo.easeIn});
        TweenMax.to('.case2-1', 0, {height:0, ease: Expo.easeIn});
        TweenMax.to('.case1>span', 0, {autoAlpha: 0, ease: Expo.easeIn});

        TweenMax.to('.online2-3', 0, { width:0, ease: Expo.easeIn});
        TweenMax.to('.online3-1', 0, { width:0, ease: Expo.easeIn});
        TweenMax.to('.online2-1', 0, { height:0, ease: Expo.easeIn});
        TweenMax.to('.online1>span', 0, {autoAlpha: 0, ease: Expo.easeIn});

        TweenMax.to('.workshop3', 0, { width:0, ease: Expo.easeIn});
        TweenMax.to('.workshop5', 0, { width:0,scale: 1, ease: Expo.easeIn});
        TweenMax.to('.workshop1>span', 0, {autoAlpha: 0, ease: Expo.easeIn});
        TweenMax.to('.workshop2', 0, { height:0,scale: 1, ease: Expo.easeIn});

        TweenMax.to('.contact1>span', 0, {autoAlpha: 0, ease: Expo.easeIn});
        TweenMax.to('.contact2', 0, { height:0,ease: Expo.easeIn});
        TweenMax.to('.contact3', 0, { height:0, ease: Expo.easeIn});
        TweenMax.to('.contact4', 0, { height:0, ease: Expo.easeIn});
        TweenMax.to('.contact5', 0, { height:0, ease: Expo.easeIn});
        TweenMax.to('.contact7', 0, { height:0,ease: Expo.easeIn});


    }

    function page0() {
        TweenMax.to('.home2-2', 2, { width:1000, ease: Expo.easeIn});
        TweenMax.to('.home3-1-wrapper', 2, { width:1000, ease: Expo.easeIn});
        TweenMax.to('.home2-1', 1.8, {height:270,delay:.9, ease: Expo.easeIn})
    }
    function page1() {
        TweenMax.to('.case3-5', 2, { width:1000, ease: Expo.easeIn});
        TweenMax.to('.case3-4', 2, { width:550, ease: Expo.easeIn});
        TweenMax.to('.case2-1', 1.8, {height:150,delay:.9, ease: Expo.easeIn});
        TweenMax.to('.case1>span', 1.8, {autoAlpha: 1,delay:.9, ease: Expo.easeIn});
    }
    function page2() {
        TweenMax.to('.online2-3', 2, { width:332, ease: Expo.easeIn});
        TweenMax.to('.online3-1', 2, { width:793, ease: Expo.easeIn});
        TweenMax.to('.online2-1', 1.8, { height:150,delay:.9, ease: Expo.easeIn});
        TweenMax.to('.online1>span', 1.8, {autoAlpha: 1,delay:.9, ease: Expo.easeIn});
    }
    function page3() {
        TweenMax.to('.workshop3', 2, { width:1451, ease: Expo.easeIn});
        TweenMax.to('.workshop5', 2, { width:667, ease: Expo.easeIn});
        TweenMax.to('.workshop1>span', 1.8, {autoAlpha: 1, delay:.9, ease: Expo.easeIn});
        TweenMax.to('.workshop2', 1.8, { height:150,delay:.9, ease: Expo.easeIn});
    }
    function page4() {
        TweenMax.to('.contact1>span', 2, {autoAlpha: 1, ease: Expo.easeIn});
        TweenMax.to('.contact2', 2, { height:152,ease: Expo.easeIn});
        TweenMax.to('.contact3', 1, { height:45,delay:1.5, ease: Expo.easeIn});
        TweenMax.to('.contact4', 1, { height:45, delay:1.8,ease: Expo.easeIn});
        TweenMax.to('.contact5', 1.8, { height:70, delay:1.9,ease: Expo.easeIn});
        TweenMax.to('.contact7', 1.8, { height:86, delay:1.9,ease: Expo.easeIn});
    }


}