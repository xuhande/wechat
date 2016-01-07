<?php v_template_part(array("name" => "header", "path" => "Public")); ?> 
 
<link rel="stylesheet" type="text/css" href="<?php echo v_site_url() ?>/Public/css/wx.css"  >

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

    .turntable-bg .pointer:hover{ 
        cursor: pointer;
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
        $("#submitformsaveaddress").click(function () {
            if ($("#realname").val() == "" || $("#mobile").val() == "" || $("#address").val() == "") {
                alert("请填写完整收货信息！");
                return false;
            } else {
                $.ajax({
                    type: "POST",
                    url: '<?php echo U("Lottery/Lottery/saveAddress") ?>',
                    data: $("#saveaddress").serialize(),
                    datatype: "json", //"xml", "html", "script", "json", "jsonp", "text". 
                    beforeSend: function () {

                    },
                    success: function (data) {
                        if (data == "200") {
                            alert("保存成功");
                            var realname = $("#realname").val();
                            var mobile = $("#mobile").val();
                            var address = $("#address").val();
                            $("#address_message").html("收货信息:" + realname + " - " + mobile + " - " + address);
                        } else { 
                            alert("保存失败，请刷新重试。");
                            return false;
                        }
                    },
                    complete: function (XMLHttpRequest, textStatus) {

                    },
                    error: function () {
                    }
                });
            }
        });
        $("#submitformcheckQustion").click(function () {

            if ($("#qustion1").val() == "" || $("#qustion2").val() == "") {
                alert("请正确回答问题。");
                return false;
            } else {
                $.ajax({
                    type: "POST",
                    url: '<?php echo U("Lottery/Lottery/checkQustion") ?>',
                    data: $("#checkQustion").serialize(),
                    datatype: "json", //"xml", "html", "script", "json", "jsonp", "text". 
                    beforeSend: function () {

                    },
                    success: function (data) { 
                        $("#errormsg").html("");
                        if (data == "200") {
                            alert("回答正确，点击关闭进行抽奖。");
                            $("#one").show("slow");
                            $("#two").hide();
                        } else if (data == "202") {
                            $("#errormsg").html("错了哦~答案都在原文中，祝你好运。");
                        } else if (data == "403") {
                            $("#errormsg").html("需要关注后才能参与活动哦。");
                        } else if (data == "404") {
                            $("#errormsg").html("用户信息未获取到。");
                        }
                    },
                    complete: function (XMLHttpRequest, textStatus) {
                    },
                    error: function () { 
                    }
                });
            }
        });




    });
    function rnd(n, m) {
        return Math.floor(Math.random() * (m - n + 1) + n)
    }
</script>

<div id="one" style="display:none">
    <div class="turntable-bg" id="cj">
        <div class="turntable-cont">
            <div class='turntable-login  text-center'><img src="<?php echo v_theme_url(); ?>/image/lottery/logo-1.png" alt="pointer" width='200'/></div>
            <div class='turntable-tit text-center'></div> 
            <div class="pointer"><img src="<?php echo v_theme_url(); ?>/image/lottery/activity-lottery-2.png" alt="pointer" width="80"/></div>
            <div class="rotate" ><img id="rotate" src="<?php echo v_theme_url(); ?>/image/lottery/turntable.png" alt="turntable" width="310"/></div>
        </div>
    </div>  
        <div class="" id="lottery_message" style="color: #fff;text-align: center; line-height: 25px;margin-bottom: 10px;
  height: 100%;
  position: relative;"> 
            <?php
            if ($lottery['id'] != "") {
                echo "恭喜你获奖" . $lottery['lottery']['prize']."<br />";
                echo "<span id='address_message'>收货信息：" . $lottery['realname'] . " - " . $lottery['mobile'] . " - " . $lottery['address'] . "</span>";
                echo '<script>   $(function () {$("#form-wrap").slideToggle();});</script>';
            } else {
                echo "您当前未中奖";
            }
            ?> 

        </div>
    <div class="turntable-bg" id="form-wrap"  style="display:none;background: none;height:100%; ">
        <div class="turntable-cont"> 
            <form id="saveaddress" action="<?php echo U("Home/Lottery/saveAddress"); ?>">
