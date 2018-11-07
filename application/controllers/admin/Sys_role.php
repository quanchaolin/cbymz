<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 角色管理
 */
include_once 'Content.php';
include_once APPPATH.'libraries/Cate.php';
include_once APPPATH.'libraries/Verify.php';
class Sys_role extends Content
{
    function __construct()
    {
        $this->name = '角色管理';
        $this->control = 'sys_role';
        $this->list_view = 'sys_role_list'; // 列表页
        $this->add_view = 'sys_role_add'; // 添加页

        parent::__construct();
        $this->baseurl = site_url('admin/sys_role/');
        $this->load->model('admin/sys_role_model', 'model');
        $this->load->model('admin/sys_role_acl_model');
        $this->load->model('admin/sys_acl_model');
        $this->load->model('admin/sys_acl_module_model');
        $this->load->model('admin/sys_role_user_model');
        $this->load->model('admin/sys_user_model');
        $this->load->helper('pinyin');
    }

    // 首页
    public function index(){
        $this->load->view('admin/'.$this->list_view);
    }
    public function lists()
    {
        $where = 'status!=-1 ';
        // 列表数据
        $count=$this->model->count($where);
        $list = $this->model->lists('id,name,remark,status', $where, 'id DESC', $count, 0);
        response_msg(0,'success',$list);
    }
    public function tree()
    {
        $roleId=intval($this->input->post('roleId'));
        $sys_acl_module_list=$this->get_acl_module();
        $role_id=$this->admin['role_id'];
        foreach($sys_acl_module_list as &$item)
        {
            $temp_acl_count=$this->sys_acl_model->count(array('acl_module_id'=>$item['id']));
            $temp_acl=$this->sys_acl_model->lists('id,acl_module_id,name,url,type',array('acl_module_id'=>$item['id']),'seq DESC',$temp_acl_count,0);
            if($temp_acl)
            {
                foreach($temp_acl as &$val)
                {
                    $url_arr=explode('/',$val['url']);
                    $hasAcl=true;
                    $uri = array(
                        'space' => 'admin',
                        'controller' => $url_arr[0],
                        'action' => $url_arr[1]
                    );
                    if(!$this->acl->checkAcl( $this->role ,$uri) && $role_id!=1){
                        $hasAcl=false;
                    }
                    $val['hasAcl']=$hasAcl;;
                    $val['checked']=false;
                    $role_acl= $this->sys_role_acl_model->row(array('role_id'=>$roleId,'acl_id'=>$val['id']));
                    if($role_acl)
                    {
                        $val['checked']=true;
                    }
                }
                $item['aclList']=$temp_acl;
            }
        }
        $sys_acl_cate=Cate::layer($sys_acl_module_list,'aclModuleList');
        response_msg(0,'success',$sys_acl_cate);
    }
    public function users()
    {
        $roleId=intval($this->input->post('roleId'));
        $where='status=1 ';
        $role_user_count=$this->sys_role_user_model->count(array('role_id!='=>$roleId));
        $role_user_list=$this->sys_role_user_model->lists('user_id',array('role_id!='=>$roleId),'id ASC',$role_user_count,0);
        $role_user_str='';
        foreach($role_user_list as $key=>$val)
        {
            if($key>=1)
            {
                $role_user_str.=',';
            }
            $role_user_str.=$val['user_id'];
        }
        if($role_user_str!='')
        {
            $where.="AND id NOT in($role_user_str)";
        }
        $user_count=$this->sys_user_model->count($where);
        $user=$this->sys_user_model->lists('id,true_name,username',$where,'id ASC',$user_count,0);
        $list=array();
        foreach($user as $item)
        {
            $role_user_row=$this->sys_role_user_model->row(array('user_id'=>$item['id'],'role_id'=>$roleId));
            if($role_user_row)
            {
                $list['selected'][]=$item;
            }
            else
            {
                $list['unselected'][]=$item;
            }
        }
        response_msg(0,'success',$list);
    }
    // 保存 添加和修改都是在这里
    public function save()
    {
        $id = intval($_POST['id']);
        $data = trims($_POST['value']);

        if (!Verify::isEmpty($data['name'])) {
            response_msg(1,'角色名称不能为空！');
        }
        $data['user_id'] = $this->uid;
        $data['update_time'] = t_time();
        $data['operator'] = $this->admin['username'];
        $data['operate_ip'] = ip();
        if ($id) { // 修改 ===========
            //检查是否重复
            $row=$this->model->row(array('name'=>$data['name'],'id !='=>$id));
            if($row)
            {
                response_msg(2,'角色名称已存在，请更换！');
            }
            $this->model->update($data, $id);
            //修改权限配置
            $this->acl_config();
            response_msg(0,'修改成功！');
        } else { // ===========添加 ===========
            //检查标题是否重复
            $row=$this->model->row(array('name'=>$data['name']));
            if($row)
            {
                response_msg(3,'角色名称已存在，请更换！');
            }
            $data['add_time'] = t_time();
            $data['code']=$this->create_code($data['name']);
            $this->model->insert($data);
            //修改权限配置
            $this->acl_config();
            response_msg(0,'添加成功！');
        }
    }
    public function change_acl()
    {
        $roleId=intval($this->input->post('roleId'));
        /*if($roleId==1)
        {
            echo json_encode(
                array(
                    'errcode'=>1,
                    'errmsg'=>'超级用户拥有所有权限！'
                )
            );exit;
        }*/
        if(!$roleId)
        {
            response_msg(2,'角色不存在！');
        }
        $aclIds=$this->input->post('aclIds');
        $this->sys_role_acl_model->delete(array('role_id'=>$roleId));
        $data=explode(',',$aclIds);
        foreach($data as $val)
        {
            $insert_data=array(
                'role_id'=>$roleId,
                'acl_id'=>$val,
                'operator'=>$this->admin['username'],
                'add_time'=>t_time(),
                'operate_ip'=>ip(),
            );
            $this->sys_role_acl_model->insert($insert_data);
        }
        //修改权限配置
        $re=$this->acl_config();
        if($re)
        {
            //创建角色菜单
            $this->create_menu($roleId);
        }
        response_msg(0,'权限更改成功！');
    }
    public function change_users()
    {
        $roleId=intval($this->input->post('roleId'));
        $userIds=trim($this->input->post('userIds'));
        //删除角色下的所有用户
        $this->sys_role_user_model->delete(array('role_id'=>$roleId));
        $data=explode(',',$userIds);
        foreach($data as $val)
        {
            if($val==0){
                continue;
            }
            $insert_data=array(
                'role_id'=>$roleId,
                'user_id'=>$val,
                'add_time'=>t_time(),
                'operator'=>$this->admin['username'],
                'operate_ip'=>ip(),
            );
            $this->sys_role_user_model->insert($insert_data);
        }
        response_msg(0,'权限更改成功！');
    }
    public function delete()
    {
        $id = intval($this->input->post('id'));
        $data=array(
            'status'=>'-1',
            'update_time'=>t_time(),
            'operator'=>$this->admin['username'],
            'operate_ip'=>ip(),
        );
        if (is_numeric($id)) {
            $this->model->update($data, $id);
        }
        //删除角色所有权限
        $this->sys_role_acl_model->delete(array('role_id'=>$id));
        //删除角色下的所有用户
        $this->sys_role_user_model->delete(array('role_id'=>$id));
        //修改权限配置
        $this->acl_config();
        response_msg(0,'删除成功！');
    }
    /*
     * 生成角色编码
     * @parse $name 角色名称
     */
    private function create_code($name)
    {
        $this->load->helper('pinyin');
        $code='';
        if($name=='')
        {
            return $code;
        }
        $code = str_replace(' ', '', pinyin($name));
        $row=$this->model->row(array('code'=>$code,'status!='=>-1));
        if($row)
        {
            $name.='8';
            $code=$this->create_code($name);
        }
        return $code;
    }
    private function create_menu($role_id)
    {
        $module_list=$this->get_acl_module();
        $list=$this->_create_menu($role_id,$module_list);
        //@unlink(APPPATH . 'cache/role_menu_'.$role_id.'.php');
        set_cache('role_menu_'.$role_id,json_encode($list));
    }
    /*
     * @parse role_id 角色id
     * 创建角色菜单
     */
    private function _create_menu($role_id,$cate,$name = 'child',$pid = 0)
    {
        $role=$this->model->row(array('id'=>$role_id,'status'=>1));
        $role_code=$role['code'];
        $arr = array();
        foreach ($cate as $v) {
            if($v['pid']==$pid){
                $v[$name] =  $this->_create_menu($role_id,$cate,$name,$v['id']);
                $acl=$this->create_acl($v['id']);
                if($acl)
                {
                    $url_arr=explode('/',$acl['url']);
                    $uri = array(
                        'space' => 'admin',
                        'controller' => $url_arr[0],
                        'action' => $url_arr[1]
                    );
                    if($this->acl->checkAcl($role_code ,$uri) || $role_id==1){
                        $v['url']=$acl['url'];
                    }
                }
                if($v['child'] || $v['url']!='')
                {
                    $arr[] = $v;
                }
            }
        }
        return $arr;
    }
    private function create_acl($acl_module_id)
    {
        $row=$this->sys_acl_model->row(array('status'=>1,'type'=>1,'acl_module_id'=>$acl_module_id));
        return $row;
    }
    /*
     * 获取权限模块
     */
    private function get_acl_module()
    {
        $count=$this->sys_acl_module_model->count(array('status'=>1));
        $list=$this->sys_acl_module_model->lists('id,name,parent_id AS pid',array('status'=>1),'seq DESC,id ASC',$count,0);
        return $list;
    }
}
