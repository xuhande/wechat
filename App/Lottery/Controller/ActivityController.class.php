<?php

namespace Lottery\Controller;

use Think\Controller;

class ActivityController extends Controller {
    /* 2016年1月品酒会线下活动抽奖，查询和保存抽奖数据
     * 
     * @author Handexu <hande.xu@yzp2p.com>
     * @version 1.0
     *  
     */

    public function index() {
        $type = I("param.type");
        $data = M("activity")->where(array("num"=>array('neq',1)))->select(); 
//        foreach ($data as &$v){
//            $v['mobile'] = substr_replace($v['mobile'],"xxxxxxx",0,7);
//        } 
        $this->data = $data ? json_encode($data) : "1";
        $this->theme("default")->display("xxcj/index");
    }

    public function sends() {
        $mobile = I("param.mobile");
        if ($mobile != "") {  
           $data['num'] = "1";
           $data['created'] = time();
            $result = M("activity")->where(array("mobile"=>$mobile))->save($data);
            $this->ajaxReturn(array("code" => "200"));
        }else{
            $this->ajaxReturn(array("code" => "202","message"=> "参选的手机号码已抽选完！"));
        }
            
    }

}
