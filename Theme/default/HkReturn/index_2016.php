<?php v_template_part(array("name" => "header", "path" => "Public")); ?> 

<link rel="stylesheet" type="text/css" href="<?php echo v_site_url() ?>/Public/css/wx.css"  >

<script src="<?php echo v_theme_url(); ?>/js/awardRotate.js"></script>
<style>
    html{
        position: relative; 
    }
    body{
        background: url("<?php echo v_theme_url(); ?>/image/HkReturn/hk_return_bg.jpg") no-repeat #B32121; 
        background-size:100% 100%;
    }

    .turntable-title{
        margin-top:30px;
    }
    .turntable-title img{
        width:100%;
    }
    .turntable-chance{
        position:relative; 
        height:52px; 
    }
    .turntable-chance span{ 
        MARGIN-RIGHT: auto; MARGIN-LEFT: auto; 
        width:192px;
        height:52px;
        line-height:52px;
        font-size:16px;
        color:#fff;
        background: url("<?php echo v_theme_url(); ?>/image/HkReturn/hk_return_chance.png") no-repeat; 
        background-size: 192px 52px;
        display:block
    }

    .turntable-chance span font{
        font-size:18px;
        color:#e38d13;
    }
    .turntable-bg {
        width: 310px;
        max-width: 320px;
        height: 350px;
        margin: 0 auto ;
        position: relative; 
        /*background: url("<?php echo v_theme_url(); ?>/image/lottery/turntable-bg.jpg");*/ 
        background-size:310px 650px;
    }
    .turntable-bg .mask {
        width: 454px;
        height: 451px;
        position: absolute;
        left: 116px;
        top: 60px;
        /*z-index:9;*/
    }
    .turntable-bg .pointer {
        width: 85px;
        height: 142px;
        position: absolute;
        left: 58.5%;
        top: 75%;
        margin-left: -67px;
        margin-top: -144px;
        z-index: 8;
    }

    .turntable-bg .pointer:hover{ 
        cursor: pointer;
    }
    .turntable-bg .rotate {
        width: 310px;
        max-width: 310px;
        height: 310px;  
        position:absolute;
        top:20px;
        overflow:hidden;
        /*        left: 116px;
                top: 60px;*/
    }
    .turntable-number{
        margin-top: 20px;
        font-size: 20px;        
        text-align: center;
        color:#fff;
    }
    .turntable-bg .turntable-cont{
        width:310px;
        height: 100%;
        position:relative;
        margin: 0 auto ;
    } 
    .turntable-number em{
        color: red
    }
    .turntable-hd{
        text-align: center;
        margin-top: 40px;
    }
    .t-hd:hover{
        cursor: pointer;
    }
    #formBtn{ 
        font-size: 9pt;
        color: #003399;
        border: 1px #003399 solid;
        color: #006699;
        border-bottom: #93bee2 1px solid;
        border-left: #93bee2 1px solid;
        border-right: #93bee2 1px solid;
        border-top: #93bee2 1px solid; 
        background-color: #e8f4ff;
        font-style: normal;
        width: 60px; 
    }
    small{
        color:#fff
    }
    .dismiss{
        position: absolute;
        width:45px;
        height:43px;
        text-align: center;
        line-height: 43px;
        top: 0%;
        right:0%;
        color: #555;
        font-size: 20px
    }
    .dismiss{
        cursor: pointer;
    }
    .turntable-detail .btn{
        color:#fff;
        border:1px solid #62100D;
        background:#821713;
    }
    .turntable-detail .btn:hover,.turntable-detail .btn:active{
        font-weight:normal;
        border:1px solid #490D0A;
        background:#62100D;
    }
</style>
<script>
    $(function () {
        var rotateTimeOut = function () {
            $('#rotate').rotate({
                angle: 0,
                animateTo: 2160,
                duration: 8000,
                callback: function () {
                    alert('网络超时，请检查您的网络设置！');
                }
            });
        };
        var bRotate = false;
        var rotateFn = function (angles, obj) {
            bRotate = !bRotate;
            var ang = parseInt(obj.angles) + 1800;
            $('#rotate').stopRotate();
            $('#rotate').rotate({
                angle: 0,
                animateTo: ang,
                duration: 1000,
                callback: function () {
//                        alert(angles[2]);
                    bRotate = !bRotate;
//                      $('#saveaddress').modal('show');
                    ajax_save(obj);
                }
            })
        };
        $('.pointer').click(function () {
            if (bRotate)
                return;
            $.ajax({
                type: "GET",
                url: '<?php echo U("HkReturn/index/getLottery") ?>',
                datatype: "json", //"xml", "html", "script", "json", "jsonp", "text". 
                beforeSend: function () {

                },
                success: function (data) {
                    var obj = $.parseJSON(data);
                    rotateFn(255, obj);
                },
                complete: function (XMLHttpRequest, textStatus) {

                },
                error: function () {
                }
            });
        });



    });
    function rnd(n, m) {
        return Math.floor(Math.random() * (m - n + 1) + n)
    }
</script>

<div id="one">

    <div class='turntable-title  text-center'>
        <img src="<?php echo v_theme_url(); ?>/image/HkReturn/hk_return_title.png" alt="pointer"  />
    </div>
    <div class='turntable-chance  text-center'>
        <span>您还有<font id="chance">0</font>次机会</span>
    </div>
    <div class="turntable-bg" id="cj">
        <div class="turntable-cont">
            <div class='turntable-tit text-center'></div> 
            <div class="pointer"><img src="<?php echo v_theme_url(); ?>/image/lottery/activity-lottery-2.png" alt="pointer" width="80"/></div>
            <div class="rotate" ><img id="rotate" src="<?php echo v_theme_url(); ?>/image/HkReturn/turntable.png" alt="turntable" width="310"/></div>
        </div>
    </div>   
    <div class="text-center turntable-detail">
        <a class="btn btn-default" href="<?php echo U("HkReturn/index/datalist") ?>">中奖详情</a>
    </div>
