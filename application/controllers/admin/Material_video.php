<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 素材管理（视频）
 */
include_once 'Content.php';

class Material_video extends Content
{
    public $type='video';
    function __construct()
    {
        $this->name = '视频管理';
        $this->control = 'material_video';
        $this->list_view = 'material_video_list'; // 列表页
        $this->add_view = 'material_video_add'; // 添加页
        parent::__construct();
        $this->baseurl = site_url('admin/material_video/');
        $this->load->model('admin/material_model', 'model');
    }

    // 首页
    public function index(){
        $url_forward = $this->baseurl . 'index?';
        // 查询条件
        $where = "type='video' ";
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
    public function video_lists()
    {
        $where = "type='video'";
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
        $list = $this->model->lists('name,media_id,description', $where, 'update_time DESC', $this->per_page, $offset);
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
    public function down()
    {
        $media_id = $this->input->post('media_id');
        $access_token=TokenUtil::getToken();
        $url="https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=$access_token";
        $data='{
                   "media_id":"'.$media_id.'"
                }';
        $result=TokenUtil::https_post($url,$data);dump($result);
    }
    public function delete()
    {
        if(!permission('SYS_Material_image','del')){
            echo json_encode(
                array(
                    'errcode'=>1,
                    'errmsg'=>'没有操作权限'
                )
            );exit;
        }
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
        $video_count=$materialcount['video_count'];
        $access_token=TokenUtil::getToken();
        $url="https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=$access_token";
        $data='{
                   "type":"'.$this->type.'",
                   "offset":0,
                   "count":'.$video_count.'
                }';
        $result=TokenUtil::https_post($url,$data);
        $result_item=$result['item'];
        if($result_item)
        {
            foreach($result_item as $item)
            {
                $row=$this->model->row(array('media_id'=>$item['media_id']));
                if(!$row)
                {
                    $item['type']=$this->type;
                    $material=$this->get_material($item['media_id']);
                    $item['title']=$material['title'];
                    $item['description']=$material['description'];
                    $item['down_url']=$material['down_url'];
                    $this->model->insert($item);
                }
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
