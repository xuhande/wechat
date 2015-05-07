<?php

namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller {

 


    public function index() { 
        if (!v_islogin()) {
            $this->success('请登录', U("Admin/User/Login"));
        } else {
             $this->theme(v_option('theme'))->display('Admin/index'); 
        }
    }


}
