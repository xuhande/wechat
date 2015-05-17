<?php

namespace Pay;

class MD5SignUtil {

    function sign($content, $key) {
        try {
            if (null == $key) {
//                throw new SDKRuntimeException("财付通签名key不能为空！" . "<br>");
                throw new SDKRuntimeException("CFT sign key can't null！" . "<br>");
            }
            if (null == $content) {
//                throw new SDKRuntimeException("财付通签名内容不能为空" . "<br>");
                throw new SDKRuntimeException("CFT sign content can't null " . "<br>");
            }
            $signStr = $content ."&key=". $key;

//            print_r("》》》".$signStr."《《《");
            return strtoupper(md5($signStr));
        } catch (SDKRuntimeException $e) {
            die($e->errorMessage());
        }
    }

    function verifySignature($content, $sign, $md5Key) {
        $signStr = $content . "&key=" . $md5Key;
        $calculateSign = strtolower(md5($signStr));
        $tenpaySign = strtolower($sign);
        return $calculateSign == $tenpaySign;
    }

}

?>