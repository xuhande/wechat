<?php v_template_part(array("name" => "header", "path" => "Public")); ?> 
<?php
$oauth2 = new Home\Controller\Oauth2Controller();
$data = $oauth2->getOpenId($_GET['code']);
$openid = json_decode($data);
$userinfo = json_decode($oauth2->getUserInfo($openid->openid));

$cork = new Cork\Controller\IndexController();
$check = $cork->checkSaveByOpenId($userinfo->openid);
if ($check != "200") {
    header("location: " . v_site_url() . "/?m=Cork&a=success&openid=" . $check);
    exit;
}
?> 
<link rel="stylesheet" type="text/css" href="<?php echo v_theme_url(); ?>/Cork/css/webuploader.css" />

<link rel="stylesheet" type="text/css" href="<?php echo v_theme_url(); ?>/Cork/css/style.css" />
<script type="text/javascript" src="<?php echo v_theme_url(); ?>/Cork/jquery.js"></script>
<script type="text/javascript" src="<?php echo v_theme_url(); ?>/Cork/dist/webuploader.js"></script>  


<link rel="stylesheet" type="text/css" href="<?php echo v_site_url() ?>/Public/css/wx.css"  >
<script type="text/javascript" src="<?php echo v_site_url() ?>/Public/js/jquery-1.8.2.min.js"></script>
<div class="msg_page" id="msg_page">

    <div class="msg_list">

        <div class="msg_list_bd">
            <p class="prompt">请选取您的作品图片，最多选一张！谢谢！</p>
            <div class="col-md-12 form-group text-center">
                <!--                <div class="col-sm-12">
                                    <div class="alert alert-warning"  role="alert">最多只能选取一张图片</div>
                                </div>-->
                <div id="thelist">

                </div>

                <div id="pickerr" style="text-align: center"><img src="<?php echo v_theme_url() ?>/Cork/image.png" /></div>
            </div>
            <div class="col-md-12 form-group">
                <!--<div id="getLocation">getLocation</div>-->
                <div   id="cancel"  class="btn btn-success" style="width: 100%;cursor: pointer; display: none;">重新选择</div>
                <!--<div id="cancel" style="text-align: center; display: none; background-color: #00b7ee; margin:0px auto;padding:15px 10px; width:100px;cursor: pointer; ">重新选择</div>-->

            </div>
            <p class="prompt">请留下您的联系方式</p>
            <div class="form-group"> 
                <input type="text" class="form-control" id="name" name="name" placeholder="请输入姓名">
                <input type="hidden" class="form-control" id="openid" name="openid" value="<?php echo $userinfo->openid ?>">
                <input type="hidden" class="form-control" id="nickname" name="nickname" value="<?php echo $userinfo->nickname ?>">
                <input type="hidden" class="form-control" id="subscribe" name="subscribe" value="<?php echo $userinfo->subscribe ?>">
            </div>
<!--            <div class="form-group"> 
                <input type="text" class="form-control" id="idno" name="idno" placeholder="请输入身份证号">
            </div> -->
            <div class="form-group"> 
                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="请输入手机号码">
            </div> 
            <p class="prompt">请输入作品相关信息</p>
            <div class="form-group"> 
                <input type="text" class="form-control" id="title" name="title" placeholder="请输入作品名称">
            </div> 
            <div class="form-group"> 
                <textarea class="form-control" id="summary" name="summary" rows="6" style="height: 10em;" placeholder="请输入作品概要介绍"></textarea>
            </div>
            <div class="col-sm-10">
                <div class="alert alert-warning" id="alert-warning" role="alert" style="display: none"></div>
            </div>
            <div class="form-group">
                <button type="submit"  id="ctlBtn"  class="btn btn-success" style="width: 100%;">提交</button>
            </div>


            <div class="form-group">
                <button type="submit"  id="share"  class="btn btn-success" style="width: 100%;">邀请好友参加</button>
            </div>

            <div class="col-xs-12" style="padding:0px 0px;">
               <h4>活动规则</h4>

