<?php v_template_part(array("name" => "header", "path" => "Public")); ?> 


<!--<link rel="stylesheet" href="http://demo.jq22.com/jquery-dzp-150204232413/css/demo.css"/>-->

<script src="<?php echo v_theme_url(); ?>/js/awardRotate.js"></script>
<style>
    body{
        background:#A77051;
    }
    .turntable-bg {
        width: 310px;
        max-width: 310px;
        height: 500px;
        margin: 0 auto ;
        position: relative; 
        background: url("<?php echo v_theme_url(); ?>/image/lottery/turntable-bg.jpg"); 
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
    .turntable-bg .rotate {
        width: 310px;
        max-width: 310px;
        height: 310px;  
        position:absolute;
        top:130px; 
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
    .turntable-bg .turntable-cont .turntable-login{
        margin-left:10px;
    }

    .turntable-number em{
        color: red
    }
    .turntable-hd{
        text-align: center;
        margin-top: 20px;
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


            var ang = angles + 1800;

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
                url: '<?php echo U("Lottery/Lottery/getLottery") ?>',
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

        $("#submitform").click(function () {
            $.ajax({
                type: "POST",
                url: '<?php echo U("Lottery/Lottery/saveAddress") ?>',
                data: $("#saveaddress").serialize(),
                datatype: "json", //"xml", "html", "script", "json", "jsonp", "text". 
                beforeSend: function () {

                },
                success: function (data) {
                    console.log(data);
                    if (data == "200") {
                        alert("保存成功");
                    } else {
                        alert("收获地址保存失败，请重新打开此页面重新操作");
                    }
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


<div class="turntable-bg">
    <div class="turntable-cont">
        <div class='turntable-login  text-center'><img src="<?php echo v_theme_url(); ?>/image/lottery/logo-1.png" alt="pointer" width='200'/></div>
        <div class='turntable-tit text-center'></div> 
        <div class="pointer"><img src="<?php echo v_theme_url(); ?>/image/lottery/activity-lottery-2.png" alt="pointer" width="80"/></div>
        <div class="rotate" ><img id="rotate" src="<?php echo v_theme_url(); ?>/image/lottery/turntable.png" alt="turntable" width="310"/></div>
    </div>
</div> 
您的中奖信息为：
<?php
if ($lottery['id'] != "") {
    echo "中了：" . $lottery['lottery']['prize'];
    echo "<br />收获地址：";
    ?>
    <form id="saveaddress" action="<?php echo U("Home/Lottery/saveAddress"); ?>">
        <input type="hidden" name="id" value="<?php echo $lottery['id'] ?>" />
        <input type="hidden" name="openid" value="<?php echo $lottery['openid'] ?>" /><br />
        真实姓名<input type="text" name="realname" value="<?php echo $lottery['realname'] ?>" /><br />
        手机号  <input type="text" name="mobile" value="<?php echo $lottery['mobile'] ?>" /><br />
        地址   <input type="text" name="address" value="<?php echo $lottery['address'] ?>" /><br />
        <input type="button" id="submitform" value="提交" />
    </form>
    <?php
} else {
    echo "您当前未中奖";
}
?>

<div class="turntable-hd" id="t-hd"  data-toggle="modal" data-target="#myModal"><img src="<?php echo v_theme_url(); ?>/image/lottery/hd.png" alt="pointer" /></div>

<!-- Modal -->
<div class="modal fade" id="myModal" style="top:5%" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width:80%; margin: 0px auto;">
            <div class="modal-header text-center" style="background-color: rgb(175,115,75); "> 
                <h4 class="modal-title" id="myModalLabel" style="line-height: 1; color:#fff">温馨提示</h4>
            </div>
            <div class="modal-body" id="mybody">

            </div>
            <div class="modal-footer" style="text-align: center; border-top: 0px;">
                <button type="button" class="btn btn-default  text-center" style="border: 1px rgb(205,145,105) solid" data-dismiss="modal">关闭</button> 
            </div>
        </div>
    </div>
</div>




<script>
    $("#t-hd").click(function () {

        $(".modal-body").html("<div style='font-size:16px;'><p>代金券抽奖活动规则</P><p>1. 活动时间：2015年05月09日 16:00pm - 2015年05月12日 17:00pm</p><p>2. 活动方式：通过转盘的方式得VYNFIELDS代金券，先到先得，抢完即止。</p><p>3. 每位用户仅有一次抽奖机会。</p><p>4. 请在有效期内使用Vynfields微商城代金券。</p><p>5. 代金券使用方法请查看图文消息，有问题找客服。</p><p>6. 本次活动最终解释权归本公司所有。</p></div>");

        $('#mybody').modal(options);
    });
//    if (<?php echo $userinfo->subscribe ? "false" : "true"; ?>) {
//        $('#myModal').modal('show');
//       
//        $(".modal-body").html("需要关注才能参与哦。<br/>微信号:vynfields");
//    }

    function ajax_save(lottery) {
        $.ajax({
            //提交数据的类型 POST GET
            type: "POST",
            //提交的网址
            url: '<?php echo U("Lottery/Lottery/savelottery") ?>',
            //提交的数据
            data: {openid: "<?php echo $userinfo->openid ?>", subscribe: "<?php echo $userinfo->subscribe ? true : false; ?>", nickname: "<?php echo $userinfo->nickname ?>", lottery: lottery.id}, //{Name: "sanmao", Password: "sanmaoword"},

            //返回数据的格式
            datatype: "json", //"xml", "html", "script", "json", "jsonp", "text".
            //在请求之前调用的函数
            beforeSend: function () {
            },
            //成功返回之后调用的函数             
            success: function (data) { 
                if (data == "200") {
                    if (lottery.id == "7") {
                        $('#myModal').modal('show');
                        $(".modal-body").html("谢谢参与");
                    } else {
                        $('#myModal').modal('show');
                        $(".modal-body").html("恭喜您中了“" + lottery.prize + "”，请查看您的中奖信息。填写您的收获或地址");
                    }

                } else if (data == "201") {
                    $('#myModal').modal('show');
                    $(".modal-body").html("您已抽奖，不能在抽奖了");
                } else if (data == "202") {
                    $('#myModal').modal('show');
                    $(".modal-body").html("感谢您的参加，活动已结束了哦！");
                } else if (data == "203") {
                    $('#myModal').modal('show');
                    $(".modal-body").html("数据处理异常，请重新参与");
                } else if (data == "303") {
                    $('#myModal').modal('show');
                    $(".modal-body").html("需要关注才能参与哦");
                } else if (data == "500") {
                    $('#myModal').modal('show');
                    $(".modal-body").html("数据异常:获取用户数据失败，重新打开此页面试试？");
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

</script>  
<?php v_template_part(array("name" => "footer", "path" => "Public")); ?>
