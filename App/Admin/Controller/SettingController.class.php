<?php

namespace Admin\Controller;

use Think\Controller;

class SettingController extends Controller {

    public function index() {

        if (!v_islogin()) {
            $this->error('请登录', U("Admin/User/Login"));
        } else {
            $meta = M('meta');
            $list = $meta->select();
            $this->assign('meta', $list); // 赋值数据集
            $this->theme("default")->display('Admin/Setting/meta');
        }
    }

    public function meta() {


        self::index();
    }

    public function option() {

        if (!v_islogin()) {
            $this->error('请登录', U("Admin/User/Login"));
        } else {
            $meta = M('option');
            $list = $meta->select();
            $this->assign('option', $list); // 赋值数据集
            $this->theme("default")->display('Admin/Setting/option');
        }
    }

//     public function edit() {
//        $this->theme("default")->display('Admin/Article/edit');
//    }

    /**
     * 保存
     */
    public function saveMeta() {
        if (!v_islogin()) {
            $this->success('请登录', U("Admin/User/Login"));
        } else {
            if (IS_POST) {
                $page['id'] = I('param.id');
                $page['meta_key'] = I('param.meta_key');
                $page['meta_value'] = I('param.meta_value');
$page['type'] = I('param.type');
                if ($page['id'] == "") {
                    $result = M('meta')->data($page)->add();
                } else {
                    $result = M('meta')->data($page)->save();
                }

                $this->success('发布成功.');
            } else {
                $this->error('你干啥呢？');
            }
        }
    }

    /**
     * 删除
     */
    public function deleteMeta($id) {
        if (!v_islogin()) {
            $this->success('请登录', U("Admin/User/Login"));
        } else {
            if (!is_numeric($id)) {
                $this->error('参数错误');
            }
            $meta = M("meta");
            $result = $meta->where('id=' . $id)->delete();
            if ($result) {
                $this->success('删除成功.');
            } else {
                $this->error('删除失败，请重试.');
            }
        }
    }

    public function saveOption() {
        if (!v_islogin()) {
            $this->success('请登录', U("Admin/User/Login"));
        } else {
            if (IS_POST) {
                $page['id'] = I('param.id');
                $page['meta_key'] = I('param.meta_key');
                $page['meta_value'] = I('param.meta_value');
$page['type'] = I('param.type');
                if ($page['id'] == "") {
                    $result = M('option')->data($page)->add();
                } else {
                    $result = M('option')->data($page)->save();
                }

                $this->success('发布成功.');
            } else {
                $this->error('你干啥呢？');
            }
        }
    }

    /**
     * 删除
     */
    public function deleteOption($id) {
        if (!v_islogin()) {
            $this->success('请登录', U("Admin/User/Login"));
        } else {
            if (!is_numeric($id)) {
                $this->error('参数错误');
            }
            $option = M("option");
            $result = $option->where('id=' . $id)->delete();
            if ($result) {
                $this->success('删除成功.');
            } else {
                $this->error('删除失败，请重试.');
            }
        }
    }

}
