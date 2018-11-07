<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 管理员
 */
include_once 'Content.php';

class Push_record extends Content
{
    function __construct()
    {
        $this->name = '消息推送记录';
        $this->control = 'push_record';
        $this->list_view = 'push_record_list'; // 列表页
        $this->add_view = 'push_record_add'; // 添加页
        parent::__construct();
        $this->baseurl = site_url('admin/push_record/');
        $this->load->model('admin/push_record_model', 'model');
        $this->load->model('admin/push_model');
    }

    // 首页
    public function index(){
        $push_id=intval($this->input->get('push_id'));
        $url_forward = $this->baseurl . "index?push_id=$push_id";
        // 查询条件

        $where = "status!=-1 AND push_id=$push_id";

        // URL及分页
        $offset = intval($_GET['per_page']);
        $data['count'] = $this->model->count($where);
        $data['pages'] = $this->page_html($url_forward, $data['count']);
        $this->url_forward($url_forward . '&per_page=' . $offset);

        // 列表数据
        $list = $this->model->lists('*', $where, 'id DESC', $this->per_page, $offset);
        foreach($list as &$item)
        {
            $push=$this->push_model->row(array('id'=>$item['push_id']));
            $item['title']=$push['title'];
        }
        $data['list'] = $list;
        $this->load->view('admin/'.$this->list_view, $data);
    }


    // 编辑
    public function edit()
    {
        $id = $_GET['id'];
        // 这条信息
        $value = $this->model->row($id);
        $data['value'] = $value;

        $this->load->view('admin/' . $this->add_view, $data);
    }

    public function delete()
    {
        $id = $_GET['id'];
        $id_arr = $_POST['delete'];
        $data=array('update_time'=>t_time(),'status'=>'-1')  ;
        if (is_numeric($id)) {
            $this->model->update($data, $id);
        } elseif(is_array($id_arr)) {
            foreach($id_arr as $item)
            {
                $this->model->update($data, $item);
            }
        }
        show_msg('删除成功！', $this->admin['url_forward']);
    }


}