<!--                <input type="hidden" name="id" value="<?php echo $lottery['id'] ?>" />
                <input type="hidden" name="openid" value="<?php echo $lottery['openid'] ?>" /><br />
                真实姓名<input type="text" name="realname" value="<?php echo $lottery['realname'] ?>" /><br />
                手机号  <input type="text" name="mobile" value="<?php echo $lottery['mobile'] ?>" /><br />
                地址   <input type="text" name="address" value="<?php echo $lottery['address'] ?>" /><br />
                <input type="button" id="submitformsaveaddress" value="提交" />--> 
                <input type="hidden" name="openid" value="<?php echo $user['openid'] ?>" />
                <p class="prompt" style="font-size:14px;color: #fff;margin: 0">请填入您的收货地址，我们将尽快发货给您!</p>
                <div class="form-group" style="margin-bottom: 5px;"> 
                    <p style="font-size:14px;color: #fff;">联系人：</p> 
                    <input type="text" class="form-control" id="realname" name="realname" value="<?php echo $lottery['realname'] ?>" placeholder="请输入收货联系人">
                </div>
                <div class="form-group" style="margin-bottom: 5px;"> 
                    <p style="font-size:14px;color: #fff;">联系号码：</p>
                    <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $lottery['mobile'] ?>"  placeholder="请输入收货联系手机号码">
                </div>    
                <div class="form-group" style="margin-bottom: 5px;"> 
                    <p style="font-size:14px;color: #fff;">收货地址：</p>
                    <textarea class="form-control" id="address"  name="address" value="" rows="6" style="height: 10em;" placeholder="请输入您收货地址！"><?php echo $lottery['address'] ?></textarea>
                </div>    
                <div class="form-group">
                    <button type="button" class="btn btn-success" id="submitformsaveaddress" style="width: 100%;">提交</button>
 
                </div>
            </form> 
        </div>  
    </div>
    <div class="turntable-hd t-hd"  data-toggle="modal" data-target="#myModal"><img src="<?php echo v_theme_url(); ?>/image/lottery/hd.png" alt="pointer" /></div>

</div>


<div id="two" style="display:none;">
    <div class="turntable-bg" id="cj" style="background: none;height:100%">
        <div class='turntable-login  text-center'><img src="<?php echo v_theme_url(); ?>/image/lottery/logo-1.png" alt="pointer" width='200'/></div>
        <form id="checkQustion" action="<?php echo U("Lottery/Lottery/checkQustion"); ?>"  method="post"  > 
        <input type="hidden" name="openid" value="<?php echo $user['openid'] ?>"/>
        <p class="prompt" style="font-size:14px;color: #fff;">请回答以下问题</p>
        <div class="form-group"> 
            <p style="font-size:14px;color: #fff;">维菲酒庄产区：</p>
            <input type="text" class="form-control"  id="qustion1" name="qustion1"placeholder="请回答维菲酒庄属于新西兰哪个产区">
        </div>
        <div class="form-group"> 
            <p style="font-size:14px;color: #fff;">维菲酒庄葡萄品种：</p>
            <input type="text" class="form-control" id="qustion2" name="qustion2" placeholder="请说出维菲的三种主要酒款所用的葡萄品种。如：赤霞珠+美乐">
        </div>                         
        <div class="form-group">
            <!--<button type="button" class="btn btn-success" style="width: 100%;">提交</button>-->
            <button type="button" class="btn btn-success" style="width: 100%;" id="submitformcheckQustion"  >提交</button> 
        </div>
        </form>
    </div>  


    <div class="turntable-hd t-hd"  data-toggle="modal" data-target="#myModal"><img src="<?php echo v_theme_url(); ?>/image/lottery/hd.png" alt="pointer" /></div>

