<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>“纯净之酩”品酒会</title>   
        <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=no" /> 
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

<!--        <div class="player-button player-rotate" id="players"> <span class="player-tip" style="display: none; ">点击开启/关闭音乐</span> </div>
        <audio src="<?php echo v_theme_url() ?>/img/invitation/audio/20150623.mp3" autoplay="true" id="audioMedia" controls> </audio>  -->
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
        </script> 
    </body>
</html>