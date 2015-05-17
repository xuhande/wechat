<!--<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=no" /> 
        <title>Vynfields退货申请</title>
        <link rel="stylesheet" type="text/css" href="<?php echo v_site_url() ?>/Public/css/wx.css"  > 

        <link rel="stylesheet" href="<?php echo v_theme_url(); ?>/css/bootstrap/css/bootstrap.min.css"> 
        <link rel="stylesheet" href="<?php echo v_theme_url(); ?>/css/style.css">
        <link rel="stylesheet" href="<?php echo v_theme_url(); ?>/css/hover.css">
        <script src="<?php echo v_theme_url(); ?>/js/jquery.min.js"></script>
        <script src="<?php echo v_theme_url(); ?>/js/jquery.animate-colors-min.js"></script>
        <script src="<?php echo v_theme_url(); ?>/css/bootstrap/js/bootstrap.min.js"></script>
        
<link rel="stylesheet" type="text/css" href="<?php echo v_theme_url(); ?>/Cork/css/webuploader.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo v_theme_url(); ?>/Cork/css/style.css" />
<script type="text/javascript" src="<?php echo v_theme_url(); ?>/Cork/jquery.js"></script>
<script type="text/javascript" src="<?php echo v_theme_url(); ?>/Cork/dist/webuploader.js"></script>  

    </head>
    <body> 

        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12" style="margin-top:20px;">
                    <span class="col-xs-12"><label>商品名称</label><span  style="float: right"><?php echo $order['product_name'] ?></span></span>
                    <span class="col-xs-12"><label>交易金额</label><span  style="float: right"><?php echo $order['order_total_price'] ?></span></span>
                    <span class="col-xs-12"><label>交易时间</label><span  style="float: right"><?php echo $order['order_create_time'] ?></span></span>
                    <span class="col-xs-12"><label>交易帐号</label><span  style="float: right"><?php echo $order['trans_id'] ?></span></span>

                    <form>
                        <div class="form-group">
                            <select class="form-control">
                                <option>维权原因</option>
                                <option>商品破损</option>
                                <option>买错了</option>
                                <option>其他</option> 
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control">
                                <option>你希望的处理方式？</option>
                                <option>退货</option>
                                <option>换货</option>
                                <option>其他</option> 
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="disabledTextInput">手机号（选填）</label>
                            <input type="text" id="disabledTextInput" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="disabledTextInput">备注（选填）</label>
                            <textarea id="disabledTextInput"  class="form-control" rows="3"></textarea>

                        </div>
                        <div class="form-group">
                            <label for="disabledTextInput">上传图片凭证（选填，最多上传5张）</label>
                            <div id="thelist">

                            </div>

                            <div id="pickerr"><img src="<?php echo v_theme_url() ?>/Cork/image.png" /></div>
 
                <div id="getLocation">getLocation</div>
                <div   id="cancel"  class="btn btn-success" style="width: 100%;cursor: pointer; display: none;">重新选择</div>
                <div id="cancel" style="text-align: center; display: none; background-color: #00b7ee; margin:0px auto;padding:15px 10px; width:100px;cursor: pointer; ">重新选择</div>
 
                        </div>
                        <div class="form-group">
                            <button class="btn btn-block btn-success"  id="ctlBtn" >send message</button>
                        </div>

                    </form>




                </div>

            </div>
        </div>



 Modal 
<div class="modal fade" id="myModal" style="top:25%" tabindex="-1"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width:80%; margin: 0px auto;">
            <div class="modal-header text-center" style="background-color: rgb(175,115,75); ">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="line-height: 1; color:#fff">温馨提示</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer" style="text-align: center; border-top: 0px;">
                <button type="button" class="btn btn-default  text-center" style="border: 1px rgb(205,145,105) solid" data-dismiss="modal">关闭</button> 
            </div>
        </div>
    </div>
</div>





        <script>
            var uploader = WebUploader.create({
                // swf文件路径 
                // 文件接收服务端。
                server: '<?php echo U("Home/GetByfilter/upload")?>',
                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick: '#pickerr',
                // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
                resize: false,
                extensions: 'gif,jpg,jpeg,bmp,png',
                multiple: false, 
        fileNumLimit: 5,
                sendAsBinary: true

            });
            var imgpath = new Array();
            var isselect = false;
// 当有文件被添加进队列的时候
            uploader.on('fileQueued', function (file) {

                var $li = $(
                        '<div id="' + file.id + '" class="file-item thumbnail">' +
                        '<img>' +
                        '<p class="state"></p>' +
                        '<div class="progress progress-bar"></div>' +
                        '<div class="info">' + file.name + '</div>' +
                        '</div>'
                        ),
                        $img = $li.find('img');
                // $list为容器jQuery实例
                $("#thelist").append($li);
                // 创建缩略图
                // 如果为非图片文件，可以不用调用此方法。
                // thumbnailWidth x thumbnailHeight 为 100 x 100
                uploader.makeThumb(file, function (error, src) {
                    if (error) {
                        $img.replaceWith('<span>不能预览</span>');
                        alert(src);
                        return;
                    }

                    $img.attr('src', src);
                }, 300, 300);
                $("#cancel").show();
                $("#pickerr").hide();
                isselect = true;
            });
