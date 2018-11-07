<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 公众号菜单
 */
include_once 'Content.php';
include_once(APPPATH.'libraries/WechatAuth.php');
class Mp_menu extends Content
{
    public $app_id;
    public $app_secret;
    function __construct()
    {
        $this->name = '菜单管理';
        $this->control = 'mp_menu';
        $this->list_view = 'mp_menu_list'; // 列表页
        $this->add_view = 'mp_menu_add'; // 添加页
        parent::__construct();
        $this->baseurl = site_url('admin/mp_menu/');
        $this->load->model('admin/mp_menu_model', 'model');
        $this->load->model('admin/mp_menu_text_model');
        $this->app_id=get_admin_config('app_id');
        $this->app_secret=get_admin_config('app_secret');
    }
    public function get_menu()
    {
        $WechatAuth=new WechatAuth($this->app_id,$this->app_secret);
        $WechatAuth->getAccessToken();
        $info=$WechatAuth->menuGet();
        echo json_encode($info);
    }
    /*
     * 获取公众号配置的
     */
    public function get_current_menu()
    {
        $WechatAuth=new WechatAuth($this->app_id,$this->app_secret);
        $access_token=$WechatAuth->getAccessToken();
        $url="https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info?access_token=$access_token[access_token]";
        echo httpGet($url);
    }
    public function create_menu()
    {
        $button_list=$this->model->lists('id,type,name,url,key',array('parent_id'=>0,'status'=>1),'seq DESC');
        foreach($button_list as &$item)
        {
            $sub_list=$this->model->lists('type,name,url,key',array('parent_id'=>$item['id'],'status'=>1),'seq DESC');
            unset($item['id']);
            if($sub_list)
            {
                foreach($sub_list as $val)
                {
                    if($val['type']=='click'){
                        unset($val['url']);
                    }elseif($val['type']=='view'){
                        unset($val['key']);
                    }
                    unset($item['url']);
                    unset($item['key']);
                    unset($item['type']);
                    $item['sub_button'][]=$val;
                }
            }else{
                if($item['type']=='click'){
                    unset($item['url']);
                }elseif($item['type']=='view'){
                    unset($item['key']);
                }
            }
        }
        $WechatAuth=new WechatAuth($this->app_id,$this->app_secret);
        $WechatAuth->getAccessToken();
        $WechatAuth->getAccessToken();
        $info=$WechatAuth->menuCreate($button_list);
        dump($info);
    }
}
