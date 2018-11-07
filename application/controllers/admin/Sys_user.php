<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 用户管理
 */
include_once 'Content.php';
include_once (APPPATH.'libraries/Verify.php');
include_once (APPPATH.'libraries/Cate.php');
class Sys_user extends Content
{
    function __construct()
    {
        $this->name = '用户管理';
        $this->control = 'sys_user';
        $this->list_view = 'sys_user_list'; // 列表页
        $this->add_view = 'sys_user_add'; // 添加页
        parent::__construct();
        $this->baseurl = site_url('admin/sys_user/');
        $this->short_url='admin/sys_user/';
        $this->load->model('admin/sys_user_model', 'model');
        $this->load->model('admin/sys_role_model');
        $this->load->model('admin/sys_role_user_model');
        $this->load->model('admin/sys_dept_model');
    }
    public function index()
    {
        show_msg('访问地址有误，请检查！');
    }
    // 首页(按区域)

    public function dept()
    {
        $this->type="dept";
        //用户三级列表选择
        $where='status=1';
        $dept_count = $this->sys_dept_model->count($where);
        $dept_list = $this->sys_dept_model->lists('id,parent_id AS pid,level,name as text', $where, 'id ASC', $dept_count, 0);
        $dept_list_cate= Cate::layer($dept_list,'nodes');
        $data['dept_data'] = json_encode($dept_list_cate);
        //角色列表
        $role_list=$this->get_role_list();
        $data['role_list']=json_encode($role_list);
        $this->load->view('admin/sys_user_dept_list.php', $data);
    }
    public function user_dept_list(){
        $dept_id=intval($this->input->get('id'));
        if($dept_id==0)
        {
            response_msg(1,'请选择部门');
        }
        $where = "status!=-1 AND dept_id=$dept_id";
        $keywords = trim($_REQUEST['keywords']);
        if ($keywords) {
            $keywords = $this->db->escape_like_str($keywords);
            $where .= " AND true_name like '%{$keywords}%' ";
        }

        // URL及分页
        $pageSize = intval($this->input->get('pageSize'));
        $pageNo = intval($this->input->get('pageNo'));
        $offset=($pageNo-1)*$pageSize;
        if($pageNo==1)
        {
            $offset=0;
        }
        $count = $this->model->count($where);
        // 列表数据
        $list = $this->model->lists('id,username,true_name,telephone,mail,remark,dept_id,status', $where, 'id DESC' ,$pageSize, $offset);
        foreach($list as &$item)
        {
            $item['role_id']='';
            $role_user=$this->sys_role_user_model->row(array('user_id'=>$item['id']));
            if($role_user)
            {
                $item['role_id']=$role_user['role_id'];
            }
        }
        $data=array(
            'data'=>$list,
            'total'=>$count,
        );
        response_msg(0,'success',$data);
    }
    // 保存 添加和修改都是在这里
    public function save()
    {
        $id = intval($_POST['id']);
        $data = trims($_POST['value']);
        $role_id=$data['role_id'];
        if($data['id']){unset($data['id']);}
        if($data['role_id']){unset($data['role_id']);}

        if ($data['true_name']=='') {
            response_msg(1,'用户名不能为空');
        }
        if (!Verify::isEmpty($data['mail'])) {
            response_msg(2,'邮箱不能为空');
        }
        if (!Verify::isEmail($data['mail'])) {
            response_msg(3,'邮箱格式不正确！');
        }
        if ($data['password']!='') {
            $data['password'] = get_password($data['password']);
        } else {
            unset ($data['password']);
        }
        $data['user_id']=$this->uid;
        $data['update_time'] = t_time();
        $data['operator'] = $this->admin['username'];
        $data['operate_ip'] = ip();
        if ($id) { // 修改 ===========
            $this->model->update($data, $id);
            $this->create_role_user($id,$role_id);
            response_msg(0,'修改成功!');
        } else { // ===========添加 ===========
            $data['username']=$this->create_username($data['true_name']);
            $data['password'] = get_password('88888888');
            $data['add_time'] = t_time();
            $id=$this->model->insert($data);
            $this->create_role_user($id,$role_id);
            response_msg(0,'添加成功!');
        }
    }

    public function delete()
    {
        $id = $_GET['id'];
        $id_arr = $_POST['delete'];
        $update_data=array(
            'status'=>'-1',
            'update_time'=>t_time(),
            'operator'=>$this->admin['username'],
            'operate_ip'=>ip()
        );
        if (is_numeric($id)) {
            $this->model->update($update_data, $id);
        } elseif(is_array($id_arr)) {
            foreach($id_arr as $item)
            {
                $this->model->update($update_data, $item);
            }
        }
        response_msg(0,'删除成功!');
    }
    private function create_username($name)
    {
        $this->load->helper('pinyin');
        $username='';
        if($name=='')
        {
            return $username;
        }
        $username = str_replace(' ', '', pinyin($name));
        $row=$this->model->row(array('username'=>$username,'status!='=>-1));
        if($row)
        {
            $name.='8';
            $username=$this->create_username($name);
        }
        return $username;
    }
    private function create_role_user($user_id,$role_id)
    {
        $row=$this->sys_role_user_model->row(array('user_id'=>$user_id));
        if($row)
        {
            $this->sys_role_user_model->delete(array('user_id'=>$user_id));
        }
        $data=array(
            'role_id'=>$role_id,
            'user_id'=>$user_id,
            'add_time'=>t_time(),
            'update_time'=>t_time(),
            'operator'=>$this->admin['username'],
            'operate_ip'=>ip()
        );
        $this->sys_role_user_model->insert($data);
    }
    /*
     * 获取角色列表
     */
    private function get_role_list()
    {
        $role_id=$this->admin['role_id'];
        $role_where='status=1';
        if($role_id!=1)
        {
            $role_where.=" AND id=$role_id";
        }
        $role_count=$this->sys_role_model->count($role_where);
        $role_list=$this->sys_role_model->lists('id,name',$role_where,'id ASC',$role_count,0);
        return $role_list;
    }
}
