<?php

namespace HkReturn\Controller;

use Think\Controller;
use \Pay\WxHongBaoHelper;
use \Pay\CommonUtil;

include_once("App/Home/pay/WxHongBaoHelper.php");

class IndexController extends Controller {

    /**
     * 
     */
    public function index() {
        $oauth2 = new \Home\Controller\Oauth2Controller();
        $data = $oauth2->getOpenId($_GET['code']);
        $openid = json_decode($data);
        $userinfo = json_decode($oauth2->getUserInfo($openid->openid));
        ///////////测试信息////////////
        $userinfo->openid = "aikangs";
        $userinfo->subscribe = true;
        $userinfo->nickname = "kangsng";
        if ($userinfo->openid) {
            $_SESSION['openid'] = $userinfo->openid;
        }
        //将用户信息保存（如果不存在的话）
        $where['openid'] = $_SESSION['openid'];
        $user = M("wechat_user")->where($where)->find();
        if ($user['id'] == "" && $userinfo->openid != "") {
            $u['openid'] = $userinfo->openid;
            $u['nickname'] = $userinfo->nickname;
            $u['subscribe'] = $userinfo->subscribe;
            $u['is_lottery'] = 0;
            $u['created'] = time();
            M("wechat_user")->data($u)->add();
        } else {
            if (!empty($userinfo->openid)) {
                $user['subscribe'] = $userinfo->subscribe;
                M("wechat_user")->data($user)->save();
            }
        }

        $this->user = $user;

        $this->theme("default")->display("HkReturn/index_2016");
    }

    /**
     * total chance number
     */
    public function chance() {
        $subscribe = I('param.subscribe');
        $openid = I("param.openid"); //openid
        $now = time();
        $beginTime = strtotime(date('Y-m-d 00:00:00', $now));
        $endTime = strtotime(date('Y-m-d 23:59:59', $now));
        $map['openid'] = $openid;
        $map['created'] = array(array('gt', $beginTime), array('lt', $endTime));
        $record_count = M("hkreturn_record")->where($map)->count();
        if ($openid) {
            echo 3 - $record_count;
        } else {
            echo 0;
        }
    }

    /**
     * 保存中奖信息
     */
    public function savelottery() {
        $subscribe = I('param.subscribe');
        $openid = I("param.openid"); //openid 
        $nickname = I("param.nickname"); //username
        $lottery_id = I("param.lottery"); //中奖信息
        $tokens = \Home\Common\Common::setrep();
        //查询是否已经抽过了   
        $now = time();
        $beginTime = strtotime(date('Y-m-d 00:00:00', $now));
        $endTime = strtotime(date('Y-m-d 23:59:59', $now));
        $mapt['openid'] = $openid;
        $mapt['created'] = array(array('gt', $beginTime), array('lt', $endTime));

        $where['openid'] = $openid;
        $user = M("wechat_user")->where($where)->find();
        if ($openid == "" || $nickname == "" || $lottery_id == "") {
            echo json_encode(array("code" => "500"));
            die;
        }
        if (!$user['subscribe']) { //没有关注 
            echo json_encode(array("code" => "303"));
            die;
        }
        $record_count = M("hkreturn_record")->where($mapt)->count();
        if ($record_count >= 3) {
            echo json_encode(array("code" => "205"));
            die;
        }
        //将奖品数量减去1
        $lottery_prize = M("hkreturn_prize")->where(array("id" => $lottery_id))->find();
        if ($lottery_prize['id'] != "") {
            $lottery_prize['number'] = $lottery_prize['number'] - 1;
            if ($lottery_prize['number'] <= 0) {
                $lottery_prize['v'] = 0;
            }
            $res = M("hkreturn_prize")->data($lottery_prize)->save();
            if ($res) {
                $map['openid'] = $openid;
                $map['username'] = $nickname;
                $map['lottery'] = $lottery_id;
                $map['created'] = time();
                $r = M("hkreturn_record")->data($map)->add();
                if ($r) {
                    $record_count = M("hkreturn_record")->where($mapt)->count();
                    $goods = M("hkreturn_record")->table('w_hkreturn_record')->join('w_hkreturn_prize on w_hkreturn_record.lottery = w_hkreturn_prize.id')->where(array('w_hkreturn_record.id' => $r, 'w_hkreturn_record.openid' => $openid
                            ))->field("w_hkreturn_prize.prize,w_hkreturn_record.created")->find();
                    $prize = urldecode($goods['prize']) . '元';
                    $created = date("Y-m-d H:i", $goods['created']);
                    $this->sendMessage($tokens, $openid, $prize, $created);
                    $chance = 3 - $record_count;
                    echo json_encode(array("code" => "200", "chance" => $chance));
                } else {
                    M("hkreturn_record")->where(array("id" => $lottery_id))->setInc('number');
                    echo json_encode(array("code" => "203"));
                }
            } else {
                echo json_encode(array("code" => "203"));
            }
        } else {
            echo json_encode(array("code" => "203"));
        }
    }

