<?php include "header.php";?>

<div class="layui-card">
    <div class="layui-card-header">
        <a href="<?php echo buildUrl('add_block'); ?>"><button class=" layui-btn layui-btn-sm layui-btn-primary">新建Block</button></a>
    </div>
    <div class="layui-card-body">
        <table class="layui-table layui-form">
            <thead>
            <tr>
                <th>ID</th>
                <th>名称</th>
                <th>code</th>
                <th>描述</th>
                <th>创建时间</th>
                <th>最后更新</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($result as $item): ?>
            <tr>
                <td><?=$item['id'];  ?></td>
                <td><?=$item['name'];  ?></td>
                <td><?=$item['block_name'];  ?></td>
                <td>
                    <div style="max-width: 200px; text-overflow: clip;overflow:hidden;max-height: 40px">
                    <?=$item['desc'];  ?></td>
    </div>

    <td><?=date('Y-m-d H:i',$item['create_time']);  ?></td>
    <td><?=date('Y-m-d H:i',$item['update_time']);  ?></td>
    <td class="sta">
        <input _id="<?=$item['id']; ?>" <?php if($item['status']=='1'): ?>checked<?php endif;?> type="checkbox" class="status_btn"  value="1" lay-filter="status_btn" lay-skin="switch" lay-text="开启|关闭">
    </td>
    <td>
        <button type="button" _id="<?=$item['id']; ?>" _type="edit" class="layui-btn layui-btn-sm layui-btn-normal block_btn">编辑</button>
        <button type="button" _id="<?=$item['id']; ?>" _type="del" class="layui-btn layui-btn-sm layui-btn-danger block_btn">删除</button>
    </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="tools_page">
        <?=$page_html ?>
    </div>
</div>
</div>



<script>
    $(function () {
        $(".sta ").on('click',function () {
            var id = $(this).find('input').attr('_id');
            var status= '';
            if($(this).find(".layui-form-switch").hasClass('layui-form-onswitch')){
                status ='1'
            }else{
                status='0';
            }
            $.ajax({
                url:"<?php echo buildAjaxUrl('block') ?>",
                type:'get',
                dataType:'json',
                data:{'id':id,'status':status,'type':'edit_status'},
                success:function (e) {
                    layer.msg(e.msg)
                },error:function (e) {
                    layer.msg('意外错误！');
                    console.log(e);
                }
            });
        });

        $(".block_btn").on('click',function () {
            var now_page ="<?=$cur_page?>";
            var type = $(this).attr('_type');
            var id=$(this).attr('_id');
            if(type=='del'){
                layer.confirm('您确定要删除此Block吗？', {
                    btn: ['确定','取消'] //按钮
                }, function(){
                    $.ajax({
                        url:"<?php echo buildAjaxUrl('block') ?>",
                        type:'get',
                        dataType:'json',
                        data:{'id':id,'type':'del'},
                        success:function (e) {
                            layer.msg(e.msg);
                            setTimeout(function () {
                                var url=window.location.href;
                                window.location.href=url;
                            },2000);
                        },error:function (e) {
                            layer.msg('意外错误！');
                            console.log(e);
                        }
                    });
                }, function(){

                });


            }else if(type=='edit'){
                var url ="<?php echo buildUrl('edit_block').'&id=' ?>"+id+'&page='+now_page;
                window.location.href=url;
            }
        });

    });
    layui.use('form', function(form){});
</script>

<?php include "footer.php";?>