1. 请在本页面上传作品图片，提交作品信息，并输入联系信息。<br />
2. 为了公平起见，请在作品背景纸上手写主办方“Vynfields”或“维尼菲尔德”并签名，否则作品无效。<br />
<div class="col-md-12 text-center"><img src="<?php echo v_theme_url()?>/image/shili.jpg" width="200px"/></div>
3. 请勿重复投稿，每人仅能提交一次作品，请谨慎选择！<br />
4. 提交成功后，作品将于48小时内审核完毕。<br />
5. 请重新进入此页面查询审核结果。<br />
6. 本次活动全部作品均属原创，参与者需保证其作品没有侵犯他人权利，如产生版权纠纷，与本公司无关。<br />
               
 

            </div>
        </div>
    </div> 
</div>

<!-- Modal -->
<div class="modal fade" id="showlodding" style="top:25%" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width:80%; text-align: center;margin: 0px auto;">
            <!--            <div class="modal-header text-center" style="background-color: rgb(175,115,75); ">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel" style="line-height: 1; color:#fff">温馨提示</h4>
                        </div>-->
            <!--<div class="modal-body">-->
<!--            <img src="<?php echo v_theme_url() ?>/image/loading.gif" width="50"/><br />
            正在提交，请稍候...-->
            <div id="loading-progress" style="width: 0%; background-color: rgb(175,115,75)">
                <div style=" width: 200px; padding: 10px; text-align: center;">
                    
                    正在提交，请稍候...<span id="loading-number"></span></div>
            </div>
            <!--</div>-->
            <!--            <div class="modal-footer" style="text-align: center; border-top: 0px;">
                            <button type="button" class="btn btn-default  text-center" style="border: 1px rgb(205,145,105) solid" data-dismiss="modal">关闭</button> 
                        </div>-->
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" style="top:25%" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width:80%; margin: 0px auto;">
            <div class="modal-header text-center" style="background-color: rgb(175,115,75); ">
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
                <h4 class="modal-title" id="myModalLabel" style="line-height: 1; color:#fff">温馨提示</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer" style="text-align: center; border-top: 0px;">
                <button type="button" class="btn btn-default  text-center" style="border: 1px rgb(205,145,105) solid" data-dismiss="modal">关闭</button> 
            </div>
        </div>
    </div>
</div>


<script src="<?php echo v_theme_url(); ?>/css/bootstrap/js/modal.js"></script>
<script>
    
     if (!<?php echo $userinfo->subscribe ? "true" : "false"; ?>) {
                $('#myModal').modal('show');
                $(".modal-body").html("需要关注后才能上传作品。<br/>微信号:vynfields");
            } 
    
    
    
    var filetimepath =  Date.parse(new Date());
    
    
    var uploader = WebUploader.create({
        // swf文件路径 
        // 文件接收服务端。
//        server: '<?php echo v_site_url() ?>?m=Cork&a=upload',
        server :'<?php echo U("Cork/index/upload")?>',
        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#pickerr',
        // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        resize: false,
        extensions: 'gif,jpg,jpeg,bmp,png',
        multiple: false,
        fileNumLimit: 1,
        sendAsBinary: true

    });
    var imgpath = new Array();
    var isselect = false;
// 当有文件被添加进队列的时候
    uploader.on('fileQueued', function (file) {

        var $li = $(
                '<div id="' + file.id + '" class="file-item thumbnail">' +
                '<img>' +
                '<p class="state"></p>' +
                '<div class="progress progress-bar"></div>' +
                '<div class="info">' + file.name + '</div>' +
                '</div>'
                ),
                $img = $li.find('img');
        // $list为容器jQuery实例
        $("#thelist").append($li);
        // 创建缩略图
        // 如果为非图片文件，可以不用调用此方法。
        // thumbnailWidth x thumbnailHeight 为 100 x 100
        uploader.makeThumb(file, function (error, src) {
            if (error) {
                $img.replaceWith('<span>不能预览</span>');
                alert(src);
                return;
            }

            $img.attr('src', src);
        }, 300, 300);
        $("#cancel").show();
        $("#pickerr").hide();
        isselect = true;
    });
