<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 管理员
 */
include_once 'Content.php';
include_once (APPPATH.'libraries/Verify.php');
include_once APPPATH.'libraries/Cate.php';
class Profile extends Content
{
    public $skills;
    function __construct()
    {
        $this->name = '个人中心';
        $this->control = 'profile';
        $this->list_view = 'profile_index'; // 列表页
        $this->add_view = 'profile_add'; // 添加页
        parent::__construct();
        $this->baseurl = site_url('admin/profile/');
        $this->short_url='admin/profile/';
        $this->load->model('admin/sys_user_model', 'model');
    }

    // 首页
    public function index(){
        $value=$this->user_info();
        $data['value']=$value;
        $edu_list=$this->edu_info();
        $data['edu_list']=$edu_list;
        $note_list=$this->note_info();
        $data['note_list']=$note_list;
        $this->load->view('admin/'.$this->list_view, $data);
    }

    /*
         * 修改密码
         */
    public function change_pwd()
    {
        $value=$this->user_info();
        $data['value']=$value;
        $edu_list=$this->edu_info();
        $data['edu_list']=$edu_list;
        $note_list=$this->note_info();
        $data['note_list']=$note_list;
        $this->load->view('admin/profile_change_pwd',$data);
    }
    /*
     * 教育背景
     */
    public function education()
    {
        $school_type=$this->config->item('school_type');
        $data['school_type']=json_encode($school_type);
        $value=$this->user_info();
        $data['value']=$value;
        $edu_list=$this->edu_info();
        $data['edu_list']=$edu_list;
        $this->load->view('admin/profile_education',$data);
    }
    /*
     * 笔记
     */
    public function note()
    {
        $value=$this->user_info();
        $data['value']=$value;
        $edu_list=$this->edu_info();
        $data['edu_list']=$edu_list;
        $note_list=$this->note_info();
        $data['note_list']=$note_list;
        $this->load->view('admin/profile_note',$data);
    }
    // 保存 添加和修改都是在这里
    public function save()
    {
        $post_data = trims($_POST['value']);
        $skills=$this->input->post('skills');
        if (!Verify::isEmpty($post_data['true_name'])) {
            echo json_encode(
                array(
                    'errcode'=>1,
                    'errmsg'=>'姓名不能为空'
                )
            );exit;
        }
        if (!Verify::isEmpty($post_data['mail'])) {
            echo json_encode(
                array(
                    'errcode'=>1,
                    'errmsg'=>'邮箱不能为空'
                )
            );exit;
        }
        if ($post_data['password']!='') {
            $post_data['password'] = get_password($post_data['password']);
        } else {
            unset ($post_data['password']);
        }
        $data=$this->deal_data($post_data);
        //主表数据
        $main_data=$data['main_data'];
        //详情表数据
        $item_data=$data['item_data'];
        $main_data['update_time'] = t_time();
        $main_data['operate_ip']=ip();
        $id=$this->uid;
        if ($id) { // 修改 ===========
            $this->model->update($main_data, $id);
            $item_data['skills']=$skills;
            //保存到详情表
            $this->item_save($item_data);
            echo json_encode(
                array(
                    'errcode'=>0,
                    'errmsg'=>'修改成功!'
                )
            );exit;
        }
    }
    /*
     * 密码修改保存
     */
    public function pwd_save()
    {
        $data=trims($this->input->post('value'));
        $old_password=$data['old_password'];
        if(!Verify::isEmpty($old_password))
        {
            echo json_encode(
                array(
                    'errcode'=>1,
                    'errmsg'=>'原密码不能为空！'
                )
            );exit;
        }
        if(!Verify::isEmpty($data['new_password']))
        {
            echo json_encode(
                array(
                    'errcode'=>2,
                    'errmsg'=>'新密码不能为空！'
                )
            );exit;
        }
        $row=$this->model->row(array('id'=>$this->uid));
        if($row['password']!=get_password($old_password))
        {
            echo json_encode(
                array(
                    'errcode'=>3,
                    'errmsg'=>'原密码有误，请检查！'
                )
            );exit;
        }
        $new_password=get_password($data['new_password']);
        $update_data=array(
            'password'=>$new_password,
            'operate_time'=>t_time()
        );
        $this->model->update($update_data,array('id'=>$row['id']));
        echo json_encode(
            array(
                'errcode'=>0,
                'errmsg'=>'密码修改成功！'
            )
        );exit;
    }
    public function crop()
    {
        include_once (APPPATH.'libraries/CropAvatar.php');
        $crop = new CropAvatar($_POST['avatar_src'], $_POST['avatar_data'], $_FILES['avatar_file']);
        $result=$crop -> getResult();
        $response = array(
            'state'  => 200,
            'message' => $crop -> getMsg(),
            'result' => $crop -> getResult()
        );
        if($result!=null)
        {
            $data=array(
                'head_img_url'=>$crop -> getResult(),
                'operator'=>$this->admin['username'],
                'operate_time'=>t_time(),
                'operate_ip'=>ip()
            );
            $this->model->update($data,array('id'=>$this->uid));
        }
        echo json_encode($response);
    }
    /*
     * 用户信息
     */
    private function user_info()
    {
        $value=$this->model->row(array('id'=>$this->uid));
        $img_url=$this->config->item('img_url');
        if($value)
        {
            if($value['head_img_url']!='')
            {
                $value['head_img_url']=$img_url.$value['head_img_url'];
            }

        }
        return $value;
    }
    /*
     * 教育背景
     */
    private function edu_info()
    {
        $this->load->model('admin/education_model');
        $where = 'status=1 AND user_id='.$this->uid;
        $edu_list = $this->education_model->lists('id,school_name,school_year,status', $where, 'id ASC', 4, 0);
        return $edu_list;
    }
    /*
     * 笔记
     */
    private function note_info()
    {
        $this->load->model('admin/note_model');
        $where = 'status=1 AND user_id='.$this->uid;
        $note_list = $this->note_model->lists('id,title,add_time', $where, 'id DESC', 4, 0);
        return $note_list;
    }
    /*
     * 保存用户信息到详情表
     */
    private function item_save($data)
    {
        $row=$this->sys_user_item_model->row(array('user_id'=>$this->uid));
        if($data['skills'])
        {
            $skills=implode(',',$data['skills']);
            $data['skills']=$skills;
        }
        if($row)
        {
            $this->sys_user_item_model->update($data,array('user_id'=>$this->uid));
        }
        else{
            $data['user_id']=$this->uid;
            $this->sys_user_item_model->insert($data);
        }
    }
    /*
     * 处理提交上来的数据
     * @parse array $post_data
     * return array()
     */
    private function deal_data($post_data)
    {
        $item_list=array('positional_titles','skills');
        $main_data=array();
        $item_data=array();
        foreach($item_list as $item)
        {
            if(isset($post_data[$item]))
            {
                $item_data[$item]=$post_data[$item];
                unset($post_data[$item]);
            }
        }
        $data['main_data']=$post_data;
        $data['item_data']=$item_data;
        return $data;
    }
    private function declare_count()
    {
        $this->load->model('admin/base_work_flow_history_model');
        $count=$this->base_work_flow_history_model->count(array('audit_user_id'=>$this->uid,'status!='=>-1));
        return $count;
    }
    private function project_count()
    {
        $this->load->model('admin/project_model');
        $count=$this->project_model->count(array('user_id'=>$this->uid,'status!='=>-1));
        return $count;
    }
}