    public function getLottery() {
        /*
         * 经典的概率算法， 
         * $proArr是一个预先设置的数组， 
         * 假设数组为：array(100,200,300，400)， 
         * 开始是从1,1000 这个概率范围内筛选第一个数是否在他的出现概率范围之内，  
         * 如果不在，则将概率空间，也就是k的值减去刚刚的那个数字的概率空间， 
         * 在本例当中就是减去100，也就是说第二个数是在1，900这个范围内筛选的。 
         * 这样 筛选到最终，总会有一个数满足要求。 
         * 就相当于去一个箱子里摸东西， 
         * 第一个不是，第二个不是，第三个还不是，那最后一个一定是。 
         * 这个算法简单，而且效率非常 高， 
         * 关键是这个算法已在我们以前的项目中有应用，尤其是大数据量的项目中效率非常棒。 
         */

        function get_rand($proArr) {
            $result = '';
            //概率数组的总概率精度   
            $proSum = array_sum($proArr);
            //概率数组循环   
            foreach ($proArr as $key => $proCur) {
                $randNum = mt_rand(1, $proSum);
                if ($randNum <= $proCur) {
                    $result = $key;
                    break;
                } else {
                    $proSum -= $proCur;
                }
            }
            unset($proArr);
            return $result;
        }

        /*
         * 奖项数组 
         * 是一个二维数组，记录了所有本次抽奖的奖项信息， 
         * 其中id表示中奖等级，prize表示奖品，v表示中奖概率。 
         * 注意其中的v必须为整数，你可以将对应的 奖项的v设置成0，即意味着该奖项抽中的几率是0， 
         * 数组中v的总和（基数），基数越大越能体现概率的准确性。 
         * 本例中v的总和为100，那么平板电脑对应的 中奖概率就是1%， 
         * 如果v的总和是10000，那中奖概率就是万分之一了。 
         *  
         */

        /**
         * [0,337,"未中奖"],[1,26,"免单4999元"],[2,88,"免单50元"],[3,137,"免单10元"],[4,185,"免单5元"],[5,235,"免分期服务费"]
         */
        //通过数据库获取中奖项 array("number"=>array("egt","1"))
        $prize_arr = M("hkreturn_prize")->where()->select();
//        $prize_arr = M("lottery_prize")->where(array("number"=>array("egt","1")))->select();
//        $prize_arr = array(
//            '0' => array('id' => 1, "angles" => 337, 'prize' => '80元代金券', 'v' => 5),
//            '1' => array('id' => 2, "angles" => 26, 'prize' => '50元代金券', 'v' => 40),
//            '2' => array('id' => 3, "angles" => 88, 'prize' => '10元代金券', 'v' => 0),
//            '3' => array('id' => 4, "angles" => 137, 'prize' => '60元代金券', 'v' => 25),
//            '4' => array('id' => 5, "angles" => 185, 'prize' => '70元代金券', 'v' => 25),
//            '5' => array('id' => 6, "angles" => 235, 'prize' => '100元代金券', 'v' => 5),
//        );

        /*
         * 每次前端页面的请求，PHP循环奖项设置数组， 
         * 通过概率计算函数get_rand获取抽中的奖项id。 
         * 将中奖奖品保存在数组$res['yes']中， 
         * 而剩下的未中奖的信息保存在$res['no']中， 
         * 最后输出json个数数据给前端页面。 
         */
        foreach ($prize_arr as $key => $val) {
            $arr[$val['lid']] = $val['v'];
        }
        $rid = get_rand($arr); //根据概率获取奖项id    
        $res['yes'] = $prize_arr[$rid - 1]; //中奖项   
//        unset($prize_arr[$rid - 1]); //将中奖项从数组中剔除，剩下未中奖项   
//        shuffle($prize_arr); //打乱数组顺序   
//        for ($i = 0; $i < count($prize_arr); $i++) {
//            $pr[] = $prize_arr[$i]['prize'];
//        }
//        $res['no'] = $pr;

        echo json_encode($res["yes"]);
    }

