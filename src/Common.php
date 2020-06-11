<?php
namespace admintools\tools;
use admintools\tools\tools\AjaxUrl;

class Common
{
    public $menus;
    protected $is_allow;

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
                'title'=>'Media',
                'class'=>'menu-second',
            ],
            3=>[
                'link'=>'block',
                'title'=>'Block',
                'class'=>'menu-third',
            ],
            4=>[
                'link'=>'#',
                'title'=>'其他',
                'class'=>'menu-fourth',
            ],
        ];
        $this->menus=$menus;
        $this->installStatus();
        $this->logout();
        $this->login();
        $this->init();
        if(!$ajax){
            $this->ajaxData();
        }
    }

    private function init()
    {
        $is_allow= $this->checkAuth();
        $this->is_allow=$is_allow;
    }

    protected function login()
    {
        if($this->installStatus()){
            $pwd= trim(Param('get.login'));
            if($pwd){
                CookieTools('admin_tools_login',md5($pwd),43200);
            }
        }
    }

    protected function logout()
    {
        if($this->installStatus()){
            if(Param('get.logout')){
            CookieTools('admin_tools_login',null);
        }
        }

    }

    protected function checkAuth()
    {
        if($this->installStatus()){
            $old=CookieTools('admin_tools_login');
            $true_key= toolsConfig('admin_tools_login');
            if($true_key){
                if($old&&$old==$true_key){
                    CookieTools('admin_tools_login',$old,43200);
                    return  true;
                }else{
                    return false;
                }
            }
        }
        return true;
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
