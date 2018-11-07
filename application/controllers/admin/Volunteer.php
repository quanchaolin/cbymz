<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 义工管理
 */
include_once 'Content.php';

class Volunteer extends Content
{
    public $send_weixin=array(0=>'不发送',1=>'发送');
    function __construct()
    {
        $this->name = '义工管理';
        $this->control = 'volunteer';
        $this->list_view = 'volunteer_list'; // 列表页
        $this->add_view = 'volunteer_add'; // 添加页
        parent::__construct();
        $this->baseurl = site_url('admin/volunteer/');
        $this->load->model('admin/volunteer_model', 'model');
        $this->load->model('admin/volunteer_product_model');
        $this->load->model('admin/product_model');
        $this->load->model('admin/sys_user_model');
        $this->load->model('admin/category_model');
    }

    // 首页
    public function index(){
        $sys_user_count=$this->sys_user_model->count(array('status'=>1));
        $sys_user=$this->sys_user_model->lists('id,true_name',array('status'=>1),'id DESC',$sys_user_count,0);
        $data['sys_user']=json_encode($sys_user);
        $this->load->view('admin/'.$this->list_view, $data);
    }
    /*
     * 获取列表信息
     */
    public function lists()
    {
        $where = 'status!=-1 ';
        $keywords = trim($_REQUEST['keywords']);
        if ($keywords) {
            $data['keywords'] = $keywords;
            $keywords = $this->db->escape_like_str($keywords);
            $where .= " AND name like '%{$keywords}%' ";
        }
        $count = $this->model->count($where);
        // 列表数据
        $list = $this->model->lists('id,user_id,name,nickname,openid,email,send_weixin,remark,status', $where, 'id DESC' ,$count, 0);
        foreach($list as &$item)
        {
            $count=$this->volunteer_product_model->count(array('volunteer_id'=>$item['id']));
            $product_list=$this->volunteer_product_model->lists('product_id',array('volunteer_id'=>$item['id']),'id ASC',$count,0);
            $item['product_name']='';
            foreach($product_list as $key=>$val)
            {
                if($key>=1)
                {
                    $item['product_name'].=',';
                }
                $product=$this->product_model->row(array('id'=>$val['product_id']));
                $item['product_name'].=$product['name'];
            }
            //义工关联的管理员
            $item['send_weixin_text']=$this->send_weixin[$item['send_weixin']];
            $sys_user=$this->sys_user_model->row(array('id'=>$item['user_id'],'status'=>1));
            $true_name='';
            if($item)
            {
                $true_name=$sys_user['true_name'];
            }
            $item['true_name']=$true_name;
        }
        $data['list'] = $list;
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

        if ($data['name']=='') {
            response_msg(1,'用户姓名不能为空！');
        }
        if ($data['email']=='') {
            response_msg(2,'邮箱不能为空！');
        }
        $data['update_time'] = t_time();
        $data['operator']=$this->admin['username'];
        $data['operate_ip']=ip();
        if ($id) { // 修改 ===========
            //检查是否重复
            $row=$this->model->row(array('name'=>$data['name'],'id !='=>$id));
            if($row)
            {
                response_msg(3,'用户姓名已存在，请更换！');
            }
            $row_email=$this->model->row(array('email'=>$data['email'],'id !='=>$id));
            if($row_email)
            {
                response_msg(4,'邮箱已存在，请更换！');
            }
            $data['update_time'] = t_time();
            $this->model->update($data, $id);
            response_msg(0,'修改成功！');
        } else { // ===========添加 ===========
            //检查标题是否重复
            $row=$this->model->row(array('name'=>$data['name']));
            if($row)
            {
                response_msg(3,'用户姓名已存在，请更换！');
            }
            $row_email=$this->model->row(array('email'=>$data['email'],'id !='=>$id));
            if($row_email)
            {
                response_msg(4,'邮箱已存在，请更换！');
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
        if (is_numeric($id)) {
            $this->model->delete($id);
            $this->volunteer_product_model->delete(array('volunteer_id'=>$id));
        } elseif(is_array($id_arr)) {
            foreach($id_arr as $item)
            {
                $this->model->delete($item);
                $this->volunteer_product_model->delete(array('volunteer_id'=>$id));
            }
        }
        show_msg('删除成功！', $this->admin['url_forward']);
    }
    /*
         * 获取分组商品列表
         */
    public function product_list()
    {
        $id=intval($this->input->get('id'));
        $volunteer=$this->model->row(array('id'=>$id));
        if(!$volunteer)
        {
            response_msg(1,'义工不存在！');
        }
        $where='status!=-1 AND send_msg=1';
        $keywords = trim($_REQUEST['keywords']);
        if ($keywords) {
            $data['keywords'] = $keywords;
            $keywords = $this->db->escape_like_str($keywords);
            $where .= " AND name like '%{$keywords}%' ";
        }
        $count=$this->product_model->count($where);
        $product=$this->product_model->lists('id,name,category_id,add_time',$where,'id DESC',$count,0);
        foreach($product as &$item)
        {
            $item['checked']='';
            $volunteer_product=$this->volunteer_product_model->row(array('volunteer_id'=>$id,'product_id'=>$item['id']));
            if($volunteer_product)
            {
                $item['checked']='checked';
            }
            $category_name='';
            $category=$this->category_model->row(array('id'=>$item['category_id']));
            if($category)
            {
                $category_name=$category['name'];
            }
            $item['category_name']=$category_name;
        }
        $data=array(
            'list'=>$product,
            'total'=>$count
        );
        response_msg(0,'success',$data);
    }
    public function product_list_save()
    {
        $id=intval($this->input->post('id'));
        $data=trims($this->input->post('value'));
        $volunteer=$this->model->row(array('id'=>$id));
        if(!$volunteer)
        {
            response_msg(1,'义工不存在！');
        }
        $this->volunteer_product_model->delete(array('volunteer_id'=>$id));
        if($data)
        {
            foreach($data as $key=>$val)
            {
                $insert_data=array(
                    'volunteer_id'=>$id,
                    'product_id'=>$val
                );
                $this->volunteer_product_model->insert($insert_data);
            }
        }
        response_msg(0,'success');
    }

}
