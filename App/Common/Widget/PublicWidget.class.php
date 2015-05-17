<?php

namespace Common\Widget;

use Think\Controller;

class PublicWidget extends Controller {

    public function index($data) {
 $path = $data['path'];
 $name = $data['name'];
 
   $this->assign('data', $data);
        $this->display("$path:$name");
    }

   

}
