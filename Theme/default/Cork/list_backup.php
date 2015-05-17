<?php v_template_part(array("name" => "header", "path" => "Public")); ?> 
<?php
$oauth2 = new Home\Controller\Oauth2Controller();
$data = $oauth2->getOpenId($_GET['code']);
$openid = json_decode($data);
$userinfo = json_decode($oauth2->getUserInfo($openid->openid));

//print_r("<pre>");
//print_r($corklist);
//print_r("</pre>");
?> 
<link rel="stylesheet" type="text/css" href="<?php echo v_theme_url(); ?>/Cork/css/webuploader.css" />
<link rel="stylesheet" type="text/css" href="<?php echo v_theme_url(); ?>/Cork/css/style.css" />
<script type="text/javascript" src="<?php echo v_theme_url(); ?>/Cork/jquery.js"></script>
<script type="text/javascript" src="<?php echo v_theme_url(); ?>/Cork/dist/webuploader.js"></script>  

<link rel="stylesheet" type="text/css" href="<?php echo v_site_url() ?>/Public/css/wx.css"  >
<style>

    .skillbar {
        position:relative;
        display:block;
        margin-bottom:15px;
        background:#eee;
        height:35px;
        border-radius:3px;
        box-shadow:1px 1px 3px #000;
        -moz-border-radius:3px;
        -webkit-border-radius:3px;
        -webkit-transition:0.4s linear;
        -moz-transition:0.4s linear;
        -ms-transition:0.4s linear;
        -o-transition:0.4s linear;
        transition:0.4s linear;
        -webkit-transition-property:width, background-color;
        -moz-transition-property:width, background-color;
        -ms-transition-property:width, background-color;
        -o-transition-property:width, background-color;
        transition-property:width, background-color;
        /*margin-left:50px;*/
    }

    .skillbar-title {
        position:absolute;
        top:0;
        left:0;
        width:110px;
        font-weight:bold;
        font-size:13px;
        color:#ffffff;
        background:#6adcfa;
        -webkit-border-top-left-radius:3px;
        -webkit-border-bottom-left-radius:4px;
        -moz-border-radius-topleft:3px;
        -moz-border-radius-bottomleft:3px;
        border-top-left-radius:3px;
        border-bottom-left-radius:3px;
    }

    .skillbar-title span {
        display:block;
        background:rgba(0, 0, 0, 0.1);
        padding:0 20px;
        height:35px;
        line-height:35px;
        -webkit-border-top-left-radius:3px;
        -webkit-border-bottom-left-radius:3px;
        -moz-border-radius-topleft:3px;
        -moz-border-radius-bottomleft:3px;
        border-top-left-radius:3px;
        border-bottom-left-radius:3px;
    }

    .skillbar-bar {
        height:35px;
        width:0px;
        background:#6adcfa;
        border-radius:3px;
        -moz-border-radius:3px;
        -webkit-border-radius:3px;
    }

    .skill-bar-percent {
        position:absolute;
        right:10px;
        top:0;
        font-size:11px;
        height:35px;
        line-height:35px;
        color:#ffffff;
        color:rgba(0, 0, 0, 0.4);
    } 
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">

            <div class="col-md-12">
                <div class="alert alert-success text-center" style="background-color:rgb(175,115,75); margin-top:20px; color: #fff;" role="alert">点击图片查看作品详情</div>
            </div>
            <?php
            $isnull = true;
            foreach ($corklist['corklist'] as $v) {
                $isnull = false;
                ?>
                <div class="col-md-6" >
                    <div class="thumbnail">
                        <div  style="padding:5px; -moz-border-radius: 80px;-webkit-border-radius: 80px;border-radius:80px; position: absolute; z-index: 1049; background-color: rgb(175,115,75)">
                            <?php echo $v['canid'] ?>
                        </div>
                        <img src="<?php echo $v['imgpath'] ?>" onclick="details(<?php echo $v['id'] ?>)"  alt="<?php echo $v['title'] ?>">
                        <div class="caption">
                            <a class="btn btn-success btn-block" data-toggle="modal"   onclick="vote(<?php echo $v['id'] ?>)"><small>VOTE</small> <span class="badge "><i id="v<?php echo $v['id'] ?>"><?php echo $v['votecount']; ?></i>票</span></a>

                        </div>
                    </div>
                </div>






                <!--</div>-->

                                                        <!--<button class="btn btn-success" data-toggle="modal"   onclick="vote(<?php echo $v['id'] ?>)">VOTE HE</button>-->


                <?php
            }
            if ($isnull) {
                ?>
                <div class="alert alert-success" role="alert">还没有人参与哦，赶紧参加把!关注公众号，获取链接</div>
                <?php
            }
            ?>


            <div id="loading" class="text-center col-xs-12">

            </div>
            <div class="col-xs-12 ">

                <a id="btn_ajx_page" data-islastpage ="<?php echo $islastpage ?>" data-url="<?php echo $next_page_url ?>" class="btn btn-success btn-lg btn-block">加载更多</a>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="myModal" style="top:25%"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center" style="background-color: rgb(175,115,75); ">
                 <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
                        <h4 class="modal-title" id="myModalLabel" style="line-height: 1; color:#fff">温馨提示</h4>
                    </div>
                    <div class="modal-body modal-alert">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button> 
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade  bs-example-modal-lg" id="myModal-details" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-center" style="background-color: rgb(175,115,75); ">
                       <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
                        <h4 class="modal-title" id="myModalLabel" style="line-height: 1; color:#fff">详情</h4>
                    </div>
                    <div class="modal-body myModal-details">
                        <div class="thumbnail">
                            <img id="myModal-details-img">
                            <div class="caption">
                                <h3 id="myModal-details-title"></h3>
                                <p><div style="overflow:auto;word-wrap:break-word; word-break:break-all;OVERFLOW-Y:auto; OVERFLOW-X:hidden; max-height: 150px;" id="myModal-details-summary" ></div></p>
                                <p>


                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="text-align: center; border-top: 0px;">
                        <button type="button" class="btn btn-default  text-center" style="border: 1px rgb(205,145,105) solid" data-dismiss="modal">关闭</button> 
                    </div>
                </div>
            </div>
        </div>





    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.skillbar').each(function () {
            $(this).find('.skillbar-bar').animate({
                width: $(this).attr('data-percent')
            }, 6000);
        });
    });
