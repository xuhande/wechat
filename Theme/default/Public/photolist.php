
<?php wx_template_part('header'); ?>
<div class="col-sm-12 ">
    <div class="alert alert-warning">
        Warning! please use wifi !!!
    </div>

    <div class="curr_page">
        <?php
        $isnull = true;
        foreach ($photo as $key => $value) {
            $isnull = false;
            ?>
            <div class="col-md-3 panel-body">
                <img src="<?php echo $value['path'] ?>" width="100%"/>
                <div class="col-md-9">
                    <?php
                    $path = $value['path'];
                    // $path
                    $name = substr($path, strrpos($path, "/", 0) + 1);
                    echo $name;
                    ?></div>
                <div class="col-md-2"><a href="<?php echo $value['path'] ?>" target="_blank" >check original picture</a></div>
            </div>
            <?php
        }
        ?>
        <?php
        if ($isnull) {
            ?>
            <div class="alert alert-warning">
                暂时没有找到相关的照片，如有需要，请查看 <a href="<?php echo wx_site_url() ?>/photo/index/index/category/品鉴会现场">品鉴会现场</a> 或退出重新输入关键字
            </div>
            <?php
        }
        ?>
    </div>
    <div id="loading" class="text-center">

    </div>

    <div class="col-sm-12 ">
        <a  href="<?php echo wx_site_url() ?>/photo/index/index/category/品鉴会现场" style="display: none;" class="btn btn-primary btn-lg  btn-block view-more">点击查看 品鉴会现场</a>
        <button type="button" id="btn_ajx_page" data-islastpage ="<?php echo $islastpage ?>" data-url="<?php echo $next_page_url ?>" class="btn btn-primary btn-lg btn-block">加载更多</button><br />

    </div>




</div>

<script>
    $(function () {
        $(window).scroll(function () {
          
            if ($(window).scrollTop() + $(window).height() == $(document).height()) {
                   ajax_load();
                
            }

 
        });


        $("#btn_ajx_page").click(function () {
            ajax_load();

        });

        function ajax_load() {
            var islastpage = $("#btn_ajx_page").data("islastpage");
            var url = $("#btn_ajx_page").data("url");
            if (islastpage == 1) {  //如果没有输据了
                $("#btn_ajx_page").attr('disabled', "true");
                $("#btn_ajx_page").html("没有更多了");
                $("#btn_ajx_page").hide("slow");
                $(".view-more").show("slow");
                return false;
            }

            $("#loading").html('<img src="<?php echo wx_theme_url(); ?>/image/loading.gif" />');

            $.ajax({
                url: url,
                type: "GET",
                datatype: "html", //"xml", "html", "script", "json", "jsonp", "text".
                beforeSend: function (XMLHttpRequest) {
                    //ShowLoading();

                    $("#loading").html('<img src="<?php echo wx_theme_url(); ?>/image/loading.gif" />');

                },
                error: function () {
//                    alert("服务器内部错误！");
                    $("#loading").html('error');

                },
                success: function (data) { 
                    $("#btn_ajx_page").data("url", $($.parseHTML(data)).find('#btn_ajx_page').data('url'));
                    $("#btn_ajx_page").data("islastpage", $($.parseHTML(data)).find('#btn_ajx_page').data('islastpage'))
                    $(".curr_page:last").append($($.parseHTML(data)).find('.curr_page'));

                    $(".curr_page:last").fadeOut(0, function () {
                        $("#loading").html('');
                    }).fadeIn(500);



                },
                complete: function (XMLHttpRequest, textStatus) {
                    //HideLoading();
                }
            });
        }

    });

</script>
