<?php 
namespace Pay;
class CommonUtil{
	/**
	 * 
	 * 
	 * @param toURL
	 * @param paras
	 * @return
	 */
	function genAllUrl($toURL, $paras) {
		$allUrl = null;
		if(null == $toURL){
			die("toURL is null");
		}
		if (strripos($toURL,"?") =="") {
			$allUrl = $toURL . "?" . $paras;
		}else {
			$allUrl = $toURL . "&" . $paras;
		}

		return $allUrl;
	}
	function create_noncestr( $length = 16 ) {  
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";  
		$str ="";  
		for ( $i = 0; $i < $length; $i++ )  {  
			$str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
			//$str .= $chars[ mt_rand(0, strlen($chars) - 1) ];  
		}  
//                echo $str."<br>";
		return $str;  
	}
	/**
	 * 
	 * 
	 * @param src
	 * @param token
	 * @return
	 */
	function splitParaStr($src, $token) {
		$resMap = array();
		$items = explode($token,$src);
		foreach ($items as $item){
			$paraAndValue = explode("=",$item);
			if ($paraAndValue != "") {
				$resMap[$paraAndValue[0]] = $parameterValue[1];
			}
		}
		return $resMap;
	}
	
	/**
	 * trim 
	 * 
	 * @param value
	 * @return
	 */
	static function trimString($value){
		$ret = null;
		if (null != $value) {
			$ret = $value;
			if (strlen($ret) == 0) {
				$ret = null;
			}
		}
		return $ret;
	}
	
	function formatQueryParaMap($paraMap, $urlencode){
		$buff = "";
		ksort($paraMap);
		foreach ($paraMap as $k => $v){
			if (null != $v && "null" != $v && "sign" != $k) {
			    if($urlencode){
				   $v = urlencode($v);
				}
				$buff .= $k . "=" . $v . "&";
			}
		}
		$reqPar;
		if (strlen($buff) > 0) {
			$reqPar = substr($buff, 0, strlen($buff)-1);
		}
		return $reqPar;
	}
	function formatBizQueryParaMap($paraMap, $urlencode){
		$buff = "";
		ksort($paraMap);
		foreach ($paraMap as $k => $v){
		//	if (null != $v && "null" != $v && "sign" != $k) {
			    if($urlencode){
				   $v = urlencode($v);
				}
				$buff .= strtolower($k) . "=" . $v . "&";
			//}
		}
		$reqPar; 
		if (strlen($buff) > 0) {
			$reqPar = substr($buff, 0, strlen($buff)-1);
		}
		return $reqPar;
	}
	function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
//        	 if (is_numeric($val))
//        	 {
//        	 	$xml.="<".$key.">".$val."</".$key.">"; 
//
//        	 }
//        	 else
        	 	$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";  
        }
        $xml.="</xml>";
        return $xml; 
    }
	
}


//<xml>
//  <act_name><!--[CDATA[[VYNFIELDS]抢红包活动]]--></act_name>
//  <client_ip><!--[CDATA[127.0.0.1]]--></client_ip>
//  <max_value><!--[CDATA[100]]--></max_value>
//  <mch_billno><!--[CDATA[10035198201502131028144463]]--></mch_billno>
//  <mch_id><!--[CDATA[10035198]]--></mch_id>
//  <min_value><!--[CDATA[100]]--></min_value>
//  <nick_name><!--[CDATA[VYNFIELDS]]--></nick_name>
//  <nonce_str><!--[CDATA[LjDKXjQbDF6oNMYp]]--></nonce_str>
//  <re_openid><!--[CDATA[ou9X8tl0p-rfJcmRriSrj2QP144s]]--></re_openid>
//  <remark><!--[CDATA[亲,请告诉你的朋友一起来抢红包吧!]]--></remark>
//  <send_name><!--[CDATA[VYNFIELDS]]--></send_name>
//  <total_amount><!--[CDATA[100]]--></total_amount>
//  <total_num><!--[CDATA[1]]--></total_num>
//  <wishing><!--[CDATA[感谢您参加VYNFIELDS抢红包，祝您新年快乐！]]--></wishing>
//  <wxappid><!--[CDATA[wx9a34fd34e14f1103]]--></wxappid>
//  <sign><!--[CDATA[DBC7AE3C9425E24D806BDC945CD4D867]]--></sign>
//      </xml>
      


?>