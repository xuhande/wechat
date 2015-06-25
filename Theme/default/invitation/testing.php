<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>“纯净之酩”品酒会</title>   
        <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> 
        <meta name="format-detection"content="telephone=no">
            <meta name="apple-mobile-web-app-capable" content="yes" />
            <meta name="apple-mobile-web-app-status-bar-style" content="black" />
            <link rel="stylesheet" href="<?php echo v_theme_url() ?>/js/invitation/pace-theme-center-atom.css" />
            <link rel="stylesheet" href="<?php echo v_theme_url() ?>/js/invitation/lrtk.css" />
            <script src="<?php echo v_theme_url() ?>/js/invitation/jquery-1.10.1.min.js"></script>
            <script>
                paceOptions = {
                    elements: true
                };
            </script>
            <script src="<?php echo v_theme_url() ?>/js/invitation/pace.min.js"></script>  <script>
                function load(time) {
                    var x = new XMLHttpRequest()
                    x.open('GET', "http://weixin.vynfields.cn/Home/Invitation/testing" + time, true);
                    x.send();
                }
                ;
  
                load(3000);

                setTimeout(function () {
                    Pace.ignore(function () {
                        load(3100);
                    });
                }, 4000);

                Pace.on('hide', function () {
                    console.log('done');
                });
            </script>

            <script>
                $(function () {

                    var status_bool = false;
                    $("#players").click(function () {
                        Media = document.getElementById("audioMedia");
                        if (status_bool == true) {
                            Media.pause();
                            $(this).addClass('player-button-stop');
                            $(this).removeClass('player-rotate');
                            status_bool = false;
                        } else {
                            Media.play();
                            $(this).removeClass('player-button-stop');
                            $(this).addClass('player-rotate');
                            status_bool = true;
                        }
                    });
                });
            </script>
            <script src="<?php echo v_theme_url() ?>/js/invitation/islider.js"></script>
            <script src="<?php echo v_theme_url() ?>/js/invitation/plugins/islider_desktop.js"></script>
    </head>
    <body>
        <!-- 代码 开始 --> 
        <div id="iSlider-effect-wrapper">
            <div id="animation-effect" class="iSlider-effect"></div>
        </div>
        <!--<div id="menu-select">
            <span class="on">default</span>
            <span>rotate</span>
            <span>flip</span>
            <span>depth</span>
        </div>-->

        <div class="player-button player-rotate" id="players"> <span class="player-tip" style="display: none; ">点击开启/关闭音乐</span> </div>
        <audio src="<?php echo v_theme_url() ?>/img/invitation/audio/20150623.mp3" autoplay="true" id="audioMedia" controls> </audio>  
        <div class="prompts">
            <<向左移动
        </div>
        <script>
                var picList = [
//                {
//                    width: 150,
//                    height: 207,
//                    content: "<?php echo v_theme_url() ?>/img/invitation/yao.jpg",
//                },
                    {
                        width: 150,
                        height: 207,
                        content: "<?php echo v_theme_url() ?>/img/invitation/yao1.jpg",
                    },
                    {
                        width: 150,
                        height: 207,
                        content: "<?php echo v_theme_url() ?>/img/invitation/yao4.jpg"
                    },
                    {
                        width: 150,
                        height: 207,
                        content: "<?php echo v_theme_url() ?>/img/invitation/yao2.jpg",
                    },
                    {
                        width: 150,
                        height: 207,
                        content: "<?php echo v_theme_url() ?>/img/invitation/yao3.jpg"
                    },
                    {
                        width: 300,
                        height: 414,
                        content: "<?php echo v_theme_url() ?>/img/invitation/yao5.jpg"
                    }
                ];

                //        var domList = [
                //        {
                //            'height' : '100%',
                //            'width' : '100%',
                //            'content' : '<div><h1>Home</h1><h2>This is home page</h2><p>home is pretty awsome</p><div>'
                //        },{
                //            'height' : '100%',
                //            'width' : '100%',
                //            'content' : '<div><h1>Page1</h1><h2>This is page1</h2><p>page1 is pretty awsome</p><div>'
                //        },{
                //            'height' : '100%',
                //            'width' : '100%',
                //            'content' : '<div><h1>Page2</h1><h2>This is Page2</h2><p>Page2 is pretty awsome</p><div>'
                //        },{
                //            'height' : '100%',
                //            'width' : '100%',
                //            'content' : '<div><h1>Page3</h1><h2>This is page3</h2><p>page3 is pretty awsome</p><div>'
                //        }
                //        ];

                //all animation effect
                var islider1 = new iSlider({
                    data: picList,
                    dom: document.getElementById("animation-effect"),
                    duration: 2000,
                    animateType: 'flip',
                    isAutoplay: false,
                    isLooping: false,
                    // isVertical: true, 是否垂直滚动
                });
                islider1.bindMouse();
                //
                //        //vertical slide
                //        var islider2 = new iSlider({
                //            data: picList,
                //            dom: document.getElementById("vertical-slide"),
                //            duration: 2000,
                //            animateType: 'default',
                //            isVertical: true,
                //            isAutoplay: true,
                //            isLooping: true,
                //        });
                //        islider2.bindMouse();
                //
                //        //不循环 不自动播放
                //        var islider3 = new iSlider({
                //            data: picList,
                //            dom: document.getElementById("non-looping"),
                //            animateType: 'default',
                //        });
                //        islider3.bindMouse();
                //
                //        //滚动dom
                //        var islider4 = new iSlider({
                //            data: domList,
                //            dom: document.getElementById("dom-effect"),
                //            type: 'dom',
                //            animateType: 'default',
                //            isAutoplay: true,
                //            isLooping: true,
                //        });
                //        islider4.bindMouse();
                //		
                //		var menu = document.getElementById('menu-select').children;
                //
                //        function clickMenuActive(target) {
                //
                //            for (var i = 0; i < menu.length; i++) {
                //                menu[i].className = '';
                //            }
                //
                //            target.className = 'on';
                //            
                //        }

                //        menu[0].onclick = function() {
                //
                //            clickMenuActive(this);
                //            islider1._opts.animateType = this.innerHTML;
                //            islider1.reset();
                //        };
                //
                //        menu[1].onclick = function() {
                //
                //            clickMenuActive(this);
                //            islider1._opts.animateType = this.innerHTML;
                //            islider1.reset();
                //        };
                //
                //        menu[2].onclick = function() {
                //
                //            clickMenuActive(this);
                //            islider1._opts.animateType = this.innerHTML;
                //            islider1.reset();
                //        };
                //
                //        menu[3].onclick = function() {
                //
                //            clickMenuActive(this);
                //            islider1._opts.animateType = this.innerHTML;
                //            islider1.reset();
                //        };
        </script> 
    </body>
</html>