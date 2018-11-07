<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 商品分组管理
 */
include_once 'Content.php';

class Product_group extends Content
{
    function __construct()
    {
        $this->name = '商品分组';
        $this->control = 'product_group';
        $this->list_view = 'product_group_list'; // 列表页
        $this->add_view = 'product_group_add'; // 添加页
        parent::__construct();
        $this->baseurl = site_url('admin/product_group/');
        $this->load->model('admin/product_group_model', 'model');
        $this->load->model('admin/product_model');
        $this->load->model('admin/category_model');
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
        $where = 'status!=-1 ';
        $keywords = trim($_REQUEST['keywords']);
        if ($keywords) {
            $data['keywords'] = $keywords;
            $keywords = $this->db->escape_like_str($keywords);
            $where .= " AND group_name like '%{$keywords}%' ";
        }
        $count = $this->model->count($where);
        // 列表数据
        $list = $this->model->lists('id,group_name,product_list,remark,seq,status', $where, 'seq DESC' ,$count, 0);
        foreach($list as &$item)
        {
            $product_list=explode(',',$item['product_list']);
            $item['product_name']='';
            foreach($product_list as $key=>$val)
            {
                if($key>=1)
                {
                    $item['product_name'].=',';
                }
                $product=$this->product_model->row(array('id'=>$val));
                $item['product_name'].=$product['name'];
            }
            unset($item['product_list']);
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
        
        if ($data['group_name']=='') {
            echo json_encode(
                array(
                    'errcode'=>1,
                    'errmsg'=>'分组名称不能为空'
                )
            );exit;
        }
        $data['update_time'] = t_time();
        $data['operator']=$this->admin['username'];
        $data['operate_ip']=ip();
        if ($id) { // 修改 ===========
            //检查是否重复
            $row=$this->model->row(array('group_name'=>$data['group_name'],'id !='=>$id));
            if($row)
            {
                response_msg(2,'分组名称已存在，请更换！');
            }
            $data['update_time'] = t_time();
            $this->model->update($data, $id);
            response_msg(0,'修改成功！');
        } else { // ===========添加 ===========
            //检查标题是否重复
            $row=$this->model->row(array('group_name'=>$data['group_name']));
            if($row)
            {
                response_msg(3,'分组名称已存在，请更换！');
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
    /*
     * 获取分组商品列表
     */
    public function product_list()
    {
        $id=intval($this->input->get('id'));
        $group=$this->model->row(array('id'=>$id));
        if(!$group)
        {
            response_msg(1,'分组数据不存在！');
        }
        $where="status=1";
        $keywords = trim($_REQUEST['keywords']);
        if ($keywords) {
            $data['keywords'] = $keywords;
            $keywords = $this->db->escape_like_str($keywords);
            $where .= " AND name like '%{$keywords}%' ";
        }
        $count=$this->product_model->count($where);
        $product=$this->product_model->lists('id,name,category_id,add_time',$where,'id DESC',$count,0);
        $product_list=explode(',',$group['product_list']);
        foreach($product as &$item)
        {
            $item['checked']='';
            if(in_array($item['id'],$product_list))
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
        $group=$this->model->row(array('id'=>$id));
        if(!$group)
        {
            response_msg(1,'分组数据不存在！');
        }
        $product_list='';
        if($data)
        {
            foreach($data as $key=>$val)
            {
                if($key>=1)
                {
                    $product_list.=',';
                }
                $product_list.=$val;
            }
        }
        $insert_data=array(
                'product_list'=>$product_list
        );
        $this->model->update($insert_data,array('id'=>$id));
        echo json_encode(
            array(
                'errcode'=>0,
                'errmsg'=>'success'
            )
        );exit;
    }
}
