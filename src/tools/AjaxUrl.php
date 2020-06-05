<?php
namespace admintools\tools\tools;

use admintools\tools\Common;

class AjaxUrl extends Common
{
    /**
     * install
     */
    public function install()
    {
        $config['host']=($_GET['host']);
        $config['dbname']=($_GET['dbname']);
        $config['user']=($_GET['user']);
        $config['password']=($_GET['password']);
        $config['port']=($_GET['port']);
        $config['charset']='utf8mb4';
        $tools=(new ToolDb($config));
        try{
            $tools->install($config);
            (new InstallDb())->installAll();
            (new InstallDb())->createInstallFile();
            toolsConfig('install','1');
            echo json_encode(['msg'=>'Install Success！','code'=>'200']);die;
        }catch (\Exception $e){
            echo  json_encode(['msg'=>'Install Error！','code'=>'100']);die;
        }

    }

    /**
     * images desc
     */
    public function imagesdesc()
    {
        $type= Param('get.type');
        //重命名
        if($type=='rename'){
            $name= Param('get.name');
            $old_path= base64_decode(Param('get.old_path'));
            $type =substr($old_path,strripos($old_path,'.'));
            $new_name = dirname($old_path).'/'.$name.$type;
            try{
                $res = rename(($old_path),$new_name);
                if($res){
                    echo json_encode(['msg'=>'重命名成功']);die;
                }else{
                    echo json_encode(['msg'=>'重命名失败,请重试！']);die;
                }
            }catch (\Exception $e){
                echo json_encode(['msg'=>'重命名失败，请检查是否有写权限']);die;
            }
        }
        elseif($type=='mkdir'){
            $name= Param('get.name');
            $old_path= base64_decode(Param('get.old_path'));
            $new_dir = ($old_path).'/'.$name;
            if(is_dir($new_dir)){
                echo json_encode(['msg'=>'创建失败,文件夹已存在']);die;
            }else{
                try{
                    mkdir ($new_dir,0777,true);
                    echo json_encode(['msg'=>'创建成功']);die;
                }catch (\Exception $e){
                    echo json_encode(['msg'=>'新建失败，请检查是否有写权限！']);die;
                }
            }
        }
        elseif($type=='delete'){
            $files= trim(Param('post.files'),',');
            $files=explode(',',$files);
            try{
                foreach ($files as $file){
                    deldir(base64_decode($file));
                }
                echo json_encode(['msg'=>'删除成功']);die;
            }catch (\Exception $e){
                echo json_encode(['msg'=>'删除失败,请检查权限重试']);die;
            }


        }
    }

    /**
     * upload
     */
    public function upload()
    {
        $res =uploadFile();
        echo json_encode($res);die;
    }
}
