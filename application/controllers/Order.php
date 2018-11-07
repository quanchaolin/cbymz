<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include 'Common.php';
class Order extends Common
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/product_model');
        $this->load->model('admin/order_model');
        $this->load->model('admin/packet_type_model');
        $this->load->model('admin/user_model');
    }
    public function index()
    {
        $id=intval($this->input->post('id'));
        $value=trims($this->input->post('value'));
        $openid=$value['openid'];
        $trans_id=build_order_no();
        $user=$this->user_model->row(array('openid'=>$openid));
        $product=$this->product_model->row(array('id'=>$id));
        if(!$product){
            response_msg(1,'找不到该项目的信息！');
        }
        $total=$product['price']==0?0:intval($value['total']);
        $min_price=$product['min_price']/100;
        if(!$user) {
            response_msg(1,'找不到用户信息!');
        }
        if($total<$min_price) {
            response_msg(2,'随喜金额不能小于'.$min_price.'元!');
        }
        $check_time=check_time($product['start_time'],$product['end_time']);
        if($check_time==false) {
            response_msg(3,'未开放购买!');
        }
        $insert_data=array(
            'order_total_price'=>$total*100,
            'buyer_openid'=>$openid,
            'buyer_nick'=>$user['nickname'],
            'receiver_name'=>$value['receiver_name'],
            'receiver_mobile'=>$value['receiver_mobile'],
            'receiver_email'=>isset($value['receiver_email'])?$value['receiver_email']:'',
            'content'=>isset($value['content'])?$value['content']:'',
            'other_name'=>isset($value['other_name'])?$value['other_name']:'',
            'product_id'=>$id,
            'product_name'=>$product['name'],
            'product_price'=>$product['price'],
            'product_count'=>1,
            'trans_id'=>$trans_id,
            'add_time'=>t_time()
        );
        try{
            $url=site_url('unified_order/index/');
            if($product['price']==0){
                $insert_data['status']=1;
                $url=site_url('back_paper/index/');
            }
            $insert_id=$this->order_model->insert($insert_data);
            $return_data=array(
                'trans_id'=>$trans_id,
                'redirect_url'=>$url
            );
            response_msg(0,'success',$return_data);
        }catch (Exception $e){
            $this->add_error($e->getCode(),$e->getMessage(),site_url('order/index'));
            response_msg(4,'服务器繁忙，请稍后!');
        }
    }
    /*
     * 日行一善订单
     */
    public function rxysh_order()
    {
        $id=intval($this->input->post('id'));
        $value=trims($this->input->post('value'));
        $openid=$value['openid'];
        $hd_value_a=$value['hd_value_a'];
        $hd_value_b=$value['hd_value_b'];
        $hd_value_c=$value['hd_value_c'];
        $hd_value_d=$value['hd_value_d'];
        $total=intval($value['all_hb'])*100;
        $trans_id=build_order_no();
        $user=$this->user_model->row(array('openid'=>$openid));
        if(!$user) {
            response_msg(1,'找不到用户信息!');
        }
        if($total<1) {
            response_msg(2,'随喜金额不能小于1元!');
        }
        $insert_data=array(
            'order_total_price'=>$total,
            'buyer_openid'=>$openid,
            'buyer_nick'=>$user['nickname'],
            'receiver_name'=>$value['receiver_name'],
            'receiver_mobile'=>$value['receiver_mobile'],
            'product_id'=>$id,
            'product_name'=>'功德海•日行一善',
            'product_price'=>'1',
            'product_count'=>1,
            'trans_id'=>$trans_id,
            'add_time'=>t_time()
        );
        $data_packet=array(
            'trans_id'=>$trans_id,
            'openid'=>$openid
        );
        if($hd_value_a!=0) {
            $data_packet['total_fee']=$hd_value_a;
            $data_packet['type']=1;
            $this->packet_type_model->insert($data_packet);
        }
        if($hd_value_b!=0) {
            $data_packet['total_fee']=$hd_value_b;
            $data_packet['type']=2;
            $this->packet_type_model->insert($data_packet);
        }
        if($hd_value_c!=0) {
            $data_packet['total_fee']=$hd_value_c;
            $data_packet['type']=3;
            $this->packet_type_model->insert($data_packet);
        }
        if($hd_value_d!=0) {
            $data_packet['total_fee']=$hd_value_d;
            $data_packet['type']=4;
            $this->packet_type_model->insert($data_packet);
        }
        try{
            $insert_id=$this->order_model->insert($insert_data);
            $return_data=array(
                'trans_id'=>$trans_id,
                'redirect_url'=>site_url('unified_order/index/')
            );
            response_msg(0,'success',$return_data);
        }catch (Exception $e){
            $this->add_error($e->getCode(),$e->getMessage(),site_url('order/rxysh_order'));
            response_msg(4,'服务器繁忙，请稍后!');
        }
    }
}