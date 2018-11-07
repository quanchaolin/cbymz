<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 日行一善管理
 */
include_once 'Content.php';

class Rxysh extends Content
{
    public $id=1;
    public $start_time;
    public $end_time;
    function __construct()
    {
        $this->name = '日行一善';
        $this->control = 'rxysh';
        $this->list_view = 'rxysh_list'; // 列表页
        $this->add_view = 'rxysh_add'; // 添加页
        parent::__construct();
        $this->baseurl = site_url('admin/rxysh/');
        $this->load->model('admin/order_model', 'model');
        $this->load->model('admin/packet_type_model');
        $this->start_time=date('Y-m-d 00:00:00');
        $this->end_time=date('Y-m-d 00:00:00',strtotime('+1 day'));
    }

    // 首页
    public function index(){
        $url_forward = $this->baseurl . 'index?';
        // 查询条件
        $where = "status=1 AND product_id=$this->id";
        $keywords = trim($_REQUEST['keywords']);
        if ($keywords) {
            $data['keywords'] = $keywords;
            $url_forward .= "&keywords=" . rawurlencode($keywords);
            $keywords = $this->db->escape_like_str($keywords);

            $where .= " AND buyer_nick like '%{$keywords}%' ";
        }
        $sel_time = intval($this->input->get_post("sel_time"));
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
        $packet_type=config_item('packet_type');
        foreach($list as &$item)
        {
            $item['order_total_price']=$item['order_total_price']/100;
            foreach($packet_type as $key=>$val)
            {
                $packet=$this->packet_type_model->row(array('trans_id'=>$item['trans_id'],'status'=>1,'type'=>$key));
                $item['packet_type'][$key]=0;
                if($packet)
                {
                    $item['packet_type'][$key]=$packet['total_fee'];
                }
            }
        }
        $data['sel_time']=$sel_time;
        $data['list'] = $list;
        $this->load->view('admin/'.$this->list_view, $data);
    }
    public function export()
    {
        $where = "status=1 AND product_id=$this->id ";
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
        $packet_type=config_item('packet_type');
        foreach($list as &$item)
        {
            $item['order_total_price']=$item['order_total_price']/100;
            foreach($packet_type as $key=>$val)
            {
                $packet=$this->packet_type_model->row(array('trans_id'=>$item['trans_id'],'status'=>1,'type'=>$key));
                $item['packet_type'][$key]=0;
                if($packet)
                {
                    $item['packet_type'][$key]=$packet['total_fee'];
                }
            }
        }
        $data['list']=$list;
        $this->load->view('admin/rxysh_export',$data);
    }
}