</script>

<script src="<?php echo v_theme_url(); ?>/css/bootstrap/js/modal.js"></script>
<script>
    function vote(corkid) {

        if (!<?php echo $userinfo->subscribe ? "true" : "false"; ?>) {
            $('#myModal').modal('show');
            $(".modal-alert").html("需要关注后才能投票哦！");

        } else {
            $.ajax({
                //提交数据的类型 POST GET
                type: "POST",
                //提交的网址
                url: '<?php echo U("Cork/Index/vote")?>',//<?php echo v_site_url() ?>?m=Cork&a=vote&corkid=' + corkid + '&voteopenid=<?php echo $userinfo->openid ?>',
                //提交的数据
                 data: {corkid: corkid, voteopenid: "<?php echo $userinfo->openid ?>"}, //{Name: "sanmao", Password: "sanmaoword"},
                //返回数据的格式
                datatype: "json", //"xml", "html", "script", "json", "jsonp", "text".
                //在请求之前调用的函数
                beforeSend: function () {
                    $('#myModal').modal('show');
                    $(".modal-alert").html("<div class='text-center'><img src='<?php echo v_theme_url(); ?>/image/loading.gif'><br/>正在投票</div>");
                },
                //成功返回之后调用的函数             
                success: function (data) {
//                $("#msg").html(decodeURI(data));
//                    alert(data);
                    if (data === "309") {

                        $(".modal-alert").html("您已投票，每个微信号仅能投一票哦！");
                    } else if (data === "200") {

                        $("#v" + corkid).html(parseInt($("#v" + corkid).html()) + 1);
                        $(".modal-alert").html("投票成功！收红包啦！");
                    } else if (data === "300") {
                        $("#v" + corkid).html(parseInt($("#v" + corkid).html()) + 1);
                        $(".modal-alert").html("Oops,亲，您下手过慢，今天的红包已被抢光啦！谢谢参与");
                    } else {

                        $("#v" + corkid).html(parseInt($("#v" + corkid).html()) + 1);
                        $(".modal-alert").html("投票成功！");
                    }

//                location.href = "<?php echo U("Cork/index/Success"); ?>";
                },
                //调用执行后调用的函数
                complete: function (XMLHttpRequest, textStatus) {

                },
                error: function () {
                    //请求出错处理
                    $(".modal-alert").html("出现异常，请重试");
                }
            });
        }

    }


    function details(corkid) {
        //请求出错处理
        $('#myModal-details').modal('show');
        $("#myModal-details-img").attr("src", "<?php echo v_theme_url(); ?>/image/loading.gif");
        $("#myModal-details-title").html("");
        $("#myModal-details-summary").html("");
        $.ajax({
            //提交数据的类型 POST GET
            type: "GET",
            //提交的网址
            url: '<?php echo v_site_url() ?>?m=Cork&a=cork&corkid=' + corkid,
            //提交的数据

            //返回数据的格式
            datatype: "json", //"xml", "html", "script", "json", "jsonp", "text".
            //在请求之前调用的函数
            beforeSend: function () {
                $("#msg").html("logining");
            },
            //成功返回之后调用的函数             
            success: function (data) {

//                $('#myModal-details').modal('show');

                var obj = $.parseJSON(data);

                $.each(obj, function (id, item) {

                    $("#myModal-details-img").attr("src", item.imgpath);
                    $("#myModal-details-title").html(item.title);
                    $("#myModal-details-summary").html(item.summary);

                });
//

                //$(".myModal-details").html(data);


            },
            //调用执行后调用的函数
            complete: function (XMLHttpRequest, textStatus) {

            },
            //调用出错执行的函数
            error: function () {
                //请求出错处理
                $('#myModal-details').modal('show');
                $(".myModal-details").html("出现异常，请重试");
            }
        });


    }
    $(function () {
        $(window).scroll(function () {


            if (($(window).scrollTop()) >= ($(document).height() - $(window).height())) {
                ajax_load();

            }


        });
        $("#btn_ajx_page").click(function () {
            ajax_load();

        });

        function ajax_load() {
            var islastpage = $("#btn_ajx_page").data("islastpage");
            var url = $("#btn_ajx_page").data("url");
            if (islastpage == 1) {  //如果没有输据了
                $("#btn_ajx_page").attr('disabled', "true");
                $("#btn_ajx_page").html("没有更多了");
                return false;
            } else {

                $("#loading").html('<img src="<?php echo v_theme_url(); ?>/image/loading.gif" />');

                $.ajax({
                    url: url,
                    type: "GET",
                    datatype: "html", //"xml", "html", "script", "json", "jsonp", "text".
                    beforeSend: function (XMLHttpRequest) {
                        //ShowLoading(); 
                        $("#loading").html('<img src="<?php echo v_theme_url(); ?>/image/loading.gif" />');

                    },
                    error: function () {
//                        $("#loading").html('error'); 
                        //请求出错处理
                        $('#myModal-details').modal('show');
                        $(".myModal-details").html("出现异常，请重试");

                    },
                    success: function (data) {
                        $("#btn_ajx_page").data("url", $($.parseHTML(data)).find('#btn_ajx_page').data('url'));
                        $("#btn_ajx_page").data("islastpage", $($.parseHTML(data)).find('#btn_ajx_page').data('islastpage'))
                        $(".curr_page:last").append($($.parseHTML(data)).find('.curr_page'));

                        $(".curr_page:last").fadeOut(0, function () {
                            $("#loading").html('');
                        }).fadeIn(500);


                    },
                    complete: function (XMLHttpRequest, textStatus) {
                        //HideLoading();
                    }
                });
            }
        }
    });

