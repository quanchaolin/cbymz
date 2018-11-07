<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 权限模块管理
 */
include_once 'Content.php';
include_once APPPATH.'libraries/Cate.php';
include_once APPPATH.'libraries/Verify.php';
class Sys_acl extends Content
{
    function __construct()
    {
        $this->name = '权限模块管理';
        $this->control = 'sys_acl';
        $this->list_view = 'sys_acl_list'; // 列表页
        $this->add_view = 'sys_acl_add'; // 添加页
        parent::__construct();
        $this->baseurl = site_url('admin/sys_acl/');
        $this->load->model('admin/sys_acl_module_model', 'model');
        $this->load->model('admin/sys_acl_model');
    }

    // 首页
    public function index(){
        $this->load->view('admin/'.$this->list_view);
    }
    public function tree()
    {
        $list=$this->model->lists('id,name,parent_id AS pid,seq,status,remark',array('status'=>1),'seq DESC',1000,0);
        $cate=Cate::layer($list,'aclModuleList');
        echo json_encode(
            array(
                'errcode'=>0,
                'errmsg'=>'success',
                'data'=>$cate
            )
        );
        exit;
    }
    public function acl(){
        $aclModuleId=intval($this->input->get('aclModuleId'));
        $where = 'status!=-1 AND acl_module_id='.$aclModuleId;
        $keywords = trim($_REQUEST['keywords']);
        if ($keywords) {
            $keywords = $this->db->escape_like_str($keywords);
            $where .= " AND true_name like '%{$keywords}%' ";
        }

        // URL及分页
        $this->per_page = intval($this->input->post('pageSize'));
        $pageNo = intval($this->input->post('pageNo'));
        $offset=ceil($this->per_page*$pageNo);
        if($pageNo==1)
        {
            $offset=0;
        }
        $count = $this->sys_acl_model->count($where);
        // 列表数据
        $list = $this->sys_acl_model->lists('id,name,acl_module_id,type,url,status,seq,remark', $where, 'id DESC' ,$this->per_page, $offset);
        foreach($list as &$item)
        {
            $item['showAclModuleName']='';
            $acl_module=$this->model->row(array('id'=>$item['acl_module_id']));
            if($acl_module)
            {
                $item['showAclModuleName']=$acl_module['name'];
            }
        }
        $data=array(
            'data'=>$list,
            'total'=>$count
        );
        echo json_encode(
            array(
                'errcode'=>0,
                'errmsg'=>'success',
                'data'=>$data
            )
        );
        exit;
    }
    // 保存 添加和修改都是在这里
    public function save()
    {
        $id = intval($_POST['id']);
        $data = trims($_POST['value']);
        if($data['id']){unset($data['id']);}
        if (!Verify::isEmpty($data['name'])) {
            echo json_encode(
                array(
                    'errcode'=>1,
                    'errmsg'=>'名称不能为空'
                )
            );exit;
        }
        $data['user_id'] = $this->uid;
        $data['update_time'] = t_time();
        $data['operator'] = $this->admin['username'];
        $data['operate_ip'] = ip();
        if ($id) { // 修改 ===========
            //检查是否重复
            $row=$this->model->row(array('name'=>$data['name'],'parent_id'=>$data['parent_id'],'id !='=>$id));
            if($row)
            {
                echo json_encode(
                    array(
                        'errcode'=>2,
                        'errmsg'=>'名称已存在，请更换'
                    )
                );exit;
            }
            $this->model->update($data, $id);
            echo json_encode(
                array(
                    'errcode'=>0,
                    'errmsg'=>'修改成功!'
                )
            );exit;
        } else { // ===========添加 ===========
            //检查标题是否重复
            $row=$this->model->row(array('name'=>$data['name'],'parent_id'=>$data['parent_id']));
            if($row)
            {
                echo json_encode(
                    array(
                        'errcode'=>3,
                        'errmsg'=>'名称已存在，请更换'
                    )
                );exit;
            }
            $data['add_time'] = t_time();
            $this->model->insert($data);
            echo json_encode(
                array(
                    'errcode'=>0,
                    'errmsg'=>'添加成功!'
                )
            );exit;
        }
    }
    public function acl_save()
    {
        $id = intval($_POST['id']);
        $data = trims($_POST['value']);
        if($data['id']){unset($data['id']);}
        if (!Verify::isEmpty($data['name'])) {
            echo json_encode(
                array(
                    'errcode'=>1,
                    'errmsg'=>'权限名称不能为空'
                )
            );exit;
        }
        $data['user_id'] = $this->uid;
        $data['update_time'] = t_time();
        $data['operator'] = $this->admin['username'];
        $data['operate_ip'] = ip();
        if ($id) { // 修改 ===========
            $this->sys_acl_model->update($data, $id);
            echo json_encode(
                array(
                    'errcode'=>0,
                    'errmsg'=>'修改成功!'
                )
            );exit;
        } else { // ===========添加 ===========
            $data['add_time'] = t_time();
            $this->sys_acl_model->insert($data);
            echo json_encode(
                array(
                    'errcode'=>0,
                    'errmsg'=>'添加成功!'
                )
            );exit;
        }
    }
    public function delete()
    {
        $id = intval($this->input->post('id'));
        $id_arr = $_POST['delete'];
        $data=array(
            'operator'=>$this->admin['username'],
            'operate_ip' => ip(),
            'update_time'=>t_time(),
            'status'=>'-1'
        );
        if (is_numeric($id)) {
            $this->model->update($data, $id);
        }elseif(is_array($id_arr)) {
            foreach($id_arr as $item)
            {
                $this->model->update($data, $item);
            }
        }
        echo json_encode(
            array(
                'errcode'=>0,
                'errmsg'=>'删除成功!'
            )
        );exit;
    }


}
