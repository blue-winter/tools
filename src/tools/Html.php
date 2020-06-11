<?php
namespace admintools\tools\tools;

use admintools\tools\Common;

class Html extends Common
{

    public function __construct($ajax = false)
    {
        error_reporting(E_ALL ^ E_NOTICE);
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
     * block
     */
    public function block()
    {
        initToolsDb();
        $page_size=8;
        $cur_page = Param('get.page')?Param('get.page'):1;
        $search = Param('get.block_name');
        if($search){
            $where = " where `block_name` LIKE '%".trim($search)."%'";
        }else{
            $where='';
        }
        $sql ="select count(id) as num from tools_blocks  {$where} order by update_time desc;";
        $total=\DB::queryFirstRow($sql);
        $total = isset($total['num'])?$total['num']:0;
        $page_config=[
            'cur_page'=>$cur_page,
            'total'=>$total,
            'page_size'=>$page_size,
            'base_url'=>buildUrl('block'),
            'num_size'=>2,
            'params'=>''//?test=1
        ];
        $page  = new ToolsPage($page_config);
        $start = ($cur_page-1)*$page_size;//按照分页规律计算出数据起始条数

        $page_html = $page->show_page();

        $sql = "SELECT * FROM tools_blocks  {$where} LIMIT $start,$page_size";
        $result = \DB::query($sql);

        require_once getPublicPath().'html/block.php';
    }

    /**
     * edit block
     */
    public function edit_block()
    {
        $id=Param('get.id');
        $page=Param('get.page');
        initToolsDb();
        $info = \Db::queryFirstRow("select * from tools_blocks where id=%s",$id);

        require_once getPublicPath().'html/edit_block.php';
    }

    /**
     * add block
     */
    public function add_block()
    {
        $page=1;
        require_once getPublicPath().'html/edit_block.php';
    }

    /**
     * show menus
     */
    public function menusShow()
    {
        if($this->is_allow){
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
                $is_show = true;
                if($this->installStatus()){
                    $_is_show=toolsConfig('is_open_admin_tools');
                    $is_show= ($_is_show=='1')?true:false;
                }
                require_once getPublicPath().'html/menus.php';
            }
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
