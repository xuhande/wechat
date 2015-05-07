<?php v_template_part(array("name" => "header", "path" => "Public")); ?> 

<link rel="stylesheet" type="text/css" href="<?php echo v_theme_url(); ?>/Cork/css/webuploader.css" />
<link rel="stylesheet" type="text/css" href="<?php echo v_theme_url(); ?>/Cork/css/style.css" />
<script type="text/javascript" src="<?php echo v_theme_url(); ?>/Cork/jquery.js"></script>
<script type="text/javascript" src="<?php echo v_theme_url(); ?>/Cork/dist/webuploader.js"></script>  

<?php 
header("location: http://wx.mynow.net/?m=Home&c=Oauth2&a=index&type=corklist");
        exit;


 function msubstr($str, $start, $length = NULL) {
        if (strlen($str) < $length) {
            return $str;
        }
        preg_match_all("/./u", $str, $ar);

        if (func_num_args() >= 3) {
            $end = func_get_arg(2);
            return join("", array_slice($ar[0], $start, $end)) . '***';
        } else {
            return join("", array_slice($ar[0], $start)) . '***';
        }
    }
?>
<div class="container">
    <div class="row">  
        <div class="col-md-12">
            <?php
            if ($cork[0]['check'] == 0) {
                echo '<div class="alert alert-info " role="alert">您的作品已提交，正在审核中，请耐心等候。</div>';
            } else if ($cork[0]['check'] == 1) {
                ?>
                <div class="alert alert-danger" role="alert">您的作品未通过审核，重新上传请联系客服。<br />原因:<?php echo $cork[0]["content"] ?></div>

                <?php
//                echo '<div class="alert alert-danger " role="alert">审核未通过，未通过原因:' . $cork[0]['content'] . ',详情请联系客服。</div>';
                // echo "您的审核已通过。请留意官方微信";
            } else if ($cork[0]['check'] == 2) {
                // echo "审核中审核未通过，详情请联系客服";
                echo '<div class="alert alert-success" role="alert">您的作品已通过审核，投票时间请留意官方微信。</div>';
            } else {
                //print_r($cork[0]['check']);
                echo '<div class="alert alert-danger" role="alert">未知异常。</div>';
            }
            ?>
            <?php
            if ($cork[0]['check'] == 2) {
                ?>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="thumbnail" style="background:url(<?php echo v_theme_url() ?>/image/fuzhu.png);background-size: 100%">
                            <h3 style="color:rgb(150,85,55)"><?php echo $cork[0]['canid'] ?>号</h3>
                            <img src="<?php echo $cork[0]['imgpath'] ?>" width="100%" />
                            <div class="caption">
                                <h3 style="color:rgb(150,85,55)"><?php echo $cork[0]['title'] ?></h3>
                                <p  style="color:rgb(175,115,75)"><?php echo $cork[0]['summary'] ?></p>
                                <p style="color:rgb(150,85,55)">姓名:<span style="color:rgb(175,115,75)"><?php echo msubstr($cork[0]['name'], '0', '1'); ?></span></p>
                                <p style="color:rgb(150,85,55)">手机号:<span style="color:rgb(175,115,75)"><?php echo substr_replace($cork[0]['mobile'], '*******', '0', '7'); ?></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 text-center">
                        <a href="http://mp.weixin.qq.com/s?__biz=MzA3MDAyMzA5OQ==&mid=211569463&idx=1&sn=a5b14cf144aa75756a1b7ecfeb6385ab&key=fbe9f9f4b565962ca850ccd7e7722cd4fa08b41e58c0dca9df28ae7d1a6aaf81a79a9340aed989d68a24068ad21ddbba&ascene=1&uin=MjQ4ODEzMjAw&devicetype=webwx&version=70000001&pass_ticket=4DKHDCVyjNvgYxv%2FdRYDuZVhfQ%2BgIFy2JljQIaW3mr0%3D">点击查看活动详情</a>
                    </div>
                </div>
                
                <!--                
                                <div class="list-group">
                
                                    <a href="#" class="list-group-item text-center">
                                        <h4 class="list-group-item-heading"></h4>
                                        <p class="list-group-item-text"></p>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <h4 class="list-group-item-heading">作品编号</h4>
                                        <p class="list-group-item-text"><?php echo $cork[0]['canid'] ?>号</p>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <h4 class="list-group-item-heading">姓名</h4>
                                        <p class="list-group-item-text"><?php echo $cork[0]['name'] ?></p>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <h4 class="list-group-item-heading">作品名称</h4>
                                        <p class="list-group-item-text"></p>
                                    </a>
                
                                    <a href="#" class="list-group-item">
                                        <h4 class="list-group-item-heading">作品描述</h4>
                                        <p class="list-group-item-text col-md-12" style="WORD-BREAK: break-all; WORD-WRAP: break-word"></p>
                                    </a>
                
                                    <a href="#" class="list-group-item">
                                        <h4 class="list-group-item-heading">身份证号</h4>
                                        <p class="list-group-item-text"><?php echo substr_replace($cork[0]['idno'], '********', '6', '14'); ?></p>
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <h4 class="list-group-item-heading">手机号</h4>
                                        <p class="list-group-item-text"><?php echo substr_replace($cork[0]['mobile'], '*******', '0', '7'); ?></p>
                                    </a>
                                </div>-->
                    <!--                <table>
                                    <tr>
                                        <td style="text-align: right"></td>
                                        <td><img src="<?php echo $cork[0]['imgpath'] ?>" width="200"></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right">姓名:</td>
                                        <td><?php echo $cork[0]['name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right">身份证号:</td>
                                        <td><?php echo $cork[0]['idno'] ?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right">作品名称:</td>
                                        <td><?php echo $cork[0]['title'] ?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right">作品描述:</td>
                                        <td><?php echo $cork[0]['summary'] ?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right">手机号:</td>
                                        <td><?php echo $cork[0]['mobile'] ?></td>
                                    </tr>
                                </table>-->

                <?php
            }
            ?>


        </div>


    </div>
</div>

<script>


    $("#share").click(function () {
        $('#myModal').modal('show');
        $(".modal-body").html("请点击右上角按钮，选择分享到朋友圈");
    });
    wx.ready(function () {
        // 在这里调用 API
<?php
if ($cork[0]['check'] != 2) {
    echo "link = 'http://mp.weixin.qq.com/s?__biz=MzA3MDAyMzA5OQ==&mid=211569463&idx=1&sn=a5b14cf144aa75756a1b7ecfeb6385ab&key=fbe9f9f4b565962ca850ccd7e7722cd4fa08b41e58c0dca9df28ae7d1a6aaf81a79a9340aed989d68a24068ad21ddbba&ascene=1&uin=MjQ4ODEzMjAw&devicetype=webwx&version=70000001&pass_ticket=4DKHDCVyjNvgYxv%2FdRYDuZVhfQ%2BgIFy2JljQIaW3mr0%3D';";
    echo "imgUrl = '" . v_theme_url() . "/image/share.jpg';";
    echo "title = '脑洞有多大，奖品就有多大！';";
    
} else {
    echo "link = '" . v_site_url() . "/?m=Cork&a=success&openid=" . $cork[0]['openid'] . "';";
    echo "imgUrl = '" . $cork[0]['imgpath'] . "';";
    echo "title = '" .  $cork[0]['nickname'] . " 已参加 “脑洞有多大，奖品就有多大！” 活动，你还在等什么？';";
}
?>

        /**
         * user share 
         */
        wx.onMenuShareTimeline({
            title: title,
            link: link,
            imgUrl: imgUrl,
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
            title: title,
            desc: '', // 分享描述
             link: link,
            imgUrl: imgUrl,
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