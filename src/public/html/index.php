<?php include "header.php";?>

<form id="setting_form" class="layui-form" method="get" action="<?php echo buildAjaxUrl('setting'); ?>">

    <div style="margin-top: 30px" class="layui-form-item">
        <label class="layui-form-label">关闭插件</label>
        <div class="layui-input-block ">
            <input value="1" type="checkbox" checked name="is_open_admin_tools"  lay-text="ON|OFF" lay-skin="switch">
        </div>
        <div class="layui-form-mid layui-word-aux layui-inline">注意:关闭后,需要手动在数据库开启!</div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">登录密码</label>
        <div class="layui-input-block">
            <input style="width: 50%" type="password" name="admin_tools_login" value="<?php toolsConfig('admin_tools_login'); ?>"  autocomplete="off" class="layui-input">
        </div>
        <div style="margin-left: 120px" class="layui-form-mid layui-word-aux layui-inline">注意:如果设置此项，须在域名后跟参数 ?login=XXXX 进行登录(XXX是登录密码),如果需要退出登录 ?logout=1</div>
    </div>

    <!--<div class="layui-form-item layui-form-text">
        <label class="layui-form-label">文本域</label>
        <div class="layui-input-block">
            <textarea name="desc" placeholder="请输入内容" class="layui-textarea"></textarea>
        </div>
    </div>-->
    <div class="layui-form-item">
        <div class="layui-input-block">
            <div style="margin: 0" class="layui-input-block">
                <button class="layui-btn sub_btn" type="button" >保 存</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(".sub_btn").click(function () {
        /*if($("input[name='host']").val()==''){
            layer.msg('host不能为空！');return false;
        }*/
        $.ajax({
            url:$("#setting_form").attr('action'),
            data:$("#setting_form").serialize(),
            dataType:'json',
            type:'post',
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

<?php include "footer.php";?>