</script>


<script>


    $("#share").click(function () {
        $('#myModal').modal('show');
        $(".modal-body").html("请点击右上角按钮，选择分享到朋友圈");
    });
    wx.ready(function () {
        // 在这里调用 API

        /**
         * user share 
         */
        wx.onMenuShareTimeline({
            title: '【福利】参与投票，得维尼菲尔德红包！',
            link: 'http://mp.weixin.qq.com/s?__biz=MzA3MDAyMzA5OQ==&mid=215797800&idx=1&sn=71c872230f638da21e65a1e421c7cb05#rd',
            imgUrl: '<?php echo v_theme_url()?>/image/01.jpg',
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
            title: '【福利】参与投票，得维尼菲尔德红包！',
            desc: '', // 分享描述
            link: 'http://mp.weixin.qq.com/s?__biz=MzA3MDAyMzA5OQ==&mid=215797800&idx=1&sn=71c872230f638da21e65a1e421c7cb05#rd',
            imgUrl: '<?php echo v_theme_url()?>/image/01.jpg',
            type: 'link', // 分享类型,music、video或link，不填默认为link
            dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
            success: function () {
                // 用户确认分享后执行的回调函数
            },
            cancel: function () {
                // 用户取消分享后执行的回调函数
            }
        });
        wx.hideAllNonBaseMenuItem();
//        wx.showMenuItems({
//            menuList: [
//                'menuItem:profile',
//                'menuItem:exposeArticle'
//            ],
//            success: function (res) {
//                alert('已显示');
//            },
//            fail: function (res) {
//                alert(JSON.stringify(res));
//            }
//        });
        wx.showAllNonBaseMenuItem();
    });


</script>

<?php v_template_part(array("name" => "footer", "path" => "Public")); ?>