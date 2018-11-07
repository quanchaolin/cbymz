<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 主页管理
 */
include_once 'Content.php';

class Main extends Content
{
    function __construct()
    {
        $this->name = '主页';
        $this->control = 'main';
        $this->list_view = 'main_list'; // 列表页
        $this->add_view = 'main_add'; // 添加页
        parent::__construct();
        $this->baseurl = site_url('admin/main/');
        $this->load->model('admin/order_model', 'model');
    }

    // 首页
    public function lists(){
        // 查询条件
        $today=date('Y-m-d 00:00:00');
        $where = "status=1 AND add_time>='$today'";
        // 列表数据
        $count=$this->model->count($where);
        $list = $this->model->lists('id,order_total_price,buyer_nick,product_name,add_time', $where, 'id DESC', $count, 0);
        foreach($list as &$item)
        {
            $item['order_total_price']=$item['order_total_price']/100;
        }
        $data=array(
            'total'=>$count,
            'list'=>$list,
        );
        response_msg(0,'success',$data);
    }

}