// 文件上传过程中创建进度条实时显示。
    uploader.on('uploadProgress', function (file, percentage) {
        var $li = $('#' + file.id),
                $percent = $li.find('.progress .progress-bar'),
                $loadingnumber =$("#loading-number"),
                $loadingprogress = $("#loading-progress");
        // 避免重复创建
        if (!$percent.length) {
            $percent = $('<div class="progress progress-striped active">' +
                    '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                    '</div>' +
                    '</div>').appendTo($li).find('.progress-bar');
        }

        $li.find('p.state').text('上传中');
      
        $percent.css('width', percentage * 100 + '%');
//        $loadingnumber.html(parseInt(percentage * 100) + '%')
        $loadingprogress.css('width', percentage * 100 + '%');
    });
    uploader.on('uploadSuccess', function (file) {
        //console.log(file);
        //$("body").append("<img src='http://localhost/server/upload/"+file.name+"'>")
        $('#' + file.id).find('p.state').text("success");
    });
    uploader.on('uploadError', function (file) {
        alert(file);
        $('#' + file.id).find('p.state').text('上传出错');
    });
    uploader.on('uploadComplete', function (file) {
        //console.log( uploader.getFiles() );
        $('#' + file.id).find('.progress').fadeOut();
    });
    uploader.on('uploadFinished', function () {
        var obj = uploader.getFiles("complete");
        $.each(obj, function (i, item) {
            imgpath.push("<?php echo v_site_url() ?>/upload" + "/"+filetimepath +"/"+ item.name);
        });
        aiax_save_img_path(imgpath);
        uploader.reset();
    });
    $("#ctlBtn").on('click', function () {
        uploader.option('formData', {
            file_dir_asd: filetimepath
        });
        var name = $("input[name*='name']").val();
//        var idno = $("input[name*='idno']").val();
        var summary = $("textarea[name*='summary']").val();
        var mobile = $("input[name*='mobile']").val();
        var title = $("input[name*='title']").val();
        var openid = $("input[name*='openid']").val();
        if (isselect) {
            if (!<?php echo $userinfo->subscribe ? "true" : "false"; ?>) {
                $('#myModal').modal('show');
                $(".modal-body").html("需要关注后才能上传作品。<br/>微信号:vynfields");
            } else {
                if (name == "" || summary == "" || mobile == "" || title == "") {
                    $('#myModal').modal('show');
                    $(".modal-body").html("信息不完全，请检查后提交!");
                } else {
                    $('#showlodding').modal('show');

                    $("#ctlBtn").html("正在提交");
                    uploader.upload();
                }
            }
        }
        else {
//             $('#showlodding').modal('show');
            $('#myModal').modal('show');
            $(".modal-body").html("请选择图片");
        }


    });
    $("#cancel").click(function () {
        isselect = false;
        uploader.reset();
        $("#thelist").html("");
        $("#pickerr").show();
    });
    function aiax_save_img_path(data) {

        $.ajax({
            //提交数据的类型 POST GET
            type: "POST",
            //提交的网址
            url: '<?php echo v_site_url() ?>?m=Cork&a=save',
            //提交的数据
            data: {path: data, name: $("input[name*='name']").val(), subscribe: $("input[name*='subscribe']").val(), summary: $("textarea[name*='summary']").val(), openid: $("input[name*='openid']").val(), nickname: $("input[name*='nickname']").val(), mobile: $("input[name*='mobile']").val(), title: $("input[name*='title']").val()}, //{Name: "sanmao", Password: "sanmaoword"},
            //返回数据的格式
            datatype: "json", //"xml", "html", "script", "json", "jsonp", "text".
            //在请求之前调用的函数
            beforeSend: function () {
                $("#msg").html("logining");
//                   alert("befor");
            },
            //成功返回之后调用的函数             
            success: function (data) {
//                $("#msg").html(decodeURI(data));
// alert(data);
                $('#showlodding').modal('hide');
                if (data == "303") {

                    $('#myModal').modal('show');
                    $(".modal-body").html("需要关注才能上传哦；公众号:vynfields");
                    $("#ctlBtn").html("提交");
                }
                else if (data === "201") {
                    $('#myModal').modal('show');
                    $(".modal-body").html("同一个用户只能提交一次哦，如有特殊情况，请联系客服");
                    $("#ctlBtn").html("提交");
                }
                else if (data == "200") {

                    $('#myModal').modal('show');
                    $(".modal-body").html("提交成功，作品正在审核中。<br />重新打开此页面查看审核进度。");
                    $("#ctlBtn").html("提交成功");
                    $("#ctlBtn").attr('disabled', false);
                }
//                location.href = "<?php echo U("Cork/index/Success"); ?>";
            },
            //调用执行后调用的函数
            complete: function (XMLHttpRequest, textStatus) {

            },
            //调用出错执行的函数
            error: function () {
                //请求出错处理
//                 alert("error");
            }
        });
    }

