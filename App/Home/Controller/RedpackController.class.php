<?php

namespace Home\Controller;

use Think\Controller;
use Pay\WxHongBaoHelper;
use Pay\CommonUtil;
use Pay\SDKRuntimeException;
use Pay\MD5SignUtil;

include_once("App/Home/pay/WxHongBaoHelper.php");

class RedpackController {

    public function index($openid) {
//        echo __FILE__;  
        define('ROOT_PATH', dirname(__FILE__));
        define('DS', DIRECTORY_SEPARATOR);

        /**
         * 微信配置
         */
        //商户 appid
        define('APPID', "wx9a34fd34e14f1103");
//        //paysign key
//        define('APPKEY', "XZsldkjflajdfLKsldfkjLKJlskdfjlsdLKJLsldkflalakdLKJ654FGD54d465sdfg66545K:DG654fWYXbrTAwqGy4coRbpSdGY0j0");
        //method 
        define('SIGNTYPE', "sha1");
        //通加密串
        define('PARTNERKEY', "QwertyuiopAsdfghjklZxcvbnm123456");
        //
//        define('APPSERCERT', "c778c49ab795b7ebdb7a4bcd7156730b");        
        define('APPSERCERT', "c778c49ab795b7ebdb7a4bcd7156730b");
        //商户id
        define('MCHID', "10035198");


//        $openid =$openid; //'ou9X8tsAIKJfcy86ynM9tXUKorbg';

        $tered = mt_rand(100, 110);
        $money = 1 * $tered; //红包金额，单位分
        $mch_billno = MCHID . date('YmdHis') . rand(1000, 9999); //订单号
        $act_name = "[橡木塞活动]投票领红包"; //活动名称
//        include_once(ROOT_PATH . DS . 'pay' . DS . 'WxHongBaoHelper.php');
        include_once( ROOT_PATH . DS . 'pay' . DS . 'WxHongBaoHelper.php');
        $commonUtil = new CommonUtil();
        $wxHongBaoHelper = new WxHongBaoHelper();
        $wxHongBaoHelper->setParameter("nonce_str", $commonUtil->create_noncestr()); //随机字符串，丌长于 32 位
        $wxHongBaoHelper->setParameter("mch_billno", $mch_billno); //订单号
        $wxHongBaoHelper->setParameter("mch_id", MCHID); //商户号
        $wxHongBaoHelper->setParameter("wxappid", APPID);
        $wxHongBaoHelper->setParameter("nick_name", 'VYNFIELDS'); //提供方名称
        $wxHongBaoHelper->setParameter("send_name", 'VYNFIELDS'); //红包发送者名称
        $wxHongBaoHelper->setParameter("re_openid", $openid); //相对于医脉互通的openid
        $wxHongBaoHelper->setParameter("total_amount", $money); //付款金额，单位分
        $wxHongBaoHelper->setParameter("min_value", $money); //最小红包金额，单位分
        $wxHongBaoHelper->setParameter("max_value", $money); //最大红包金额，单位分
        $wxHongBaoHelper->setParameter("total_num", 1); //红包収放总人数
        $wxHongBaoHelper->setParameter("wishing", '万元红包等你来拆'); //红包祝福
        $wxHongBaoHelper->setParameter("client_ip", '115.28.224.96'); //调用接口的机器 Ip 地址
        $wxHongBaoHelper->setParameter("act_name", $act_name); //活劢名称
        $wxHongBaoHelper->setParameter("remark", '万元红包等你来拆'); //备注信息
        $wxHongBaoHelper->setParameter("logo_imgurl", 'https://mp.weixin.qq.com/misc/getheadimg?token=82309495&fakeid=3070023099&r=805847'); //商户logo的url
        $wxHongBaoHelper->setParameter("share_content", '一起来投票拿红包吧～'); //分享文案
        $wxHongBaoHelper->setParameter("share_url", 'http://mp.weixin.qq.com/s?__biz=MzA3MDAyMzA5OQ==&mid=215797800&idx=1&sn=71c872230f638da21e65a1e421c7cb05#rd'); //分享链接
        $wxHongBaoHelper->setParameter("share_imgurl", 'https://mp.weixin.qq.com/misc/getheadimg?token=82309495&fakeid=3070023099&r=805847'); //分享的图片url
        //echo "================".$commonUtil->create_noncestr().'==========================';
     
        $postXml = $wxHongBaoHelper->create_hongbao_xml();
        
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';

        $responseXml = $wxHongBaoHelper->curl_post_ssl($url, $postXml);
        $responseObj = simplexml_load_string($responseXml, 'SimpleXMLElement', LIBXML_NOCDATA);
    
     self::saveSendRedPack($responseObj, $responseXml);
        if ($responseObj->return_code == "SUCCESS" && $responseObj->result_code == "SUCCESS") {// return_code 和 result_code 都为 SUCCESS 的时候保存
            return "200";
        }
        else{
            return "300";
        }
    }

    /**
     * save send success redpack
     */
    public function saveSendRedPack($responseObj, $content) {
        $page['mch_billno'] = $responseObj->mch_billno . "";
        $page['mch_id'] = $responseObj->mch_id . "";
        $page['wxappid'] = $responseObj->wxappid . "";
        $page['re_openid'] = $responseObj->re_openid . "";
        $page['total_amount'] = $responseObj->total_amount . "";
        $page['content'] = $content;
        $page['type'] = "1";
        M('redpack')->data($page)->add();
    }

}
