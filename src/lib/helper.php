<?php
/**
 * helper functions
 */

if (!function_exists('dump'))
{
    /**
     * 浏览器友好的变量输出
     * @param mixed $vars 要输出的变量
     * @return void
     */
    function dump(...$vars)
    {
        ob_start();
        var_dump(...$vars);

        $output = ob_get_clean();
        $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);

        if (PHP_SAPI == 'cli') {
            $output = PHP_EOL . $output . PHP_EOL;
        } else {
            if (!extension_loaded('xdebug')) {
                $output = htmlspecialchars($output, ENT_SUBSTITUTE);
            }
            $output = '<pre>' . $output . '</pre>';
        }

        echo $output;
    }
}

if(!function_exists('showToolsMenu'))
{
    /**
     * show menu
     * @return mixed
     */
    function showToolsMenu(){
        return \admintools\tools\facade\Html::menusShow();
    }
}

if(!function_exists('initToolsDb'))
{
    function initToolsDb(){
        return \admintools\tools\facade\ToolDb::init();
    }
}

if(!function_exists('getBasePath'))
{
    function getBasePath()
    {
        return $_SERVER['DOCUMENT_ROOT'].'/' ;
    }
}

if(!function_exists('getMediaPath'))
{
    /**
     * @return string
     */
    function getMediaPath()
    {
        $dir =getBasePath().'/tools/media/';
        if(!is_dir($dir)){
            try{
                mkdir ($dir,0777,true);
            }catch (\Exception $e){
                return "File creation failed, no permission! \n Please manually create in the root directory of the website: tools/config.php";
                die;
            }
        }
        return $dir;
    }
}

if(!function_exists('deldir'))
{
    /**
     * 删除文件/文件夹
     * @param $path
     * @return bool
     */
    function deldir($path){
        //给定的目录不是一个文件夹
        if(!is_dir($path)){
            if(is_file($path)){
                $res =unlink($path);
                if($res){
                    return true;
                }else{
                    return  false;
                }
            }else{
                return  false;
            }
        }
        $fh = opendir($path);
        while(($row = readdir($fh)) !== false){
            //过滤掉虚拟目录
            if($row == '.' || $row == '..'){
                continue;
            }
            if(!is_dir($path.'/'.$row)){
                unlink($path.'/'.$row);
            }
            deldir($path.'/'.$row);
        }
        //关闭目录句柄，否则出Permission denied
        closedir($fh);
        //删除文件之后再删除自身
        if(!rmdir($path)){
            return  false;
        }
        return true;
    }
}

if(!function_exists('listPath')){
    /**
     * 遍历文件夹
     * @param $path
     */
    function listPath($path)
    {
        if(is_dir($path)){
            $info=[];
            $files=scandir($path);
            foreach ($files as $file)
            {
                if($file=='.'||$file=='..'){continue;}
                $temp= $path.'/'.$file;
                if(is_dir($temp)){
                    $t['type']='path';
                    $t['name']=$file;
                    $t['path']=$temp.'/';
                    $t['sort']=2;
                    $t['size']='未计算';
                    $t['last_time']=filemtime($temp)?date('Y-m-d H:i:s',filemtime($temp)):'未知';
                }else{
                    $type = substr($file,strripos($file,'.'));
                    $img=['.jpg','.jpeg','.gif','.png'];
                    if(in_array($type,$img)){
                        $t['type']='img';
                        $t['sort']=1;
                    }else{
                        $t['type']='file';
                        $t['sort']=0;
                    }
                    $t['size']=round(filesize($temp)/1024,2).'Kb';
                    $t['last_time']=filemtime($temp)?date('Y-m-d H:i:s',filemtime($temp)):'未知';
                    $t['name']=$file;
                    $t['base_path']=substr($temp,strpos($temp,'/tools/media/')+13);
                    $t['path']=$temp;
                }
                $info[]= $t;
            }
            array_multisort($info,SORT_DESC);
            return  $info;
        }else{
            return false;
        }
    }
}

