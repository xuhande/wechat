<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>“纯净之酩”品酒会</title>    
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> 
        <meta name="format-detection"content="telephone=no">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <script type="text/javascript">
            var jsVer = 29;
            var phoneWidth = parseInt(window.screen.width);
            var phoneScale = phoneWidth / 640;

            var ua = navigator.userAgent;
            if (/Android (\d+\.\d+)/.test(ua)) {
                var version = parseFloat(RegExp.$1);
                // andriod 2.3
                if (version > 2.3) {
                    document.write('<meta name="viewport" content="width=640, minimum-scale = ' + phoneScale + ', maximum-scale = ' + phoneScale + ', target-densitydpi=device-dpi">');
                    // andriod 2.3以上
                } else {
                    document.write('<meta name="viewport" content="width=640, target-densitydpi=device-dpi">');
                }
                // 其他系统
            } else {
                document.write('<meta name="viewport" content="width=640, user-scalable=no, target-densitydpi=device-dpi">');
            }
        </script>



        <script src="<?php echo v_theme_url() ?>/js/invitation/jquery-1.10.1.min.js"></script>
        <script src="<?php echo v_theme_url() ?>/js/invitation/jquery.eraser.js"></script>
        <script src="<?php echo v_theme_url() ?>/js/invitation/turn.js"></script>
    </head>
    <style>
        *{
            margin:0px;
            padding:0px;
        }
        body{
            margin:0px auto; 

        }
        .flipbook { text-align:center; 
                    display:none;

                    z-index:999;
                    margin:0px auto;
                    overflow: hidden;
        }
        .flipbook div{width:100%; height:100%}
        .eraser {
            position:absolute;
            text-align:center;
            z-index:998;

            -webkit-transition: opacity 1s ease-in-out;
            -moz-transition: opacity 1s ease-in-out;
            -o-transition: opacity 1s ease-in-out;
            transition: opacity 1s ease-in-out;
        }
        #robot {
            position: absolute;
            top: 0px;
            left: 0px;
            z-index: 1;
        }
        #redux {
            position: absolute;
            top: 0px;
            left: 0px;
            z-index: 2;

        }
        .transition-form {
            position:absolute;
            -webkit-transition: opacity 1s ease-in-out;
            -moz-transition: opacity 1s ease-in-out;
            -o-transition: opacity 1s ease-in-out;
            transition: opacity 1s ease-in-out;
        }
        .anim_fade_hide_image {
            /*display:none;*/
            opacity:0;
            filter: alpha(opacity=0);
        }
        .anim_fade_show_image {
            /*display:none;*/
            opacity:1;
            filter: alpha(opacity=1);
        }
        audio{
            display:none;
        }
        .player-button{position:fixed;z-index:10000;display:block;top:10px;right:10px;width:30px;height:30px;background:url(<?php echo v_theme_url() ?>/img/invitation/player-button.png) -30px 0;background-size:60px 30px;cursor:pointer;/*background-position: center;*/background-repeat: no-repeat;}
        .player-button-stop{background:url(<?php echo v_theme_url() ?>/img/invitation/player-button.png) 0 0;background-size:60px 30px;}
        .player-tip{position:absolute;top:5px;left:-140px;width:120px;background:rgba(59,89,114,.6);border-radius:4px 0 0 4px;font-size:10px;color:#ccc;line-height:20px;text-align:center}
        .player-tip:after{content:"";position:absolute;right:-32px;width:0;height:0;border-left:16px solid rgba(59,89,114,.6);border-top:10px solid transparent;border-right:16px solid transparent;border-bottom:10px solid transparent;}
        .player-rotate { 
            -webkit-animation-name: rotate;
            -webkit-animation-duration:5s;
            -webkit-animation-iteration-count:100000;
            -webkit-animation-timing-function:linear;
            -ms-animation-name: rotate;
            -ms-animation-duration:5s;
            -ms-animation-iteration-count:100000;
            -ms-animation-timing-function:linear;
            -moz-animation-name: rotate;    
            -moz-animation-duration:5s;
            -moz-animation-iteration-count:100000;
            -moz-animation-timing-function:linear;
        }
        @-webkit-keyframes rotate {
            from {-webkit-transform: rotate(0deg);}
            to {-webkit-transform: rotate(360deg);}
        } 
        @-ms-keyframes rotate {
            from {-ms-transform: rotate(0deg);}
            to {-ms-transform: rotate(360deg);}
        }
        @-moz-keyframes rotate {
            from {-moz-transform: rotate(0deg);}
            to {-moz-transform: rotate(360deg);}
        }
    </style>
    <body> 
        <section  style="position:relative;overflow: visible;width:100%;height:100%;">
            <div class="eraser" id="ers"> 
                <img id="robot"src="<?php echo v_theme_url() ?>/img/invitation/yao1.jpg"  /> 
                <img id="redux" src="<?php echo v_theme_url() ?>/img/invitation/yao.jpg" /> 
            </div>
            <div class="flipbook" > 

                <div style="background: url(<?php echo v_theme_url() ?>/img/invitation/yao1.jpg);background-size:100% 100%;">
                    <img src="<?php echo v_theme_url() ?>/img/invitation/yao1.jpg" height="100%" width="100%"/>
                </div>
                <div style="background: url(<?php echo v_theme_url() ?>/img/invitation/yao4.jpg);background-size:100% 100%;">
                    <img src="<?php echo v_theme_url() ?>/img/invitation/yao4.jpg" height="100%" width="100%"/>
                </div>
                <div style="background: url(<?php echo v_theme_url() ?>/img/invitation/yao2.jpg);background-size:100% 100%;">
                    <img src="<?php echo v_theme_url() ?>/img/invitation/yao2.jpg"  height="100%" width="100%"/>
                </div> 
                <div style="background: url(<?php echo v_theme_url() ?>/img/invitation/yao3.jpg);background-size:100% 100%;">
                    <img src="<?php echo v_theme_url() ?>/img/invitation/yao3.jpg"  height="100%" width="100%"/>
                </div>
                <div style="background: url(<?php echo v_theme_url() ?>/img/invitation/yao5.jpg);background-size:100% 100%;">
                    <img src="<?php echo v_theme_url() ?>/img/invitation/yao5.jpg" height="100%" width="100%"/>
                </div>

            </div> 


        </section>
        <div class="player-button player-rotate" id="audio-img"> <span class="player-tip" style="display: none; ">点击开启/关闭音乐</span> </div>
        <audio src="<?php echo v_theme_url() ?>/img/invitation/audio/20150623.mp3" autoplay="true" id="audioMedia" controls> </audio> 
    </body>
</html>

<script type="text/javascript">
            $(function () {
                $("#robot").height($(window).height()).width($(window).width());

                //屏蔽ios下上下弹性
                $(window).on('scroll.elasticity', function (e) {
                    e.preventDefault();
                }).on('touchmove.elasticity', function (e) {
                    e.preventDefault();
                });

                var w = $(window).width();
                var h = $(window).height();
                $('.flipboox').width(w);
                $('.flipboox').height(h);
                $(window).resize(function () {
                    w = $(window).width();
                    h = $(window).height();
                    $('.flipboox').width(w);
                    $('.flipboox').height(h);
                });

                function loadApp() {
                    var $flipbook = $('.flipbook');
                    // Create the flipbook
                    $flipbook.turn({
                        width: w,
                        height: h,
                        elevation: 500,
                        display: 'single',
                        gradients: true,
                        autoCenter: true,
                        turnCorners: "r,l"
                    }).bind("star", function (event) {
                        $flipbook.turn("next"); 
                    });
                }


                $('#redux').eraser({size: 100,
                    progressFunction: function (p) {
                        console.log(p * 10);
                        if (p * 10 > 5) {

                            $("#ers").addClass("anim_fade_hide_image");
//                    $("#ers").remove();
//$("#redux").remove(); 
                            $(".flipbook").show();
                            $(".flipbook").addClass("anim_fade_show_image");
                            loadApp();
                            $('audio').trigger('play');
                        }
                    }
                });
                var status_bool = false;
                $("#audio-img").click(function () {
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


