<?php
namespace admintools\tools\tools;


class ToolsPage{
    private $cur_page;//当前页
    private $total;//总条数
    private $page_size = 10;//每页显示的条数
    private $total_page;//总页数
    private $first_page;//首页显示名称
    private $pre_page;//上一页的显示名称
    private $nex_page;//下一页的显示名称
    private $end_page;//尾页名称
    private $params;//分页后面的筛选参数
    private $num_size = 2;//当前页前后显示几个分页码
    private $base_url;//分页链接地址
    public function __construct(array $page_config=[])
    {
        $this->cur_page = $page_config['cur_page'];
        $this->total = $page_config['total'];
        $this->page_size = $page_config['page_size'];
        $this->base_url = $page_config['base_url'];
        $this->pre_page = isset($page_config['pre_page']) ? $page_config['pre_page'] : "上一页";
        $this->nex_page = isset($page_config['next_page']) ? $page_config['next_page'] : "下一页";
        $this->end_page = isset($page_config['end_page']) ? $page_config['end_page'] : "尾页";
        $this->first_page = isset($page_config['first_page']) ? $page_config['first_page'] : "首页";
        $this->num_size = isset($page_config['num_size']) ? $page_config['num_size'] : 2;
        $this->params = isset($page_config['params']) ?$page_config['params'] : '';
        $this->total_page = ceil($this->total/$this->page_size);
    }

    /**
     * 获取首页的链接地址
     */
    public function get_first_page(){
        if ($this->cur_page > 1 && $this->cur_page != 1){
            return $this->get_link($this->get_url(1),$this->first_page);
        }
        return "<span class='layui-disabled'>$this->first_page</span>";
    }

    /**
     * 获取上一页链接地址
     */
    public function get_prev_page(){
        if ($this->cur_page > 1 && $this->cur_page !=1){
            return $this->get_link($this->get_url($this->cur_page-1),$this->pre_page);
        }
        return '<span>'.$this->pre_page.'</span>';
    }

    /**
     * 获取下一页链接地址
     * @return string
     */
    public function get_next_page(){
        if ($this->cur_page < $this->total_page){
            return $this->get_link($this->get_url($this->cur_page+1),$this->nex_page);
        }
        return '<span class="layui-disabled">'.$this->nex_page.'</span>';
    }

    /**
     * 获取...符号
     * @return string
     */
    public function get_ext(){
        return '<span>...</span>';
    }

    /**
     * 获取尾页地址
     */
    public function get_end_page(){
        if ($this->cur_page < $this->total_page){
            return $this->get_link($this->get_url($this->total_page),$this->end_page);
        }
        return '<span class="layui-disabled">'.$this->end_page.'</span>';
    }

    /**
     * 中间的数字分页
     */
    public function now_bar(){
        if ($this->cur_page > $this->num_size){
            $begin = $this->cur_page - $this->num_size;
            $end = $this->cur_page + $this->num_size;
            //判断最后一页是否大于总页数
            if ($end > $this->total_page){
                //重新计算开始页和结束页
                $begin = ($this->total_page - 2*$this->num_size > 0) ? $this->total_page - 2*$this->num_size : 1;
                //这里为什么用2*$this->num_size呢？因为当前页前后有2个$this->num_size的间距，所以这里是2*$this->num_size
                $end = $this->total_page;
            }
        }else{
            $begin = 1;
            $end = 2*$this->num_size+1;//此处的2和上面已经解释过了，+1是因为除了当前页，前后还有2*$this->num_size的间距，所以总页码条数为2*$this->num_size+1
        }
        $total_num =$this->total_page;
        if($end>$total_num)$end= $total_num;

        $page_html='';
        for ($i=$begin;$i<=$end;$i++){
            if ($i == $this->cur_page){
                $page_html .= '<span class="layui-disabled">'.$i.'</span>';
            }else{
                $page_html .= $this->get_link($this->get_url($i),$i);
            }
        }
        return $page_html;
    }

    /**
     * 输出分页码
     */
    public function show_page(){
        $show_page = '';
        //$ext = ($this->cur_page>$this->num_size) ? $this->get_ext() : '';
        $ext = '';
        $show_page.= $this->show_total_row();
        $show_page.= $this->show_total_page();
        $show_page.= $this->get_first_page();
        $show_page.= $this->get_prev_page();
        $show_page.= $ext;
        $show_page.= $this->now_bar();
        $show_page.= $ext;
        $show_page.= $this->get_next_page();
        $show_page.= $this->get_end_page();

        return $show_page;
    }

    /**
     * 获取分页地址 xxx.com/index/3
     * @param $i
     */
    public function get_url($i){
        return $this->base_url.'&page='.$i;
    }

    /**
     * 获取分页完整链接
     * @param $url
     */
    public function get_link($url,$text){
        if ($this->params) $url.=$this->params;
        return "<a href='$url'>$text</a>";
    }

    /**
     * 返回总条数
     * @return string
     */
    public function show_total_row(){
        return "共{$this->total}条";
    }

    /**
     * 返回总页数
     */
    public function show_total_page(){
        return "共{$this->total_page}页";
    }
}