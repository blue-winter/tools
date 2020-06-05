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
<?php  if($is_show_menu){ ?>
    <div class="aside-nav bounceInUp animated" id="aside-nav">
        <label for="" class="aside-menu" title="Admin Tools">Tools</label>
        <?php foreach ($menus as $menu): ?>
            <a _link="<?php echo $menu['link']; ?>" href="javascript:void(0)" title="<?php echo $menu['title']; ?>" class="tool_menu menu-item <?php echo $menu['class']; ?> "><?php echo $menu['title']; ?></a>
        <?php endforeach; ?>
    </div>
    <script>
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
<?php }?>

<div>