</div>




<!-- Modal -->
<div class="modal fade" id="myModal" style="top:5%" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width:80%; margin: 0px auto;">
            <div class="modal-header text-center" style="background-color: rgb(175,115,75); "> 
                <h4 class="modal-title" id="myModalLabel" style="line-height: 1; color:#fff">温馨提示</h4>
            </div>
            <div class="modal-body-alert" id="mybody" style="padding: 10px; text-align:center">

            </div>
            <div class="modal-footer" style="text-align: center; border-top: 0px;">
                <button type="button" class="btn btn-default  text-center" style="border: 1px rgb(205,145,105) solid" data-dismiss="modal">关闭</button> 
            </div>
        </div>
    </div>
</div>


<script>
    $(".t-hd").click(function () {
        $(".modal-body-alert").html("<div style='font-size:16px;padding: 10px; text-align:left'><p style='text-align:center'>答题抽奖</P><p>1. 活动时间：2016年01月08日 - 2016年01月14日 </p><p>2. 活动方式：关注公众号后回答问题进入抽奖环节。先到先得，抢完即止。</p><p>3. 每位用户仅有一次抽奖机会。</p><p>4. 如已中奖，请正确填写收货地址。</p><p>5. 如有疑问，请咨询客服。</p><p>6. 本次活动最终解释权归本公司所有。</p></div>");
        $('#mybody').modal(options);
    });
    $("#one").show();
    $("#two").hide();
    subscribe = true;
    if (<?php echo $user['subscribe'] ? "false" : "true"; ?>) {
        $('#myModal').modal('show');
        $(".modal-body-alert").html("请关注维菲公众号参与活动。<br/>公众号:vynfields");
        $("#one").hide();
        $("#two").show(); 
    }
    if (<?php echo $user['is_lottery'] ? "false" : "true"; ?> ) {
        $("#one").hide();
        $("#two").show();
    }
    function ajax_save(lottery) {
        $.ajax({
            //提交数据的类型 POST GET
            type: "POST",
            //提交的网址
            url: '<?php echo U("Lottery/Lottery/savelottery") ?>',
            //提交的数据
            data: {openid: "<?php echo $user['openid'] ?>", subscribe: "<?php echo $user['subscribe'] ? true : false; ?>", nickname: "<?php echo $user['nickname'] ?>", lottery: lottery.id}, //{Name: "sanmao", Password: "sanmaoword"},

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
                        $(".modal-body-alert").html("谢谢参与");
                    } else {
                        $('#myModal').modal('show');
                        $(".modal-body-alert").html("恭喜您中奖了。请查看您的中奖信息，填写您的收货地址。");
                        $("#lottery_message").html("恭喜您中了" + lottery.prize);
                        $("#form-wrap").slideToggle();
                    }

                } else if (data == "201") {
                    $('#myModal').modal('show');
                    $(".modal-body-alert").html("您已抽奖，不能再抽奖了。");
                } else if (data == "202") {
                    $('#myModal').modal('show');
                    $(".modal-body-alert").html("感谢您的参加，活动已结束了哦！");
                } else if (data == "203") {
                    $('#myModal').modal('show');
                    $(".modal-body-alert").html("数据处理异常，请重新参与。");
                } else if (data == "303") {
                    $('#myModal').modal('show');
                    $(".modal-body-alert").html("需要关注才能参与哦。");
                } else if (data == "500") {
                    $('#myModal').modal('show');
                    $(".modal-body-alert").html("数据异常:获取用户数据失败，重新打开此页面试试。");
                } else if (data == "503") {
                    $('#myModal').modal('show');
                    $(".modal-body-alert").html("您还没有回答问题呢，需要回答问题才能参与哦。");
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

</script>  
<?php v_template_part(array("name" => "footer", "path" => "Public")); ?>
