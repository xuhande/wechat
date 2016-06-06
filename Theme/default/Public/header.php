<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title><?php echo v_title() ?></title> 

        <link rel="stylesheet" href="<?php echo v_theme_url(); ?>/css/bootstrap/css/bootstrap.min.css"/> 
        <link rel="stylesheet" href="<?php echo v_theme_url(); ?>/css/style.css"/>
        <link rel="stylesheet" href="<?php echo v_theme_url(); ?>/css/hover.css"/>
        <script src="<?php echo v_theme_url(); ?>/js/jquery.min.js"></script>
        <script src="<?php echo v_theme_url(); ?>/js/jquery.animate-colors-min.js"></script>
        <script src="<?php echo v_theme_url(); ?>/css/bootstrap/js/bootstrap.min.js"></script>



        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    </head>
    <body>

        <!--        <nav class="navbar navbar-default content  navbar-inverse navbar-fixed-top"  id="nav" role="navigation">
        
                    <div class="container">
                       
                        <ul class="nav navbar-nav ">
        
                            <li><a href="<?php echo U("Article/index/index"); ?>">photo</a></li>
         
                            <li> <a href='<?php echo U("Admin/index/index"); ?>'>管理</a></li>
                          
                        </ul>
                    </div>
                </nav> 
        -->

        <?php
        $jssdk = new \JSSDK\Controller\IndexController(C("WX_CONF_APPID"), C("WX_CONF_APPSECRET"));

        $signPackage = $jssdk->GetSignPackage();
        ?>
        
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
                appId: '<?php echo $signPackage["appId"]; ?>',
                timestamp: <?php echo $signPackage["timestamp"]; ?>,
                nonceStr: '<?php echo $signPackage["nonceStr"]; ?>',
                signature: '<?php echo $signPackage["signature"]; ?>',
                jsApiList: [
                    'checkJsApi',
                    'onMenuShareTimeline',
                    'onMenuShareAppMessage',
                    'onMenuShareQQ',
                    'onMenuShareWeibo',
                    'hideMenuItems',
                    'showMenuItems',
                    'hideAllNonBaseMenuItem',
                    'showAllNonBaseMenuItem',
                    'translateVoice',
                    'startRecord',
                    'stopRecord',
                    'onRecordEnd',
                    'playVoice',
                    'pauseVoice',
                    'stopVoice',
                    'uploadVoice',
                    'downloadVoice',
                    'chooseImage',
                    'previewImage',
                    'uploadImage',
                    'downloadImage',
                    'getNetworkType',
                    'openLocation',
                    'getLocation',
                    'hideOptionMenu',
                    'showOptionMenu',
                    'closeWindow',
                    'scanQRCode',
                    'chooseWXPay',
                    'openProductSpecificView',
                    'addCard',
                    'chooseCard',
                    'openCard'
                ]
            });

        </script>