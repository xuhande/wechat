<?php

namespace Home\Controller;

use Think\Controller;

class MenuController {

    private function getAccessTokens() { //获取access_token 
        $appid = C('WX_CONF_APPID');
        $appsecret = C('WX_CONF_APPSECRET');
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
        $data = $this->getCurl($url); //通过自定义函数getCurl得到https的内容
        $resultArr = json_decode($data, true); //转为数组
        $this->logger("R " . $resultArr["access_token"]);
        return $resultArr["access_token"]; //获取access_token
    }

    public function creatMenu() {//创建菜单.
        $postStr = $GLOBALS ["HTTP_RAW_POST_DATA"];
        if (empty($postStr)) {

            return false;
        } else {
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $openId = $postObj->FromUserName;
        };
        $this->logger("postObj: " . json_encode($postObj));
        $this->logger("openid menuss: " . $openId);
        $accessToken = $this->getAccessTokens(); //获取access_token       
//                    "url": "http://mp.weixin.qq.com/bizmall/mallshelf?id=&t=mall/list&biz=MzA3MDAyMzA5OQ==&shelf_id=1&showwxpaytitle=1#wechat_redirect"
//             {
//                    "type": "view", 
//                    "name": "维权", 
//                    "url": ""url": "http://wx.mynow.net/Home/GetByfilter/index/openId/' . \Home\Common\Common::encode($openId) . '"
//                    "url": "https://mp.weixin.qq.com/payfb/payfeedbackindex?appid=' . C('WX_CONF_APPID') . '#wechat_webview_type=1&wechat_redirect"
//                }, 
//                
//               {http://mp.weixin.qq.com/bizmall/mallshelf?id=&t=mall/list&biz=MzA3MDAyMzA5OQ==&shelf_id=1&showwxpaytitle=1#wechat_redirect
//                          "type": "view", 
//                         "name": "订单查询", 
//                        "url": "http://wx.mynow.net/Home/GetByfilter/index/openId/'.$postObj->FromUserName. '"
//                     }, 
        //$_SESSION['openid'] = $openId; //        {
//            "name": "活动", 
//            "sub_button": [
//                {
//                    "type": "view", 
//                    "name": "母亲节", 
//                    "url": "http://weixin.vynfields.cn/?m=Home&c=Oauth2&a=index&type=lottery"
//                }
//            ]
////        }
//        $menuPostString = '
//{
//    "button": [
//        {
//            "name": "商城", 
//            "sub_button": [
//                {
//                    "type": "view", 
//                    "name": "小店", 
//                    "url": "http://mp.weixin.qq.com/bizmall/mallshelf?id=&t=mall/list&biz=MzA3MDAyMzA5OQ==&shelf_id=1&showwxpaytitle=1#wechat_redirect"
//                }, 
//                {
//                    "type": "click", 
//                    "name": "订单查询", 
//                    "key": "Orders"
//                }, 
//                {
//                    "type": "view", 
//                    "name": "教程", 
//                    "url": "http://mp.weixin.qq.com/s?__biz=MzA3MDAyMzA5OQ==&mid=212798009&idx=1&sn=e0dea58e2dfd47b8ab2fe79fede3c91d#rd"
//                }
//            ]
//        }, 
//        {
//            "name": "Vynfields", 
//            "sub_button": [
//                {
//                    "type": "click", 
//                    "name": "品牌介绍", 
//                    "key": "VINEYARD"
//                }, 
//                {
//                    "type": "click", 
//                    "name": "产品介绍", 
//                    "key": "WINE"
//                }, 
//                {
//                    "type": "view", 
//                    "name": "往期资讯", 
//                    "url": "http://mp.weixin.qq.com/mp/getmasssendmsg?__biz=MzA3MDAyMzA5OQ==#wechat_webview_type=1&wechat_redirect"
//                }, 
//                {
//                    "type": "view", 
//                    "name": "反馈建议", 
//                    "url": "http://weixin.vynfields.cn/Home/Suggestion/index"
//                }, 
//                {
//                    "type": "click", 
//                    "name": "合作洽谈", 
//                    "key": "Contact"
//                }
//            ]
//        }, 
//         {
//            "type": "view",
//            "name": "实体店", 
//            "url": "http://weixin.vynfields.cn/Home/index/store"
//        }
//    ]
//}
//';

        $menuPostString = '
{
    "button": [
        {
            "name": "商城", 
            "sub_button": [
                {
                    "type": "view", 
                    "name": "小店", 
                    "url": "http://weidian.com/?userid=809310365&infoType=1"
                },  
                {
                    "type": "view", 
                    "name": "教程", 
                    "url": "http://mp.weixin.qq.com/s?__biz=MzA3MDAyMzA5OQ==&mid=212798009&idx=1&sn=e0dea58e2dfd47b8ab2fe79fede3c91d#rd"
                }
            ]
        }, 
        {
            "name": "Vynfields", 
            "sub_button": [
                {
                    "type": "click", 
                    "name": "品牌介绍", 
                    "key": "VINEYARD"
                }, 
                {
                    "type": "click", 
                    "name": "产品介绍", 
                    "key": "WINE"
                }, 
                {
                    "type": "view", 
                    "name": "往期资讯", 
                    "url": "http://mp.weixin.qq.com/mp/getmasssendmsg?__biz=MzA3MDAyMzA5OQ==#wechat_webview_type=1&wechat_redirect"
                }, 
                {
                    "type": "view", 
                    "name": "反馈建议", 
                    "url": "http://weixin.vynfields.cn/Home/Suggestion/index"
                }, 
                {
                    "type": "click", 
                    "name": "合作洽谈", 
                    "key": "Contact"
                }
            ]
        }, 
         {
            "type": "view",
            "name": "销售链", 
            "url": "http://weixin.vynfields.cn/Home/index/store"
        }
    ]
}
';
        $this->logger("post menu" . $menuPostString);
        $menuPostUrl = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $accessToken; //POST的url
        $menu = $this->dataPost($menuPostString, $menuPostUrl); //将菜单结构体POST给微信服务器
    }

    private function logger($log_content) {
        $filename = "Public/Data/logs/wechat_menu" . date("Y-m-d") . ".txt";
        $k = fopen($filename, "a+");
        fwrite($k, "\n" . date("Y-m-d H:i:s") . ":" . $log_content);
        fclose($k);
    }

    private function getCurl($url) {//get https的内容
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //不输出内容
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    private function dataPost($post_string, $url) {//POST方式提交数据
        $context = array('http' => array('method' => "POST", 'header' => "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US) \r\n Accept: */*", 'content' => $post_string));
        $stream_context = stream_context_create($context);
        $data = file_get_contents($url, FALSE, $stream_context);
        return $data;
    }

}

?>
