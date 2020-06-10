<?php
/**
 * images list
 * by lk
 */
?>
<?php include "header.php";  $path =getPublicPath(false);
    $path =getPublicPath(false);
    $font_path=$path."css/fontawesome-webfont.woff"
?>
<style>
    @font-face{
        font-family: 'FontAwesome';
        src : url(<?php echo $font_path ?>);
    }
    .file-continer .file .item-select .item-check:after {
        content: "\f00c";
        position: relative;
        top: -6px;
    }
    .file_page a{
        /*background-image: url(<?php echo $path.'img/ybutton.png' ?>);
        background-repeat: no-repeat;
        background-position: 100% 0;*/
    }

    .desc_btn_cont{
        display: none;
    }
    .file-list-icon .file.select, .file-list-icon .file.file-select-drag-temp {
        border: 1px solid #d2d2d2;
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f3f3f3', endColorstr='#d9d9d9');
        background-image: -webkit-linear-gradient(top,#f3f3f3,#d9d9d9);
        background-image: -moz-linear-gradient(top,#f3f3f3,#d9d9d9);
        background-image: -o-linear-gradient(top,#f3f3f3,#d9d9d9);
        background-image: -ms-linear-gradient(top,#f3f3f3,#d9d9d9);
        background-image: linear-gradient(top,#f3f3f3,#d9d9d9);
        -pie-background: linear-gradient(to top,#f3f3f3,#d9d9d9);
        border-radius: 3px;
        padding: 0px;
    }

    .file-list-icon {
        padding: 10px 20px 0 10px;
        display: block;
        justify-content: space-between;
        flex-wrap: wrap;
        align-items: flex-start;
    }
    .file-continer {
        margin-bottom: 40px;
    }
    div.file-list-icon div.file {
        max-height: 130px;
    }
    .file-list-icon div.file, .file-list-icon .flex-empty {
        height: 115px;
        width: 80px;
    }
    body .file-list-icon .file {
        color: #444;
    }
    .file-list-icon div.file {
        transition: all 0.2s ease 0s;
    }
    .file-list-icon .file {
        color: #335;
        border: 1px solid transparent;
        box-shadow: 0px 0px 2px rgba(255,255,255,0);
        -webkit-transition: background 0.2s, border 0.2s, color 0.2s;
        -moz-transition: background 0.2s, border 0.2s, color 0.2s;
        -o-transition: background 0.2s, border 0.2s, color 0.2s;
        -ms-transition: background 0.2s, border 0.2s, color 0.2s;
        transition: background 0.2s, border 0.2s, color 0.2s;
        width: 60px;
        height: 75px;
        text-decoration: none;
        margin: 0;
        margin-right: 10px;
        margin-bottom: 10px;
        overflow: hidden;
        float: left;
    }
    .file-list-icon .file {
        position: relative;
    }
    .file-continer .file.select .item-select {
        color: #fff;
        background: #3b8cff;
    }
    .file-continer .file.hover .item-select, .file-continer .file.select .item-select, .file-continer .file.file-select-drag-temp .item-select {
        display: block;
    }
    body .file-continer .file .item-select {
        width: 12px;
        height: 12px;
    }
    .file-continer .file .item-select {
        display: none;
        position: absolute;
        right: 4px;
        top: 4px;
        width: 14px;
        height: 14px;
        box-sizing: content-box;
        text-align: center;
        border: 1px solid #ddd;
        background: #fff;
        cursor: pointer;
        z-index: 50;
        border-radius: 2px;
        padding: 2px;
        left: 5px;
        border-radius: 50%;
        background: rgba(0,0,0,0.05);
        border: none;
        color: #fff;
    }
    .file-continer .file .item-select .item-check {
        font-family: FontAwesome;
        font-weight: normal;
        font-style: normal;
        text-decoration: inherit;
        font-size: 18px;
        font-size: 12px;
        text-shadow: none;
    }
    body .file-continer .file .item-select .item-check {
        font-size: 10px;
    }
    .file-list-icon div.file .ico {
        padding-left: 5px;
        height: 70px;
        width: 70px;
    }
    .file-list-icon .file .ico {
        height: 60px;
        width: 60px;
        padding-top: 4px;
        text-align: center;
        vertical-align: middle;
        display: table-cell;
    }
    .file-list-icon .file .ico {
        -webkit-transition: all 0.168s;
        -moz-transition: all 0.168s;
        -o-transition: all 0.168s;
        -ms-transition: all 0.168s;
        transition: all 0.168s;
    }
    .file-list-icon .file .ico .x-item-file {
        border-radius: 5px;
        margin-top: 6px;
        margin-top: 4px;
    }
    body .x-folder {
        background-image: url(<?php echo $path; ?>/img/folder_mac.png);
        background-image: none \9;
    }
    .x-item-file {
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        width: 100%;
        height: 100%;
        display: inline-block;
        pointer-events: none;
    }
    .file-list-icon div.file .filename {
        width: 80px;
    }
    .file-list-icon .file .filename {
        width: 60px;
        cursor: default;
        text-align: center;
        word-break: break-all;
        font-size: 1.0em;
        margin: 0 auto;
        line-height: 1.5em;
        padding-bottom: 5px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
    }
    *, *:before, *:after {
        -webkit-box-sizing: content-box;
        -moz-box-sizing: content-box;
        box-sizing: content-box;
    }
    .file-continer .file .filename .title.db-click-rename {
        cursor: text;
    }
    .file-list-icon div.file, .file-list-icon .flex-empty {
        height: 115px;
        width: 80px;
    }
    body .file-list-icon .file {
        color: #444;
    }
    .file-list-icon div.file {
        transition: all 0.2s ease 0s;
    }
    div.file-list-icon div.file {
        max-height: 130px;
    }
    .file-list-icon .file {
        color: #335;
        border: 1px solid transparent;
        box-shadow: 0px 0px 2px rgba(255,255,255,0);
        -webkit-transition: background 0.2s, border 0.2s, color 0.2s;
        -moz-transition: background 0.2s, border 0.2s, color 0.2s;
        -o-transition: background 0.2s, border 0.2s, color 0.2s;
        -ms-transition: background 0.2s, border 0.2s, color 0.2s;
        transition: background 0.2s, border 0.2s, color 0.2s;
        width: 60px;
        height: 75px;
        text-decoration: none;
        margin: 0;
        margin-right: 10px;
        margin-bottom: 10px;
        overflow: hidden;
        float: left;
    }
    .file-list-icon .file {
        position: relative;
    }
    .file-list-icon div.file .ico {
        padding-left: 5px;
        height: 70px;
        width: 70px;
    }
    .file-list-icon .file .filename{
        line-height: 1!important;
    }
    .file-list-icon .file .ico {
        height: 60px;
        width: 60px;
        padding-top: 4px;
        text-align: center;
        vertical-align: middle;
        display: table-cell;
    }
    .file-list-icon .file .ico {
        -webkit-transition: all 0.168s;
        -moz-transition: all 0.168s;
        -o-transition: all 0.168s;
        -ms-transition: all 0.168s;
        transition: all 0.168s;
    }
    .file-list-icon .file .ico .x-item-file {
        border-radius: 5px;
        margin-top: 6px;
        margin-top: 4px;
    }
    .x-item-file {
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        width: 100%;
        height: 100%;
        display: inline-block;
        pointer-events: none;
    }
</style>
<div  class="layui-card">
    <div class="layui-card-header">
        <div style="">
            <input type="hidden" name="now_path" id="now_path" value="<?php echo ($data['now_path']); ?>">
            <div style=" position: relative;top: -4px;" class="layui-inline">
                <?php if($data['is_show']): ?>
                    <span now_path="<?php echo ($data['now_path']); ?>" class="layui-btn layui-btn-sm layui-btn-primary back_btn_file"><i class="layui-icon layui-icon-left"></i></span>
                <?php else: ?>
                    <span  class="layui-btn layui-btn-sm layui-btn-primary layui-btn-disabled"><i class="layui-icon layui-icon-left"></i></span>
                <?php endif; ?>
                <span style="margin-left: 0px" class=" layui-btn layui-btn-sm layui-btn-primary reload_btn"><i class="layui-icon layui-icon-refresh"></i></span>
                <!--<span style="margin-left: 0px" class="layui-btn-disabled layui-btn layui-btn-sm layui-btn-primary"><i class="layui-icon layui-icon-right"></i></span>-->
            </div>

            <div style="margin: 0;padding-left: 20px" class="file_page layui-box layui-laypage layui-laypage-default layui-inline" >
                <a style="" href="<?php echo  buildUrl('images').'&base_path=' ?>" ><i class="layui-icon layui-icon-home"></i>
                </a>
                <?php foreach ($data['top_menu'] as $_menu): ?>
                    <a  href="<?php echo buildUrl('images').'&base_path='.$_menu['path']; ?>"><?php echo $_menu['name']; ?> &nbsp;></a>
                <?php endforeach; ?>

            </div>
            <div class="layui-inline layui-layout-right" style="margin-right: 5%" >
                <button class="layui-btn layui-btn-sm layui-btn-warm desc_btn_cont  delete_desc_btn"><i class="layui-icon layui-icon-delete"></i>删 除</button>
                <button class="layui-btn layui-btn-sm layui-btn-primary  desc_btn_cont  rename_desc_btn"><i class="layui-icon layui-icon-edit"></i>重命名</button>
                <!--<button class="layui-btn layui-btn-sm layui-btn-primary "><i class="layui-icon layui-icon-templeate-1"></i>复 制</button>-->
                <!--<button class="layui-btn layui-btn-sm layui-btn-primary "><i class="layui-icon layui-icon-templeate-1"></i>移 动</button>-->

                <button class="layui-btn layui-btn-sm layui-btn-primary mkdir_desc_btn"><i class="layui-icon layui-icon-file"></i>创建文件夹</button>
                <button class="layui-btn layui-btn-sm layui-btn-primary " id="upload_data"><i class="layui-icon layui-icon-file-b"></i>上传文件</button>
                <!--<button class="layui-btn layui-btn-sm layui-btn-primary reload_btn"><i class="layui-icon layui-icon-refresh"></i>刷新</button>-->
            </div>
        </div>
    </div>
    <script>
        layui.use('upload', function(){
            var upload = layui.upload;
            var link = "/?ajax_url=upload";
            //执行实例
            var uploadInst = upload.render({
                 elem: '#upload_data' //绑定元素
                ,url: link //上传接口
                ,multiple : 'true' //多文件上传
                ,accept: 'file'
                ,done: function (res) {
                     console.log(res);
                    layer.msg(res.msg);
                    setTimeout(function () {
                        $(".reload_btn").click();
                    },1500);
                }
                ,allDone:function (res) {
                    console.log(res);
                    //layer.msg(res.msg);
                    /*setTimeout(function () {
                        $(".reload_btn").click();
                    },1500);*/
                }
                ,error: function(e){
                    //请求异常回调
                    console.log(e);
                    layer.msg('意外错误');
                }
            });
        });
    </script>
    <div style="min-height: 300px" class="layui-card-body">
        <div class="file-continer file-list-icon">
            <!--文件夹-->
            <?php if(isset($data['files'])&&$data['files']): foreach ($data['files'] as $file): ?>
                <?php if($file['type']=='path'): ?>
                    <!-- 文件夹 -->
                    <div data-path="<?php echo base64_encode($file['path']); ?>"
                         class="file folder-box menu-folder folder_btn select_btn " title="名称:<?php echo $file['name']; ?>
修改时间 :<?php echo $file['last_time'];?> 大小: <?php echo $file['size'];?>" >
                        <div class="item-select">
                            <div class="item-check"></div>
                        </div>
                        <div class="item-menu">
                            <div class="cert"></div>
                        </div>
                        <div class="ico" filetype="folder">
                            <i class="x-item-file x-folder"></i>
                        </div>

                        <div class="filename">
                            <span class="title db-click-rename" title="<?php echo $file['name']; ?>"><?php echo $file['name']; ?></span>
                        </div>
                    </div>
                    <!-- 文件夹 -->
                <?php endif; ?>
            <?php endforeach; ?>
            <?php endif; ?>
            <!-- 文件夹 -->

            <!--文件-->
            <?php if(isset($data['files'])&&$data['files']): foreach ($data['files'] as $file): ?>
                <?php if($file['type']!='path'): ?>
                    <!--图片-->
                    <?php if ($file['type']=='img'): ?>
                        <!-- 图片 -->
                        <div data-path="<?php echo base64_encode($file['path']); ?>" class="file  file-box menu-file  select_btn" title="名称:<?php echo $file['name']; ?>修改时间 :<?php echo $file['last_time'];?> 大小: <?php echo $file['size'];?>" >
                            <div class="item-select">
                                <div class="item-check"></div>
                            </div>

                            <div class="ico img_tips"  src="/tools/media/<?php echo $file['base_path']; ?>">
                                <img width="80px" style="cursor: pointer" src="/tools/media/<?php echo $file['base_path']; ?>" >
                            </div>
                            <div class="filename">
                                <span class="title db-click-rename" title="<?php echo $file['name']; ?>"><?php echo $file['name']; ?></span>
                            </div>
                        </div>
                        <!-- 图片 -->
                    <!--其他文件-->
                    <?php else: ?>
                        <!-- 文件 -->
                        <div  data-path="<?php echo base64_encode($file['path']); ?>" class="file  file-box menu-file select_btn" title="名称:<?php echo $file['name']; ?>修改时间 :<?php echo $file['last_time'];?> 大小: <?php echo $file['size'];?>" >
                            <div class="item-select">
                                <div class="item-check"></div>
                            </div>
                            <div class="ico" >
                                <i style="font-size: 56px!important;cursor: pointer" class="layui-icon layui-icon-file"></i>
                            </div>
                            <div class="filename">
                                <span class="title db-click-rename" title="<?php echo $file['name']; ?>"><?php echo $file['name']; ?></span>
                            </div>
                        </div>
                        <!-- 文件 -->

                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php else: ?>
            Empty!
            <?php endif; ?>



        </div>
    </div>

</div>


<?php include "footer.php";?>
