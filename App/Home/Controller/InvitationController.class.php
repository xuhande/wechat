<?php

namespace Home\Controller;

use Think\Controller;

class InvitationController extends Controller {

    public function index() {       

        $this->theme("default")->display("invitation/index");
    }  

}
