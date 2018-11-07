<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
* 后台公共页控制器
*/
include_once 'Base.php';
class Common extends Base
{
    function __construct()
    {
        $this->name = '公共模块';
        parent::__construct();
    }

    // 框架首页
    public function index()
    {

        if (empty ($this->uid)) {
            redirect('admin/common/login');
            //header ( 'Location: index.php?d=admin&c=common&m=login' );
        }

        //redirect('common/gov_project_manage/index');
        $this->load->view('admin/welcome');
    }

    // 默认搜索页
    public function main()
    {
        if (empty ($this->uid)) {
            redirect('admin/common/login');
        }
        $this->load->view('admin/welcome');
    }

    // 登陆页
    public function login()
    {
        if (!empty ($this->uid)) {
            redirect('admin/common');
        }
        $login_info=(array)json_decode(get_cookie('remember'));
        $redirect_uri=$this->input->get('redirect_uri');
        //获取验证码的设置值
        $data['yzm_open']=get_admin_config('yzm_open');
        $data['redirect_uri']=$redirect_uri;
        $data['login_info']=$login_info;
        $this->load->view('admin/login',$data);
    }

    // 验证登陆
    public function check_login()
    {
        $this->load->model('admin/sys_user_model');
        $this->load->model('admin/sys_role_user_model');
        $redirect_uri=$this->input->get('redirect_uri');
        if($redirect_uri=='')
        {
            $redirect_uri=site_url('admin/common/main/');
        }
        $username = trim($this->input->post('username'));
        $password = trim($this->input->post('password'));
        $checkcode = trim($this->input->post('checkcode'));
        $remember   =intval($this->input->post('remember'));

        //获取验证码的设置值
        $yzm_open=get_admin_config('yzm_open');
        if ($yzm_open==1 && $checkcode != $this->session->userdata ( 'checkcode' )) {
            response_msg(100,'验证码不正确，请重新输入！');
        }
        //获取用户信息
        $user = $this->sys_user_model->row(array('username' => $username));
        if (empty ($user)) {
            response_msg(1,'用户名错误或者密码错误，请重新输入！');
        }
        if ($user ['status'] != 1) {
            response_msg(2,'您的账号已被锁定，请联系管理员！');
        }
        $true_password = get_password($password);
        if ($user['password'] != $true_password) {
            response_msg(3,'密码错误，请重新输入！');
        }
        $this->sys_user_model->update_logins($user['id']); // 更新登录次数和时间
        //获取当前用户的role_id
        $role_user = $this->sys_role_user_model->row(array('user_id' => $user['id']));
        $img_url=$this->config->item('img_url');
        $admin_data = array(
            'id' => $user['id'],
            'role_id' => $role_user['role_id'],
            'username' => $user['username'],
            'true_name' => $user['true_name'],
            'head_img_url'=>$img_url.$user['head_img_url']
        );
        $this->session->set_userdata('admin',$admin_data);
        $cookie_value=json_encode(array('username'=>$username,'password'=>$password));
        if($remember==1){
            set_cookie('remember',$cookie_value,86400*7);
        }else{
            set_cookie('remember',json_encode(array()));
        }
        response_msg(0,'登录成功！',array('redirect_uri'=>$redirect_uri));
    }

    // 退出
    public function login_out()
    {
        $this->session->unset_userdata('admin');
        redirect('admin/common/login');
    }

    // 验证码
    public function checkcode()
    {
        include_once (APPPATH.'libraries/Checkcode.php');
        $checkcode = new checkcode();
        $checkcode->doimage();
        $this->session->set_userdata('checkcode', $checkcode->get_code());
        //$_SESSION['checkcode'] = $checkcode->get_code();
    }
}

/* End of file welcome.php */