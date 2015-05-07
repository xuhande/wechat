<?php

namespace Cork\Controller;

use Think\Controller;
use \Pay\WxHongBaoHelper;
use \Pay\CommonUtil;

include_once("App/Home/pay/WxHongBaoHelper.php");

class IndexController extends Controller {

    /**
     * 
     */
    public function index() {

        $this->theme("default")->display("Cork/index");
    }

    public function cork() {
        $id = $_GET["corkid"];
        $cork = M("cork")->where(array("id" => $id))->select();
        echo json_encode($cork);
    }

    public function success($openid) {

        $cork = M("cork")->where(array("openid" => $openid))->select();
        $this->assign('cork', $cork);
        $this->theme("default")->display("Cork/success");
    }

    public function corkList() {
//        $pagesize = 6;


        $cork = M('cork'); // 实例化Data数据对象
//        $map['tag'] = array('like', "%" . $tag . "%");
        $map['check'] = "2";
        $map['del'] = "0";

        $count = $cork->where($map)->count(); // 查询满足要求的总记录数 $map表示查询条件

        $votecount = M('vote')->count();

//        $Page = new \Think\Page($count, $pagesize); // 实例化分页类 传入总记录数(这是根据@979137的意见修改的,这个建议非常好!)
//        $totalpage = ceil($Page->totalRows / $pagesize);
//        $show["total_page"] = $totalpage; // 分页显示输出
//        $show["curr_page"] = $Page->parameter['p']; // 分页显示输出
        // 进行分页数据查询

        $orderby['canid'] = 'asc';
        $corklist = array();
//        $list = $cork->order($orderby)->limit($Page->firstRow . ',' . $Page->listRows)->where($map)->select();
        $list = $cork->order($orderby)->where($map)->select();
        foreach ($list as $v) {
            $singlecount = M("vote")->where(array("corkid" => $v['id']))->count();
            $v['votecount'] = $singlecount;
            $corklist[$v['id']] = $v;
        }

        $data = array(
            "corklist" => $corklist,
            "votecount" => $votecount
        );

        $next_page_url = "?m=Cork&&a=corklist&p=";
        $this->assign('islastpage', "0");
        if ($Page->parameter['p'] == "") {
            $Page->parameter['p'] = 1;
        }
        if ($Page->parameter['p'] < 1) {
            $next_page_url .= 1;
        } else if ($Page->parameter['p'] < $totalpage) {
            $next_page_url .= $Page->parameter['p'] + 1;
        } else if ($Page->parameter['p'] >= $totalpage) {
            $next_page_url .= $totalpage;
            $this->assign('islastpage', "1");
        }


        $this->assign('corklist', $data); // 赋值数据集
//print_r($Page->show());die;
        $this->assign('page', $show); // 赋值分页输出

        $this->assign('next_page_url', $next_page_url); // 赋值分页输出

        $this->theme("default")->display('Cork/list');
    }

    public function vote() {

        $vote_openid = I("param.voteopenid"); //vote openid 
        $corkid = I("param.corkid");

        $map['voteopenid'] = $vote_openid;
//        $map['type'] = array('like', "article");

        $count = M('vote')->where($map)->count(); // 查询满足要求的总记录数 $map表示查询条件
        //先发红包，然后判断红包是否发放成功，然后在把投票的保存到数据库


        if ($count <= 0) {
            $res = self::sendRedPack($vote_openid);
            if ($res == "300") { //没有红包了
                echo "300";
            } else {  //发放成功
                $map['corkid'] = $corkid;
                $map['created'] = time();
                M('vote')->data($map)->add();
                echo "200";
            }
        } else {
            echo "309";
        }



//        if ($count <= 0) {
//            $map['corkid'] = $corkid;
//            $map['created'] = time();
//            M('vote')->data($map)->add();
//            $res = self::sendRedPack($vote_openid);
//            if ($res == "300") {
//                echo "300";
//            } else if ($res == "200") {
//                echo "200";
//            }
//        } else {
//            echo "309";
//        }
    }

    public function sendRedPack($openid) {
        $s = new \Home\Controller\RedpackController();
        return $s->index($openid);
    }