</div>



<div class="modal fade" id="myModal" style="display:none"  tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="position:relative;height: 100%">
        <div class="modal-content" style=" position: absolute; width: 90%; height: 45px; top: 0; left: 0; bottom: 0; right: 0; margin:auto; "> 
            <div class="modal-body-alert" id="mybody" style="padding: 12px; text-align:center;font-size:12px">

            </div> 
            <div  data-dismiss="modal" class="dismiss">x</div>
        </div>
    </div>
</div>


<script>
    $.get("<?php echo U("HkReturn/index/chance", array('openid' => $user['openid'], 'subscribe' => $user['subscribe'] ? true : false)) ?>", function (result) {
        $("#chance").html(result);
    });
    subscribe = true;
    if (<?php echo $user['subscribe'] ? "false" : "true"; ?>) {
        $('#myModal').modal('show');
        $(".modal-body-alert").html("请您先关注<span style='color:#e38d13'>酒庄公众号</span>后进行抽奖！");
        setTimeout('jumpurl()', 5000);
    }
    function ajax_save(lottery) {
        $.ajax({
            //提交数据的类型 POST GET
            type: "POST",
            //提交的网址
            url: '<?php echo U("HkReturn/index/savelottery") ?>',
            //提交的数据
            data: {openid: "<?php echo $user['openid'] ?>", subscribe: "<?php echo $user['subscribe'] ? true : false; ?>", nickname: "<?php echo $user['nickname'] ?>", lottery: lottery.id}, //{Name: "sanmao", Password: "sanmaoword"},

            //返回数据的格式
            datatype: "json", //"xml", "html", "script", "json", "jsonp", "text".
            //在请求之前调用的函数
            beforeSend: function () {
            },
            //成功返回之后调用的函数             
            success: function (data) {
                var obj = eval('(' + data + ')');
                console.log(obj);
                if (obj.code == "200") {
                    $('#chance').html(obj.chance);
                    if (lottery.id == "7") {
                        $('#myModal').modal('show');
                        $(".modal-body-alert").html("谢谢参与");
                    } else {
                        $('#myModal').modal('show');
                        $(".modal-body-alert").html("恭喜您中了<span style='color:#e38d13'>" + lottery.prize + "</span>，请联系客服！");
                        $("#form-wrap").slideToggle();
                    }

                } else if (obj.code == "202") {
                    $('#myModal').modal('show');
                    $(".modal-body-alert").html("数据处理异常，请重新参与。");
                } else if (obj.code == "203") {
                    $('#myModal').modal('show');
                    $(".modal-body-alert").html("数据处理异常，请重新参与。");
                } else if (obj.code == "303") {
                    $('#myModal').modal('show');
                    $(".modal-body-alert").html("请您先关注<span style='color:#e38d13'>酒庄公众号</span>后进行抽奖！");
                    setTimeout('jumpurl()', 2000);
                } else if (obj.code == "500") {
                    $('#myModal').modal('show');
                    $(".modal-body-alert").html("用户数据错误，重新打开页面。");
                } else if (obj.code == "205") {
                    $('#myModal').modal('show');
                    $(".modal-body-alert").html("您今天的<span style='color:#e38d13'>3</span>次机会已抽完！");
                } else if (obj.code == "206") {
                    $('#myModal').modal('show');
                    $(".modal-body-alert").html("本次活动已结束,谢谢您的参与!");
                }

            },
            //调用执行后调用的函数
            complete: function (XMLHttpRequest, textStatus) {

            },
            //调用出错执行的函数
            error: function () {
            }
        });
    }
    $("#formBtn").click(function () {
        $("#form-wrap").slideToggle();
    });

    function jumpurl() {
        location = 'http://mp.weixin.qq.com/s?__biz=MzA3MDAyMzA5OQ==&mid=203156234&idx=1&sn=0e564ec19e82cebd4b50873883fcd07d#rd';
    }
</script>  

<script>
    wx.ready(function () {
        /**
         * user share 
         */
        wx.onMenuShareTimeline({
            title: '维菲迎端午庆香港回归，幸运大抽奖！',
//            link: '<?php echo v_site_url() . "/?s=/Home/Oauth2/index/type/lottery" ?>',
            link: 'http://mp.weixin.qq.com/s?__biz=MzA3MDAyMzA5OQ==&mid=456294243&idx=1&sn=faf51100240618ada9114ec4de184e8e#rd',
            imgUrl: '<?php echo v_theme_url() ?>image/HkReturn/turntable.png',
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
            title: '维菲迎端午庆香港回归，幸运大抽奖！',
            desc: '', // 分享描述
            link: 'http://mp.weixin.qq.com/s?__biz=MzA3MDAyMzA5OQ==&mid=456294243&idx=1&sn=faf51100240618ada9114ec4de184e8e#rd',
            imgUrl: '<?php echo v_theme_url() ?>image/HkReturn/turntable.png',
            type: 'link', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                // 用户确认分享后执行的回调函数
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
        wx.showAllNonBaseMenuItem();
    });
</script>


<?php v_template_part(array("name" => "footer", "path" => "Public")); ?>
