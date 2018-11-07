<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include 'Common.php';
class Qfxz extends Common
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/product_group_model');
        $this->load->model('admin/product_model');
        $this->load->model('admin/category_model');
        $this->load->model('admin/order_model');
        $this->baseurl = site_url('qfxz/');
        $this->title='祈福消灾';
    }
    public function index()
    {
        $product_group=$this->product_group_model->row(array('id'=>1,'status'=>1));
        if(!$product_group)
        {
            response_msg(1,'数据不存在!');
        }
        $product_list=$product_group['product_list'];
        $category_count=$this->category_model->count(array('status'=>1));
        $category=$this->category_model->lists('id,name',array('status'=>1),'order ASC',$category_count,0);
        $list=array();
        foreach($category as $item)
        {
            $where="status!=-1 AND category_id=$item[id] AND id in($product_list)";
            $count=$this->product_model->count($where);
            $product=$this->product_model->lists('id,name,main_img,start_time,end_time,remark',$where,'order ASC',$count,0);
            if($product)
            {
                $list[$item['id']]['id']=$item['id'];
                $list[$item['id']]['name']=$item['name'];
                foreach($product as &$val)
                {
                    $val['main_img']=$this->img_url.$val['main_img'];
                    $check_time=check_time($val['start_time'],$val['end_time']);
                    if($check_time) {
                        $val['can_buy']=1;
                    }
                    else {
                        $val['can_buy']=0;
                    }
                    if($val['product_url']=='') {
                        $val['product_url']=site_url('qfxz/detail?id='.$val['id']);
                    }
                }
                $list[$item['id']]['product_item']=$product;
            }
        }
        //分享的信息
        $share_data=$this->get_share($this->baseurl.'index');
        $data['signPackage']=$share_data['signPackage'];
        $data['news']=$share_data['news'];

        $data['list']=$list;
        $this->load->view('qfxz',$data);
    }
    public function category()
    {
        $product_group=$this->product_group_model->row(array('id'=>1,'status'=>1));
        if(!$product_group)
        {
            response_msg(1,'数据不存在!');
        }
        $product_list=$product_group['product_list'];
        $category_count=$this->category_model->count(array('status='=>1));
        $category=$this->category_model->lists('id,name',array('status'=>1),'order ASC',$category_count,0);
        $list=array();
        foreach($category as $item)
        {
            $where="status=1 AND category_id=$item[id] AND id in($product_list)";
            $count=$this->product_model->count($where);
            $product=$this->product_model->lists('id,name,main_img,start_time,end_time,remark',$where,'order ASC',$count,0);
            if($product)
            {
                $list[$item['id']]['id']=$item['id'];
                foreach($product as &$val)
                {
                    $val['main_img']=$this->img_url.$val['main_img'];
                    if($val['product_url']=='')
                    {
                        $val['product_url']=site_url('qfxz/detail?id='.$val['id']);
                    }
                }
                $list[$item['id']]['product_item']=$product;
            }
        }
        //分享的信息
        $share_data=$this->get_share($this->baseurl.'category');
        $data['signPackage']=$share_data['signPackage'];
        $data['news']=$share_data['news'];

        $data['list']=$list;
        $data['category']=$category;
        $this->load->view('qfxz_category',$data);
    }
    public function detail()
    {
        $id=intval($this->input->get('id'));
        $value=$this->product_model->row(array('id'=>$id,'status'=>1));
        if(!$value)
        {
            response_msg(1,'数据不存在!');
        }
        $this->title=$value['name'];
        $value=$this->merge_data($value);
        $check_time=check_time($value['start_time'],$value['end_time']);
        if($check_time) {
            $value['can_buy']=1;
        }
        else {
            $value['can_buy']=0;
        }
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