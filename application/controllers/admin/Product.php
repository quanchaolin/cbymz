<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 商品管理
 */
include_once 'Content.php';
include_once APPPATH.'libraries/Cate.php';
class Product extends Content
{
    function __construct()
    {
        $this->name = '商品管理';
        $this->control = 'product';
        $this->list_view = 'product_list'; // 列表页
        $this->add_view = 'product_add'; // 添加页
        parent::__construct();
        $this->baseurl = site_url('admin/product/');
        $this->load->model('admin/product_model', 'model');
        $this->load->model('admin/category_model');
        $this->load->model('admin/back_paper_model');
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

            $where .= " AND name like '%{$keywords}%' ";
        }
        $category_id = $_REQUEST['category_id'];
        if ($category_id) {
            $data['category_id'] = $category_id;
            $url_forward .= "&category_id=" . rawurlencode($category_id);
            $category_id = $this->db->escape_like_str($category_id);

            $where .= " AND category_id like '%{$category_id}%' ";
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
            $category=$this->category_model->row(array('id'=>$item['category_id']));
            $item['category_name']=$category['name'];

            $back_paper=$this->back_paper_model->row(array('id'=>$item['back_paper_id']));
            $item['back_paper_name']=$back_paper['title'];
            $item['main_img']=config_item('img_url').$item['main_img'];
        }
        $data['list'] = $list;
        $category_count=$this->category_model->count(array('status'=>1));
        $category=$this->category_model->lists('id,name',array('status'=>1),'id DESC',$category_count,0);
        $data['category']=$category;
        $this->load->view('admin/'.$this->list_view, $data);
    }

    // 添加
    public function add()
    {
        $category_count=$this->category_model->count(array('status'=>1));
        $list=$this->category_model->lists('id,pid,name',array('status'=>1),'id DESC',$category_count,0);
        $cate= Cate::level($list,'&nbsp;&nbsp;├');
        $selected='selected';
        $categorytree="<select name='category_id' class='form-control category_id'><option $selected value='0'>顶级分类</option>";
        foreach($cate as $item)
        {
            $categorytree.="<option value='$item[id]'>$item[html]$item[name]</option>";
        }
        $categorytree.='</select>';
        $data['categorytree']=$categorytree;
        $back_paper_count=$this->back_paper_model->count(array('status'=>1));
        $back_paper=$this->back_paper_model->lists('id,title',array('status'=>1),'id DESC',$back_paper_count,0);
        $data['back_paper']=$back_paper;
        $this->load->view('admin/'.$this->add_view, $data);
    }

    // 编辑
    public function edit()
    {
        $id = $_GET['id'];
        // 这条信息
        $value = $this->model->row($id);

        if($value && $value['min_price']!=0)
        {
            $value['min_price']=$value['min_price']/100;
        }
        if($value['main_img']=='')
        {
            $value['main_img']='static/images/default_avatar_male.jpg';
        }
        if($value['detail_img']=='')
        {
            $value['detail_img']='static/images/default_avatar_male.jpg';
        }
        $data['value'] = $value;
        $category_count=$this->category_model->count(array('status'=>1));
        $list=$this->category_model->lists('id,pid,name',array('status'=>1),'id DESC',$category_count,0);
        $cate= Cate::level($list,'&nbsp;&nbsp;├');
        $selected='';
        if($value['category_id']==0)
        {
            $selected='selected';
        }
        $categorytree="<select name='category_id' class='form-control category_id'><option $selected value='0'>顶级分类</option>";
        $selected='';
        foreach($cate as $item)
        {
            if($item['id']==$value['category_id'])
            {
                $selected='selected';
            }
            $categorytree.="<option $selected value='$item[id]'>$item[html]$item[name]</option>";
            $selected='';
        }
        $categorytree.='</select>';
        $data['categorytree']=$categorytree;
        $back_paper_count=$this->back_paper_model->count(array('status'=>1));
        $back_paper=$this->back_paper_model->lists('id,title',array('status'=>1),'id DESC',$back_paper_count,0);
        $data['back_paper']=$back_paper;
        $this->load->view('admin/' . $this->add_view, $data);
    }


    // 保存 添加和修改都是在这里
    public function save()
    {
        $id = intval($_POST['id']);
        $data = trims($_POST['value']);
        if(isset($data['editorValue']))
        {
            unset($data['editorValue']);
        }
        if ($data['name']=='') {
            response_msg(1,'商品名称不能为空');
        }
        if ($data['main_img']=='') {
            response_msg(2,'商品主图不能为空');
        }
        if ($data['detail_img']=='') {
            response_msg(3,'商品详情图片不能为空');
        }
        if ($data['price']=='') {
            response_msg(4,'商品价格不能为空');
        }
        if($data['min_price']!=0)
        {
            $data['min_price']*=100;
        }
        $config=array(
            'email_input_show'=>true,
            'show_price_input'=>false,
            'tpl'=>'qfxz_detail',
            'pay_title'=>'——请选择随喜金额——',
            'button'=>'确定',
            'placeholder'=>'超度往生者名字',
            'content_show'=>true,
            'other_content'=>false
        );
        $data['custom_config']=@serialize($config);
        $data['update_time'] = t_time();
        $data['operator']=$this->admin['username'];
        $data['operate_ip']=ip();
        if ($id) { // 修改 ===========
            //检查是否重复
            $row=$this->model->row(array('name'=>$data['name'],'id !='=>$id));
            if($row)
            {
                response_msg(5,'商品名已存在，请更换！');
            }
            $this->model->update($data, $id);
            response_msg(0,'修改成功！');
        } else { // ===========添加 ===========
            //检查标题是否重复
            $row=$this->model->row(array('name'=>$data['name']));
            if($row)
            {
                response_msg(5,'商品名已存在，请更换！');
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
