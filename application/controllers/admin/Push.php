<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 消息推送
 */
include_once 'Content.php';
class Push extends Content
{
    public $img_url;
    public $msgtype=array(
        'text'=>'文本消息',//文本消息
        'image'=>'图片消息',//图片消息
        'voice'=>'语音消息',//语音消息
        'video'=>'视频消息',//视频消息
        'music'=>'音乐消息',//音乐消息
        'news'=>'图文消息（点击跳转到外链）',//图文消息（点击跳转到外链） 图文消息条数限制在8条以内，注意，如果图文数超过8，则将会无响应。
        'mpnews'=>'图文消息（点击跳转到图文消息页面）',//图文消息（点击跳转到图文消息页面） 图文消息条数限制在8条以内，注意，如果图文数超过8，则将会无响应。
        'wxcard'=>'卡券',//卡券
    );
    public $execute_type=array(
        '1'=>'一次',
        '2'=>'每天',
        '3'=>'每周',
        '4'=>'每月'
    );
    function __construct()
    {
        $this->name = '消息推送';
        $this->control = 'push';
        $this->list_view = 'push_list'; // 列表页
        $this->add_view = 'push_add'; // 添加页
        parent::__construct();
        $this->baseurl = site_url('admin/push/');
        $this->load->model('admin/push_model', 'model');
        $this->load->model('admin/push_item_model');
        $this->load->model('admin/push_record_model');
        $this->load->model('admin/user_model');
        $this->load->model('admin/push_record_model');
        $this->load->model('admin/time_task_model');
        $this->img_url=config_item('img_url');
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

            $where .= " AND title like '%{$keywords}%' ";
        }
        $msgtype=$this->input->get('msgtype');
        if($msgtype)
        {
            $data['msgtype']=$msgtype;
            $url_forward.="&msgtype=".rawurlencode($msgtype);
            $msgtype=$this->db->escape_like_str($msgtype);
            $where.=" AND msgtype='$msgtype'";
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
            $item['msgtype']=$this->msgtype[$item['msgtype']];
        }
        $data['list'] = $list;
        $this->load->view('admin/'.$this->list_view, $data);
    }

    /**
     * 定时任务
     */
    public function timed_task()
    {
        $id = intval($this->input->get('id'));
        $row=$this->time_task_model->row(array('push_id'=>$id,'status!='=>-1));
        if($row){
            response_msg(0,'success',array('data'=>$row));
        }else{
            response_msg(1,'error');
        }
    }
    public function task_save()
    {
        $push_id = intval($this->input->post('push_id'));
        $execute_time = $this->input->post('execute_time');
        if($push_id==0 || $execute_time=='')
        {
            response_msg(1,'参数有误，请检查！');
        }
        $push = $this->model->row(array('id'=>$push_id));
        if(!$push){
            response_msg(2,'消息不存在，请检查！');
        }
        $row=$this->time_task_model->row(array('push_id'=>$push_id,'status!='=>-1));
        $data=array(
            'push_id'=>$push_id,
            'url'=>site_url('push_mpnews?id='.$push_id),
            'status'=>1,
            'execute_time'=>$execute_time,
            'add_time'=>t_time(),
            'operate_ip'=>ip()
        );
        if($row)
        {
            $this->time_task_model->update($data,array('id'=>$row['id']));
        }else{
            $this->time_task_model->insert($data);
        }
        response_msg(0,'定时任务添加成功！');
    }
    // 添加
    public function add()
    {
        $msgtype=$this->input->get('msgtype')?trim($this->input->get('msgtype')):'text';
        if(!array_key_exists($msgtype,$this->msgtype))
        {
            show_msg('消息类型不存在！');
        }
        $data['push_item']=json_encode(array());
        $this->load->view('admin/push_'.$msgtype,$data);
    }

    // 编辑
    public function edit()
    {
        $id = $_GET['id'];
        // 这条信息
        $value = $this->model->row($id);
        $value['push_item']=array();
        if($value['msgtype']=='news')
        {
            $push_item=$this->push_item_model->lists('*',array('push_id'=>$value['id']),'id ASC');
            $data['push_item']=json_encode($push_item);
        }
        $data['value'] = $value;
        $msgtype=$value['msgtype'];
        $this->load->view('admin/push_'.$msgtype, $data);
    }


    // 保存 添加和修改都是在这里
    public function save()
    {
        $id = intval($_POST['id']);
        $data = trims($_POST['value']);
        if($data['title']=='') {
            response_msg(1,'标题不能为空！');
        }
        if($data['msgtype']=='text' && $data['content']==''){
            response_msg(2,'文本消息内容不能为空！');
        }
        $data['update_time'] = t_time();
        $data['operator']=$this->admin['username'];
        $data['operate_ip']=t_time();
        if ($id) { // 修改 ===========
            $data['update_time'] = t_time();
            $this->model->update($data, $id);
            response_msg(0,'修改成功！');
        } else { // ===========添加 ===========
            $data['add_time'] = t_time();
            $this->model->insert($data);
            response_msg(0,'添加成功！');
        }
    }
    public function save_news()
    {
        $id = intval($_POST['id']);
        $list = trims($_POST['list']);
        $data['update_time'] = t_time();
        $data['msgtype']='news';
        $data['title']=$list[0]['title'];
        if ($id) { // 修改 ===========
            $data['update_time'] = t_time();
            $this->model->update($data, $id);
            foreach($list as $item)
            {
                $insert_data=array(
                    'push_id'=>$id,
                    'title'=>$item['title'],
                    'picurl'=>$item['picurl'],
                    'description'=>$item['description'],
                    'add_time'=>t_time(),
                    'update_time'=>t_time(),
                );
                if($item['back_paper_item_id']!=''){
                    $this->push_item_model->update($insert_data,array('id'=>$item['back_paper_item_id']));
                }else{
                    $item_insert_id=$this->push_item_model->insert($insert_data);
                }
            }
            response_msg(0,'修改成功!');
        } else { // ===========添加 ===========
            $data['add_time'] = t_time();
            $insert_id=$this->model->insert($data);
            foreach($list as $item) {
                $insert_data = array(
                    'push_id' => $insert_id,
                    'title' => $item['title'],
                    'picurl' => $item['picurl'],
                    'description' => $item['description'],
                    'add_time' => t_time(),
                    'update_time' => t_time(),
                );
                $item_insert_id=$this->push_item_model->insert($insert_data);
            }
            response_msg(0,'添加成功!');
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
    public function send()
    {
        $id=intval($this->input->get_post('id'));
        $count=$this->user_model->count(array('subscribe'=>1));
        $list=$this->user_model->lists('openid',array('subscribe'=>1),'subscribe_time ASC',$count,0);
        $this->wechat_send($id,$list);
    }
    /*
     * 预览
     */
    public function preview()
    {
        $id=intval($this->input->post('id'));
        $list=$this->input->post('value');
        $this->wechat_send($id,$list);
    }
    /*
     * 客服消息发送
     */
    private function wechat_send($id,$list)
    {
        set_time_limit(0);
        if(!$list)
        {
            response_msg(1,'openid不能为空！');
        }
        $row=$this->model->row(array('id'=>$id));
        if(!$row)
        {
            response_msg(1,'找不到信息！');
        }
        $wechat=new WechatAuth($this->app_id,$this->app_secret);
        $wechat->getAccessToken();
        $total=0;
        $total_success=0;
        foreach($list as $val){
            $openid=is_array($val)?$val['openid']:$val;
            switch($row['msgtype'])
            {
                case 'text':
                    $result=$wechat->sendText($openid,$row['content']);
                    break;
                case 'image':
                    $result=$wechat->sendImage($openid,$row['media_id']);
                    break;
                case 'voice':
                    $result=$wechat->sendVoice($openid,$row['media_id']);
                    break;
                case 'video':
                    $result=$wechat->sendVideo($openid,$row['media_id'],$row['title'],$row['description']);
                    break;
                case 'music':
                    $result=$wechat->sendMusic($openid,$row['title'],$row['description'],$row['musicurl'],$row['hqmusicurl'],$row['thumb_media_id']);
                    break;
                case 'news':
                    $back_paper_item=$this->push_item_model->lists('title,description,url,picurl',array('push_id'=>$row['id']),'id ASC');
                    $news_data=array();
                    foreach ($back_paper_item as $item) {
                        $news_data[] =array(
                            'title'=>$item['title'],
                            'description'=>$item['description'],
                            'url'=>$item['url'],
                            'picurl'=>$item['picurl'],
                        );
                    }
                    if($news_data){
                        $result=$wechat->messageCustomSend($openid,$news_data,'news');
                    }
                    break;
                case 'mpnews':
                    $result=$wechat->sendMpnews($openid,$row['media_id']);
                    break;
            }
            $total++;
            if($result['errcode']==0){
                $total_success++;
            }
        }
        $insert_data=array(
            'push_id'=>$id,
            'total'=>$total,
            'total_success'=>$total_success,
            'add_time'=>t_time(),
        );
        if(count($list)>1){
            $this->push_record_model->insert($insert_data);
        }
        response_msg($result['errcode'],$result['errmsg']);
    }
}
