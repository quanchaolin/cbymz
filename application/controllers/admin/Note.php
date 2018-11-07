<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 *  笔记
 */
include_once 'Content.php';
include_once (APPPATH.'libraries/Verify.php');
class Note extends Content
{
    function __construct()
    {
        $this->name = '笔记';
        $this->control = 'note';
        $this->list_view = 'note_list'; // 列表页
        $this->add_view = 'note_add'; // 添加页
        parent::__construct();
        $this->short_url='admin/note/';
        $this->baseurl = site_url('admin/note/');
        $this->load->model('admin/note_model', 'model');
    }
    public function lists(){
        // 查询条件
        $where = 'status!=-1 AND user_id='.$this->uid;
        $keywords = trim($_REQUEST['keywords']);
        if ($keywords) {
            $keywords = $this->db->escape_like_str($keywords);
            $where .= " AND title like '%{$keywords}%' ";
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
        $list = $this->model->lists('id,title,description,status', $where, 'id DESC',$pageSize, $offset);
        foreach($list as &$item)
        {
            break;
        }
        $data['total']=$count;
        $data['data']=$list;
        echo json_encode(
            array(
                'errcode'=>0,
                'errmsg'=>'success',
                'data'=>$data
            )
        );exit;
    }

    // 保存 添加和修改都是在这里
    public function save()
    {
        $id = intval($_POST['id']);
        $data = trims($_POST['value']);
        if (!Verify::isEmpty($data['description'])) {
            echo json_encode(
                array(
                    'errcode'=>1,
                    'errmsg'=>'笔记内容不能为空'
                )
            );exit;
        }
        $data['user_id']=$this->uid;
        $data['update_time'] = t_time();
        $data['operator']=$this->admin['username'];
        $data['operate_ip']=ip();
        if ($id) { // 修改 ===========
            $this->model->update($data, $id);
            echo json_encode(
                array(
                    'errcode'=>0,
                    'errmsg'=>'修改成功'
                )
            );exit;
        } else { // ===========添加 ===========
            $data['add_time'] = t_time();
            $this->model->insert($data);
            echo json_encode(
                array(
                    'errcode'=>0,
                    'errmsg'=>'添加成功',
                )
            );exit;
        }
    }
}
