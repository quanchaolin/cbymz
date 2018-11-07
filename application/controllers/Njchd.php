<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include 'Common.php';
class Njchd extends Common
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/product_group_model');
        $this->load->model('admin/product_model');
        $this->load->model('admin/order_model');
        $this->baseurl = site_url('njchd/');
        $this->title='念经超度';
    }
    public function index()
    {
        $product_group=$this->product_group_model->row(array('id'=>3,'status'=>1));
        if(!$product_group)
        {
            response_msg(1,'数据不存在!');
        }
        $product_list=$product_group['product_list'];
        $where="status=1 AND id in($product_list)";
        $count=$this->product_model->count($where);
        $list=$this->product_model->lists('id,name,main_img,product_url',$where,'order DESC',$count,0);
        foreach($list as &$val)
        {
            $val['main_img']=$this->img_url.$val['main_img'];
            if($val['product_url']=='')
            {
                $val['product_url']=site_url('njchd/detail?id='.$val['id']);
            }
        }
        //分享的信息
        $share_data=$this->get_share($this->baseurl.'index');
        $data['signPackage']=$share_data['signPackage'];
        $data['news']=$share_data['news'];

        $data['list']=$list;
        $this->load->view('njchd',$data);
    }
    public function detail()
    {
        $id=intval($this->input->get('id'));
        $value=$this->product_model->row(array('id'=>$id,'status='=>1));
        if(!$value)
        {
            response_msg(1,'数据不存在!');
        }
        $this->title=$value['name'];
        $check_time=check_time($value['start_time'],$value['end_time']);
        if($check_time) {
            $value['can_buy']=1;
        }
        else {
            $value['can_buy']=0;
        }
        $value=$this->merge_data($value);
        $price=explode(',',$value['price']);
        $value['detail_img']=$this->img_url.$value['detail_img'];
        $value['min_price']=$value['min_price']/100;
        //最近订单
        $order=$this->order_model->row_lately(array('buyer_openid'=>$this->openid,'product_id'=>$id));
        //分享的信息
        $share_data=$this->get_share($this->baseurl.'detail?id='.$id);
        $data['signPackage']=$share_data['signPackage'];
        $data['news']=$share_data['news'];

        $data['openid']=$this->openid;
        $data['price']=$price;
        $data['value']=$value;
        $data['order']=$order;
        $this->load->view($value['tpl'],$data);
    }
}