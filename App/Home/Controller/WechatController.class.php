<?php

namespace Home\Controller;

use Think\Controller;

session_start();

class WechatController {

    //验证消息
    public function valid() {
        //$echoStr = trim ( $this->_request ( 'echostr', '' ) );
        $echoStr = $_GET["echostr"];
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

    //获取access_token
    protected function getAccessToken() {
        $url = 'https://api.weixin.qq.com/cgi-bin/token?';
        $appid = C('WX_CONF_APPID');
        $appsecret = C('WX_CONF_APPSECRET');
        $cont = "grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
        $data = file_get_contents($url . $cont);
        $data = json_decode($data, TRUE);
        //		$this->setaccess_token ( $data ['access_token'] );
        //		$this->setexpires_in ( time () + $data ['expires_in'] );

        $_SESSION['maxtimes'] = time() + $data ['expires_in'] - 6000;
        $_SESSION['token'] = $data ['access_token'];
    }

    //设置access_token的更新周期
    protected function setrep() {
        $time = time();
        //	$maxtime = $this->getexpires_in ();
        if (!isset($_SESSION['maxtimes']) || (isset($_SESSION['maxtimes']) && $_SESSION['maxtimes'] <= $time)) {
            $this->getAccessToken();
        }
    }

    //检查签名
    private function checkSignature() {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
//        $token = Wechat_Config::_TOKEN;
        $token = C('WX_CONF_TOKEN');
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    //响应消息
    public function responseMsg() {
        $postStr = $GLOBALS ["HTTP_RAW_POST_DATA"];
        $this->logger("$postStr " . $postStr);
        if (!empty($postStr)) {
            $this->logger("R " . $postStr);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);
            $openid = $postObj->FromUserName;
            $_SESSION['openid'] = $openid;
            $this->logger("OPenid " . $openid);
            switch ($RX_TYPE) {
                case "event" :
                    $result = $this->receiveEvent($postObj);
                    break;
                case "text" :

                    $result = $this->receiveText($postObj);
                    break;
                case "image" :

                    $result = $this->receiveImage($postObj);
                    break;
                case "location" :

                    $result = $this->receiveLocation($postObj);
                    break;
                case "voice" :

                    $result = $this->receiveVoice($postObj);
                    break;
                case "video" :

                    $result = $this->receiveVideo($postObj);
                    break;
                case "link" :

                    $result = $this->receiveLink($postObj);
                    break;
                default :
                    $result = "unknown msg type: " . $RX_TYPE;
                    break;
            }
            $this->logger("R " . $result);
            echo $result;
        } else {
            echo "";
            exit();
        }
    }

    //接收事件消息
    private function receiveEvent($object) {
        $content = "";
        $contents = "";
        $openid = $object->FromUserName;
        $this->logger("object->order: " . $object);
        switch ($object->Event) {
            case "subscribe" :
                $this->logger("user" . $openid);
                $content = $this->getYMassage();
//                $content .= (!empty($object->EventKey)) ? ("\n来自二维码场景 " . str_replace("qrscene_", "", $object->EventKey)) : "";
                switch (str_replace("qrscene_", "", $object->EventKey)) {
                    case "cork-down" :
                        $map['openid'] = $object->FromUserName . "";
                        $map['eventkey'] = $object->EventKey . "";
                        $map['time'] = $object->CreateTime . "";
//                        $content = json_encode($object);
                        $message .= \Home\Common\Common::savescaninfo($map);
                        sendMessage($openid, $message);
                        break;
                }
                break;
            case "merchant_order" :
                $arr = array('ou9X8tl0p-rfJcmRriSrj2QP144s', 'ou9X8tmgcfDo8PRv_kOQlaXsTE1U', 'ou9X8tsAIKJfcy86ynM9tXUKorbg', 'ou9X8tvqWzg16EhbYeBDJGyYLPU0', 'ou9X8tsB-9LyL1grx7-M1nR5YR5A','ou9X8trvxCTbI8_vNImSPaUOi3C4','ou9X8tu0XbdM4eg_x4T_fBKCFqB4', 'ou9X8tt6rj9WwwlR_OLpXFLH9F4M', 'ou9X8thCGmOBe6GTJBU3IbzKRWJs');
                $this->setrep();
                $url = "http://weixin.vynfields.cn/Home/GetByfilter/index/openId/$object->FromUserName";
                $jsonData = $this->orderData($_SESSION['token'], $object->OrderId);
                $_SESSION["jsonData"] = $jsonData;
                foreach ($arr as $v) {
                    $this->sendMessage($_SESSION['token'], $v, $_SESSION["jsonData"]);
                }
                $this->send_template_message($_SESSION['token'], $jsonData, $object->FromUserName, $url);
                break;
            case "unsubscribe" :
                $this->userDefriend($openid);
                $content = "取消关注";
                break;
            case "SCAN" :
                //                $content = "扫描场景 " . $object->EventKey;
                switch ($object->EventKey) {
                    case "cork-down" :

                        $map['openid'] = $object->FromUserName . "";
                        $map['eventkey'] = $object->EventKey . "";
                        $map['time'] = $object->CreateTime . "";
//                        $content = json_encode($map);
                        $content = \Home\Common\Common::savescaninfo($map);


                        break;
                    default :
                        $content = "";
                        break;
                }
                break;
            case "CLICK" :
                switch ($object->EventKey) {
                    case "V1001_CONN_CUSTOM" :
                        $content = $this->getYMassage();
                        break;
                    case "VINEYARD":
                        $content = array();
                        $content[] = array("Title" => "维尼菲尔德（VYNFIELDS）酒庄", "Description" => "维尼菲尔德酒庄坐落于马尔堡的梯田上,拥有5.3公顷有机葡萄园，园区内古老的碎石土壤表层覆盖着薄薄一层粉砂壤土，具有良好的排水性。气候适宜，降雨少，夏季炎热干燥，秋季夜间凉爽，这为黑皮诺和雷司令的生长创造了理想的条件。", "PicUrl" => "https://mmbiz.qlogo.cn/mmbiz/cNQxibw2z3wRebFKV8CObsmC4lYA9A9KEleUWicF6X4iblEMkovkOxns6bTf8mfVwvqgx64Ll9pcshbCMXTw9Cuzg/0", "Url" => "http://mp.weixin.qq.com/s?__biz=MzA3MDAyMzA5OQ==&mid=203156234&idx=1&sn=0e564ec19e82cebd4b50873883fcd07d#rd");
                        break;
                    case "WINE":
                        $content = array();
                        $content[] = array("Title" => "维尼菲尔德（VYNFIELDS）葡萄酒", "Description" => "维尼菲尔德酒庄精心酿造的2003 Pinot Noir及2004 Classic Riesling蜚声国际", "PicUrl" => "https://mmbiz.qlogo.cn/mmbiz/cNQxibw2z3wQIVfMACB4WT2uatjWh1n4iaTvftmicBmQCmvjicXxONShcnM9FtIZ8ugoeayRlcIURXFa4ohl3ByLIw/0", "Url" => "http://mp.weixin.qq.com/s?__biz=MzA3MDAyMzA5OQ==&mid=203156559&idx=1&sn=99f1c22cb4357bb9811a151af3b44ae6#rd");
                        break;
                    case "Suggestions":
                        $content = array();
                        $this->setrep();
                        $this->logger("object->contents: " . $_SESSION['token']);
                        break;
                    case "Contact":
                        $content = "欢迎推荐，投诉，合作，咨询。\n邮箱：\n info@vynfields.cn \n联系号码：\n400-888-2232\n感谢您对维尼菲尔德【Vynfields】的关注和支持！";
                        break;
                    case "Orders":
                        $content = array();
                        $content[] = array("Title" => "Vynfields商城订单查询", "Description" => "", "PicUrl" => "https://mmbiz.qlogo.cn/mmbiz/cNQxibw2z3wQOpSx9cia1ib4DDNEpmWJWUA7d286ENzq81BDOjwtrl6ibibDmhXPKAFD4e2NA0xA9HLeUSshvgZxlGw/0", "Url" => "http://weixin.vynfields.cn//Home/GetByfilter/index/openId/$object->FromUserName");
                        break;
                    default :
                        $content = "";
                        break;
                }
                break;
            case "LOCATION" :
                //	$content = "上传位置：纬度 " . $object->Latitude . ";经度 " . $object->Longitude;
                $content = "";
                break;
            case "VIEW" :
                $content = "跳转链接 " . $object->EventKey;
                break;
            default :
                $content = "receive a new event: " . $object->Event;
                break;
        }

        if (is_array($content)) {
            if (isset($content[0])) {
                $result = $this->transmitNews($object, $content);
            } else if (isset($content['MusicUrl'])) {
                $result = $this->transmitMusic($object, $content);
            }
        } else if (is_array($contents)) {
            if (isset($contents[0])) {
                $this->logger("array->contents: " . $contents);
                $result = $this->transmitOrder($object, $contents);
            }
        } else {
            $result = $this->transmitText($object, $content);
        }

        return $result;
    }

    //接收文本消息
    private function receiveText($object) {
        $openid = $object->FromUserName;
        $keyword = trim($object->Content);
        //多客服人工回复模式
        if ($keyword == '4' || strstr($keyword, "客服")) {
            $result = $this->transmitService($object);
        }

        //自动回复模式
        else {


            if ($keyword == '1' || strstr($keyword, "Vynfields") || strstr($keyword, "vynfields") || strstr($keyword, "酒庄") || strstr($keyword, "庄园") || strstr($keyword, "VYNFIELDS") || strstr($keyword, "维尼菲尔德") || strstr($keyword, "维尼菲尔德酒庄")) {
                $content = array();
                $content[] = array("Title" => "维尼菲尔德（VYNFIELDS）酒庄", "Description" => "维尼菲尔德酒庄坐落于马尔堡的梯田上,拥有5.3公顷有机葡萄园，园区内古老的碎石土壤表层覆盖着薄薄一层粉砂壤土，具有良好的排水性。气候适宜，降雨少，夏季炎热干燥，秋季夜间凉爽，这为黑皮诺和雷司令的生长创造了理想的条件。", "PicUrl" => "https://mmbiz.qlogo.cn/mmbiz/cNQxibw2z3wRebFKV8CObsmC4lYA9A9KEleUWicF6X4iblEMkovkOxns6bTf8mfVwvqgx64Ll9pcshbCMXTw9Cuzg/0", "Url" => "http://mp.weixin.qq.com/s?__biz=MzA3MDAyMzA5OQ==&mid=203156234&idx=1&sn=0e564ec19e82cebd4b50873883fcd07d#rd");
            } else if ($keyword == '2' || strstr($keyword, "红酒") || strstr($keyword, "葡萄酒") || strstr($keyword, "Vynfields红酒") || strstr($keyword, "白葡萄酒") || strstr($keyword, "Vynfields葡萄酒") || strstr($keyword, "酒") || strstr($keyword, "酒类")) {
                $content = array();
                $content[] = array("Title" => "维尼菲尔德（VYNFIELDS）葡萄酒", "Description" => "维尼菲尔德酒庄精心酿造的2003 Pinot Noir及2004 Classic Riesling蜚声国际", "PicUrl" => "http://mmbiz.qpic.cn/mmbiz/cNQxibw2z3wSjUox7Tfsh6jhDBdXAiaQM13H5symzPgjE3t9oYI4C73MxmIRAE7urvicAbbU65XQBj4J4L9icmUPZw/0?tp=webp", "Url" => "http://mp.weixin.qq.com/s?__biz=MzA3MDAyMzA5OQ==&mid=203156559&idx=1&sn=99f1c22cb4357bb9811a151af3b44ae6#rd");
                $content[] = array("Title" => "维尼菲尔德（VYNFIELDS）酒庄红酒文化分享会", "Description" => "新西兰维尼菲尔德（VYNFIELDS）庄园是新世界中成长较为迅速的酒庄，是新西兰十大酒庄之一，以其典雅优质的黑皮诺、雷司令闻名于世。", "PicUrl" => "http://mmbiz.qpic.cn/mmbiz/cNQxibw2z3wSjUox7Tfsh6jhDBdXAiaQM1I5yic1xYLUicibDHicuPOSAJzIgs9SMWDKUPb3za2vRGRwXN8nKN2fXU0Q/0?tp=webp", "Url" => "http://mp.weixin.qq.com/s?__biz=MzA3MDAyMzA5OQ==&mid=203156559&idx=2&sn=43d875b3ee3f883c502c0966938cded8#rd");
            } else if (strstr($keyword, "天气")) {
                $keywords = trim($object->Content);
                $entity = str_replace('天气', '', $keywords);
                $getWeather = new WeatherController();
                $content = $getWeather->getWeatherInfo($entity);
            } else if (strstr($keyword, "音乐")) {
                $keywords = trim($object->Content);
                $entity = str_replace('音乐', '', $keywords);
                $getMusic = new MusicController();
                $content = $getMusic->getMusicInfo($entity);
            }
//            else if ($keyword == '3' || strstr($keyword, "品鉴会")) {
//
//                $keywords = trim($object->Content);
//                $entity = str_replace('品鉴会', '', $keywords);
//                if ($entity == "" || (strstr($entity, "+"))) {
//                    $content = "1：回复“品鉴会场景”查看精美的品鉴会场景;\n";
//                    $content .= "2：回复嘉宾名字查看个人图片，如“品鉴会章子怡”；\n";
//                    $content .= "3：更多精彩瞬间，请回复“品鉴会现场”。";
//                } else {
//                    $content = "点击链接后，长按照片即可保存；\n "
//                            . "http://weixin.vynfields.cn//photo/index/index/category/" . urlencode($entity) . ".html";
//                }
//            } 
            else if (strstr($keyword, "3")) {

                $keywords = trim($object->Content);
                $entity = str_replace('3', '', $keywords);
                if ($entity == "" || (strstr($entity, "+"))) {
                    $content = "1：回复 ： “3SC”查看商城;\n";
                    $content .= "2：回复 ： “3JC”查看商城如何购买教程;\n";
                } else {
                    if (strstr($keyword, "3SC") || strstr($keyword, "3sc")) {

                        $content = "点击此商城链接地址：\n "
                                . "http://mp.weixin.qq.com/bizmall/mallshelf?id=&t=mall/list&biz=MzA3MDAyMzA5OQ==&shelf_id=1&showwxpaytitle=1#wechat_redirect";
                    } else if (strstr($keyword, "3JC") || strstr($keyword, "3jc")) {
                        $content = array();
                        $content[] = array("Title" => "维尼菲尔德（VYNFIELDS）葡萄酒购买教程", "Description" => "号外号外！今日起，维尼菲尔德微商城完美上线啦！小伙伴们久等了，赶紧猛戳原文看看具体详情吧！", "PicUrl" => "https://mmbiz.qlogo.cn/mmbiz/cNQxibw2z3wS9FhdeFEOsHf3h2QzO719pSzgJtCDhuHwFWKOBKrlonwwEoicreFeBkbVlWEcfR8PTCykJ6zjpGQg/0", "Url" => "http://mp.weixin.qq.com/s?__biz=MzA3MDAyMzA5OQ==&mid=212798009&idx=1&sn=e0dea58e2dfd47b8ab2fe79fede3c91d#rd");
                    }
                }
            } else if (strstr($keyword, "1357")) {
                 $oauth = new Oauth2Controller();
                $content = $oauth->getCode(urlencode("http://weixin.vynfields.cn/Lottery/index/index.html"));
            } else if (strstr($keyword, "2468")) {
                $oauth = new Oauth2Controller();

                $content = $oauth->getCode(urlencode("http://weixin.vynfields.cn/Lottery/index/index.html"));
            }  else if (strstr($keyword, "投票")) {
                $oauth = new Oauth2Controller();

                $content = "活动已结束，谢谢参与。请期待下一次活动！么么哒～";//.$oauth->getCode(urlencode("http://weixin.vynfields.cn//Cork/index/corklist.html"));
            }
             else if (strstr($keyword, "红包")) {
                $oauth = new Oauth2Controller();

                $content = "活动已结束，谢谢参与。请期待下一次活动！么么哒～";//.$oauth->getCode(urlencode("http://weixin.vynfields.cn//Cork/index/corklist.html"));
            } else if (strstr($keyword, "789")) {
                $red = new RedpackController();
                $red->index($openid, '79679');
            } else {

                $content = $this->getYMassage();
            }

            if (is_array($content)) {
                if (isset($content[0]['PicUrl'])) {
                    $result = $this->transmitNews($object, $content);
                } else if (isset($content['MusicUrl'])) {
                    $result = $this->transmitMusic($object, $content);
                }
            } else {
                $result = $this->transmitText($object, $content);
            }
        }

        return $result;
    }

    //接收图片消息
    private function receiveImage($object) {
        $content = array("MediaId" => $object->MediaId);
        $result = $this->transmitImage($object, $content);
        return $result;
    }

    //接收位置消息
    private function receiveLocation($object) {
        $result = '';
        //$content = "你发送的是位置，纬度为：" . $object->Location_X . "；经度为：" . $object->Location_Y . "；缩放级别为：" . $object->Scale . "；位置为：" . $object->Label;
        //$result = $this->transmitText ( $object, $content );
        return $result;
    }

    //接收语音消息
    private function receiveVoice($object) {
        if (isset($object->Recognition) && !empty($object->Recognition)) {
            $content = "你刚才说的是：" . $object->Recognition;
            $result = $this->transmitText($object, $content);
        } else {
            $content = array("MediaId" => $object->MediaId);
            $result = $this->transmitVoice($object, $content);
        }

        return $result;
    }

    //接收视频消息
    private function receiveVideo($object) {
        $content = array("MediaId" => $object->MediaId, "ThumbMediaId" => $object->ThumbMediaId, "Title" => "", "Description" => "");
        $result = $this->transmitVideo($object, $content);
        return $result;
    }

    //接收链接消息
    private function receiveLink($object) {
        $content = "你发送的是链接，标题为：" . $object->Title . "；内容为：" . $object->Description . "；链接地址为：" . $object->Url;
        $result = $this->transmitText($object, $content);
        return $result;
    }

    //回复文本消息
    private function transmitText($object, $content) {
        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }

    //回复多客服消息
    private function transmitService($object) {
        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[transfer_customer_service]]></MsgType>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复图片消息
    private function transmitImage($object, $imageArray) {
        $itemTpl = "<Image>
    <MediaId><![CDATA[%s]]></MediaId>
</Image>";

        $item_str = sprintf($itemTpl, $imageArray ['MediaId']);

        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[image]]></MsgType>
		$item_str
</xml>";

        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复语音消息
    private function transmitVoice($object, $voiceArray) {
        $itemTpl = "<Voice>
    <MediaId><![CDATA[%s]]></MediaId>
</Voice>";

        $item_str = sprintf($itemTpl, $voiceArray ['MediaId']);

        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[voice]]></MsgType>
		$item_str
</xml>";

        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复视频消息
    private function transmitVideo($object, $videoArray) {
        $itemTpl = "<Video>
    <MediaId><![CDATA[%s]]></MediaId>
    <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
    <Title><![CDATA[%s]]></Title>
    <Description><![CDATA[%s]]></Description>
</Video>";

        $item_str = sprintf($itemTpl, $videoArray ['MediaId'], $videoArray ['ThumbMediaId'], $videoArray ['Title'], $videoArray ['Description']);

        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[video]]></MsgType>
		$item_str
</xml>";

        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复图文消息
    private function transmitNews($object, $newsArray) {
        if (!is_array($newsArray)) {
            return;
        }
        $itemTpl = "    <item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
    </item>
";
        $item_str = "";
        foreach ($newsArray as $item) {
            $item_str .= sprintf($itemTpl, $item ['Title'], $item ['Description'], $item ['PicUrl'], $item ['Url']);
        }
        $newsTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<Content><![CDATA[]]></Content>
<ArticleCount>%s</ArticleCount>
<Articles>
		$item_str</Articles>
</xml>";

        $result = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
        return $result;
    }

    //回复音乐消息
    private function transmitMusic($object, $musicArray) {
        $itemTpl = "<Music>
    <Title><![CDATA[%s]]></Title>
    <Description><![CDATA[%s]]></Description>
    <MusicUrl><![CDATA[%s]]></MusicUrl>
    <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
</Music>";

        $item_str = sprintf($itemTpl, $musicArray ['Title'], $musicArray ['Description'], $musicArray ['MusicUrl'], $musicArray ['HQMusicUrl']);

        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[music]]></MsgType>
		$item_str
</xml>";

        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //获取用户MId,SID
    private function getUsersInfo($mobile) {
        return Leshou_DBconnection::proxyQueryMerchantInfo($mobile);
    }

    //用户取消关注
    private function userDefriend($openid) {
        $set = array('t_subscribe' => 0, 't_state' => 0);
        $rs = Sql_wechatSqlClass::userdefriend($set, $openid);
    }

    //日志记录
    private function logger($log_content) {
        $filename = "Public/Data/logs/wechat_log" . date("Y-m-d") . ".txt";
        $k = fopen($filename, "a+");
        fwrite($k, "\n" . date("Y-m-d H:i:s") . ":" . $log_content);
        fclose($k);
    }

    //设置消息回合内容
    private function getYMassage() {

        $content = "您好, 欢迎关注【维尼菲尔德（VYNFIELDS）酒庄】，惟你专享的迷人价值！\n请回复以下数字：\n";
        $content .= "【1】：查看维尼菲尔德酒庄介绍;\n";
        $content .= "【2】：查看维尼菲尔德葡萄酒;\n";
//        $content .= "【3】：查看Vynfields品鉴会;\n";
        $content .= "【3】：查看微商城;\n";
        $content .= "【4】：转入人工客服咨询;";
        return $content;
    }

    protected function setaccess_token($access_token) {
        if (isset(self::$access_token))
            self::$access_token = '';
        self::$access_token = $access_token;
    }

    protected function getaccess_token() {
        return isset($_SESSION['token']) ? $_SESSION['token'] : '';
    }

    protected function setexpires_in($expires_in) {
        if (isset(self::$expires_in))
            self::$expires_in = 0;
        self::$expires_in = $expires_in;
    }

    protected function getexpires_in() {
        return isset(self::$expires_in) ? self::$expires_in : 0;
    }

    private function send_template_message($access_token, $OrderId = null, $OpenId, $url) {
//	 $format_total=number_format($table['order_total_price'] * 0.01, 2, '.', ','); 
        $accessToken = $access_token; //获取access_token 
        $jsons = json_decode($OrderId, true);
//        $this->logger("object->jsons: " . $jsons);
        $product = $jsons["order"]["product_name"];
        $order_id = $jsons["order"]["order_id"];
        $time = date('Y-m-d H:i:s', $jsons["order"]["order_create_time"]);
        $total_price = number_format($jsons["order"]["order_total_price"] * 0.01, 2, '.', ',');
        $product_price = number_format($jsons["order"]['product_price'] * 0.01, 2, '.', ',');
        $address = $jsons["order"]["receiver_province"] . $jsons["order"]["receiver_city"] . $jsons["order"]["receiver_address"];
        $pro_conut = $jsons["order"]["product_count"];
        $name = $jsons["order"]["receiver_name"];
        $mobile = $jsons["order"]["receiver_mobile"];
        $express = number_format($jsons["order"]["order_express_price"] * 0.01, 2, '.', ',');
        $xjson = '{
           "touser":"' . $OpenId . '",
           "template_id":"5RozHEOlWkYU6ELgshTU6PxhjS2M4WzHIhoc2vHp_mQ",
           "url":"' . $url . '",
           "topcolor":"#00B050",
           "data":{
                   "first": {
                       "value":"恭喜您在维尼菲尔德【Vynfields】商城购买成功！",
                       "color":"#00B050"
                   },
                   "product":{
                       "value":"' . $product . '",
                       "color":"#000000"
                   },
                   "price": {
                       "value":"￥' . urldecode($product_price) . '元",
                       "color":"#000000"
                   },
                   "time": {
                       "value":"' . $time . '",
                       "color":"#000000"
                   },
                   "remark":{
                       "value":"订单编号：' . $order_id . '\n订购数量：' . $pro_conut . '支\n商品总额：￥' . urldecode($total_price) . '元\n运费金额：￥' . urldecode($express) . '元\n收件人：' . $name . '\n移动手机：' . $mobile . '\n收件地址：' . $address . '\n\n您的订单已提交，我们将尽快为您发货。祝您生活愉快！",
                       "color":"#000000"
                   }
           }
       }
';
        $PostUrl = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $accessToken; //POST的url  
        $result = $this->vpost($PostUrl, $xjson);
        return $result;
    }

