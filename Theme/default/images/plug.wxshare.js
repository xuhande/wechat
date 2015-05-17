/*******************************
 * Copyright:智讯互动(www.zhixunhudong.com)
 * Author:Mr.Think
 * Description:微信分享通用代码
 * 使用方法：_WXShare('分享显示的LOGO','LOGO宽度','LOGO高度','分享标题','分享描述','分享链接','微信APPID(一般不用填)');
 *******************************/
function _WXShare(e,c,j,g,f,b,h){e=e||"http://a.zhixun.in/plug/img/ico-share.png";c=c||100;j=j||100;g=g||document.title;f=f||document.title;b=b||document.location.href;h=h||"";function i(){WeixinJSBridge.invoke("sendAppMessage",{appid:h,img_url:e,img_width:c,img_height:j,link:b,desc:f,title:g},function(l){_report("send_msg",l.err_msg)})}function a(){WeixinJSBridge.invoke("shareTimeline",{img_url:e,img_width:c,img_height:j,link:b,desc:f,title:g},function(l){_report("timeline",l.err_msg)})}function d(){WeixinJSBridge.invoke("shareWeibo",{content:f,url:b},function(l){_report("weibo",l.err_msg)})}document.addEventListener("WeixinJSBridgeReady",function k(){WeixinJSBridge.on("menu:share:appmessage",function(l){i()});WeixinJSBridge.on("menu:share:timeline",function(l){a()});WeixinJSBridge.on("menu:share:weibo",function(l){d()})},false)};
