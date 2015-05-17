<?php
    if(C('LAYOUT_ON')) {
        echo '{__NOLAYOUT__}';
    }
?><?php v_template_part(array("name" => "header", "path" => "Public")); ?> 
<div class="container">
	<div class="system-message well error text-center">
		<h1>
			<i class="glyphicon glyphicon-warning-sign"></i>
		</h1>
		<p class="message"><?php echo($error); ?></p>
		<p class="detail"></p>
		<p class="jump">
			页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo($waitSecond); ?></b>
		</p>
	</div>
</div>
<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script> 
<?php v_template_part(array("name" => "footer", "path" => "Public")); ?>