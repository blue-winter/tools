<?php include "header.php";?>

<div class="layui-card">
    <div class="layui-card-header">
        <a href="<?php echo buildUrl('block').'&page='.$page; ?>"><button class=" layui-btn layui-btn-sm layui-btn-primary">返回</button></a>
    </div>
    <div class="layui-card-body">
        <form id="edit_form" class="layui-form" method="post" action="<?php echo buildAjaxUrl('block'); ?>">
            <input type="hidden" name="id" value="<?php toolsEcho($info['id']); ?>">
            <div class="layui-form-item">
                <label class="layui-form-label">名称</label>
                <div class="layui-input-block">
                    <input type="text" name="name" value="<?php toolsEcho($info['name']); ?>" required  lay-verify="required" placeholder="请输入名称" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">Blocke Name</label>
                <div class="layui-input-block">
                    <input id="block_name" type="text" name="block_name" value="<?php toolsEcho($info['block_name']); ?>" required  lay-verify="required" placeholder="Blocke Name" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux layui-inline">调用block的唯一标识!</div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">描述</label>
                <div class="layui-input-block">
                    <textarea name="desc" placeholder="请输入描述" class="layui-textarea"><?php toolsEcho($info['desc']); ?></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">状态</label>
                <div class="layui-input-inline status_c">
                    <input type="checkbox"  class="status_btn" name="status"
                        <?php if(isset($info['status'])&&$info['status']=='1'){echo 'checked';} ?>
                           value="1" lay-skin="switch" lay-text="开启|关闭">
                    <input type="hidden" name="status" id="status"  value="<?php toolsEcho($info['status']); ?>">
                </div>
            </div>

            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">内容</label>
                <div class="layui-input-block">
                    <textarea style="min-height: 300px" name="content" placeholder="请输入内容" class="layui-textarea"><?php toolsEcho($info['content']); ?></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <div style="margin: 0" class="layui-input-block">
                        <button class="layui-btn sub_btn" type="button" >保 存</button>
                    </div>
                </div>
            </div>
        </form>

        <script>
            $(function () {
                $(".sub_btn").click(function () {
                    if($("input[name='name']").val()==''){
                        layer.msg('名称不能为空！');return false;
                    }
                    if($("input[name='block_name']").val()==''){
                        layer.msg('Block Name不能为空！');return false;
                    }
                    var url="<?php echo buildUrl('block').'&page='.$page; ?>";
                    $.ajax({
                        url:$("#edit_form").attr('action'),
                        data:$("#edit_form").serialize(),
                        dataType:'json',
                        type:'post',
                        success:function (e) {
                            layer.msg(e.msg);
                            setTimeout(function () {
                                window.location.href=url;
                            },2000)
                        },
                        error:function (e) {
                            layer.msg('意外错误！');
                            console.log(e);
                        }
                    });
                });


                $(".status_c").click(function () {
                    var status= '';
                    if($(this).find('.layui-form-switch').hasClass('layui-form-onswitch')){
                        status ='1'
                    }else{
                        status='0';
                    }
                    $("#status").val(status);
                });

                $("#block_name").blur(function () {
                    var block_name = $(this).val();
                    if(block_name!=''){
                        var id="<?php toolsEcho($info['id']); ?>";
                        $.ajax({
                            url:"<?php echo buildAjaxUrl('block').'&type=check' ?>",
                            data:{'block_name':block_name,'id':id},
                            dataType:'json',
                            type:'get',
                            success:function (e) {
                                if(e.code!='1'){
                                    layer.msg(e.msg);
                                }
                            },
                            error:function (e) {
                                layer.msg('意外错误！');
                                console.log(e);
                            }
                        });
                    }

                });
            });

            layui.use('form', function(){
                var form = layui.form;
            });
        </script>
    </div>
</div>


<?php include "footer.php";?>