    /**
     * save send success redpack
     */
    public function saveSendRedPack($responseObj, $content) {
        $page['mch_billno'] = $responseObj->mch_billno . "";
        $page['mch_id'] = $responseObj->mch_id . "";
        $page['wxappid'] = $responseObj->wxappid . "";
        $page['re_openid'] = $responseObj->re_openid . "";
        $page['total_amount'] = $responseObj->total_amount . "";
        $page['content'] = $content;
        $page['type'] = "1";
        M('redpack')->data($page)->add();
    }

    /**
     * check database extens curr openid
     * @param type $openid
     */
    public function checkSaveByOpenId($openid) {
        $count = M("cork")->where(array("openid" => $openid))->count();
        if ($count <= 0) {
            return "200";
        } else {
            return $openid;
        }
    }

    public function save() {
        $subscribe = $_POST['subscribe'];
        if (!$subscribe) {
//            if (!true) {
            echo "303";
        } else {


            $path = $_POST['path'];
            $name = $_POST['name'];
            $mobile = $_POST['mobile'];
            $title = $_POST['title'];
//            $idno = $_POST['idno']; //$("input[name*='idno']").val();
            $summary = $_POST['summary']; //$("textarea[name*='summary']").val();
            $openid = $_POST['openid'];
            $nickname = $_POST['nickname'];
            $paths = "";
            $data = array();
            foreach ($path as $v) {
                $paths .=$v;
            }

            $data['imgpath'] = $paths;
            $data['name'] = $name;
            $data['mobile'] = $mobile;
            $data['title'] = $title;
            $data["del"] = "0";

//            $data['idno'] = $idno;
            $data['openid'] = $openid;
            $data['summary'] = $summary;
            $data['nickname'] = $nickname;

            $data['check'] = "0"; //check default no check, so value == 0 
            $data['created'] = time();

            $count = M("cork")->where(array("openid" => $openid))->count();






            if ($count <= 0) {
                M('cork')->data($data)->add();
                sendMessage($openid, "您的作品已提交，正在审核中，请耐心等候。");
                echo "200";
            } else {
                echo "201";
            }
        }
    }

    /**
     * upload function 
     */
    public function upload() {


// Make sure file is not cached (as it happens for example on iOS devices)
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");


// Support CORS
// header("Access-Control-Allow-Origin: *");
// other CORS headers if any...
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit; // finish preflight CORS requests here
        }


        if (!empty($_REQUEST['debug'])) {
            $random = rand(0, intval($_REQUEST['debug']));
            if ($random === 0) {
                header("HTTP/1.0 500 Internal Server Error");
                exit;
            }
        }

// header("HTTP/1.0 500 Internal Server Error");
// exit;
// 5 minutes execution time
        @set_time_limit(5 * 60);

// Uncomment this one to fake upload time
// usleep(5000);
// Settings
// $targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
        $targetDir = 'upload_tmp';
        $uploadDir = 'upload/' . $_REQUEST['file_dir_asd'];

        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds
// Create target dir
        if (!file_exists($targetDir)) {
            @mkdir($targetDir);
        }

// Create target dir
        if (!file_exists($uploadDir)) {
            @mkdir($uploadDir);
        }

// Get a file name
        if (isset($_REQUEST["name"])) {
            $fileName = $_REQUEST["name"];
        } elseif (!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
        } else {
            $fileName = uniqid("file_");
        }

        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
        $uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

// Chunking might be enabled
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;


// Remove old temp files
        if ($cleanupTargetDir) {
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
            }

            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                // If temp file is current file proceed to the next
                if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
                    continue;
                }

                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }


// Open temp file
        if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }

            // Read binary input stream and append it to temp file
            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        } else {
            if (!$in = @fopen("php://input", "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }

        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }

        @fclose($out);
        @fclose($in);

        rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");

        $index = 0;
        $done = true;
        for ($index = 0; $index < $chunks; $index++) {
            if (!file_exists("{$filePath}_{$index}.part")) {
                $done = false;
                break;
            }
        }
        if ($done) {
            if (!$out = @fopen($uploadPath, "wb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
            }

            if (flock($out, LOCK_EX)) {
                for ($index = 0; $index < $chunks; $index++) {
                    if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
                        break;
                    }

                    while ($buff = fread($in, 4096)) {
                        fwrite($out, $buff);
                    }

                    @fclose($in);
                    @unlink("{$filePath}_{$index}.part");
                }

                flock($out, LOCK_UN);
            }
            @fclose($out);
        }

// Return Success JSON-RPC response
        die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
    }

}