</script>  

<script>


    $("#share").click(function () {
        $('#myModal').modal('show');
        $(".modal-body").html("请点击右上角按钮，选择分享到朋友圈");
    });
    wx.ready(function () {
        // 在这里调用 API

 
//    wx.checkJsApi({
//        jsApiList: [
//                    'checkJsApi',
//                    'onMenuShareTimeline',
//                    'onMenuShareAppMessage',
//                    'onMenuShareQQ',
//                    'onMenuShareWeibo',
//                    'hideMenuItems',
//                    'showMenuItems',
//                    'hideAllNonBaseMenuItem',
//                    'showAllNonBaseMenuItem',
//                    'translateVoice',
//                    'startRecord',
//                    'stopRecord',
//                    'onRecordEnd',
//                    'playVoice',
//                    'pauseVoice',
//                    'stopVoice',
//                    'uploadVoice',
//                    'downloadVoice',
//                    'chooseImage',
//                    'previewImage',
//                    'uploadImage',
//                    'downloadImage',
//                    'getNetworkType',
//                    'openLocation',
//                    'getLocation',
//                    'hideOptionMenu',
//                    'showOptionMenu',
//                    'closeWindow',
//                    'scanQRCode',
//                    'chooseWXPay',
//                    'openProductSpecificView',
//                    'addCard',
//                    'chooseCard',
//                    'openCard'
//                ],
//      success: function (res) {
//        alert(JSON.stringify(res));
//      },
//      error:function(res){
//        alert(JSON.stringify(res));  
//      }
//    }); 
        /**
         * user share 
         */
        wx.onMenuShareTimeline({
            title: '脑洞有多大，奖品就有多大！',
//            link: '<?php echo v_site_url() . "/?s=/Home/Oauth2/index/type/index" ?>',
            link:'http://mp.weixin.qq.com/s?__biz=MzA3MDAyMzA5OQ==&mid=211569463&idx=1&sn=a5b14cf144aa75756a1b7ecfeb6385ab&key=fbe9f9f4b565962ca850ccd7e7722cd4fa08b41e58c0dca9df28ae7d1a6aaf81a79a9340aed989d68a24068ad21ddbba&ascene=1&uin=MjQ4ODEzMjAw&devicetype=webwx&version=70000001&pass_ticket=4DKHDCVyjNvgYxv%2FdRYDuZVhfQ%2BgIFy2JljQIaW3mr0%3D',
            imgUrl: '<?php echo v_theme_url()?>/image/share.jpg',
            trigger: function (res) {
                // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回

            },
            success: function (res) {
                // alert('已分享');
            },
            cancel: function (res) {
                //alert('已取消');
            },
            fail: function (res) {
                // alert(JSON.stringify(res));
            }
        });
        wx.onMenuShareAppMessage({
            title: '脑洞有多大，奖品就有多大！',
            desc: '', // 分享描述
           link:'http://mp.weixin.qq.com/s?__biz=MzA3MDAyMzA5OQ==&mid=211569463&idx=1&sn=a5b14cf144aa75756a1b7ecfeb6385ab&key=fbe9f9f4b565962ca850ccd7e7722cd4fa08b41e58c0dca9df28ae7d1a6aaf81a79a9340aed989d68a24068ad21ddbba&ascene=1&uin=MjQ4ODEzMjAw&devicetype=webwx&version=70000001&pass_ticket=4DKHDCVyjNvgYxv%2FdRYDuZVhfQ%2BgIFy2JljQIaW3mr0%3D',
            imgUrl: '<?php echo v_theme_url()?>/image/share.jpg',
            type: 'link', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                // 用户确认分享后执行的回调函数
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
//        wx.hideAllNonBaseMenuItem();
//        wx.showMenuItems({
//            menuList: [
//                'menuItem:profile',
//                'menuItem:exposeArticle'
//            ],
//            success: function (res) {
////                alert('已显示');
//            },
//            fail: function (res) {
////                alert(JSON.stringify(res));
//            }
//        });
        wx.showAllNonBaseMenuItem();
    });


</script>
<?php v_template_part(array("name" => "footer", "path" => "Public")); ?>