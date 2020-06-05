<?php
namespace admintools\tools;
use admintools\tools\tools\AjaxUrl;

class Common
{
    public $menus;

    public function __construct($ajax=false)
    {
        $menus=[
            1=>[
                'link'=>'index',
                'title'=>'设置',
                'class'=>'menu-first',
            ],
            2=>[
                'link'=>'images',
                'title'=>'文件管理',
                'class'=>'menu-second',
            ],
            3=>[
                'link'=>'#',
                'title'=>'Block',
                'class'=>'menu-third',
            ],
            4=>[
                'link'=>'#',
                'title'=>'更多',
                'class'=>'menu-fourth',
            ],
        ];
        $this->menus=$menus;
        $this->installStatus();
        if(!$ajax){
            $this->ajaxData();
        }
    }

    /**
     * set menus data
     * @param $menus
     */
    protected function setMenus($menus)
    {
        $this->menus=$menus;
    }

    /**
     * ajax request
     */
    protected function ajaxData()
    {
        if(Param('get.ajax_url')){
            $url = Param('get.ajax_url');
            if($url){
                call_user_func([new AjaxUrl(true),$url]);
                die;
            }else{
                die;
            }
        }
    }

    /**
     * install status
     * @return bool
     */
    public function installStatus()
    {
        try{
            $is_install=\admintools\tools\facade\InstallDb::createInstallFile(true);
            return  $is_install;
        }catch (\Exception $e){
            return false;
        }
    }
}
