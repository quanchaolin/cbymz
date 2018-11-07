<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include 'Common.php';
class Sxgd extends Common
{
    public $table;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/product_model');
        $this->load->model('admin/order_model');
        $this->baseurl = site_url('sxgd/');
        $this->title='随喜功德';
    }
    /*
     * 随喜发心
     */
    public function index()
    {
        $id=intval($this->input->get('id'));
        $value=$this->product_model->row(array('id'=>$id,'status'=>1));
        if(!$value) {
            response_msg(1,'数据不存在!');
        }
        $price=explode(',',$value['price']);
        $value['detail_img']=$this->img_url.$value['detail_img'];
        $value['min_price']=$value['min_price']/100;
        $this->title=$value['name'];
        //最近订单
        $order=$this->order_model->row_lately(array('buyer_openid'=>$this->openid,'product_id'=>$id));
        //分享的信息
        $share_data=$this->get_share($this->baseurl.'index');
        $data['signPackage']=$share_data['signPackage'];
        $data['news']=$share_data['news'];

        $data['openid']=$this->openid;
        $data['price']=$price;
        $data['value']=$value;
        $data['order']=$order;
        $this->title=$value['name'];
        $this->load->view('sxgd',$data);
    }
    /*
     * 随喜发心
     */
    public function sxgd_free()
    {
        $id=intval($this->input->get('id'));
        $type=$this->input->get('type');
        $value=$this->product_model->row(array('id'=>$id,'status'=>1));
        if(!$value) {
            response_msg(1,'数据不存在!');
        }
        if($value['price']!=0) {
            response_msg(2,'此栏目非免费!');
        }
        $value['detail_img']=$this->img_url.$value['detail_img'];
        $this->title=$value['name'];
        //最近订单
        $order=$this->order_model->row_lately(array('buyer_openid'=>$this->openid,'product_id'=>$id));
        //分享的信息
        $share_data=$this->get_share($this->baseurl.'index');
        $data['signPackage']=$share_data['signPackage'];
        $data['news']=$share_data['news'];

        $data['openid']=$this->openid;
        $data['value']=$value;
        $data['order']=$order;
        $data['type']=$type;
        $this->title=$value['name'];
        $this->load->view('sxgd_free',$data);
    }
}