    public function datalist() {
        $dataType = I("param.dataType");
        $limit = I("param.total");
        $openids = I("param.openid");

        $oauth2 = new \Home\Controller\Oauth2Controller();
        $data = $oauth2->getOpenId($_GET['code']);
        $openid = json_decode($data);
        $userinfo = json_decode($oauth2->getUserInfo($openid->openid));
        //将用户信息保存（如果不存在的话）
        if (!empty($userinfo->openid)) {
            $_SESSION['openid'] = $userinfo->openid;
        }
        $where['openid'] = $_SESSION['openid'];
        $user = M("wechat_user")->where($where)->find();
        if ($user['id'] == "" && $userinfo->openid != "") {
            $u['openid'] = $userinfo->openid;
            $u['nickname'] = $userinfo->nickname;
            $u['subscribe'] = $userinfo->subscribe;
            $u['is_lottery'] = 0;
            $u['created'] = time();
            M("wechat_user")->data($u)->add();
        } else {
            if (!empty($userinfo->openid)) {
                $user['subscribe'] = $userinfo->subscribe;
                M("wechat_user")->data($user)->save();
            }
        }

        if ($dataType == "dataJson") {
            $list = M("hkreturn_record")->table('w_hkreturn_record')->join('w_hkreturn_prize on w_hkreturn_record.lottery = w_hkreturn_prize.id')->where(array('w_hkreturn_record.openid' => $openids
                    ))->field("w_hkreturn_prize.prize,w_hkreturn_record.created")->order(array("created" => "desc"))->limit(0, $limit)->select();
            foreach ($list as &$val) {
                $val['created'] = date("Y-m-d H:i", $val['created']);
            }
            echo json_encode($list);
        } else {
            $this->user = $user;
            $this->theme("default")->display("HkReturn/lists");
        }
    }

    public function goods() {
        $lottery_prize = M("hkreturn_prize")->field("prize,number")->order(array("lid" => "desc"))->select();
        echo json_encode($lottery_prize);
    }

    public function goodsNumber() {
        $ip = get_client_ip();
        if ($ip == "220.152.193.11") { 
            $now = time();
            $beginTime = strtotime(date('Y-m-d 00:00:00', $now));
            $endTime = strtotime(date('Y-m-d 23:59:59', $now));
            if ($now > $beginTime and $now < $endTime) {
                $lottery_prize = M("hkreturn_prize")->field("lid,number,v")->order(array("lid" => "desc"))->select();
                foreach ($lottery_prize as $v) {
                    $map["lid"] = $v["lid"];
                    $v['number'] = 80;
                    switch ($v["lid"]) {
                        case 6:
                            $v["v"] = 50;
                            break;
                        case 5:
                            $v["v"] = 20;
                            break;
                        case 4:
                            $v["v"] = 15;
                            break;
                        case 3:
                            $v["v"] = 5;
                            break;
                        case 2:
                            $v["v"] = 5;
                            break;
                        case 1:
                            $v["v"] = 5;
                            break;
                    }
                    $d = M("hkreturn_prize")->where($map)->data($v)->save();
                }
                echo json_encode(array("code" => 200, "message" => "数据更新完成！"));
            } else {
                echo json_encode(array("code" => 500, "message" => "您访问的页面错误！"));
            }
        } else {
            echo json_encode(array("code" => 500, "message" => "您访问的页面错误！"));
        }
    }

    private function sendMessage($access_token, $openId, $amount, $time) {//发送信息通知到指定人员         
        $xjson = '      {
           "touser":"' . $openId . '",
           "template_id":"ZmbZpfSnKvDofxTs_dbDeETA5x7CBWWS7wPRsrC1AJQ", 
           "url":"", 
           "data":{
                   "first": {
                       "value":"付款中奖金额购买长相思！",
                       "color":"#000000"
                   },
                   "keyword1":{
                       "value":"' . $amount . '",
                       "color":"#000000"
                   },
                   "keyword2": {
                       "value":"' . $time . '",
                       "color":"#000000"
                   },  
                   "remark":{
                       "value":"请联系客服人员咨询，感谢你的参与!",
                       "color":"#000000"
                   }
           }
       }';
        $PostUrl = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token;
//        $value = $this->vpost($PostUrl, $xjson);
        $value = \Home\Common\Common::PData($PostUrl, $xjson);
        $this->logger($value);
        return $value;
    }

    //日志记录
    private function logger($log_content) {
        $filename = "Public/Data/logs/Lottery" . date("Y-m-d") . ".txt";
        $k = fopen($filename, "a+");
        fwrite($k, "\n" . date("Y-m-d H:i:s") . ":" . $log_content);
        fclose($k);
    }

}
