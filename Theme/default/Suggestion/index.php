<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=no" /> 
        <title>意见及建议</title>
        <link rel="stylesheet" type="text/css" href="<?php echo v_site_url() ?>/Public/css/wx.css"  >
        <script type="text/javascript" src="<?php echo v_site_url() ?>/Public/js/jquery-1.8.2.min.js"></script>
        <script>
            $(function () {
                $('#sForm').submit(function () {
                     var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
                     var kg = /(^\s*)|(\s*$)/g;
                    if ($("#realName").val().replace(/(^\s*)|(\s*$)/g, "") === "") {
                        alert("请输入姓名！");
                        return false;
                    }else if ($("#realName").val().replace(/(^\s*)|(\s*$)/g, "") === "") {
                          alert("请输入邮件！");
                        return false;
                    } else if (!myreg.test($("#email").val())) {
                            alert("邮箱格式不符合规范！");
                            return false;
                    }else if ($("#content").val().replace(/(^\s*)|(\s*$)/g, "") === "") {
                        alert("请输入您宝贵的意见及建议！");
                        return false;
                    }else{
                        return true;
                    } 
                });
            });
            function onBridgeReady() {
                WeixinJSBridge.call('hideOptionMenu');
            }

            if (typeof WeixinJSBridge == "undefined") {
                if (document.addEventListener) {
                    document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
                } else if (document.attachEvent) {
                    document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
                    document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
                }
            } else {
                onBridgeReady();
            }
        </script>
    </head>
    <body>
        <div class="msg_page" id="msg_page">    

            <div class="msg_list">

                <div class="msg_list_bd">
                    <form action="<?php echo v_site_url() ?>?m=Home&c=Suggestion&a=pSuggestion" method="post" id="sForm">
                        <p class="prompt">请留下您的联系方式，以便后期联系您！谢谢！</p>
                        <div class="form-group"> 
                            <input type="text" class="form-control" id="realName" name="realName" placeholder="请输入姓名">
                        </div>
                        <div class="form-group"> 
                            <input type="text" class="form-control" id="email" name="email" placeholder="请输入邮件">
                        </div>                        
                        <p class="prompt">请输入您宝贵的意见及建议，我们需要您的详细！谢谢！</p>
                        <div class="form-group"> 
                            <textarea class="form-control" id="content" name="content" rows="6" style="height: 10em;" placeholder="请输入您宝贵的意见及建议，感谢支持，我们会做得更好！"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success" style="width: 100%;">提交</button>
                        </div>
                    </form>
                </div>
            </div> 
        </div>

    </body>
</html>

