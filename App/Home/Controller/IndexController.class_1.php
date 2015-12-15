<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller {

    public function index() { 
        $wechatObj = new WechatController();
        if (!isset($_GET['echostr'])) {
            echo "responseMsg";
            $wechatObj->responseMsg(); 
        } else {
            echo "valid";
            $wechatObj->valid();
        }
         
        $Menus = new MenuController();//实例化微信类$ 
        $creatMenu = $Menus->creatMenu();//创建菜单
        $this->logger("index:".  time());
    }
      private function logger($log_content) {
        $filename = "Public/Data/logs/wechat_index" . date("Y-m-d") . ".txt";
        $k = fopen($filename, "a+");
        fwrite($k, "\n" . date("Y-m-d H:i:s") . ":" . $log_content);
        fclose($k);
    }
        public function getbyfilter() {
//                 $getByfilter = new ByfilterController();
//                 $getByfilter->index();

//        ByfilterController::getUser(); 
    }
//     public function redTest() {
//
//        $red = new RedpackController();
//        $red->index();
//
////        $red = new RedController();
////        $red -> index();
//    }
    public function store(){
        
        $this->theme("default")->display("store/index");
    }
}
