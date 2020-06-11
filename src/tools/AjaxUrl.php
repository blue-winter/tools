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
        $config['host']=Param('get.host');
        $config['dbname']=Param('get.dbname');
        $config['user']=Param('get.user');
        $config['password']=Param('get.password');
        $config['port']=Param('get.port');
        $config['charset']='utf8mb4';
        $tools=(new ToolDb($config));
        try{
            $tools->install($config);
            (new InstallDb())->installAll();
            (new InstallDb())->createInstallFile();
            toolsConfig('install','1');
            toolsConfig('is_open_admin_tools','1');
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

    public function base64()
    {
        $type =Param('get.type');
        $str =Param('get.str');
        if($type=='decode'){
            echo json_encode(['val'=>base64_decode($str)]);die;
        }elseif($type=='encode'){
            echo json_encode(['val'=>base64_encode($str)]);die;
        }
    }

    public function setting()
    {
        $info = Param('post.');
        $is_open = Param('post.is_open_admin_tools');
        $is_open = $is_open=='1'?'1':'0';
        toolsConfig('is_open_admin_tools',$is_open);
        if($info){
            foreach ($info as $k=> $vo)
            {
                if($k!='is_open_admin_tools'){
                    toolsConfig($k,$vo);
                }
                if($k=='admin_tools_login'){
                    toolsConfig($k,md5($vo));
                }
            }
        }
        echo json_encode(['msg'=>'修改成功！']);

    }

    public function block()
    {
        if($data=Param('post.'))
        {
            $id = $data['id'];
            initToolsDb();

            if($id!=''){
                $res =\DB::update('tools_blocks',['status'=>$data['status'],'name'=>$data['name'],'block_name'=>trim($data['block_name']),'desc'=>$data['desc'],'content'=>$data['content'],'create_time'=>time()],"id=%s",$id);
            }else{
                $res=\DB::insert('tools_blocks',
                    [
                        'status'=>$data['status'],
                        'name'=>$data['name'],
                        'block_name'=>trim($data['block_name']),
                        'desc'=>$data['desc'],
                        'content'=>$data['content'],
                        'create_time'=>time(),
                        'update_time'=>time(),
                    ]);
            }
            if($res){
                echo json_encode(['msg'=>'操作成功！']);die;
            }else{
                echo json_encode(['msg'=>'操作失败！']);die;
            }
        }


        $type =Param('get.type');
        if($type=='edit_status')
        {
            $id = $type =Param('get.id');
            $status = $type =Param('get.status');
            initToolsDb();
            $res = \DB::update('tools_blocks',['status'=>$status,'create_time'=>time()],"id=%s",$id);
            if($res)
            {
                echo json_encode(['msg'=>'修改成功！']);die;
            }else{
                echo json_encode(['msg'=>'修改失败！']);die;
            }
        }elseif($type=='del')
        {
            initToolsDb();
            $id = $type =Param('get.id');
            $res = \DB::delete('tools_blocks',"id=%s",$id);
            if($res)
            {
                echo json_encode(['msg'=>'删除成功！']);die;
            }else{
                echo json_encode(['msg'=>'删除失败！']);die;
            }
        }elseif($type=='check')
        {
            initToolsDb();
            $block_name =Param('get.block_name');
            $id =Param('get.id');
            if($id){
                $is_exist = \DB::queryFirstRow("select * from tools_blocks where block_name =%s and id <> %i",$block_name,$id);
            }else{
                $is_exist = \DB::queryFirstRow("select * from tools_blocks where block_name =%s",$block_name);
            }

            if($is_exist)
            {
                echo json_encode(['code'=>'0','msg'=>'此Block Name已存在！']);die;
            }else{
                echo json_encode(['code'=>'1']);die;
            }
        }


    }


    /**
     * upload
     */
    public function upload()
    {
        $path =Param('get.path');
        $res =uploadFile(base64_decode($path));
        echo json_encode($res);die;
    }
}
