<?php v_template_part(array("name" => "header", "path" => "Public")); ?> 

<link rel="stylesheet" type="text/css" href="<?php echo v_site_url() ?>/Public/css/wx.css"  >

<script src="<?php echo v_theme_url(); ?>/js/awardRotate.js"></script>
<style>
    html{
        position: relative; 
    }
    body{
        background: #eee; 
        background-size:100% 100%;
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
    small{
        color:#888
    }
    .weui_panel {
        background-color: #FFFFFF;
        position: relative;
        overflow: hidden;
    }
    .weui_panel_hd {
        padding: 14px 15px 10px;
        color: #999999;
        font-size: 13px;
        position: relative;
    }
    .weui_panel_bt {
        padding: 14px 15px 14px;
        color: #999999;
        font-size: 14px;
        text-align: center;
        position: relative;
    }
    .weui_panel_bt:hover,.weui_panel_bt:active{
        cursor: pointer;
    }
    .weui_panel_bt:before {
        content: " ";
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 1px;
        border-top: 1px solid #D9D9D9;
        color: #D9D9D9;
        -webkit-transform-origin: 0 0;
        transform-origin: 0 0;
        -webkit-transform: scaleY(0.5);
        transform: scaleY(0.5);
        left: 15px;
    }
    .weui_panel_hd:after {
        content: " ";
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 1px; 
        color: #E5E5E5;
        -webkit-transform-origin: 0 100%;
        transform-origin: 0 100%;
        -webkit-transform: scaleY(0.5);
        transform: scaleY(0.5);
        left: 15px;
    }
    .weui_media_box.weui_media_small_appmsg {
        padding: 0;
    }
    .weui_media_box {
        padding: 15px;
        position: relative;
    }
    .weui_media_box.weui_media_small_appmsg .weui_cells {
        margin-top: 0;
    }
    .weui_cells {
        margin-top: 1.17647059em;
        background-color: #FFFFFF;
        line-height: 1.41176471;
        font-size: 14px;
        overflow: hidden;
        position: relative;
    }
    .weui_cell {
        padding: 10px 15px;
        position: relative;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
    }
    .weui_cell_primary {
        -webkit-box-flex: 1;
        -webkit-flex: 1;
        -ms-flex: 1;
        flex: 1;
    }
    .weui_cells_access .weui_cell:not(.no_access) {
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    }
    .weui_cell:before {
        content: " ";
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 1px;
        border-top: 1px solid #D9D9D9;
        color: #D9D9D9;
        -webkit-transform-origin: 0 0;
        transform-origin: 0 0;
        -webkit-transform: scaleY(0.5);
        transform: scaleY(0.5);
        left: 15px;
    }
    .weui_cell .weui_cell_bd .weui_cell_bd_tit{
        width:70%;float:left;
    }
    .weui_cell .weui_cell_bd .weui_cell_bd_time{
        width:30%;
        float:left;
        font-size: 12px;
        text-align: right;
        color:#999
    }

    #lodding{
        position:absolute;
        width: 100%;
        height: 100%;
        z-index: 99999;
        top:0;
        bottom: 0;
        left: 0;
        right: 0;
    }
    #lodding .lodding-wrap{
        width:100px;
        height: 50px;
        position: absolute;
        top:45%;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 9999999;
        background-color:rgb(0,0,0);
        opacity:0.7;
        filter:alpha(opacity=70);
        padding:15px 15px;
        margin: 0 auto;
        border-radius:8px;
        font-size: 14px;
        color:#fff;
        background: #000;
    }
</style>   
<div class=''>
    <div style="position: relative;height:40px;line-height: 40px;background:#B32121">
        <div style="float:left;width:18%;text-align: center;color:#fff;font-size:22px;border-right: 1px solid #891B1B;">
            <a href="<?php echo U("Home/Oauth2/index", array("type" => "hkReturn")) ?>" style="display: block;height: 100%;width:100%;color:#fff"><</a>
        </div>
        <div style="float:left;text-align: center;font-size:18px; color:#fff;width: 64%">中奖详情</div>
        <div style="float:left;width:18%;text-align: center;color:#fff;font-size:22px;border-left: 1px solid #891B1B;">
            <a href="<?php echo U("Home/Oauth2/index", array("type" => "hkReturn")) ?>" style="display: block;height: 100%;font-size: 14px;width:100%;color:#fff">活动规则</a>
        </div>
    </div>
    <div class="weui_panel">
        <div class="weui_panel_hd">下述您中奖的列表：</div>
        <div class="weui_panel_bd">
            <div class="weui_media_box weui_media_small_appmsg">
                <div class="weui_cells weui_cells_access" id="weui_cell_data"> 
                </div>
            </div>
        </div>
        <div class='weui_panel_bt' id="weui_cell_more">加载更多数据 <span style='font-size:18px;'> &#8595;</span></div>
    </div>
</div>  
<script>
    function getData(id, pages, more) { //获取当前页数据 
        var length = $(id + " .weui_cell").length;
        var page = pages ? pages + length : 10;
        $.ajax({
            type: "GET",
            url: '<?php echo U("HkReturn/index/datalist") ?>',
            data: {openid: "<?php echo $user['openid'] ?>",dataType: "dataJson", total: page},
            datatype: "json", //"xml", "html", "script", "json", "jsonp", "text". 
            beforeSend: function () {
                $("#weui_cell_more").text("正在加载数据中...");
                $("body").append("<div id='lodding'><div class='lodding-wrap' style='width:145px'>正在加载数据中...</div></div>");
            },
            success: function (data) {
                var obj = $.parseJSON(data);
                var html = '';
                if (obj == null) {
                    html += '<div class="weui_cell"><div class="weui_cell_bd weui_cell_primary" ><div style="line-height:50px;text-align:center;">您暂时还没有抽奖！</div></div></div>';
                } else {

                    $.each(obj, function (k, v) {
                        html += "<div class='weui_cell'><div class='weui_cell_bd weui_cell_primary'>" +
                                "<div class='weui_cell_bd_tit' >恭喜您中了" + obj[k].prize + "</div>" +
                                "<div class='weui_cell_bd_time'>" + obj[k].created + "</div>" +
                                "<span class='weui_cell_ft'></span></div></div>";
                    });
                }
                $(id).html(html);
            },
            complete: function () {
                $("#weui_cell_more").html("加载更多数据 <span style='font-size:18px;'> &#8595;</span>");
                $("#lodding").remove();
            },
            error: function () {
                alert("数据异常,请检查是否json格式");
            }
        });
    }
    getData("#weui_cell_data");
    $(function () {
        $("#weui_cell_more").click(function () {
            getData("#weui_cell_data", 5, this);
        });

    });

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
