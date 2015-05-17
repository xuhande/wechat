<?php

namespace Pay;

/**
 * 微信卡券类 
 */
use Pay\CommonUtil;
use Pay\SDKRuntimeException;
use Pay\MD5SignUtil;

include_once("CommonUtil.php");
include_once("SDKRuntimeException.class.php");
include_once("MD5SignUtil.php");

class WxCouponHelper {

    var $parameters; //cft 参数

    function __construct() {
        
    }

    function setParameter($parameter, $parameterValue) {
        $this->parameters[CommonUtil::trimString($parameter)] = CommonUtil::trimString($parameterValue);
    }

    function getParameter($parameter) {
        return $this->parameters[$parameter];
    }

    protected function create_noncestr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str.= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
            //$str .= $chars[ mt_rand(0, strlen($chars) - 1) ];  
        }
        return $str;
    }

    function check_sign_parameters() {
        if ($this->parameters["coupon_stock_id"] == null ||
                $this->parameters["openid_count"] == null ||
                $this->parameters["partner_trade_no"] == null ||
                $this->parameters["openid"] == null ||
                $this->parameters["appid"] == null ||
                $this->parameters["mch_id"] == null ||
//                $this->parameters["sub_mch_id"] == null ||
//                $this->parameters["op_user_id"] == null ||
//                $this->parameters["device_info"] == null ||
                $this->parameters["nonce_str"] == null
//                $this->parameters["sign"] == null
//                $this->parameters["version"] == null ||
//                $this->parameters["type"] == null  
        ) {
            return false;
        }
        return true;
    } 
    protected function get_sign() {
        try {
            if (null == PARTNERKEY || "" == PARTNERKEY) {
//                throw new SDKRuntimeException("密钥不能为空！" . "<br>");
                throw new SDKRuntimeException("Pkey can't null！" . "<br>");
            }
            if ($this->check_sign_parameters() == false) {   //检查生成签名参数
//                throw new SDKRuntimeException("生成签名参数缺失！" . "<br>");
                throw new SDKRuntimeException("check_sign_parameters！" . "<br>");
            }
            $commonUtil = new CommonUtil();
            ksort($this->parameters);

            $unSignParaString = $commonUtil->formatQueryParaMap($this->parameters, false);

            $md5SignUtil = new MD5SignUtil();
            return $md5SignUtil->sign($unSignParaString, $commonUtil->trimString(PARTNERKEY));
        } catch (SDKRuntimeException $e) {
            die($e->errorMessage());
        }
    }

    function create_hongbao_xml($retcode = 0, $reterrmsg = "ok") {//签名加入请求参数，生成XML信息
        try {
            $this->setParameter('sign', $this->get_sign());
            $commonUtil = new CommonUtil();
//            echo $commonUtil->arrayToXml($this->parameters);
            return $commonUtil->arrayToXml($this->parameters);
        } catch (SDKRuntimeException $e) {
            die($e->errorMessage());
        }
    }

    function curl_post_ssl($url, $vars, $second = 30, $aHeader = array()) {
        $cacert = ROOT_PATH . DS . 'pay' . DS . 'rootca.pem'; 
        $SSL = substr($url, 0, 8) == "https://" ? true : false;

        $ch = curl_init();
        $this_header = array(
            "content-type: application/x-www-form-urlencoded; 
charset=UTF-8"
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this_header);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/xml"));
        if ($SSL && $CA) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);   // 只信任CA颁布的证书   
            curl_setopt($ch, CURLOPT_SSLCERT, ROOT_PATH . DS . 'pay' . DS . 'apiclient_cert.pem');
            curl_setopt($ch, CURLOPT_SSLKEY, ROOT_PATH . DS . 'pay' . DS . 'apiclient_key.pem');
            curl_setopt($ch, CURLOPT_CAINFO, $cacert); // CA根证书（用来验证的网站证书是否是CA颁布）  
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名，并且是否与提供的主机名匹配  
        } else if ($SSL && !$CA) { 
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // 信任任何证书  
            curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLCERTPASSWD, '10035198');
            curl_setopt($ch, CURLOPT_SSLCERT, ROOT_PATH . DS . 'pay' . DS . 'apiclient_cert.pem');
            curl_setopt($ch, CURLOPT_SSLKEY, ROOT_PATH . DS . 'pay' . DS . 'apiclient_key.pem');

            curl_setopt($ch, CURLOPT_CAINFO, $cacert); // CA根证书（用来验证的网站证书是否是CA颁布）  
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 检查证书中是否设置域名  
        }
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $res = curl_exec($ch);
        $error = curl_error($curl); //需放在curl_close($curl)执行之前
//        var_dump($error);
        curl_close($ch);
        return $res;
    }

}

?>