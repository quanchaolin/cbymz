<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 素材管理（图片）
 */
include_once 'Content.php';
class Material_image extends Content
{
    public $material_type='image';
    function __construct()
    {
        $this->name = '图片管理';
        $this->control = 'material_image';
        $this->list_view = 'material_image_list'; // 列表页
        $this->add_view = 'material_image_add'; // 添加页
        parent::__construct();
        $this->baseurl = site_url('admin/material_image/');
        $this->load->model('admin/material_model', 'model');
    }

    // 首页
    public function index(){
        $url_forward = $this->baseurl . 'index?';
        // 查询条件
        $where = "type='$this->material_type' ";
        $keywords = trim($_REQUEST['keywords']);
        if ($keywords) {
            $data['keywords'] = $keywords;
            $url_forward .= "&keywords=" . rawurlencode($keywords);
            $keywords = $this->db->escape_like_str($keywords);

            $where .= " AND name like '%{$keywords}%' ";
        }

        // URL及分页
        $offset = intval($_GET['per_page']);
        $data['count'] = $this->model->count($where);
        $data['pages'] = $this->page_html($url_forward, $data['count']);
        $this->url_forward($url_forward . '&per_page=' . $offset);

        // 列表数据
        $list = $this->model->lists('*', $where, 'update_time DESC', $this->per_page, $offset);
        foreach($list as &$item)
        {
            $item['update_time']=date('Y-m-d',$item['update_time']);
            $img_url=config_item('img_url').$item['down_url'];
            $item['img_url']=$img_url;
        }
        $data['list'] = $list;
        $this->load->view('admin/'.$this->list_view, $data);
    }
    /*
     * 获取图片列表
     */
    public function image_lists()
    {
        $where = "type='$this->material_type'";
        $keywords = trim($_REQUEST['keywords']);
        if ($keywords) {
            $keywords = $this->db->escape_like_str($keywords);
            $where .= " AND name like '%{$keywords}%' ";
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
        $list = $this->model->lists('name,media_id,url,down_url', $where, 'update_time DESC', $this->per_page, $offset);
        foreach($list as &$item)
        {
            $img_url=config_item('img_url').$item['down_url'];
            $item['img_url']=$img_url;
        }
        $data=array(
            'data'=>$list,
            'total'=>$count,
        );
        response_msg(0,'success',$data);
    }
    public function delete()
    {
        $media_id = $this->input->post('media_id');
        $this->model->delete(array('media_id'=>$media_id));
        $wechat=new WechatAuth($this->app_id,$this->app_secret);
        $token=$wechat->getAccessToken();
        $url="https://api.weixin.qq.com/cgi-bin/material/del_material?access_token=$token->access_token";
        $data=json_encode(array(
            "media_id"=>$media_id
        ));
        $result=https_post($url,$data);
        response_msg($result['errcode'],$result['errmsg']);
    }
    public function refresh()
    {
        set_time_limit(0);
        $materialcount=$this->get_materialcount();
        $image_count=$materialcount->image_count;
        $wechat=new WechatAuth($this->app_id,$this->app_secret);
        $token=$wechat->getAccessToken();
        $url="https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=$token->access_token";
        $data=json_encode(array(
           "type"=>$this->material_type,
           "offset"=>0,
           "count"=>$image_count
        ));
        $result=https_post($url,$data);
        $result_item=$result['item'];
        if($result_item)
        {
            foreach($result_item as $item)
            {
                $row=$this->model->row(array('media_id'=>$item['media_id']));
                if($row && $row['update_time']==$item['update_time']){
                    continue;
                }
                elseif($row)
                {
                    $this->model->update(array('media_id'=>$item['media_id'],'name'=>$item['name'],'update_time'=>$item['update_time'],'url'=>$item['url']),array('media_id'=>$item['media_id']));
                    continue;
                }
                //下载图片
                $file_path='uploads/material/images/'.$item['media_id'];
                $info= downloadImage($item['url'],$file_path);
                $filename='uploads/material/images/'.$info['filename'];
                $item['down_url']=$filename;
                $item['type']=$this->material_type;
                $this->model->insert($item);
            }
            response_msg(0,'更新成功!');
        }
        response_msg($result['errcode'],$result['errmsg']);
    }
    public function get_materialcount()
    {
        $wechat=new WechatAuth($this->app_id,$this->app_secret);
        $token=$wechat->getAccessToken();
        $url="https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token=$token->access_token";
        $result=httpGet($url);
        return json_decode($result);
    }
}
