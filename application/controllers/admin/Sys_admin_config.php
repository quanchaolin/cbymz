<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 *  系统配置项
 */
include_once 'Content.php';

class Sys_admin_config extends Content
{
    function __construct()
    {
        $this->name = '系统配置项';
        $this->control = 'sys_admin_config';
        $this->list_view = 'sys_admin_config_list'; // 列表页
        $this->add_view = 'sys_admin_config_add'; // 添加页
        parent::__construct();
        $this->short_url='admin/sys_admin_config/';
        $this->baseurl = site_url('admin/sys_admin_config/');
        $this->load->model('admin/sys_admin_config_model', 'model');
    }
    //协审单位主页
    public function index(){
        $value['yzm_open']=get_admin_config('yzm_open');
        $data['value']=$value;
        $this->load->view('admin/'.$this->list_view,$data);
    }
    /*
     * 网站信息
     */
    public function site_info()
    {
        $site=array(
            1=>'site_name',
            2=>'site_title',
            3=>'site_keywords',
            4=>'site_description',
            5=>'site_copyright',
        );
        $list=array();
        foreach($site as $val)
        {
            $list[$val]=get_admin_config($val);
        }
        echo json_encode(
            array(
                'errcode'=>0,
                'errmsg'=>'success',
                'data'=>$list
            )
        );exit;
    }
    /*
     * 邮件信息
     */
    public function mail_info()
    {
        $site=array(
            1=>'email_host',
            2=>'email_username',
            3=>'email_password'
        );
        $list=array();
        foreach($site as $val)
        {
            $list[$val]=get_admin_config($val);
        }
        echo json_encode(
            array(
                'errcode'=>0,
                'errmsg'=>'success',
                'data'=>$list
            )
        );exit;
    }
    // 保存 添加和修改都是在这里
    public function save()
    {
        $data = trims($_POST['value']);
        $update_data['operator'] = $this->admin['username'];
        $update_data['operate_ip'] = ip();
        $update_data['update_time'] = t_time();
        foreach($data as $key=>$val)
        {
            $update_data['update_time'] = t_time();
            $update_data['value'] = $val;
            $this->model->update($update_data, array('config_name'=>$key));
        }
        //保存设置到缓存
        $this->save_cache();
        echo json_encode(
            array(
                'errcode'=>0,
                'errmsg'=>'修改成功',
                'data'=>$this->admin['url_forward']
            )
        );exit;
    }
    /*
     * 保存设置到缓存
     */
    private function save_cache()
    {
        $count=$this->model->count(array('status'=>1));
        $config_list=$this->model->lists('config_name,value',array('status'=>1),'id ASC',$count,0);
        $list=array();
        foreach($config_list as $item)
        {
            $list[$item['config_name']]=$item['value'];
        }
        set_cache('admin_config',$list);
    }
}
