<?php
include_once("WxPayPubHelper.php");


$commonUtil = new Common_util_pub();
$wxPayHelper = new Notify_pub();


$wxPayHelper->setReturnParameter("bank_type", "WX");
$wxPayHelper->setReturnParameter("body", "test");
$wxPayHelper->setReturnParameter("partner", "1900000109");
$wxPayHelper->setReturnParameter("out_trade_no", $commonUtil->create_noncestr());
$wxPayHelper->setReturnParameter("total_fee", "1");
$wxPayHelper->setReturnParameter("fee_type", "1");
$wxPayHelper->setReturnParameter("notify_url", "http://1.yzrc.sinaapp.com/wxpay/test/notify_url.php");
$wxPayHelper->setReturnParameter("spbill_create_ip", "127.0.0.1");
$wxPayHelper->setReturnParameter("input_charset", "GBK");


?>
<html>
<script language="javascript">
function callpay()
{
    WeixinJSBridge.invoke('getBrandWCPayRequest',<?php echo $wxPayHelper->create_biz_package(); ?>,function(res){
    WeixinJSBridge.log(res.err_msg);
    alert(res.err_code+res.err_desc+res.err_msg);
    });
}
</script>
<body>
<button type="button" onclick="callpay()">wx pay test</button>
</body>
</html>