<?php if (! defined('BASEPATH'))
    exit('No direct script access allowed');
/* 
 * 后台基础类，其他类必须继承该类  code by qcl
 */
include_once(APPPATH.'libraries/Acl.php');
class Base extends CI_Controller
{
    public $uid = 0; // 管理员id
    var $role = '';
    public $admin = array(); // 管理员信息
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin/sys_admin_log_model');
        $this->load->library('user_agent');
        $this->load->library('session');
        //引入Acl类库
        $this->load->library('acl');

        //假设现在角色为admin，这里可以自已定义获取角色权限的方法。
        $this->role = 'acl_everyone';

        //header("Cache-control: private");
        $this->admin = $this->session->userdata('admin');
        $role_id=0;
        if (!empty($this->admin)) {
            $this->uid = $this->admin['id'];
            $role_id=$this->admin['role_id'];
            $this->load->model('admin/sys_role_model');
            $role=$this->sys_role_model->row(array('id'=>$role_id,'status'=>1));
            if($role)
            {
                $this->role=$role['code'];
            }
        }
        //执行权限判断
        if(!$this->acl->checkAcl( $this->role ) && $role_id!=1 && !empty ($this->uid)){
            if( method_exists($this,'_on_access_denied') ) $this->_on_access_denied();
        }
        // 后台访问日志
        $this->sys_admin_log_model->logs();

    }

    // 保存上一级网址,通过session $this->admin['url_forward'] 上页的URL,用来 修改和 删除后做跳转的
    function url_forward($url)
    {
        $this->admin['url_forward'] = $url;
        $this->session->set_userdata('admin', $this->admin);
    }

    /*
     * @name _on_access_denied 访问无权限时处理方法
     * @return null
     */
    protected function _on_access_denied()
    {
        $IS_AJAX=isAjax();
        if($IS_AJAX==true)
        {
            echo json_encode(
                array(
                    'errcode'=>1001,
                    'errmsg'=>'没有操作权限！'
                )
            );
            exit;
        }
        else
        {

        }

        header('Location: '.site_url('admin/base/sso_admin_url/'));exit;
    }
    public function sso_admin_url()
    {
        $this->load->view('admin/no_auth');
    }
    protected function acl_config()
    {
        $this->load->model('admin/sys_acl_model');
        $this->load->model('admin/sys_role_acl_model');
        $this->load->model('admin/sys_role_model');
        $acl_count=$this->sys_acl_model->count(array('status'=>1));
        $acl_list=$this->sys_acl_model->lists('id,name,acl_module_id,url','status=1','id ASC',$acl_count,0);
        $list=array();
        $str='<?php'.PHP_EOL
                .'if ( ! defined("BASEPATH")) exit("No direct script access allowed");'.PHP_EOL
                .'//遵循qeephp中的acl规则'.PHP_EOL
                .'$acl["all_controllers"] = array('.PHP_EOL
                    .'"allow"=>"ACL_HAS_ROLE",//表示所有拥有角色的用户'.PHP_EOL
                    .');'.PHP_EOL;
        foreach($acl_list as $item)
        {
            $url_arr=explode('/',$item['url']);
            $controller=$url_arr[0];
            $action=$url_arr[1];
            $list[$controller]['allow']='ACL_HAS_ROLE';
            $role_acl_count=$this->sys_role_acl_model->count(array('acl_id'=>$item['id']));
            $role_acl=$this->sys_role_acl_model->lists('role_id',array('acl_id'=>$item['id']),'id ASC',$role_acl_count,0);
            $role_str='';
            foreach($role_acl as $val)
            {
                $role=$this->sys_role_model->row(array('status'=>1,'id'=>$val['role_id']));
                if($role)
                {
                    if($role_str!='')
                    {
                        $role_str.=',';
                    }
                    $role_str.=$role['code'];
                }
            }
            $list[$controller]['actions'][$action]['allow']=$role_str;
        }
        $str.='$acl='.var_export($list,true).';';
        $fp=fopen(APPPATH.'config/acl_admin.php','w');
        fwrite($fp,$str);
        fclose($fp);
        return true;
    }
}