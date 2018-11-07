<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include 'Base.php';
class Common extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/user_model');
        $cur_page_url=rawurlencode(cur_page_url());
        $this->check_login($cur_page_url);
        $CI=& get_instance();
        $ct=$CI->router->fetch_class();
        $upgrade_arr=array('rxysh','njchd','qfxz','gzhft');
        $sign=$this->input->get('sign');
        if(in_array($ct,$upgrade_arr) && $sign!='qclwel888'){
            redirect('upgrade/index');
        }
    }
    /*
     * 检查用户是否登录
     * @param 当前url 用于跳转
     */
    public function check_login($cur_page_url='')
    {
        $cur_page_url=$cur_page_url==''?site_url('rxysh/index/'):$cur_page_url;
        $user_info=$_SESSION['user_info'];
        $user=$this->user_model->row(array('openid'=>$user_info['openid']));//调用user控制器，检查用户是否存在
        if($user_info && $user) {
            $this->openid=$user_info['openid'];
        }
        else {
            $url=site_url('base/get_code?redirect_url=').$cur_page_url;
            redirect($url);
        }
    }
    protected function merge_data($data)
    {
        $custom_config=(array)json_decode($data['custom_config']);
        return array_merge($data,$custom_config);
    }
}