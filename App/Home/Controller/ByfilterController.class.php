<?php

namespace Home\Controller;

use Think\Controller;

class ByfilterController extends Controller {

    private function getAccessTokens() { //获取access_token
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx9a34fd34e14f1103&secret=c778c49ab795b7ebdb7a4bcd7156730b";
        //   $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".Wechat_Config::_AppID."&secret=".Wechat_Config::_APPSEERET;

        $data = $this->VData($url); //通过自定义函数getCurl得到https的内容
        $resultArr = json_decode($data, true); //转为数组
        $this->logger($resultArr["access_token"]);

        return $resultArr["access_token"]; //获取access_token
    }

    private function getUser($access_token) { //获取单用户数据
        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$access_token";
//        $result = https_request($url);
        $result = $this->getSslPage($url);
        $jsoninfo = json_decode($result, true);
//        var_dump($result);
        return $jsoninfo;
//        print_r("<pre>");
//        print_r($jsoninfo['data']['openid']);
//        print_r("</pre>");
    }

    private function getAllUser($access_token, $openId = '') {//获取多用户数据
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openId&lang=zh_CN";
        $result = $this->VData($url, $xjson);
//        $jsoninfo = $resul;
        $jsoninfo = json_decode($result, true);
        return $jsoninfo;
//        print_r("<pre>");
//        print_r($jsoninfo);
//        print_r("</pre>");
    } 

    private function getSslPage($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function index() {

//        $beintime = date('Y-m-d H:i:s', $_POST['begintime']);
//        $endtime = date('Y-m-d H:i:s', $_POST['endtime']); 
        $accessToken = $this->getAccessTokens(); //获取access_token 
        $v = $this->getUser($accessToken);
        foreach ($v['data']['openid'] as $value) {

            $d = $this->getAllUser($accessToken, $value);

            print_r("<pre>");
            print_r($d);
            print_r("</pre>");
        }

//        $xjson = '
//       { 
//             
//        }
//         ';
//        $PostUrl = "https://api.weixin.qq.com/merchant/order/getbyfilter?access_token=" . $accessToken; //POST的url  
//        $result = $this->VData($PostUrl, $xjson);
////        echo $result;
//        return $result;
    }

    private function VData($url, $data = null) { // get and post模拟提交数据函数 
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

    private function logger($log_content) {
        $filename = "Public/Data/logs/wechat_order" . date("Y-m-d") . ".txt";
        $k = fopen($filename, "a+");
        fwrite($k, "\n" . date("Y-m-d H:i:s") . ":" . $log_content);
        fclose($k);
    }

}

?>
