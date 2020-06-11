/**
 * common js
 **/

var BASE64={

    enKey: 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/',

    deKey: new Array(
        -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
        -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
        -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 62, -1, -1, -1, 63,
        52, 53, 54, 55, 56, 57, 58, 59, 60, 61, -1, -1, -1, -1, -1, -1,
        -1, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14,
        15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, -1, -1, -1, -1, -1,
        -1, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40,
        41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, -1, -1, -1, -1, -1
    ),

    encode: function(src){
        //用一个数组来存放编码后的字符，效率比用字符串相加高很多。
        var str=new Array();
        var ch1, ch2, ch3;
        var pos=0;
        //每三个字符进行编码。
        while(pos+3<=src.length){
            ch1=src.charCodeAt(pos++);
            ch2=src.charCodeAt(pos++);
            ch3=src.charCodeAt(pos++);
            str.push(this.enKey.charAt(ch1>>2), this.enKey.charAt(((ch1<<4)+(ch2>>4))&0x3f));
            str.push(this.enKey.charAt(((ch2<<2)+(ch3>>6))&0x3f), this.enKey.charAt(ch3&0x3f));
        }
        //给剩下的字符进行编码。
        if(pos<src.length){
            ch1=src.charCodeAt(pos++);
            str.push(this.enKey.charAt(ch1>>2));
            if(pos<src.length){
                ch2=src.charCodeAt(pos);
                str.push(this.enKey.charAt(((ch1<<4)+(ch2>>4))&0x3f));
                str.push(this.enKey.charAt(ch2<<2&0x3f), '=');
            }else{
                str.push(this.enKey.charAt(ch1<<4&0x3f), '==');
            }
        }
        //组合各编码后的字符，连成一个字符串。
        return str.join('');
    },

    decode: function(src){
        //用一个数组来存放解码后的字符。
        var str=new Array();
        var ch1, ch2, ch3, ch4;
        var pos=0;
        //过滤非法字符，并去掉'='。
        src=src.replace(/[^A-Za-z0-9\+\/]/g, '');
        //decode the source string in partition of per four characters.
        while(pos+4<=src.length){
            ch1=this.deKey[src.charCodeAt(pos++)];
            ch2=this.deKey[src.charCodeAt(pos++)];
            ch3=this.deKey[src.charCodeAt(pos++)];
            ch4=this.deKey[src.charCodeAt(pos++)];
            str.push(String.fromCharCode(
                (ch1<<2&0xff)+(ch2>>4), (ch2<<4&0xff)+(ch3>>2), (ch3<<6&0xff)+ch4));
        }
        //给剩下的字符进行解码。
        if(pos+1<src.length){
            ch1=this.deKey[src.charCodeAt(pos++)];
            ch2=this.deKey[src.charCodeAt(pos++)];
            if(pos<src.length){
                ch3=this.deKey[src.charCodeAt(pos)];
                str.push(String.fromCharCode((ch1<<2&0xff)+(ch2>>4), (ch2<<4&0xff)+(ch3>>2)));
            }else{
                str.push(String.fromCharCode((ch1<<2&0xff)+(ch2>>4)));
            }
        }
        //组合各解码后的字符，连成一个字符串。
        return str.join('');
    }
};


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
    var old_name = $(".select .filename .db-click-rename").html();
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
 * file path
 */
$(document).on('click','.file_path_btn',function () {
    var count =showDescBtn();
    if(count>1){
        layer.msg('查看失败！最多选择一个文件进行此操作！');
        return false;
    }
    var old_path = $(".select").attr('data-path');
    var old_name = $(".select .filename .db-click-rename").html();
    $.ajax({
        url:'/?ajax_url=base64',
        data:{'type':'decode','str':old_path},
        dataType:'json',
        type:'get',
        success:function (e) {
            var path =e.val;
            if(path){
                layer.prompt({title: '路径', formType: 3,value:path}, function(name, index){
                    layer.close(index);
                });
            }
        },
        error:function (e) {
            layer.msg('意外错误！');
            console.log(e);
        }
    });
    return ;




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