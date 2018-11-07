<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 登录日志
 */
include_once 'Content.php';

class Sys_Admin_log extends Content
{
    function __construct()
    {
        $this->name = '管理员';
        $this->control = 'sys_admin_log';
        $this->list_view = 'sys_admin_log_list'; // 列表页
        $this->add_view = 'sys_admin_log_add'; // 添加页
        parent::__construct();
        $this->baseurl = site_url('admin/sys_admin_log/');
        $this->load->model('admin/sys_admin_log_model', 'model');
        $this->load->model('admin/sys_user_model');
    }

    // 首页
    public function index(){
        $url_forward = $this->baseurl . 'index?';
        // 查询条件
        $where = 'status!=-1 ';
        $keywords = trim($_REQUEST['keywords']);
        if ($keywords) {
            $data['keywords'] = $keywords;
            $url_forward .= "&keywords=" . rawurlencode($keywords);
            $keywords = $this->db->escape_like_str($keywords);

            $admin_where = " true_name like '%{$keywords}%' OR username like '%$keywords%' ";
            $admin=$this->sys_user_model->lists('id,true_name,username',$admin_where,'id DESC');
            if($admin)
            {
                $uid='';
                foreach($admin as $k=>$val)
                {
                    if($k>=1)
                    {
                        $uid.=',';
                    }
                    $uid.=$val['id'];
                }
                $where.=" AND user_id IN($uid) ";
            }
        }
        // URL及分页
        $offset = intval($_GET['per_page']);
        $data['count'] = $this->model->count($where);
        $data['pages'] = $this->page_html($url_forward, $data['count']);
        $this->url_forward($url_forward . '&per_page=' . $offset);

        // 列表数据
        $list = $this->model->lists('*', $where, 'id DESC', $this->per_page, $offset);
        foreach($list as &$item)
        {
            $admin_temp=$this->sys_user_model->row(array('id'=>$item['user_id']));
            $item['true_name']='';
            if($admin_temp)
            {
                $item['true_name']=$admin_temp['true_name'];
            }

        }
        $data['list'] = $list;
        $this->load->view('admin/'.$this->list_view, $data);
    }
}
