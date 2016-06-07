<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Common;

session_start();

class Common {

    public function encode($string = '', $skey = 'cxphp') {   //加密
        $strArr = str_split(base64_encode($string));
        $strCount = count($strArr);
        foreach (str_split($skey) as $key => $value)
            $key < $strCount && $strArr[$key].=$value;
        return str_replace(array('=', '+', '/'), array('vynfields', 'o000o', '2015'), join('', $strArr));
    }

    public function decode($string = '', $skey = 'cxphp') { //解密
        $strArr = str_split(str_replace(array('vynfields', 'o000o', '2015'), array('=', '+', '/'), $string), 2);
        $strCount = count($strArr);
        foreach (str_split($skey) as $key => $value)
            $key <= $strCount && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
        return base64_decode(join('', $strArr));
    }

    public function getAccessTokens() { //获取access_token
        $appid = C('WX_CONF_APPID');
        $appsecret = C('WX_CONF_APPSECRET');
//        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
//        $curl = curl_init();
//        curl_setopt($curl, CURLOPT_URL, $url);
//        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
//        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
//        if (!empty($data)) {
//            curl_setopt($curl, CURLOPT_POST, 1);
//            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
//        }
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//        $data = curl_exec($curl);
//        curl_close($curl); 
////        $data = $this->PData($url); //通过自定义函数getCurl得到https的内容
//
//        $resultArr = json_decode($data, true); //转为数组 
//        
//        $_SESSION['maxtimes'] = time() + $resultArr ['expires_in'] - 6000;
//        $_SESSION['token'] = $resultArr["access_token"];
////        return $resultArr["access_token"]; //获取access_token
        $url = 'https://api.weixin.qq.com/cgi-bin/token?';
        $cont = "grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
        $data = file_get_contents($url . $cont);
        $data = json_decode($data, TRUE);
        $_SESSION['maxtime'] = time() + $data ['expires_in'] - 6000;
        Common::saveAccessToken($data ['access_token']);
    }

    public function setrep() {
        $time = time();
        //	$maxtime = $this->getexpires_in ();
        if (!isset($_SESSION['maxtimes']) || (isset($_SESSION['maxtimes']) && $_SESSION['maxtimes'] <= $time)) {            
            Common::getAccessTokens();
        }
         $_SESSION['token'] = Common::getAccessToken();
    }

    public function PData($url, $data = null) { // get and post模拟提交数据函数 
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    /**
     * 
     * @param type $data
     */
    public function savescaninfo($data) {

        $count = M('scaninfo')->where(array("openid" => $data['openid']))->select(); // 查询满足要求的总记录数 $map表示查询条件
        print_r($count);
        if ($count[0]['openid'] == "") {
            M('scaninfo')->data($data)->add();
            return $content = "请凭此信息领取礼品";
        } else {
            return $content = "请勿重复扫描领取，上次扫描时间：" . date('Y-m-d H:i:s', $count[0]['time']);
        }
    }

    /* logger save access
     * 
     */

    public function saveAccessToken($content) {
        $filename = "Public/Data/token/token.txt";
        $k = fopen($filename, "w+");
        fwrite($k, $content);
        fclose($k);
    }

    public function getAccessToken() {
        $filename = "Public/Data/token/token.txt";
        $k = fopen($filename, "r");
        $d = fgets($k, 10000);
        return $d;
    }

}