// 文件上传过程中创建进度条实时显示。
            uploader.on('uploadProgress', function (file, percentage) {
                var $li = $('#' + file.id),
                        $percent = $li.find('.progress .progress-bar'),
                        $loadingnumber = $("#loading-number"),
                        $loadingprogress = $("#loading-progress");
                // 避免重复创建
                if (!$percent.length) {
                    $percent = $('<div class="progress progress-striped active">' +
                            '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                            '</div>' +
                            '</div>').appendTo($li).find('.progress-bar');
                }

                $li.find('p.state').text('上传中');

                $percent.css('width', percentage * 100 + '%');
//        $loadingnumber.html(parseInt(percentage * 100) + '%')
                $loadingprogress.css('width', percentage * 100 + '%');
            });
            uploader.on('uploadSuccess', function (file) { 
                $('#' + file.id).find('p.state').text("success");
            });
            uploader.on('uploadError', function (file) {
                alert(file);
                $('#' + file.id).find('p.state').text('上传出错');
            });
            uploader.on('uploadComplete', function (file) { 
                $('#' + file.id).find('.progress').fadeOut();
            });
            uploader.on('uploadFinished', function () {
                var obj = uploader.getFiles("complete");
                $.each(obj, function (i, item) {
                    imgpath.push("<?php echo v_site_url() ?>/upload" + "/cork/" + item.name);
                });
                aiax_save_img_path(imgpath);
                uploader.reset();
            });
            $("#ctlBtn").on('click', function () {
                uploader.option('formData', {
                    file_dir_asd: "cork"
                });
                var name = $("input[name*='name']").val();
                var idno = $("input[name*='idno']").val();
                var summary = $("textarea[name*='summary']").val();
                var mobile = $("input[name*='mobile']").val();
                var title = $("input[name*='title']").val();
                var openid = $("input[name*='openid']").val();
                if (isselect) {
                    if (!<?php echo $userinfo->subscribe ? "true" : "false"; ?>) {
                        $('#myModal').modal('show');
                        $(".modal-body").html("需要关注后才能上传作品哦");
                    } else {
                        if (name == "" || idno == "" || summary == "" || mobile == "" || title == "") {
                            $('#myModal').modal('show');
                            $(".modal-body").html("信息不完全，请检查后提交!");
                        } else {
                            $('#showlodding').modal('show');

                            $("#ctlBtn").html("正在提交");
                            uploader.upload();
                        }
                    }
                }
                else {
//             $('#showlodding').modal('show');
                    $('#myModal').modal('show');
                    $(".modal-body").html("请选择图片");
                }


            });
            $("#cancel").click(function () {
                isselect = false;
                uploader.reset();
                $("#thelist").html("");
                $("#pickerr").show();
            });
            function aiax_save_img_path(data) {

                $.ajax({
                    //提交数据的类型 POST GET
                    type: "POST",
                    //提交的网址
                    url: '<?php echo v_site_url() ?>?m=Cork&a=save',
                    //提交的数据
                    data: {path: data, name: $("input[name*='name']").val(), subscribe: $("input[name*='subscribe']").val(), idno: $("input[name*='idno']").val(), summary: $("textarea[name*='summary']").val(), openid: $("input[name*='openid']").val(), nickname: $("input[name*='nickname']").val(), mobile: $("input[name*='mobile']").val(), title: $("input[name*='title']").val()}, //{Name: "sanmao", Password: "sanmaoword"},
                    //返回数据的格式
                    datatype: "json", //"xml", "html", "script", "json", "jsonp", "text".
                    //在请求之前调用的函数
                    beforeSend: function () {
                        $("#msg").html("logining");
//                   alert("befor");
                    },
                    //成功返回之后调用的函数             
                    success: function (data) {
//                $("#msg").html(decodeURI(data));
// alert(data);
                        $('#showlodding').modal('hide');
                        if (data == "303") {

                            $('#myModal').modal('show');
                            $(".modal-body").html("需要关注才能上传哦");
                            $("#ctlBtn").html("提交");
                        }
                        else if (data === "201") {
                            $('#myModal').modal('show');
                            $(".modal-body").html("同一个用户只能提交一次哦，如有特殊情况，请联系客服");
                            $("#ctlBtn").html("提交");
                        }
                        else if (data == "200") {

                            $('#myModal').modal('show');
                            $(".modal-body").html("提交成功，作品正在审核中。<br />重新打开此页面查看审核进度。");
                            $("#ctlBtn").html("提交成功");
                            $("#ctlBtn").attr('disabled', false);
                        } 
                    },
                    //调用执行后调用的函数
                    complete: function (XMLHttpRequest, textStatus) {

                    },
                    //调用出错执行的函数
                    error: function () {
                        //请求出错处理
//                 alert("error");
                    }
                });
            }

        </script>  



    </body>
</html>
-->
