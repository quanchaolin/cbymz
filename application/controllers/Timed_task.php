<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by cbymz.
 * User: 2450718148@qq.com
 * Date: 2018/7/22
 * Time: 22:06
 */
include_once ('Base.php');
class Timed_task extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->baseurl = site_url('timed_task/');
        $this->load->model('admin/time_task_model','model');
        $this->load->model('admin/error_model');
    }
    public function index()
    {
        $now_time=date('Y-m-d H:i');
        $where="status!=-1 OR status!=2";
        $count=$this->model->count($where);
        $list=$this->model->lists('id,execute_type,week,month,url,execute_time',$where,'id DESC',$count,0);
        foreach ($list as $item)
        {
            $execute_time=date('Y-m-d H:i',strtotime($item['execute_time']));
            switch ($item['execute_type']){
                case 1://固定日期
                    if($now_time==$execute_time){
                        httpGet($item['url'].'&sign=qclwel888');
                    }else{
                        $this->model->update(array('status'=>2),array('id'=>$item['id']));
                    }
                    break;
                case 2://每天
                    if($now_time==$execute_time){
                        httpGet($item['url'].'&sign=qclwel888');
                    }
                    break;
                case 3://每周
                    if($now_time==$execute_time){
                        $weekarray=array("日","一","二","三","四","五","六"); //先定义一个数组
                        $w=date('w');
                        if($item['week']==$weekarray[$w])
                        {
                            httpGet($item['url'].'&sign=qclwel888');
                        }
                    }
                    break;
                case 4://每月
                    if($now_time==$execute_time){
                        httpGet($item['url'].'&sign=qclwel888');
                    }
                    break;
            }
        }
    }
    public function test()
    {
        $error_data=array(
            'errcode'=>'500',
            'errmsg'=>'认证错误！',
            'content'=>site_url('time_task/index'),
            'add_time'=>t_time()
        );
        $this->error_model->insert($error_data);
    }
}