<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Controller;

use Think\Controller;

session_start();

class GetByfilterController extends Controller {

    public function index($openId = null) {  
        if ($openId != null) {
//            $this->assign("list", GetByfilterController::byfilter(\Home\Common\Common::decode($openId)));
            $this->assign("list", GetByfilterController::byfilter($openId));
            $this->theme("default")->display('GetByfilter/index');
        } else {
            $this->theme("default")->display('GetByfilter/index');
        }
    }

    public function byfilter($openId) {
        
        \Home\Common\Common::setrep(); 
        $accessToken = $_SESSION["tokens"]; //获取access_token   
        $xjson = '
       {  
        }
         ';
        $PostUrl = "https://api.weixin.qq.com/merchant/order/getbyfilter?access_token=" . $accessToken; //POST的url  
        $value = \Home\Common\Common::PData($PostUrl, $xjson);
        $datas = json_decode($value, ture);
        $isnull = true;

//        $openId = "ou9X8tl0p-rfJcmRriSrj2QP144s";
//        $openId = "ou9X8tmgcfDo8PRv_kOQlaXsTE1U";
//        $openId = "ou9X8tsAIKJfcy86ynM9tXUKorbg"; 
        
        $arr = array();
        foreach ($datas['order_list'] as $tableName => $table) {
            if ($table['buyer_openid'] == $openId) {
                $arr[] = $table;
            }
        }

        $result = json_encode($arr);

        return $result;
    }

}
