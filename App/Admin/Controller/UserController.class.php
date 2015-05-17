<?php

namespace Admin\Controller;

use Think\Controller;

class UserController extends Controller {

    public function login() {

        if (IS_POST) {

            $name = I('param.username');
            $password = I('param.password');

            $map['username'] = $name;
            $map['password'] = md5($password);
//        $map['type'] = array('like', "article");

            $count = M('user')->where($map)->count(); // 查询满足要求的总记录数 $map表示查询条件

            if ($count >= 1) {

                $_SESSION['admin_user'] = $name;
                $this->success('登录成功', U("Admin/Index/Index"));
            } else {
                $this->error('登录失败', U("Admin/User/Login"));
            }
        } else {
            $this->theme(v_option('theme'))->display('Admin/login');
        }
    }

    public function loginOut() {
//        session('admin_user', "");  //设置session
        $_SESSION['admin_user'] = "";
        $this->theme(v_option('theme'))->display('Admin/login');
    }

    public function index() {
        $this->theme("default")->display('Admin/index');
    }

    public function changePass() {
        if (!v_islogin()) {
            $this->error('请登录', U("Admin/User/Login"));
        } else {
            if (IS_POST) {

              
                $password = I('param.password');
                $newpass = I('param.new-password');
                $map['username'] = $_SESSION['admin_user'];
                $map['password'] = md5($password); 

                $count = M('user')->where($map)->select(); // 查询满足要求的总记录数 $map表示查询条件
               
                if($count){
                    //change 
                    print_r($count[0]['password']);
                    
                    $count[0]['password'] = md5($newpass);
                      M('user')->data($count[0])->save();
                     $this->success('修改成功', U("Admin/User/profile"),3);
                }else{
                    //no change
                     $this->error('旧密码错误，请重新输入', U("Admin/User/profile"),5);
                }
                
            } else {
                $this->theme(v_option('theme'))->display('Admin/profile');
            }
        }
    }

    public function profile() {
        $this->theme("default")->display('Admin/profile');
    }

}
