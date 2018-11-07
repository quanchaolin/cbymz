<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * 订单管理
 */
include_once 'Content.php';

class Order extends Content
{
    public $start_time;
    public $end_time;
    function __construct()
    {
        $this->name = '心愿单';
        $this->control = 'order';
        $this->list_view = 'order_list'; // 列表页
        $this->add_view = 'order_add'; // 添加页
        parent::__construct();
        $this->baseurl = site_url('admin/order/');
        $this->load->model('admin/order_model', 'model');
        $this->start_time=date('Y-m-d 00:00:00');
        $this->end_time=date('Y-m-d 00:00:00',strtotime('+1 day'));
    }

    // 首页
    public function index(){
        $url_forward = $this->baseurl . 'index?';
        // 查询条件
        $where = "status=1";
        $where=$this->get_condition($where);
        $keywords = trim($_REQUEST['keywords']);
        if ($keywords) {
            $data['keywords'] = $keywords;
            $url_forward .= "&keywords=" . rawurlencode($keywords);
            $keywords = $this->db->escape_like_str($keywords);
            $where .= " AND (buyer_nick like '%{$keywords}%' OR product_name like '%{$keywords}%')";
        }
        $sel_time = $this->input->get_post("sel_time")?intval($this->input->get_post("sel_time")):1;
        if($sel_time!=0)
        {
            switch($sel_time)
            {
                case 1:
                    $time=date('Y-m-d');
                    $url_forward .= "&sel_time=" . rawurlencode($sel_time);
                    $where.=" AND add_time>='$time'";
                    break;
                case 2:
                    $time=date('Y-m-d',strtotime("-1 day"));
                    $end_time=date('Y-m-d');
                    $url_forward .= "&sel_time=" . rawurlencode($sel_time);
                    $where.=" AND add_time>='$time' AND add_time<'$end_time'";
                    break;
                case 3:
                    $time=date('Y-m-d',strtotime("last month"));
                    $url_forward .= "&sel_time=" . rawurlencode($sel_time);
                    $where.=" AND add_time>='$time'";
                    break;
            }
        }
        // URL及分页
        $offset = intval($_GET['per_page']);
        $data['count'] = $this->model->count($where);
        $data['pages'] = $this->page_html($url_forward, $data['count']);
        $this->url_forward($url_forward . '&per_page=' . $offset);

        // 列表数据
        $list = $this->model->lists('*', $where, 'id DESC', $this->per_page, $offset);
        foreach($list as &$item)
        {
            $item['order_total_price']=$item['order_total_price']/100;
        }
        $data['sel_time']=$sel_time;
        $data['list'] = $list;
        $this->load->view('admin/'.$this->list_view, $data);
    }
    public function export()
    {
        $type=trim($this->input->get('type'));
        $where = "status=1";
        $where=$this->get_condition($where);
        $start_time=trim($this->input->get('start_time'));
        $end_time=trim($this->input->get('end_time'));
        if($start_time!='')
        {
            $where.=" AND add_time>='$start_time'";
        }
        if($end_time!='')
        {
            $where.=" AND add_time<='$end_time'";
        }
        $list = $this->model->lists('*', $where, 'id DESC', 100000,0);
        $txt='';
        foreach($list as &$item)
        {
            $item['order_total_price']=$item['order_total_price']/100;
            if($type=='txt')
            {
                if($item['product_name']!='')
                {
                    $txt.=$item['product_name'].PHP_EOL;
                }
                if($item['receiver_name']!='') {
                    $txt.=$item['receiver_name'].PHP_EOL;
                }
                if($item['content']!=''){
                    $txt.=$item['content'].PHP_EOL;
                }
                if($item['content']!=''){
                    $txt.=$item['add_time'].PHP_EOL;
                }
                $txt.=PHP_EOL.PHP_EOL;
            }
        }
        if($type=='txt') {
            $file_name=date('Y-m-d').'.txt';
            header("Content-type:text/plain");
            header("Accept-Ranges:bytes");
            header("ContentDisposition:attachment;filename=".$file_name);
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0" );
            header("Pragma:no-cache");
            header("Expires:0");
            exit($txt);
        }
        else{
            $data['list']=$list;
            $this->load->view('admin/order_export',$data);
        }
    }
    private function get_condition($where)
    {
        $this->load->model('admin/volunteer_model');
        $this->load->model('admin/volunteer_product_model');
        if($this->admin['role_id']==3)
        {
            $volunteer_where=array('status'=>1,'user_id'=>$this->uid);
            $volunteer_count=$this->volunteer_model->count($volunteer_where);
            $volunteer_list=$this->volunteer_model->lists('id',$volunteer_where,'id DESC',$volunteer_count,0);
            $product_str='';
            foreach($volunteer_list as $item)
            {
                $volunteer_product_count=$this->volunteer_product_model->count(array('volunteer_id'=>$item['id']));
                $volunteer_product_list=$this->volunteer_product_model->lists('product_id',array('volunteer_id'=>$item['id']),'id DESC',$volunteer_product_count,0);
                foreach($volunteer_product_list as $key=>$val)
                {
                    if($key>0)
                    {
                        $product_str.=',';
                    }
                    $product_str.=$val['product_id'];
                }
            }
            if($product_str!='')
            {
                $where.=" AND product_id IN($product_str)";
            }
        }
        return $where;
    }
}