    private function orderData($access_token, $OrderId) {  //订单数据返回
        $accessToken = $access_token; //获取access_token 
        $OrderIds = $OrderId;
        $xjson = '
        { 
          "order_id" : "' . $OrderIds . '" 
        }
         ';
        $PostUrl = "https://api.weixin.qq.com/merchant/order/getbyid?access_token=" . $accessToken; //POST的url  
        $result = $this->vpost($PostUrl, $xjson);
        return $result;
    }

    private function sendMessage($access_token, $openId, $data) {//发送信息通知到指定人员          
        $jsons = json_decode($data, true);
        $product_name = $jsons["order"]["product_name"];
        $order_id = $jsons["order"]["order_id"];
        $time = date('Y-m-d H:i:s', $jsons["order"]["order_create_time"]);
        $total_price = number_format($jsons["order"]["order_total_price"] * 0.01, 2, '.', ',');
        $product_price = number_format($jsons["order"]['product_price'] * 0.01, 2, '.', ',');
        $address = $jsons["order"]["receiver_province"] . $jsons["order"]["receiver_city"] . $jsons["order"]["receiver_address"];
        $pro_conut = $jsons["order"]["product_count"];
        $name = $jsons["order"]["receiver_name"];
        $mobile = $jsons["order"]["receiver_mobile"];
        $express = (($jsons["order"]["order_express_price"] == 0) ? '免邮费' : '￥' . number_format($jsons["order"]["order_express_price"] * 0.01, 2, '.', ',') . '元');
        $xjson = '      {
           "touser":"' . $openId . '",
           "template_id":"5RozHEOlWkYU6ELgshTU6PxhjS2M4WzHIhoc2vHp_mQ",
           "url":"http://mp.weixin.qq.com/bizmall/mallshelf?id=&t=mall/list&biz=MzA3MDAyMzA5OQ==&shelf_id=1&showwxpaytitle=1#wechat_redirect",
           "topcolor":"#00B050",
           "data":{
                   "first": {
                       "value":"已有最新订单通知！",
                       "color":"#000000"
                   },
                   "product":{
                       "value":"' . $product_name . '",
                       "color":"#000000"
                   },
                   "price": {
                       "value":"' . urldecode($total_price) . '元",
                       "color":"#000000"
                   }, 
                   "time": {
                       "value":"' . $time . '",
                       "color":"#000000"
                   },
                   "remark":{
                       "value":"商品ID：' . $order_id . '\n订购数量：' . $pro_conut . '支\n运费金额：' . urldecode($express) . '\n订购人：' . $name . '\n移动手机：' . $mobile . '\n收件地址：' . $address . '\n请各部门检查一下订单和收款，确定后给物流部门发货，谢谢！",
                       "color":"#000000"
                   }
           }
       }';
        $PostUrl = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token;
        $value = $this->vpost($PostUrl, $xjson);

        $this->logger("object->value: " . $value);

        return $value;
    }

    private function vpost($url, $data = null) { // 模拟提交数据函数
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

}
