<?php
$path =getPublicPath(false);
$menus = isset($menus)&&$menus?$menus:(new \admintools\tools\tools\Html())->menus;
?>
<link rel="stylesheet" href="<?php echo $path; ?>css/asidenav.css">
<script>
    !window.jQuery && document.write('<script src="<?php echo $path; ?>js/jquery.min.js"><\/script>');
</script>
<script type="text/javascript" src="<?php echo $path; ?>js/asidenav.js"></script>
<script>
    !window.layer && document.write('<script src="<?php echo $path; ?>layui/layui.all.js"><\/script>');
</script>

<div  class="aside-nav bounceInUp animated" id="aside-nav">
    <label  class="aside-menu" title="Admin Tools">Tools</label>
    <?php foreach ($menus as $menu): ?>
        <a _link="<?php echo $menu['link']; ?>" href="javascript:void(0)" title="<?php echo $menu['title']; ?>" class="tool_menu menu-item <?php echo $menu['class']; ?> "><?php echo $menu['title']; ?></a>
    <?php endforeach; ?>
</div>
<script>
    $(function () {
        $(".aside-menu").each(function (index,val) {
            if(index!=0){
                $(val).parent().remove();
            }
        })
    });
    $(document).on('click','.tool_menu',function () {
        var url =$(this).attr('_link');
        layer.open({
            type:2,
            shadeClose:false,
            title:$(this).attr('title'),
            area: ['60%', '80%'],
            content:'/?get_url='+url
        });

    });
</script>
