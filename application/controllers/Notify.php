<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'libraries/WxpayAPI_php_v3/example/notify.php');
include 'Base.php';
class Notify extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/order_model');
        $this->load->model('admin/wxpay_back_model');
        $this->load->model('admin/packet_type_model');
        $this->load->model('admin/back_paper_model');
        $this->load->model('admin/product_model');
    }
    public function index()
    {
        $notify = new \PayNotifyCallBack();
        $notify->Handle(false);
        //这里的IsSuccess是我自定义的一个方法，后面我会贴出这个文件的代码，供参考。
        $is_success = $notify->IsSuccess();
        $bdata = $is_success['data'];
        //支付成功
        if($is_success['code'] == 1){
            //商户逻辑处理，如订单状态更新为已支付
            $out_trade_no=$bdata['out_trade_no'];
            $wxpay_back=$this->wxpay_back_model->row(array('trans_id'=>$out_trade_no));
            $return_code='SUCCESS';
            if($wxpay_back['transaction_id']=='')
            {
                $update_data=array(
                    'transaction_id'=>$bdata['transaction_id'],
                    'return_code'=>$bdata['return_code'],
                    'result_code'=>$bdata['result_code'],
                    'time_end'=>$bdata['time_end'],
                    'result'=>json_encode($bdata)
                );
                $result=$this->wxpay_back_model->update($update_data,array('id'=>$wxpay_back['id']));
                if($result<=0)  $return_code='FAIL';
            }
            //订单信息
            $order_info=$this->order_model->row(array('trans_id'=>$out_trade_no));
            if($order_info['status']==0)
            {
                $order_result=$this->order_model->update(array('status'=>1,'update_time'=>t_time()),array('id'=>$order_info['id']));
                if($order_result<=0)  $return_code='FAIL';
            }
            if($order_info['product_id']==1)
            {
                $packet_res=$this->packet_type_model->update(array('status'=>1),array('trans_id'=>$out_trade_no));
                if($packet_res<=0)   $return_code='FAIL';
            }
            $product=$this->product_model->row(array('id'=>$order_info['product_id']));
            $back_paper=$this->back_paper_model->row(array('id'=>$product['back_paper_id'],'status'=>1));
            $this->service_msg($order_info,$back_paper);
            $this->save_message($order_info,$product);
            echo $return_code;
        }else{//支付失败
            $return_code='FAIL';
            echo $return_code;
        }
    }
    /*
     * 发送回向文
     */
    public function service_msg($order_info,$back_paper)
    {
        $this->order_model->update(array('service_status'=>2,'template_status'=>2,'update_time'=>t_time()),array('id'=>$order_info['id']));
        if($order_info['service_status']==0) {
            $openid=$order_info['buyer_openid'];
            $service_result=$this->service_send($openid,$back_paper);
            if($service_result) {
                $this->order_model->update(array('service_status'=>1,'update_time'=>t_time()),array('id'=>$order_info['id']));
            }
        }
        if($order_info['template_status']==0) {
            $template_result=$this->template_send($order_info);
            if($template_result) {
                $this->order_model->update(array('template_status'=>1,'update_time'=>t_time()),array('id'=>$order_info['id']));
            }
        }
    }

}