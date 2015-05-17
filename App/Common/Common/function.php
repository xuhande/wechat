<?php

//--------------- PUBLIC ---------------// 
//调用option
function v_option($meta_key, $type = 'public') {
    return M('option')->where("meta_key='$meta_key' AND type='$type'")->getField('meta_value');
}

/**
 * meta 
 * @return string
 */
//调用meta
function v_meta($meta_key, $type = 'public') {
    return M('meta')->where("meta_key='$meta_key' AND type='$type'")->getField('meta_value');
}

/**
 * 检查是否存在这个key
 * @param type $meta_key
 * @return type
 */
function v_check_meta($meta_key) {
    return M('meta')->where("meta_key='$meta_key'")->getField('meta_key');
}

//网站地址
function v_site_url() {
	return  M('option')->where("meta_key='site_url'")->getField('meta_value');
//    return  "http://localhost:8009";
}
//title
function v_title() {
    $title ="";
    //MODULE_NAME get HOME
    //CONTROLLER_NAME get controler
    //ACTION_NAME get action name
    if(MODULE_NAME == "Cork"){
        
        $title = "脑洞有多大，奖品就有多大！";
    }
    else if(MODULE_NAME == "Admin"){
        $title = "admin manager";
    }
  
	 
    
    
	return $title;
    //return  "http://localhost";
}
 

//模板目录
function v_theme_url() {
    return v_site_url() . '/Theme/default';
}

/**
 * 加载公共模板
 */
function v_template_part($data) {
    echo W("Common/Public/index", array("data"=>$data));
}
 

function v_islogin() {
    $value = $_SESSION['admin_user'];
    if ($value != "") {
        return true;
    } else {
        return false;
    }
};
function v_meta_seo() {
    
    $list = M("meta")->select();
    $meta = "";
    foreach ($list as $v){
        $meta .= '<meta name="'.$v['meta_key'].'" content="' . $v['meta_value'] . '">'; 
    }
//    $keywords = v_meta("site_keywords"); //"java,php,WEB前端,web前端开发,javascript,HTML,css,技术随笔";//mc_option('article_keywords');
//    $description = v_meta("site_description"); //mc_option('article_description');
   
    return $meta;
}

//获取用户真实IP
function v_user_ip() {
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } elseif (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    } elseif (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
        $ip = getenv("REMOTE_ADDR");
    } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
        $ip = $_SERVER['REMOTE_ADDR'];
    } else {
        $ip = "unknown";
    };
    return $ip;
}

 
 


//HTML危险标签过滤
function v_remove_html($str) {
    $str = htmlspecialchars_decode($str);
    $str = preg_replace("/\s+/", " ", $str); //过滤多余回车 
    $str = preg_replace("/<[ ]+/si", "<", $str); //过滤<__("<"号后面带空格) 

    $str = preg_replace("/<\!--.*?-->/si", "", $str); //注释 
    $str = preg_replace("/<(\!.*?)>/si", "", $str); //过滤DOCTYPE 
    $str = preg_replace("/<(\/?html.*?)>/si", "", $str); //过滤html标签 
    $str = preg_replace("/<(\/?head.*?)>/si", "", $str); //过滤head标签 
    $str = preg_replace("/<(\/?meta.*?)>/si", "", $str); //过滤meta标签 
    $str = preg_replace("/<(\/?body.*?)>/si", "", $str); //过滤body标签 
    $str = preg_replace("/<(\/?link.*?)>/si", "", $str); //过滤link标签 
    $str = preg_replace("/<(\/?form.*?)>/si", "", $str); //过滤form标签 
    $str = preg_replace("/cookie/si", "COOKIE", $str); //过滤COOKIE标签 

    $str = preg_replace("/<(applet.*?)>(.*?)<(\/applet.*?)>/si", "", $str); //过滤applet标签 
    $str = preg_replace("/<(\/?applet.*?)>/si", "", $str); //过滤applet标签 

    $str = preg_replace("/<(style.*?)>(.*?)<(\/style.*?)>/si", "", $str); //过滤style标签 
    $str = preg_replace("/<(\/?style.*?)>/si", "", $str); //过滤style标签 

    $str = preg_replace("/<(title.*?)>(.*?)<(\/title.*?)>/si", "", $str); //过滤title标签 
    $str = preg_replace("/<(\/?title.*?)>/si", "", $str); //过滤title标签 

    $str = preg_replace("/<(object.*?)>(.*?)<(\/object.*?)>/si", "", $str); //过滤object标签 
    $str = preg_replace("/<(\/?objec.*?)>/si", "", $str); //过滤object标签 

    $str = preg_replace("/<(noframes.*?)>(.*?)<(\/noframes.*?)>/si", "", $str); //过滤noframes标签 
    $str = preg_replace("/<(\/?noframes.*?)>/si", "", $str); //过滤noframes标签 

    $str = preg_replace("/<(i?frame.*?)>(.*?)<(\/i?frame.*?)>/si", "", $str); //过滤frame标签 
    $str = preg_replace("/<(\/?i?frame.*?)>/si", "", $str); //过滤frame标签 

    $str = preg_replace("/<(script.*?)>(.*?)<(\/script.*?)>/si", "", $str); //过滤script标签 
    $str = preg_replace("/<(\/?script.*?)>/si", "", $str); //过滤script标签 
    $str = preg_replace("/javascript/si", "Javascript", $str); //过滤script标签 
    $str = preg_replace("/vbscript/si", "Vbscript", $str); //过滤script标签 
    $str = preg_replace("/on([a-z]+)\s*=/si", "On\\1=", $str); //过滤script标签 
    $str = preg_replace("/&#/si", "&＃", $str); //过滤script标签

    return $str;
}


/**
 * send message to openid
 * @param type $openid openid
 * @param type $content content
 * @return type
 */
function sendMessage($openid,$content){
    
        \Home\Common\Common::setrep();
        $accessToken = $_SESSION["tokens"]; //获取access_token   
        $xjson = '
     {
    "touser":"'.$openid.'",
    "msgtype":"text",
    "text":
    {
         "content":"'.$content.'"
    }
}
         ';
        $PostUrl = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $accessToken; //POST的url  
        $value = \Home\Common\Common::PData($PostUrl, $xjson);
        $datas = json_decode($value, ture);
      

        return $value;
}




?>
