<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=no" /> 
        <title>Vynfields商城订单查询</title>
        <link rel="stylesheet" type="text/css" href="<?php echo v_site_url() ?>/Public/css/wx.css"  >
        <script type="text/javascript" src="<?php echo v_site_url() ?>/Public/js/jquery-1.8.2.min.js"></script>
        <script>
            $(document).ready(function () {

                /* 滑动/展开 */
                $("ul.expmenu li > div.header").click(function () {

                    var arrow = $(this).find("span.arrow");

                    if (arrow.hasClass("up")) {
                        arrow.removeClass("up");
                        arrow.addClass("down");
                    } else if (arrow.hasClass("down")) {
                        arrow.removeClass("down");
                        arrow.addClass("up");
                    }

                    $(this).parent().find("ul.detail").slideToggle();

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

        <ul id="accordion" class="accordion">
            <?php
            $datas = json_decode($list, ture);
            $isnull = true;
            foreach ($datas as $tableName => $table) {
                $isnull = false;
                ?>
                <li>
                    <div class="link sub_msg_list sub_msg_ite">
                        <span class="thumb">
                            <img style="width: 70px; height: 70px; visibility: visible !important;" src="<?php echo $table['product_img'] ?>">
                        </span>
                        <p style="font-size: 16px;font-weight: bold;"><?php echo $table['product_name'] ?></p>                        
                        <p style="font-size: 12px;color: #999;padding-top: 10px;"><?php echo "时间：" . date('Y-m-d H:i:s', $table['order_create_time']); ?></p>
                        <p style="font-size: 12px;color: #999;padding-top: 2px;font-weight: bold;">    <?php
                            echo ' 总额：' . number_format($table['order_total_price'] * 0.01, 2, '.', ',') . '元 ';
                            switch ($table['order_status']) {
                                case 2:
                                    echo '状态：<span style="color:red">待发货</span>';
                                    break;
                                case 3:
                                    echo '状态：<span style="color:green">已发货</span>';
                                    break;
                                case 5:
                                    echo '状态：<span style="color:green">已完成</span>';
                                    break;
                                case 6:
                                    echo '状态：<span style="color:green">已退款</span>';
                                    break;
                                case 8:
                                    echo '状态：<span style="color:Yellow">维权中</span>';
                                    break;
                            };
                            ?></p></div>
                    <ul class="submenu">
                        <li>
                            <div class="sub_msg_detail"> 
                                <p>订单编号： <?php echo $table['order_id'] ?></p>
                                <p>产品价格： ￥<?php echo number_format($table['product_price'] * 0.01, 2, '.', ',') . '元' ?></p>
                                <p>产品数量： <?php echo $table['product_count'] . '支' ?></p>
                                <?php
                                if ($table['delivery_id']) {
                                    echo " <p>物流单号： " . $table['delivery_id'] . "</p>";
                                }
                                ?>
                                <?php
                                //if($table['delivery_company']){ echo " <p>物流单号： ".$table['delivery_company']."</p>";}
                                switch ($table['delivery_company']) {
                                    case 'Fsearch_code':
                                        echo " <p>物流公司： 邮政EMS</p>";
                                        break;
                                    case '002shentong':
                                        echo " <p>物流公司： 申通快递</p>";
                                        break;
                                    case '066zhongtong':
                                        echo " <p>物流公司： 中通速递</p>";
                                        break;
                                    case '056yuantong':
                                        echo " <p>物流公司： 圆通速递</p>";
                                        break;
                                    case '042tiantian':
                                        echo " <p>物流公司： 天天快递</p>";
                                        break;
                                    case '003shunfeng':
                                        echo " <p>物流公司： 顺丰速运</p>";
                                        break;
                                    case '059Yunda':
                                        echo " <p>物流公司： 韵达快运</p>";
                                        break;
                                    case '064zhaijisong':
                                        echo " <p>物流公司： 宅急送</p>";
                                        break;
                                    case '020huitong':
                                        echo " <p>物流公司： 汇通快运</p>";
                                        break;
                                    case 'zj001yixun':
                                        echo " <p>物流公司： 易迅快递</p>";
                                        break;
                                    default:
                                }
                                ?>
                                <p>运费： <?php
                                    if ($table['order_express_price'] == 0) {
                                        echo "免邮费";
                                    } else {
                                        echo '￥' . number_format($table['order_express_price'] * 0.01, 2, '.', ',') . '元';
                                    }
                                    ?></p>
                                <p>地址：<?php echo $table['receiver_province'] . $table['receiver_city'] . $table['receiver_address'] ?></p>
                                <p>接收人：<?php echo $table['receiver_name'] ?></p>
                                <p>联系电话：<?php echo $table['receiver_phone'] ?></p>
                                <p>微信昵称：<?php echo $table['buyer_nick'] ?></p>
    <?php
    if ($table['delivery_id']) {
        echo " <p>请复制物流单号，点击菜航 “商城-><a href='http://m.kuaidi100.com/index_all.html' >快递</a>”查看物流</p>";
    }
    ?>
                            </div>	
                        </li> 
                    </ul>
                </li>
            <?php
        }
        ?>

        </ul>
<?php
if ($isnull) {
    echo '<p style="text-align:center;font-size:16px;color:#999;margin-top:50px;">暂无葡萄酒订单信息！</p>';
}
?>
        <script type="text/javascript" src="<?php echo v_site_url() ?>/Public/js/list.js"></script>

    </body>
</html>

