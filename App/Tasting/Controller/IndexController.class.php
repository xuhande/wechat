<?php

namespace Photo\Controller;

use Think\Controller;

class IndexController extends Controller {

    /**
     * 
     */
    public function index($category = "") {
        /**
         *  初始化文章
         */
        $Photo = M('photo'); // 实例化Data数据对象

        $map['category'] = array('like', "%" . $category . "%");

        $count = $Photo->where($map)->count(); // 查询满足要求的总记录数 $map表示查询条件

        $Page = new \Think\Page($count, 5); // 实例化分页类 传入总记录数(这是根据@979137的意见修改的,这个建议非常好!)

        $show = $Page->show(); // 分页显示输出
        // 进行分页数据查询

        $orderby['id'] = 'desc';

        $list = $Photo->order($orderby)->limit($Page->firstRow . ',' . $Page->listRows)->where($map)->select();



        $this->assign('photo', $list); // 赋值数据集

        $next_page_url = "?m=Photo&c=Index&a=index&category=" . $category . "&p=";
        $this->assign('islastpage', "0");
        if ($Page->nowPage < 1) {
            $next_page_url .= 1;
        } else if ($Page->nowPage < $Page->totalPages) {
            $next_page_url .= $Page->nowPage + 1;
        } else if ($Page->nowPage >= $Page->totalPages) {
            $next_page_url .= $Page->totalPages;
            $this->assign('islastpage', "1");
        }

        $this->assign('next_page_url', $next_page_url); // 赋值分页输出

        $this->theme("default")->display("Public/photolist");
    }

    public function getCategory() {
        $temp = M('photo')->field('category')->select();
    $res = array();
    foreach ($temp as $key => $value) {
        foreach (explode(",", $value["category"]) as $k => $v) {
            $res[] = $v;
        }
    }


    echo json_encode(array_unique($res));
        
        
        
    }

    public function download($imgid) {
        $photo = M('photo')->where("id='$imgid'")->select();
        $name = substr($photo[0]['path'], strrpos($photo[0]['path'], "/", 0) + 1);

        // header('Content-Disposition: attachment; filename="'.$name.'"');
        //readfile($photo[0]['path']);
        $path = $photo[0]['path'];

        header('Content-type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $name);
        header("Content-Length:" . filesize($name));
        ob_clean();
        flush();
        readfile($path);
    }

}
