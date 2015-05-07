<?php

namespace Home\Controller;

use Think\Controller;
use Pay\WxCouponHelper;
use Pay\CommonUtil;
use Pay\SDKRuntimeException;
use Pay\MD5SignUtil;

include_once("App/Home/pay/WxCouponHelper.php");

class CouponController {

    public function index($openId,$coupon_stock_id) { 
        define('ROOT_PATH', dirname(__FILE__));
        define('DS', DIRECTORY_SEPARATOR);

        /**
         * 微信配置
         */
        //商户 appid
        define('APPID', "wx9a34fd34e14f1103");
        //method 
        define('SIGNTYPE', "sha1");
        //通加密串
        define('PARTNERKEY', "QwertyuiopAsdfghjklZxcvbnm123456");

        define('APPSERCERT', "c778c49ab795b7ebdb7a4bcd7156730b");
        //商户id
        define('MCHID', "10035198");


//        $openid = 'ou9X8tl0p-rfJcmRriSrj2QP144s'; 
        $mch_billno = MCHID . date('YmdHis') . rand(1000, 9999);   
        include_once( ROOT_PATH . DS . 'pay' . DS . 'WxCouponHelper.php');
        $commonUtil = new CommonUtil();
        $wxCouponHelper = new WxCouponHelper();
        $wxCouponHelper->setParameter("coupon_stock_id", $coupon_stock_id);
        $wxCouponHelper->setParameter("openid_count", 1);
        $wxCouponHelper->setParameter("partner_trade_no", $mch_billno);
        $wxCouponHelper->setParameter("openid", $openId);
        $wxCouponHelper->setParameter("appid", APPID);
        $wxCouponHelper->setParameter("mch_id", MCHID);
        $wxCouponHelper->setParameter("nonce_str", $commonUtil->create_noncestr()); //随机字符串，丌长于 32 位 
        $postXml = $wxCouponHelper->create_hongbao_xml();  
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/send_coupon';
        $responseXml = $wxCouponHelper->curl_post_ssl($url, $postXml);
//        var_dump($responseXml); //可以看返回信息
        $responseObj = simplexml_load_string($responseXml, 'SimpleXMLElement', LIBXML_NOCDATA); 
        $msg = $responseObj->return_code . ',' . $responseObj->return_msg;

//        echo $msg;
    }

}
