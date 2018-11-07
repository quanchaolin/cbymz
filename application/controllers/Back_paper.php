<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once('Base.php');
include_once(APPPATH.'libraries/WechatAuth.php');
class Back_paper extends Base {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/back_paper_model');
        $this->load->model('admin/back_paper_item_model');
        $this->load->model('admin/order_model');
        $this->load->model('admin/product_model');
    }
    public function index()
    {
        $trans_id=trim($this->input->get('trans_id'));
        //订单信息
        $order_info=$this->order_model->row(array('trans_id'=>$trans_id));
        if(!$order_info) {
            response_msg(1,'订单信息不存在！');
        }
        //商品信息
        $product=$this->product_model->row(array('id'=>$order_info['product_id']));
        $back_paper=$this->back_paper_model->row(array('id'=>$product['back_paper_id'],'status'=>1));
        $this->service_msg($order_info,$back_paper);
        $back_paper_item=$this->back_paper_item_model->row(array('back_paper_id'=>$back_paper['id'],'status'=>1));
        $back_paper_item['pic_url']=$this->img_url.$back_paper_item['thumb'];
        $data['value']=$back_paper_item;
        $this->load->view('back_paper',$data);
    }
    public function show()
    {
        $id=intval($this->input->get('id'));
        $value=$this->back_paper_item_model->row(array('id'=>$id,'status'=>1));
        $value['pic_url']=$this->img_url.$value['thumb'];
        $data['value']=$value;
        $this->load->view('back_paper',$data);
    }
    /*
     * 免费的发送回向文
     */
    public function service_msg($order_info,$back_paper)
    {
        if($order_info['service_status']==0 && $order_info['order_total_price']==0){
            $openid=$order_info['buyer_openid'];
            $service_result=$this->service_send($openid,$back_paper);
            if($service_result)
            {
                $this->order_model->update(array('service_status'=>1,'update_time'=>t_time()),array('id'=>$order_info['id']));
            }
        }
        if($order_info['template_status']==0 && $order_info['order_total_price']==0) {
            $template_result=$this->template_send($order_info);
            if($template_result)
            {
                $this->order_model->update(array('template_status'=>1,'update_time'=>t_time()),array('id'=>$order_info['id']));
            }
        }
    }
}
