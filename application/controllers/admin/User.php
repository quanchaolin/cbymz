<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 用户管理
 */
include_once 'Content.php';
class User extends Content
{
    function __construct()
    {
        $this->name = '用户管理';
        $this->control = 'user';
        $this->list_view = 'user_list'; // 列表页
        $this->add_view = 'user_add'; // 添加页
        parent::__construct();
        $this->baseurl = site_url('admin/user/');
        $this->load->model('admin/user_model', 'model');
    }

    // 首页
    public function index(){
        $url_forward = $this->baseurl . 'index?';
        // 查询条件
        $where = 'subscribe=1 ';
        $keywords = trim($_REQUEST['keywords']);
        if ($keywords) {
            $data['keywords'] = $keywords;
            $url_forward .= "&keywords=" . rawurlencode($keywords);
            $keywords = $this->db->escape_like_str($keywords);

            $where .= " AND nickname like '%{$keywords}%' ";
        }

        // URL及分页
        $offset = intval($_GET['per_page']);
        $data['count'] = $this->model->count($where);
        $data['pages'] = $this->page_html($url_forward, $data['count']);
        $this->url_forward($url_forward . '&per_page=' . $offset);

        // 列表数据
        $list = $this->model->lists('*', $where, 'subscribe_time DESC', $this->per_page, $offset);
        $sex=$this->config->item('sex');
        foreach($list as &$item)
        {
            $item['subscribe_time']=times($item['subscribe_time']);
            $item['headimgurl_thumb']='';
            if($item['headimgurl']!='')
            {
                $item['headimgurl_thumb']=substr($item['headimgurl'],0,-1).'96';
            }
            $item['sex']=$sex[$item['sex']];
        }
        $data['list'] = $list;
        $this->load->view('admin/'.$this->list_view, $data);
    }
    public function lists(){
        $where = "status!=-1 AND subscribe=1";
        $keywords = trim($_REQUEST['keywords']);
        if ($keywords) {
            $keywords = $this->db->escape_like_str($keywords);
            $where .= " AND nickname like '%{$keywords}%' ";
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
        $list = $this->model->lists('nickname,openid', $where, 'subscribe_time ASC' ,$pageSize, $offset);
        foreach($list as &$item)
        {
            break;
        }
        $data=array(
            'data'=>$list,
            'total'=>$count,
        );
        response_msg(0,'success',$data);
    }
    /**
     *关注者信息
     */
    function detail()
    {
        $openid = trim($this->input->get('openid'));
        // 这条信息
        $value = $this->model->row(array('openid'=>$openid));
        if($value['headimgurl']!='')
        {
            $value['headimgurl']=substr($value['headimgurl'],0,-1).'96';
        }
        $value['group_name']='';
        $value['subscribe_time']=times($value['subscribe_time'],1);
        $data['value']=$value;
        $this->load->view('admin/user_detail', $data);
    }
    public function get_user(){
        $url_forward = $this->baseurl . 'get_user?';
        // 查询条件
        $where = 'subscribe=1 ';
        $keywords = trim($_REQUEST['keywords']);
        if ($keywords) {
            $data['keywords'] = $keywords;
            $url_forward .= "&keywords=" . rawurlencode($keywords);
            $keywords = $this->db->escape_like_str($keywords);

            $where .= " AND nickname like '%{$keywords}%' ";
        }

        // URL及分页
        $offset = intval($_GET['per_page']);
        $data['count'] = $this->model->count($where);
        $data['pages'] = $this->page_html($url_forward, $data['count']);
        $this->url_forward($url_forward . '&per_page=' . $offset);

        // 列表数据
        $list = $this->model->lists('*', $where, 'subscribe_time DESC', $this->per_page, $offset);
        $data['list'] = $list;
        $this->load->view('admin/user_page', $data);
    }
    /*
     * 更新关注者信息
     */
    public function refresh()
    {
        set_time_limit(0);
        $this->model->update(array('subscribe'=>0));
        $result=$this->get_user_list();
        response_msg(0,'同步成功!');
    }
    /*
     * 获取关注者列表
     */
    private function get_user_list($next_openid='')
    {
        $wechat=new WechatAuth($this->app_id,$this->app_secret);
        $wechat->getAccessToken();
        $result=$wechat->userGet($next_openid);
        $list=$result['data']['openid'];
        $next_openid=$result['next_openid'];
        if($list){
            foreach ($list as $openid){
                $row=$this->model->row(array('openid'=>$openid));
                if($row)
                {
                    $this->model->update(array('subscribe'=>1),array('openid'=>$openid));
                }else{
                    $user_info=$wechat->userInfo($openid);
                    $data=array(
                        'subscribe'=>$user_info['subscribe'],
                        'openid'=>$user_info['openid'],
                        'nickname'=>$user_info['nickname'],
                        'sex'=>$user_info['sex'],
                        'language'=>$user_info['language'],
                        'city'=>$user_info['city'],
                        'province'=>$user_info['province'],
                        'country'=>$user_info['country'],
                        'headimgurl'=>$user_info['headimgurl'],
                        'subscribe_time'=>$user_info['subscribe_time'],
                        'remark'=>$user_info['remark']
                    );
                    $result=$this->model->insert($data);
                }
            }
        }
        if($next_openid!=''){
            $this->get_user_list($next_openid);
        }
    }
}
