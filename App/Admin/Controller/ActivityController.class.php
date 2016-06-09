<?php

namespace Admin\Controller;

use Think\Controller;

class ActivityController extends Controller {

    public function index() {
        $pagesize = 5;

        if (!v_islogin()) {
            $this->error('请登录', U("Admin/User/Login"));
        } else {

            /**
             *  初始化文章
             */
            $Article = M('cork'); // 实例化Data数据对象
//        $map['type'] = array('like', "article");

            $count = $Article->where($map)->count(); // 查询满足要求的总记录数 $map表示查询条件

            $Page = new \Think\Page($count, $pagesize); // 实例化分页类 传入总记录数(这是根据@979137的意见修改的,这个建议非常好!)

            $totalpage = ceil($Page->totalRows / $pagesize);

            $show["total_page"] = $totalpage; // 分页显示输出
            $show["curr_page"] = $Page->parameter['p']; // 分页显示输出
            // 进行分页数据查询

            $orderby['canid'] = 'desc';

            $list = $Article->order($orderby)->limit($Page->firstRow . ',' . $Page->listRows)->select();



            $this->assign('cork', $list); // 赋值数据集
//print_r($Page->show());die;
            $this->assign('page', $show); // 赋值分页输出



            $this->theme("default")->display('Admin/Activity/cork');
        }
    }

    public function cork() {
        self::index();
    }

    /**
     * 
     * update check value 
     * @param type $id  curr id
     * @param type $status   status: 0 or 1 
     */
    public function updateCheck() {

        if (!v_islogin()) {
            $this->error('请登录', U("Admin/User/Login"));
        } else {

            $status = I('param.status');
            $id = I('param.cork-id');
            $canid = I('param.canid');
            $content = I('param.content');


            $cork = M('cork')->where(array("id" => $id))->select();
            if ($cork) {
                $cork[0]['check'] = $status;
                $cork[0]['content'] = $content;
                $cork[0]['canid'] = $canid;
                M('cork')->data($cork[0])->save();

                if ($status == 1) {
                    self::delete($id);
                    sendMessage($cork[0]['openid'], "您的作品未通过审核，请按规则重新上传，如有疑问请联系客服。\n原因：" . $content . "\n点击链接重新上传:http://wx.mynow.net/?s=/Home/Oauth2/index/type/index");
                } else if ($status == 2) {
                    sendMessage($cork[0]['openid'], "您的作品已通过审核，详情请点击：http://wx.mynow.net/?s=/Home/Oauth2/index/type/index");
                }


                $this->success('审核成功', U("Admin/Activity/cork"), 3);
            } else {
                //no change
                $this->error('参数错误，ID未找到', U("Admin/Activity/cork"), 5);
            }
        }
    }

    public function delete($id) {

        if (!v_islogin()) {
            $this->error('请登录', U("Admin/User/Login"));
        } else {
            if (!is_numeric($id)) {
                $this->error('参数错误');
            }

            $cork = M("cork")->where('id=' . $id)->select(); //->delete();

            $cork[0]["openid"] = $cork[0]["openid"] . "_delete";
            $cork[0]["del"] = "1";

            $result = M('cork')->data($cork[0])->save();
            if ($result) {
                $this->success('删除成功.');
            } else {
                $this->error('删除失败，请重试.');
            }
        }
    }

    public function redelete($id) {

        if (!v_islogin()) {
            $this->error('请登录', U("Admin/User/Login"));
        } else {
            if (!is_numeric($id)) {
                $this->error('参数错误');
            }

            $cork = M("cork")->where('id=' . $id)->select(); //->delete();
            $openid = $cork[0]["openid"];
            $cork[0]["openid"] = substr($openid, 0, strripos($openid, "_"));
            $cork[0]["del"] = "0";

            $result = M('cork')->data($cork[0])->save();
            if ($result) {
                $this->success('恢复成功.');
            } else {
                $this->error('恢复失败，请重试.');
            }
        }
    }

    public function hkReturn() {
        $sUsername = I("param.username");
        $pagesize = 12;

        if (!v_islogin()) {
            $this->error('请登录', U("Admin/User/Login"));
        } else {

            $map['username'] = array('like', '%' . $sUsername . '%');
            print_r($map);
            /**
             *  初始化文章
             */
            $Article = M('hkreturn_record'); // 实例化Data数据对象
//        $map['type'] = array('like', "article");

            $count = $Article->where($map)->count(); // 查询满足要求的总记录数 $map表示查询条件
 
            $Page = new \Think\Page($count, $pagesize); // 实例化分页类 传入总记录数(这是根据@979137的意见修改的,这个建议非常好!)

            $totalpage = ceil($Page->totalRows / $pagesize);

            $show["total_page"] = $totalpage; // 分页显示输出
            $show["curr_page"] = $Page->parameter['p']; // 分页显示输出
            // 进行分页数据查询

            $orderby['w_hkreturn_record.created'] = 'desc';
            $list = M("hkreturn_record")->table('w_hkreturn_record')->join('w_hkreturn_prize on w_hkreturn_record.lottery = w_hkreturn_prize.id')
                            ->field("w_hkreturn_record.id,w_hkreturn_record.openid,w_hkreturn_record.username,w_hkreturn_prize.prize,w_hkreturn_record.created")->where($map)->order($orderby)->limit($Page->firstRow . ',' . $Page->listRows)->select();

//            $list = $Article->order($orderby)->limit($Page->firstRow . ',' . $Page->listRows)->select();



            $this->assign('sUsername', $sUsername); // 赋值数据集
            $this->assign('data', $list); // 赋值数据集
//print_r($Page->show());die;
            $this->assign('page', $show); // 赋值分页输出



            $this->theme("default")->display('Admin/Activity/hkReturn');
        }
    }

}
