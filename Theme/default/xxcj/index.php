<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>数字滚动抽奖</title>

        <script type="text/javascript" src="http://www.jq22.com/demo/jquery-lhj-150421204139/js/jquery-1.7.2-min.js"></script> 


        <style>

            html,body{margin:0;padding:0;overflow:hidden;}

            body{background:url(<?php echo v_theme_url(); ?>/img/xxcj/body_bg.jpg) 0px 0px repeat-x #000;}

            .main_bg{background:url(<?php echo v_theme_url(); ?>/img/xxcj/main_bg.jpg) top center no-repeat;height:1000px;}

            .main{width:1000px;height:1000px;position:relative;margin:0 auto;}

            .num_mask{background:url(<?php echo v_theme_url(); ?>/img/xxcj/num_mask.png) 0px 0px no-repeat;height:184px;width:740px;position:absolute;left:50%;top:340px;margin-left:-370px;z-index:9;}

            .num_box{height:450px;width:740px;position:absolute;left:50%;top:340px;margin-left:-370px;z-index:8;overflow:hidden;text-align:center;}


            .btn{background:url(<?php echo v_theme_url(); ?>/img/xxcj/btn_start.png) 0px 0px no-repeat;width:264px;height:89px;position:absolute;left:50%;bottom:50px;margin-left:-132px;cursor:pointer;clear:both;}
            #result{ 
                font-size: 220px;
                color:#a17112; 
            }
        </style>
    </head>

    <body>

        <div class="main_bg">

            <div class="main">

                <div id="res" style="text-align:center;color:#fff;padding-top:15px;"></div>

                <div class="num_mask"></div>

                <div class="num_box"> 
                    <h1 id="result" style="height: 224px;line-height: 224px;padding: 20px 0;font-size: 129px;margin: 0">
                        xxxxxxxxxxx
                    </h1> 
                    <div class="btn" onclick="btn()"></div>
                    <input type="hidden" value="1" id="btnVal" />
                    <input type="hidden" value="" id="mobileVal" />
                </div>

            </div>

        </div>

        <audio src="<?php echo v_theme_url(); ?>/img/xxcj/6666.mp3" controls="controls" id="myAudio" style="display: none"></audio>
        <audio src="<?php echo v_theme_url(); ?>/img/xxcj/7777.wav" controls="controls" id="myAudio2"  style="display: none"></audio>
    </body>

</html>


<script language="javascript">
    // global variables全局变量
    var timer;
    var flag = new Array(100);
    var existingnum = new Array(100);
    var clickTimes = 0;
    var randnum;
    var cellnum = 1;
//    var mobile = new Array(13020000100,13928474773,13020000102);  
    var myobj = eval('<?php echo $data; ?>');
    var dataTmp = [];
    $.each(myobj, function (k, v) {
        dataTmp += "['" + v.mobile + "']" + ",";
    });
    var mobile = eval('[' + dataTmp + ']');
    var dataID = [];
    $.each(myobj, function (k, v) {
        dataID += "['" + v.mobile + "']" + ",";
    });
    var mobileID = eval('[' + dataID + ']');
    var num = mobile.length - 1;
    function getRandNum() {
        num = parseInt(num);
        if (num != -1) {
            var y = GetRnd(0, num);
            re = /([\s\S]{3})([\s\S]{4})/;
            document.getElementById("result").innerHTML = mobile[y][0].replace(re, "$1xxxx");
            document.getElementById("mobileVal").value = mobile[y];
        } else {
            document.getElementById("result").innerHTML = "xxxxxxxxxxx";
            document.getElementById("mobileVal").value = "";
            pause();
            pause2();
        }
    }
    function start() {
        clearInterval(timer);
    }
    function ok() {
        clearInterval(timer);
    }
    function GetRnd(m, n) {
        randnum = parseInt(Math.random() * (n - m + 1));
        return randnum;
    }
    function setTimer() {
        num = parseInt(num);
        if (num != -1) {
            play();
            pause2();
            time = setInterval("getRandNum()", 50);
        }
    }
    function clearTimer() {
        noDupNum();
        clearInterval(time);
        pause();
        play2();
    }
    function noDupNum() {
        // to remove the selected mobile phone number删除选定的移动电话号码
        mobile.removeEleAt(randnum);
        // to reorganize the mobile number array!!重组移动数字阵列！！
        var o = 0;
        for (p = 0; p < mobile.length; p++) {
            if (typeof mobile[p] != "undefined") {
                mobile[o] = mobile[p];
                o++;
            }
        }
        num = mobile.length - 1;
    }
    // method to remove the element in the array数组中元素的删除方法
    Array.prototype.removeEleAt = function (dx)
    {
        if (isNaN(dx) || dx > this.length) {
            return false;
        }
        this.splice(dx, 1);
    }
    function play() {
        var myAudio = document.getElementById("myAudio");
        myAudio.play();
    }
    function pause() {
        var myAudio = document.getElementById("myAudio");
        myAudio.pause();
        myAudio.load();
    }
    function load() {
        var myAudio = document.getElementById("myAudio");
        myAudio.load();
    }
    function play2() {
        var myAudio2 = document.getElementById("myAudio2");
        myAudio2.play();
    }
    function pause2() {
        var myAudio2 = document.getElementById("myAudio2");
        myAudio2.pause();
        myAudio2.load();
    }
    function btn() {
        var btnVal = document.getElementById("btnVal").value;
        if (btnVal == 1) {
            document.getElementById("btnVal").value = 0;
            setTimer();
        } else {
            document.getElementById("btnVal").value = 1; 
            clearTimer();
            sends();
        }
    }
    function sends() {
        var mobileVal = document.getElementById("mobileVal").value;
        $.post("sends", {mobile: mobileVal}, function (result) {
            console.log(result);
            if (result == "202") {
                alert(result.message);
            }
        });
    }
</script> 