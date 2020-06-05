<?php
    $path =getPublicPath(false);
    $menus = isset($menus)&&$menus?$menus:(new \admintools\tools\tools\Html())->menus;
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
<meta charset="UTF-8" />
<title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <script type="text/javascript" src="<?php echo $path; ?>js/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo $path; ?>layui/css/layui.css">
    <link rel="stylesheet" href="<?php echo $path; ?>css/public.css">
    <link rel="stylesheet" href="<?php echo $path; ?>css/asidenav.css">
    <script type="text/javascript" src="<?php echo $path; ?>js/asidenav.js"></script>
    <script type="text/javascript" src="<?php echo $path; ?>layui/layui.all.js"></script>
    <script type="text/javascript" src="<?php echo $path; ?>layui/layui.js"></script>
    <script src="<?php echo $path; ?>js/common.js" type="text/javascript"></script>
</head>
<body>
<div class="layui-card-body">
    <fieldset class="layui-elem-field layui-field-title">
        <legend>Install</legend>
        <hr class="layui-bg-gray">
        <div class="layui-field-box">
            <form id="install_form" class="layui-form" method="get" action="<?php echo buildAjaxUrl('install'); ?>">
                <div class="layui-form-item">
                    <label class="layui-form-label">Database Host</label>
                    <div class="layui-input-block">
                        <input type="text" name="host" required  value="127.0.0.1" lay-verify="required" placeholder="127.0.0.1" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">Database dbname</label>
                    <div class="layui-input-block">
                        <input type="text" name="dbname" required  lay-verify="required" placeholder="数据库名称" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">Database username</label>
                    <div class="layui-input-block">
                        <input type="text" name="user" required  lay-verify="required" placeholder="用户名" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">Database password</label>
                    <div class="layui-input-block">
                        <input type="password" name="password" required  lay-verify="required" placeholder="密码" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">Database Port</label>
                    <div class="layui-input-block">
                        <input type="text" name="port" value="3306" required  lay-verify="required" placeholder="3306" autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn sub_btn" type="button" >立即安装</button>
                    </div>
                </div>
            </form>

            <script>
                $(".sub_btn").click(function () {
                    if($("input[name='host']").val()==''){
                        layer.msg('host不能为空！');return false;
                    }
                    if($("input[name='dbname']").val()==''){
                        layer.msg('dbname不能为空！');return false;
                    }
                    if($("input[name='user']").val()==''){
                        layer.msg('user不能为空！');return false;
                    }
                    if($("input[name='password']").val()==''){
                        layer.msg('password不能为空！');return false;
                    }
                    if($("input[name='port']").val()==''){
                        layer.msg('port不能为空！');return false;
                    }
                    $.ajax({
                        url:$("#install_form").attr('action'),
                        data:$("#install_form").serialize(),
                        dataType:'json',
                        type:'get',
                        success:function (e) {
                            layer.msg(e.msg);
                            setTimeout(function () {
                                parent.location.reload()
                            },2000)
                        },
                        error:function (e) {
                            layer.msg('意外错误！');
                            console.log(e);
                            setTimeout(function () {
                                parent.location.reload()
                            },2000)
                        }
                    });
                });
                layui.use('form', function(){
                    var form = layui.form;
                });
            </script>

        </div>
    </fieldset>
</div>
</body>
</html>

