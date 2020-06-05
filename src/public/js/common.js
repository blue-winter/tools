/**
 * common js
 **/
$(document).on('click','.reload_btn',function () {
    var href =window.location.href;
    window.location.href=href;
});



/*images begin*/

/**
 * 双击预览图片事件
 */
$(document).on('dblclick','.img_tips',function () {
    var src = $(this).attr('src');
    previewImage(src);
});

/**
 * 返回上一级目录
 */
$(document).on('click','.back_btn_file',function () {
    var path = $(this).attr('now_path');
    window.location.href="/?get_url=images&return=1&base_path="+path;
});

/**
 * 选择文件/文件夹事件
 */
$(document).on('click','.select_btn',function () {
    if($(this).hasClass('select')){
        $(this).removeClass('select');
    }else{
        $(this).addClass('select');
    }
    showDescBtn();
});


/**
 * 重命名
 */
$(document).on('click','.rename_desc_btn',function () {
    var count =showDescBtn();
    if(count>1){
        layer.msg('操作失败！最多选择一个文件进行此操作！');
        return false;
    }
    var old_path = $(".select").attr('data-path');
    layer.prompt({title: '请输入新的名称', formType: 3,value:old_name}, function(name, index){
        layer.close(index);
        $.ajax({
            url:'/?ajax_url=imagesdesc',
            data:{'type':'rename','name':name,'old_path':old_path},
            dataType:'json',
            type:'get',
            success:function (e) {
                layer.msg(e.msg);
                setTimeout(function () {
                    $(".reload_btn").click();
                },1500);
            },
            error:function (e) {
                layer.msg('意外错误！');
                console.log(e);
            }
        });
    });



});

/**
 * 创建文件夹
 */
$(document).on('click','.mkdir_desc_btn',function () {

    var old_path = $("#now_path").val();
    layer.prompt({title: '请输入文件夹名称', formType: 3,value:'newDir'}, function(name, index){
        layer.close(index);
        $.ajax({
            url:'/?ajax_url=imagesdesc',
            data:{'type':'mkdir','name':name,'old_path':old_path},
            dataType:'json',
            type:'get',
            success:function (e) {
                layer.msg(e.msg);
                setTimeout(function () {
                    $(".reload_btn").click();
                },1500);
            },
            error:function (e) {
                layer.msg('意外错误！');
                console.log(e);
            }
        });
    });



});

/**
 * 删除文件/文件夹
 */
$(document).on('click','.delete_desc_btn',function () {
    layer.confirm('您确定删除所选中文件/文件夹？将会删除文件夹下所有文件！', {
        btn: ['确定','取消'] //按钮
    }, function(){
        var files= '';
        $(".select_btn").each(function (index,val) {
            if($(this).hasClass('select')){
                var path =$(this).attr("data-path");
                files+=path+',';
            }
        });
        $.ajax({
            url:'/?ajax_url=imagesdesc&type=delete',
            data:{'type':'delete','files':files},
            dataType:'json',
            type:'post',
            success:function (e) {
                layer.msg(e.msg);
                setTimeout(function () {
                    $(".reload_btn").click();
                },1500);
            },
            error:function (e) {
                layer.msg('意外错误！');
                console.log(e);
            }
        });


    }, function(){
    });
});

/**
 * 双击打开文件夹
 */
$(document).on('dblclick','.folder_btn',function () {
    var path = $(this).attr('data-path');
    window.location.href="/?get_url=images&base_path="+path;
});

/**
 * 预览图片
 * @param src
 * @param area
 */
function previewImage(src,area) {
    var img = new Image(), index = layer.load();
    img.style.background = '#fff', img.style.display = 'none';
    img.style.height = 'auto', img.style.width = area || '480px';
    document.body.appendChild(img), img.onerror = function () {
        layer.close(index);
    }, img.onload = function () {
        layer.open({
            type: 1, shadeClose: true, success: img.onerror, content: $(img), title: false,
            area: area || '480px', closeBtn: 1, skin: 'layui-layer-nobg', end: function () {
                document.body.removeChild(img);
            }
        });
    };
    img.src = src;
}


function showDescBtn() {
    var is_show=false;
    var count=0;
    $(".select_btn").each(function (index,val) {
        if($(this).hasClass('select')){
            is_show=true;
            count++;
        }
    });
    if(is_show){
        $(".desc_btn_cont").show();
    }else{
        $(".desc_btn_cont").hide();
    }
    return count;
}

/*images end */