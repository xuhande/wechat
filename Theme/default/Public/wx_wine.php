

<html class="ks-webkit537 ks-webkit ks-chrome21 ks-chrome">
<head>

<title>赢正瑞创</title>
 
<meta charset="utf-8">
<link rel="stylesheet" href="<?php echo wx_theme_url()?>/images/mobi.css">
<link rel="apple-touch-icon-precomposed" href="<?php echo wx_theme_url()?>/images/ico-startup-57x57.png">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no">
<meta http-equiv="Cache-Control" content="max-age=0">
<meta name="apple-touch-fullscreen" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<section class="p-index" style="height: 100%; display: block; ">
 
<section class="m-page m-page2 hide" style="height: 100%; top: 0px; ">
    <div class="m-img m-img01" style="background:url(<?php echo wx_theme_url()?>/img/1-bg.jpg) center no-repeat;background-size:100% 100%;">
  <img class="animated fadeInDown J_fTxt" src="<?php echo wx_theme_url()?>/img/1.png" style="position:absolute; left:0px; top:0px; width: 100%; height:100%; display: none; ">
  <a href="javascript:;" class="help-up"></a> </div>
</section>

<section class="m-page m-page2 hide" style="height: 100%; top: 0px; ">
    <div class="m-img m-img01" style="background:url(<?php echo wx_theme_url()?>//img/2-bg.jpg) center no-repeat;background-size:100% 100%;">
  <img class="animated fadeInDown J_fTxt" src="<?php echo wx_theme_url()?>/img/2.png" style="position:absolute; left:0px; top:0px; width: 100%; height:100%; display: none; ">
  <a href="javascript:;" class="help-up"></a> </div>
</section>
 
<!--
<section class="m-page m-page2 hide" style="height: 100%; top: 0px; ">
  <div class="m-img m-img01" style="background:url() center no-repeat;background-size:100% 100%;">
  <img class="animated fadeInDown J_fTxt" src="" style="position:absolute; left:0px; top:0px; width: 100%; height:100%; display: none; ">
  <a href="javascript:;" class="help-up"></a> </div>
</section>
-->

  
  <article class="run-dialog"> <a href=""></a> </article>
  <a href="javascript:;" class="player-button"> <span class="player-tip" style="display: none; ">点击开启/关闭音乐</span> </a>
  </section>
<!-- 引入脚本 --> 
<script src="<?php echo wx_theme_url()?>/images/plug.wxshare.js"></script> 
<!--<script src="<?php echo wx_theme_url()?>/images/plug.preload.js"></script>-->  
<script src="<?php echo wx_theme_url()?>/images/jquery-1.8.2.min.js"></script> 
<script src="<?php echo wx_theme_url()?>/images/jquery.easing.1.3.js"></script> 
<script src="<?php echo wx_theme_url()?>/images/hd_main.js"></script> 
<script src="http://g.tbcdn.cn/kissy/k/1.4.4/seed.js" data-config="{combine:true}"></script>
 
<script type="text/javascript">

    
_WXShare('http://jenny.egehua.com/uploadfile/20140814163539154.jpg','200','200','VYNFIELDS【维尼菲尔德酒庄】','维尼菲尔德酒庄(Vynfields)由深圳赢正瑞创公司所有，其2003 Pinot Noir 及2004 Classic Riesling 为酒庄赢得首次大奖。其分别于皇家复活节葡萄酒展荣获金牌奖， 以及在Bragato葡萄酒比赛中荣膺金牌奖及最佳雷司令葡萄酒荣誉。最近，酒庄也屡获嘉奖，其Reserve Pinot Noir 09 及Pinot Noir 09分别在伦敦国际葡萄酒展和《醇鉴》中荣获金牌奖。酒庄所产的每一款黑皮诺葡萄酒均至少荣获五星级奖项或金牌奖。',
'http://www.vynfields.cn')

KISSY.use('node,dom,event,io,cookie,gallery/simple-mask/1.0/,gallery/kissy-mscroller/1.3/index,gallery/simple-mask/1.0/,gallery/datalazyload/1.0.1/index,gallery/musicPlayer/2.0/index',function(S,Node,DOM,Event,IO,Cookie,Mask,KSMscroller,Mask,DataLazyload,MusicPlayer){
	var $=Node.all;
	var musicPlayer = new MusicPlayer({
			type:'auto',
        	mode:'random',
        	volume:1,
            auto:'true', 
            musicList:[{"name":"MP3", "path":"<?php echo wx_theme_url()?>/img/happynewyear.mp3"}]
        });
		
		
	var status_bool=false;

	$(".player-button").on("click",function(){ 
	 	if(status_bool==true){
	 		musicPlayer.stop();
	 		$(this).addClass('.player-button-stop');
	 		status_bool=false;
	 	}else{
	 		musicPlayer.play();
	 		$(this).removeClass('.player-button-stop');
	 		status_bool=true;
	 	}
	 });
	
 });

    
</script>

	  <div style="display:none;"><script src="http://s6.cnzz.com/stat.php?id=1253392243&web_id=1253392243" language="JavaScript"></script></div>
</body>
</html>
