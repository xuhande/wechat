<?php

namespace Home\Controller;

use Think\Controller;

class Oauth2Controller extends Controller {

    public function index($type) {
        $url = v_site_url() . "/Cork/index/index";
        if ($type == "index") {
            $url = v_site_url() . "/Cork/index/index";
        } else if ($type == "corklist") {
            $url = v_site_url() . "/Cork/index/corklist";
        } else if ($type == "lottery") {
            $url = v_site_url() . "/Lottery/Lottery";
        } else if ($type == "hkReturn") {
            $url = v_site_url() . "/HkReturn/index/index";
        } else if ($type == "hkReturnList") {
            $url = v_site_url() . "/HkReturn/index/datalist";
        }


        $oauth = new Oauth2Controller();

        $content = $oauth->getCode(urlencode($url));

        header("location: " . $content);
        exit;
    }

    public function getCode($url) {
        $baseurl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . C("WX_CONF_APPID") . "&redirect_uri=" . $url . "&response_type=code&scope=snsapi_userinfo&state=state#wechat_redirect";

        return $baseurl;
//        if (isset($baseurl)) {
//            Header("HTTP/1.1 303 See Other");
//            Header("Location: $baseurl");
//            exit;
//        }
    }

    public function getOpenId($code) {

        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . C("WX_CONF_APPID") . "&secret=" . C("WX_CONF_APPSECRET") . "&code=" . $code . "&grant_type=authorization_code";

        $value = \Home\Common\Common::PData($url);
        $token = json_decode($value);
        \Home\Common\Common::saveAccessToken($token->access_token);
        return $value;
    }

    public function getUserInfo($openid) {
        $tokens = \Home\Common\Common::setrep();
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $tokens . "&openid=" . $openid . "&lang=zh_CN";
        $value = \Home\Common\Common::PData($url);
        return $value;
    }

    public function checkGZ($openid) {
        $tokens = \Home\Common\Common::setrep();
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $tokens . "&openid=" . $openid . "&lang=zh_CN";
        $value = \Home\Common\Common::PData($url);
        return $value;
    }

    public function pullUserInfo($openid) {
        $tokens = \Home\Common\Common::setrep();
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $tokens . "&openid=" . $openid . "&lang=zh_CN ";
        $value = \Home\Common\Common::PData($url);
        return $value;
    }

}
