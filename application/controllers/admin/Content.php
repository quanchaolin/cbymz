<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 内容总类
*/
include_once 'Base.php';
include_once (APPPATH.'libraries/WechatAuth.php');
class Content extends Base
{
    public $name = '内容名称'; // 模块中文名
    public $control = 'content'; // 控制器名称
    public $model_name = 'base_model';
    public $baseurl = 'admin/content/'; // 本控制器的前段URL
    public $list_view = 'content_list'; // 列表页
    public $add_view = 'content_add'; // 添加页
    public $per_page = 20; // 每页显示20条
    public $like_fields = array('title'); // 列表页，模糊查询字段
    public $type='';//类型
    public $app_id;
    public $app_secret;
    function __construct()
    {
        parent::__construct();
        $this->app_id=get_admin_config('app_id');
        $this->app_secret=get_admin_config('app_secret');
        if (empty($this->uid)) {
            $redirect_uri=rawurlencode(cur_page_url());
            $IS_AJAX=isAjax();
            if($IS_AJAX)
            {
                response_msg(1002,'请先登录!');
            }
            else
            {
                show_msg('请先登录', site_url('admin/common/login?redirect_uri='.$redirect_uri));
            }
        }


    }
    // 首页
    public function index()
    {
        $url_forward = $this->baseurl . '/index?';

        // 查询条件
        $where = '1=1 ';
        $keywords = trim($_REQUEST['keywords']);
        if ($keywords) {
            $data['keywords'] = $keywords;
            $url_forward .= "&keywords=" . rawurlencode($keywords);
            $keywords = $this->db->escape_like_str($keywords);
            $where .= " AND (";
            foreach ($this->like_fields as $key => $field) {
                if ($key == 0) {
                    $where .= " $field like '%{$keywords}%' ";
                } else {
                    $where .= " OR $field like '%{$keywords}%' ";
                }
            }
            $where .= ") ";
        }

        // URL及分页
        $offset = intval($_GET['per_page']);
        $data['count'] = $this->model->count($where);
        $data['pages'] = $this->page_html($url_forward, $data['count']);
        $this->url_forward($url_forward . '&per_page=' . $offset);

        // 列表数据
        $list = $this->model->lists('*', $where, 'id DESC', $this->per_page, $offset);
//        foreach ($list as &$value) {
//            if($value['thumb']) $value['thumb'] = base_url($value['thumb']);
//        }
        $data['list'] = ($list);

        $this->load->view('admin/' . $this->list_view, $data);
    }

    // 添加
    public function add()
    {
        $value['catid'] = intval($_REQUEST['catid']);
        $data['value'] = $value;

        $this->load->view('admin/' . $this->add_view, $data);
    }

    // 编辑
    public function edit()
    {
        $id = $_GET['id'];
        // 这条信息
        $value = $this->model->row($id);
        $data['value'] = html_escape_move($value);

        $this->load->view('admin/' . $this->add_view, $data);
    }

    // 保存 添加和修改都是在这里
    public function save()
    {
        $id = intval($_POST['id']);
        $data = trims($_POST['value']);

//         if ($data['title'] == "") {
//             show_msg('标题不能为空');
//         }

//        // 生成两张缩略图
//        if($data['thumb']) {
//            $data['thumb'] = str_replace('../','',$data['thumb']);
//            thumb2($data['thumb']);
//        }

        if ($id) { // 修改 ===========         
            $this->model->update($data, $id);
            show_msg('修改成功！', $this->admin['url_forward']);
        } else { // ===========添加 ===========
            $data['addtime'] = time();
            $this->model->insert($data);
            show_msg('添加成功！', $this->admin['url_forward']);
        }
    }

    // 删除
    public function delete()
    {
        $id = $_GET['id'];
        $id_arr = $_POST['delete'];

        if ($id) {
            $this->model->delete($id);
        } else {
            $this->model->delete($id_arr);
        }

        show_msg('删除成功！', $this->admin['url_forward']);
    }

    // 审核
    public function update_status()
    {
        $id = intval($_GET['id']);
        $status = intval($_GET['status']);
        if ($id && strlen($status)) {
            echo $this->model->update_status($status, $id);
        } else {
            echo 0;
        }
    }
    // 返回分页信息
    public function page_html($url, $count)
    {
        $this->config->load('pagination', true);
        $pagination = $this->config->item('pagination');
        $pagination['base_url'] = $url;
        $pagination['total_rows'] = $count;
        $pagination['per_page'] = $this->per_page;
        $this->load->library('pagination');
        $this->pagination->initialize($pagination);

        return $this->pagination->create_links();
    }
}