if(!function_exists('getDirParent'))
{
    /**
     * 获取父级路径
     * @param $dir
     * @return array
     */
    function getDirParent($dir)
    {
        $stop_dir =getMediaPath();
        $result=[];
        do{
            if(trim($stop_dir,'/')==trim($dir,'/')){
                $now_name = trim($dir,'/');
                $now_name=trim(substr($now_name,strripos($now_name,'/')),'/');
                $t=[
                    'name'=>  $now_name,
                    'path' =>base64_encode($dir)
                ];
                $result[] = $t;
                break;
            }else{
                $now_name = trim($dir,'/');
                $now_name=trim(substr($now_name,strripos($now_name,'/')),'/');
                $t=[];
                $t['name']=$now_name;
                $t['path']=base64_encode($dir);
                $dir=dirname($dir);
                $result[]=$t;
            }
        }while(true);
        return  array_reverse($result);
    }
}





if(!function_exists('Param'))
{
    /**
     * 获取输入参数 支持过滤和默认值
     * 使用方法:
     * <code>
     * Param('id',0); 获取id参数 自动判断get或者post
     * Param('post.name','','htmlspecialchars'); 获取$_POST['name']
     * Param('get.'); 获取$_GET
     * </code>
     * @param string $name 变量的名称 支持指定类型
     * @param mixed $default 不存在的时候默认值
     * @param mixed $filter 参数过滤方法
     * @param mixed $datas 要获取的额外数据源
     * @return mixed
     */
    function Param($name,$default='',$filter=null,$datas=null) {
        if(strpos($name,'.')) { // 指定参数来源
            list($method,$name) =   explode('.',$name,2);
        }else{ // 默认为自动判断
            $method =   'param';
        }
        switch(strtolower($method)) {
            case 'get'     :   $input =& $_GET;break;
            case 'post'    :   $input =& $_POST;break;
            case 'put'     :   parse_str(file_get_contents('php://input'), $input);break;
            case 'param'   :
                switch($_SERVER['REQUEST_METHOD']) {
                    case 'POST':
                        $input  =  $_POST;
                        break;
                    case 'PUT':
                        parse_str(file_get_contents('php://input'), $input);
                        break;
                    default:
                        $input  =  $_GET;
                }
                break;
            case 'path'    :
                $input  =   array();
                if(!empty($_SERVER['PATH_INFO'])){
                    $depr   =   '/';
                    $input  =   explode($depr,trim($_SERVER['PATH_INFO'],$depr));
                }
                break;
            case 'request' :   $input =& $_REQUEST;   break;
            case 'session' :   $input =& $_SESSION;   break;
            case 'cookie'  :   $input =& $_COOKIE;    break;
            case 'server'  :   $input =& $_SERVER;    break;
            case 'globals' :   $input =& $GLOBALS;    break;
            case 'data'    :   $input =& $datas;      break;
            default:
                return NULL;
        }
        if(''==$name) { // 获取全部变量
            $data       =   $input;
            $filters    =   isset($filter)?$filter:'';
            if($filters) {
                if(is_string($filters)){
                    $filters    =   explode(',',$filters);
                }
                foreach($filters as $filter){
                    $data   =   array_map_recursive($filter,$data); // 参数过滤
                }
            }
        }elseif(isset($input[$name])) { // 取值操作
            $data       =   $input[$name];
            $filters    =   isset($filter)?$filter:'htmlspecialchars';
            if($filters) {
                if(is_string($filters)){
                    $filters    =   explode(',',$filters);
                }elseif(is_int($filters)){
                    $filters    =   array($filters);
                }

                foreach($filters as $filter){
                    if(function_exists($filter)) {
                        $data   =   is_array($data)?array_map_recursive($filter,$data):$filter($data); // 参数过滤
                    }else{
                        $data   =   filter_var($data,is_int($filter)?$filter:filter_id($filter));
                        if(false === $data) {
                            return   isset($default)?$default:NULL;
                        }
                    }
                }
            }
        }else{ // 变量默认值
            $data       =    isset($default)?$default:NULL;
        }
        return $data;
    }

}

