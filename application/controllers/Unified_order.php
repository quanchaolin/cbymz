<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * 统一下单
 */
include_once('Common.php');
require_once(APPPATH."libraries/WxpayAPI_php_v3/lib/WxPay.Api.php");
require_once(APPPATH."libraries/WxpayAPI_php_v3/example/WxPay.JsApiPay.php");
require_once(APPPATH.'libraries/WxpayAPI_php_v3/example/log.php');
class Unified_order extends Common
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/order_model');
        $this->load->model('admin/wxpay_back_model');
        $logHandler= new CLogFileHandler(APPPATH."libraries/WxpayAPI_php_v3/logs/".date('Y-m-d').'.log');
        $log = Log::Init($logHandler, 15);
    }
    public function index()
    {
        $trans_id=trim($this->input->get('trans_id'));
        $order_info=$this->order_model->row(array('trans_id'=>$trans_id,'status'=>0));
        if(!$order_info) {
            response_msg(1,'订单信息不存在或已支付!');
        }
        $insert_data=array(
            'openid'=>$order_info['buyer_openid'],
            'trans_id'=>$trans_id,
            'appid'=>$this->app_id,
            'mch_id'=>WxPayConfig::MCHID,
            'total_fee'=>$order_info['order_total_price'],
            'trade_type'=>'JSAPI',
        );
        $wxpay_back=$this->wxpay_back_model->row(array('trans_id'=>$trans_id));
        if(!$wxpay_back)
        {
            try{
                $insert_id=$this->wxpay_back_model->insert($insert_data);
            }catch (Exception $e){
                $this->add_error($e->getCode(),$e->getMessage(),site_url('unified_order/index'));
                response_msg(2,'服务器繁忙，请稍后!');
            }
        }
        $total_fee=$order_info['order_total_price'];
        if($total_fee<1) {
            response_msg(3,"随喜金额不能小于.$total_fee.元！");
        }
        $tools = new JsApiPay();
        //②、统一下单
        $input = new WxPayUnifiedOrder();
        $input->SetBody($order_info['product_name']);
        $input->SetAttach("test");
        $input->SetOut_trade_no($trans_id);
        $input->SetTotal_fee($total_fee);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("随喜红包");
        $input->SetNotify_url(site_url('notify/index'));
        $input->SetTrade_type("JSAPI");
        $input->SetLimit_pay('no_credit');
        $input->SetOpenid($order_info['buyer_openid']);
        $order = WxPayApi::unifiedOrder($input);
        $data['jsApiParameters'] = $tools->GetJsApiParameters($order);
        $data['trans_id']=$trans_id;
        $this->load->view('unified_order',$data);
    }
}