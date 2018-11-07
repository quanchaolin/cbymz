<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 部门管理
 */
include_once 'Content.php';
include_once APPPATH.'libraries/Verify.php';
include_once APPPATH.'libraries/Cate.php';
class Sys_dept extends Content
{
    function __construct()
    {
        $this->name = '部门管理';
        $this->control = 'sys_dept';
        $this->list_view = 'sys_dept_list'; // 列表页
        $this->add_view = 'sys_dept_add'; // 添加页
        parent::__construct();
        $this->baseurl = site_url('admin/sys_dept/');
        $this->load->model('admin/sys_dept_model', 'model');
    }

    // 首页
    public function index(){
        $this->load->view('admin/'.$this->list_view);
    }
    /*
     * 获取列表信息
     */
    public function lists()
    {
        $where = "status!=-1 ";
        $count = $this->model->count($where);
        // 列表数据
        $area_list = $this->model->lists('id,name,remark,seq,parent_id AS pid,status', $where, 'seq DESC' ,$count, 0);
        foreach($area_list as &$item)
        {
           break;
        }
        $list=Cate::level($area_list,'..∟');
        $data=array(
            'data'=>$list,
            'total'=>$count
        );
        response_msg(0,'success',$data);
    }

    // 保存 添加和修改都是在这里
    public function save()
    {
        $id = intval($_POST['id']);
        $data = trims($_POST['value']);
        if($data['id']){unset($data['id']);}
        if (!Verify::isEmpty($data['name'])) {
            response_msg(1,'部门名称不能为空');
        }
        $data['operator'] = $this->admin['username'];
        $data['update_time'] = t_time();
        $data['operate_ip'] = ip();
        if ($id) { // 修改 ===========
            //检查是否重复
            $row=$this->model->row(array('name'=>$data['name'],'parent_id'=>$data['parent_id'],'id!='=>$id));
            if($row)
            {
                response_msg(2,'同一层级下部门名称已存在！');
            }
            $this->model->update($data, $id);
            response_msg(0,'修改成功！');
        } else { // ===========添加 ===========
            //检查标题是否重复
            $row=$this->model->row(array('name'=>$data['name'],'parent_id'=>$data['parent_id']));
            if($row)
            {
                response_msg(2,'同一层级下部门名称已存在！');
            }
            $data['add_time'] = t_time();
            $this->model->insert($data);
            response_msg(0,'添加成功！');
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
        response_msg(0,'删除成功！');
    }
}
