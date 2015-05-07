<?php

namespace Home\Controller;

use Think\Controller;

class SuggestionController extends Controller {

    public function index() {
       //$this->display();
         $this->theme("default")->display('Suggestion/index');
    } 
 public function pSuggestion() {
        $name = $_POST['realName'];
        $email = $_POST['email'];
        $content = $_POST['content'];
        $this->recordText($name, $email, $content);
        header("Content-Type:text/html;   charset=utf-8");
        header("refresh:5;url=/Home/suggestion");
        print_r(""
                . "<!DOCTYPE html>
                <html>
                    <head>
                        <meta charset='utf-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=no' /> 
                        <title></title>
                        <link rel='stylesheet' type='text/css' href='/Public/css/wx.css'>
                        <script type='text/javascript' src=/Public/js/jquery-1.8.2.min.js'></script>

                    </head>
                    <body>"
                . "</style>"
                . "<div class='alert1';><p>感谢您宝贵的意见及建议，我们将通过邮件联系您！<p>"
                . "<p style='margin-top:20px;'><a href='/?m=home&c=Suggestion' class='btn btn-success' style='width:80px'>确定</a></p>"
                . "</div>");
    }

    private function recordText($name, $email, $content) {
        $data = 'array("姓名"=>"' . $name . '","邮箱"=>"' . $email . '","留言"=>"' . $content . '","时间"=> ' . date("Y-m-d H:i:s") . ')';
//        var_dump($data);
        $filename = "Public/Data/suggestion/suggestions_" . date("Y-m-d") . ".txt";
        $k = fopen($filename, "a+");
        fwrite($k, "\n" . $data);
        fclose($k);
    }
 
}
