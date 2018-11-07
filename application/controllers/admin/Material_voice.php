<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 素材管理（语音）
 */
include_once 'Content.php';

class Material_voice extends Content
{
    public $type='voice';
    function __construct()
    {
        $this->name = '语音管理';
        $this->control = 'material_voice';
        $this->list_view = 'material_voice_list'; // 列表页
        $this->add_view = 'material_voice_add'; // 添加页
        parent::__construct();
        $this->baseurl = site_url('admin/material_voice/');
        $this->load->model('admin/material_model', 'model');
    }

    // 首页
    public function index(){
        $url_forward = $this->baseurl . 'index?';
        // 查询条件
        $where = "type='voice' ";
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
            break;
        }
        $data['list'] = $list;
        $this->load->view('admin/'.$this->list_view, $data);
    }
    /*
     * 获取图片列表
     */
    public function voice_lists()
    {
        $where = "type='voice'";
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
        $list = $this->model->lists('name,media_id,url', $where, 'update_time DESC', $this->per_page, $offset);
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
    public function get_voice()
    {
        $url_forward = $this->baseurl . 'get_voice?';
        // 查询条件
        $where = "type='voice' ";
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
        $data['list'] = $list;
        $this->load->view('admin/material_voice_page', $data);
    }
    public function delete()
    {
        $media_id = $this->input->post('media_id');
        $this->model->delete(array('media_id'=>$media_id));
        $access_token=TokenUtil::getToken();
        $url="https://api.weixin.qq.com/cgi-bin/material/del_material?access_token=$access_token";
        $data='{
                "media_id":"'.$media_id.'"
            }';
        $result=TokenUtil::https_post($url,$data);
        echo json_encode(
            array(
                'errcode'=>$result['errcode'],
                'errmsg'=>$result['errmsg']
            )
        );exit;
    }

    public function refresh()
    {
        set_time_limit(0);
        $materialcount=$this->get_materialcount();
        $voice_count=$materialcount['voice_count'];
        $access_token=TokenUtil::getToken();
        $url="https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=$access_token";
        $data='{
                   "type":"'.$this->type.'",
                   "offset":0,
                   "count":'.$voice_count.'
                }';
        $result=TokenUtil::https_post($url,$data);
        $result_item=$result['item'];
        if($result_item)
        {
            foreach($result['item'] as $item)
            {
                $row=$this->model->row(array('media_id'=>$item['media_id']));
                if($row)
                {
                    continue;
                }
                $item['type']=$this->type;
                $this->model->insert($item);
            }
            echo json_encode(
                array(
                    'errcode'=>0,
                    'errmsg'=>'更新成功'
                )
            );exit;
        }
        else {
            echo json_encode(
                array(
                    'errcode'=>$result['errcode'],
                    'errmsg'=>$result['errmsg']
                )
            );exit;
        }
    }
    public function get_materialcount()
    {
        $access_token=TokenUtil::getToken();
        $url="https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token=$access_token";
        $result=TokenUtil::https_post($url);
        return $result;
    }
    public function get_material($media_id)
    {
        $access_token=TokenUtil::getToken();
        $url="https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=$access_token";
        $data='{
                "media_id":"'.$media_id.'"
            }';
        $result=TokenUtil::https_post($url,$data);
        return $result;
    }
}