if(!function_exists('toolsConfig')){
    function toolsConfig($name,$value=false)
    {
        initToolsDb();
        //修改
        if($value!==false){
            $is_exist =DB::queryFirstRow('SELECT * FROM tools_core_config where name =%s',$name);
            if($is_exist){
                if(is_array($value)){
                    $res=DB::update('tools_core_config',['value'=>json_encode($value)],'id=%s',$is_exist['id']);
                }else{
                    $res=DB::update('tools_core_config',['value'=>($value)],'id=%s',$is_exist['id']);
                }
                if($res!==false){
                    return true;
                }else{
                    return false;
                }
            }else{
                if(is_array($value)){
                    $res =DB::insert('tools_core_config',['name'=>$name,'value'=>json_encode($value)]);
                }else{
                    $res =DB::insert('tools_core_config',['name'=>$name,'value'=>($value)]);
                }
                if($res){
                    return true;
                }else{
                    return false;
                }
            }
        }
        //查询
        else{
            $res = DB::queryFirstRow('SELECT * FROM tools_core_config where name =%s',$name);
            $is_array =$res['value']&&is_array(json_decode($res['value']))?true:false;
            if($is_array&&$res['value']){
                return json_decode($res['value']);
            }else{
                return $res['value'];
            }
        }
    }
}

if(!function_exists('get_client_ip'))
{
    function get_client_ip() {
        $ip = $_SERVER['REMOTE_ADDR'];
        if (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
            foreach ($matches[0] AS $xip) {
                if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                    $ip = $xip;
                    break;
                }
            }
        }
        return $ip;
    }
}

if(!function_exists('getPublicPath'))
{
    /**
     * 获取资源目录路径
     * @param bool $absolute  绝对路径
     * @return string
     */
    function getPublicPath($absolute =true)
    {
        if($absolute){
            $path =dirname(dirname(__FILE__)).'/public/';
        }else{
            $path_1='/vendor/admintools/tools/src/public/';
            $path_2='/src/public/';//test
            if(is_dir(getBasePath().$path_1)){
                $path = $path_1;
            }else{
                $path = $path_2;
            }
        }
        return $path;
    }
}

if(!function_exists('uploadFile'))
{
    /**
     * layui+多文件上传
     * @param string $path
     * @return array
     */
    function uploadFile($path='')
    {
        //上传文件目录获取
        //define('BASE_PATH',str_replace('\\','/',realpath(dirname(__FILE__).'/'))."/");
        $dir = $path==''?'./tools/media/':$path;

        //初始化返回数组
        $arr = array(
            'code' => 0,
            'msg'=> '',
            'data' =>array(
                'src' => $dir . $_FILES["file"]["name"]
            ),
        );

        $file_info = $_FILES['file'];
        $file_error = $file_info['error'];
        if(!is_dir($dir))//判断目录是否存在
        {
            mkdir ($dir,0777,true);//如果目录不存在则创建目录
        };
        $file = $dir.$_FILES["file"]["name"];
        if(file_exists($file)){
            $file_name =$_FILES["file"]["name"];
            $type =substr($file_name,strripos($file_name,'.'));
            $name= substr($file_name,0,strripos($file_name,'.'));
            $file = $dir.$name.'('.rand(1000000,9000000).')'.$type;
            $arr['data']['src']= $file;
        }
        if(!file_exists($file))
        {
            if($file_error == 0){
                if(move_uploaded_file($_FILES["file"]["tmp_name"],$dir. $_FILES["file"]["name"])){
                    $arr['msg'] ="上传成功";
                }else{
                    $arr['msg'] = "上传失败";
                }
            }else{
                switch($file_error){
                    case 1:
                        $arr['msg'] ='上传文件超过了PHP配置文件中upload_max_filesize选项的值';
                        break;
                    case 2:
                        $arr['msg'] ='超过了表单max_file_size限制的大小';
                        break;
                    case 3:
                        $arr['msg'] ='文件部分被上传';
                        break;
                    case 4:
                        $arr['msg'] ='没有选择上传文件';
                        break;
                    case 6:
                        $arr['msg'] ='没有找到临时文件';
                        break;
                    case 7:
                    case 8:
                        $arr['msg'] = '系统错误';
                        break;
                }
            }
        }
        else
        {
            $arr['code'] ="1";
            $arr['msg'] = "当前目录中，文件".$file."已存在";
        }
        return $arr;
    }
}


if(!function_exists('buildAjaxUrl'))
{
    function buildAjaxUrl($action)
    {
        return "/?ajax_url=".$action;
    }
}

if(!function_exists('buildUrl'))
{
    function buildUrl($action)
    {
        return "/?get_url=".$action;
    }
}



