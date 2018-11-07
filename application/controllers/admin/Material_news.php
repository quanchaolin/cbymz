<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 素材管理（图文）
 */
include_once 'Content.php';
class Material_news extends Content
{
    public $material_type='news';
    function __construct()
    {
        $this->name = '图文管理';
        $this->control = 'material_news';
        $this->list_view = 'material_news_list'; // 列表页
        $this->add_view = 'material_news_add'; // 添加页
        parent::__construct();
        $this->baseurl = site_url('admin/material_news/');
        $this->load->model('admin/material_model', 'model');
        $this->load->model('admin/material_item_model');
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

            $news_item=$this->material_item_model->lists('media_id',"title like '%{$keywords}%'",'sort ASC');
            $media_id='';
            foreach($news_item as $key=>$row)
            {
                if($key>=1)
                {
                    $media_id.=',';
                }
                $media_id.='"'.$row['media_id'].'"';
            }
            if($media_id!='')
            {
                $where.=" AND media_id in($media_id)";
            }
        }

        // URL及分页
        $offset = intval($_GET['per_page']);
        $data['count'] = $this->model->count($where);
        $data['pages'] = $this->page_html($url_forward, $data['count']);
        $this->url_forward($url_forward . '&per_page=' . $offset);

        // 列表数据
        $list = $this->model->lists('*', $where, 'create_time DESC', $this->per_page, $offset);
        foreach($list as &$item)
        {
            $item['update_time']=date('Y-m-d',$item['update_time']);
            $news_item=$this->material_item_model->lists('thumb_media_id,title,url,thumb_url',array('media_id'=>$item['media_id']),'sort ASC');
            $item['news_item']=$news_item;
            $item['news_item_count']=count($news_item);
            $first_item=$this->model->row(array('media_id'=>$news_item[0]['thumb_media_id']));
            $item['thumb_url']=config_item('img_url').$first_item['down_url'];
        }
        $data['list'] = $list;
        $this->load->view('admin/'.$this->list_view, $data);
    }
    /*
     * 获取图片列表
     */
    public function news_lists()
    {
        $where = "type='$this->material_type'";
        $keywords = trim($_REQUEST['keywords']);
        if ($keywords) {
            $keywords = $this->db->escape_like_str($keywords);
            $news_item=$this->material_item_model->lists('media_id',"title like '%{$keywords}%'",'sort ASC');
            $media_id='';
            foreach($news_item as $key=>$row)
            {
                if($key>=1)
                {
                    $media_id.=',';
                }
                $media_id.='"'.$row['media_id'].'"';
            }
            if($media_id!='')
            {
                $where.=" AND media_id in($media_id)";
            }
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
        $list = $this->model->lists('media_id,update_time', $where, 'create_time DESC', $this->per_page, $offset);
        foreach($list as &$item)
        {
            $news_item=$this->material_item_model->lists('thumb_media_id,title,url,thumb_url',array('media_id'=>$item['media_id']),'sort ASC');
            $item['news_item']=$news_item;
            $item['news_item_count']=count($news_item);
            $item['name']=$news_item[0]['title'];
            $first_item=$this->model->row(array('media_id'=>$news_item[0]['thumb_media_id']));
            $item['thumb_url']=config_item('img_url').$first_item['down_url'];
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
        $data='{
                "media_id":"'.$media_id.'"
            }';
        $result=https_post($url,$data);
        response_msg($result['errcode'],$result['errmsg']);
    }

    public function refresh()
    {
        set_time_limit(0);
        $materialcount=$this->get_materialcount();
        $news_count=$materialcount->news_count;
        $wechat=new WechatAuth($this->app_id,$this->app_secret);
        $token=$wechat->getAccessToken();
        $url="https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=$token->access_token";
        $data=json_encode(array(
           "type"=>$this->material_type,
           "offset"=>0,
           "count"=>$news_count
        ));
        $result=https_post($url,$data);
        $result_item=$result['item'];
        if($result_item)
        {
            foreach($result_item as $item)
            {
                $media_id=$item['media_id'];
                $row=$this->model->row(array('media_id'=>$media_id));
                if($row && $row['update_time']==$item['update_time']){
                    continue;
                }
                elseif($row)
                {
                    $this->model->update(array('update_time'=>$item['content']['update_time'],'create_time'=>$item['content']['create_time']),array('media_id'=>$media_id));
                    $this->material_item_model->delete(array('media_id'=>$media_id));
                }
                else{
                    $insert_data['type']=$this->material_type;
                    $insert_data['media_id']=$media_id;
                    $insert_data['create_time']=$item['content']['create_time'];
                    $insert_data['update_time']=$item['content']['update_time'];
                    $this->model->insert($insert_data);
                }
                $sort=1;
                foreach($item['content']['news_item'] as $material_item)
                {
                    $material_item['sort']=$sort;
                    $material_item['media_id']=$media_id;
                    $this->material_item_model->insert($material_item);
                    $sort++;
                }
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
    public function get_material()
    {
        $wechat=new WechatAuth($this->app_id,$this->app_secret);
        $token=$wechat->getAccessToken();
        $url="https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=$token->access_token";
        $result=https_post($url,array('media_id'=>'6k554OcxvhmoGhBQ1Kop0cpKyGIARHWyeBKioO6hu9Y'));
        dump($result);
    }
}
