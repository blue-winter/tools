<?php
namespace admintools\tools\tools;

use admintools\tools\Common;

class Html extends Common
{

    public function __construct($ajax = false)
    {
        parent::__construct($ajax);
    }

    /**
     * index setting
     */
    public function index()
    {
        require_once getPublicPath().'html/index.php';
    }

    /**
     * images
     */
    public function images()
    {
        $file = Param('get.base_path');
        $dir = $file?base64_decode($file):getMediaPath();
        $return =Param('get.return');
        if($return=='1'){
            $dir = dirname(($dir));
        }
        $is_show=false;
        if(trim($dir,'/')!=trim(getMediaPath(),'/')){
            $is_show=true;
        }

        $data['top_menu'] =getDirParent($dir);
        $data['is_show'] = $is_show;

        $data['files']=listPath(trim($dir,'/'));
        $data['now_path']= base64_encode($dir);
        $data['level']=[];

        require_once getPublicPath().'html/images.php';
    }

    /**
     * show menus
     */
    public function menusShow()
    {
        createStatic();
        header("Content-Type: text/html;charset=utf-8");
        $get_url = Param('get.get_url');
        if($get_url){
            //is install
            if($this->installStatus()){
                $url = $get_url;
                call_user_func([new Html(false),$url]);
            }else{
                require_once getPublicPath().'html/install.php';
            }
            die;
        }else{
            require_once getPublicPath().'html/menus.php';
        }
    }

    /**
     * install page
     */
    public function install()
    {
        require_once getPublicPath().'html/install.php';
    }
}
