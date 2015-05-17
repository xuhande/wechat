<?php

namespace Home\Controller;

use Think\Controller;

class MusicController {

    public function getMusicInfo($entity) {
        //$entitys=str_replace('点歌','',$entity); 
        if ($entity == "") {
            $music = "请输入如：”音乐恭喜发财”";
        } else {
            $url = "http://box.zhangmen.baidu.com/x?op=12&count=1&title=" . $entity . "$$";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $data = curl_exec($ch);
            $music = "没有找到这首歌曲，换首歌试试吧！" . $str;
            try {

                @$menus = simplexml_load_string($data, "SimpleXMLElement", LIBXML_NOCDATA);
                foreach ($menus as $menu) {

                    if (isset($menu->encode) && isset($menu->decode) && !strpos($menu->encode, "baidu.com") && strpos($menu->decode, ".mp3")) {

                        $result = substr($menu->encode, 0, strripos($menu->encode, '/') + 1) . $menu->decode;
                        if (!strpos($result, "?") && !strpos($result, "xcode")) {

                            $music = array("Title" => $entity, "Description" => "Vynfields酒庄之音乐", "MusicUrl" => urldecode($result), "HQMusicUrl" => urldecode($result));
                            break;
                        }
                    }
                }
            } catch (Exception $e) {
                
            }
        }

        return $music;
    }

}

?>
