<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 祈福消灾管理
 */
include_once 'Content.php';

class Qfxz extends Content
{
    public $start_time;
    public $end_time;
    function __construct()
    {
        $this->name = '祈福消灾';
        $this->control = 'qfxz';
        $this->list_view = 'qfxz_list'; // 列表页
        $this->add_view = 'qfxz_add'; // 添加页
        parent::__construct();
        $this->baseurl = site_url('admin/qfxz/');
        $this->load->model('admin/order_model', 'model');
        $this->load->model('admin/product_group_model');
        $this->start_time=date('Y-m-d 00:00:00');
        $this->end_time=date('Y-m-d 00:00:00',strtotime('+1 day'));
    }

    // 首页
    public function index(){
        $product_group=$this->product_group_model->row(array('id'=>1,'status'=>1));
        if(!$product_group)
        {
            echo json_encode(
                array(
                    'errcode'=>1,
                    'errmsg'=>'数据不存在!',
                )
            );exit;
        }
        $url_forward = $this->baseurl . 'index?';
        // 查询条件
        $product_list=$product_group['product_list'];
        $where = "status=1 AND product_id in($product_list)";
        $keywords = trim($_REQUEST['keywords']);
        if ($keywords) {
            $data['keywords'] = $keywords;
            $url_forward .= "&keywords=" . rawurlencode($keywords);
            $keywords = $this->db->escape_like_str($keywords);
            $where .= " AND (buyer_nick like '%{$keywords}%' OR product_name like '%{$keywords}%')";
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
        $product_group=$this->product_group_model->row(array('id'=>1,'status'=>1));
        if(!$product_group)
        {
            echo json_encode(
                array(
                    'errcode'=>1,
                    'errmsg'=>'数据不存在!',
                )
            );exit;
        }
        $product_list=$product_group['product_list'];
        $where = "status=1 AND product_id in($product_list)";
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
        foreach($list as &$item)
        {
            $item['order_total_price']=$item['order_total_price']/100;
        }
        $data['list']=$list;
        $this->load->view('admin/qfxz_export',$data);
    }
}
