<?php
/**
 * Created by cbymz.
 * User: Administrator
 * Date: 2016-11-01
 * Time: 9:58
 */
include_once (APPPATH.'libraries/WechatAuth.php');
require_once (APPPATH."libraries/JsSdk.php");
class Base extends CI_Controller
{
    public $title;
    public $baseurl;
    public $img_url;
    public $openid;
    public $app_id;
    public $app_secret;
    public function __construct()
    {
        parent::__construct();
        $this->title = '慈悲圆满洲';
        $this->baseurl='index.php?c=base';
        $this->app_id=get_admin_config('app_id');
        $this->app_secret=get_admin_config('app_secret');
        if ( ! session_id() ) @ session_start();
        $this->img_url=$this->config->item('img_url');
    }
    /*
     * 获取分享信息
     */
    public function get_share($url='')
    {
        $url=$url==''?site_url('rxysh/index'):$url;
        $jssdk=new JsSdk($this->app_id,$this->app_secret);
        $signPackage = $jssdk->GetSignPackage();
        $img_url=$this->img_url.'static/images/qrcode_for_gh_9139243f5ec7_258.jpg';
        $news = array("Title" =>"慈悲圆满洲", "Description"=>"愿智慧光明普照十方世界，一切众生证见诸法实相，获得究竟菩提果！", "PicUrl" =>$img_url, "Url" =>$url);
        $data['signPackage']=$signPackage;
        $data['news']=$news;
        return $data;
    }
    public function get_code()
    {
        $scope=$this->input->get('scope_type')?trim($this->input->get('scope_type')):'snsapi_base';
        $redirect_url=rawurlencode($this->input->get('redirect_url'));
        $wechat=new WechatAuth($this->app_id,$this->app_secret);
        $code_url=$wechat->getRequestCodeURL(site_url('base/get_access_token?redirect_url='.$redirect_url),'123',$scope);
        redirect($code_url);
    }
    public function get_access_token()
    {
        $code=$this->input->get('code');
        $redirect_url=$this->input->get('redirect_url');
        if($code) {
            $wechat = new WechatAuth($this->app_id, $this->app_secret);
            $access_token = $wechat->getAccessToken('code', $code);
            if(isset($access_token['errcode']))
            {
                $url=site_url('base/get_code?redirect_url='.$redirect_url);
                redirect($url);
            }else{
                $this->get_user_info($access_token,$redirect_url);
            }
        }
    }
    public function get_user_info($access_token,$redirect_url)
    {
        $this->load->model('admin/user_model');
        $openid=$access_token['openid'];
        $scope=$access_token['scope'];
        $user_row=$this->user_model->row(array('openid'=>$openid));//调用user控制器，检查用户是否存在
        if(!$user_row && $scope=='snsapi_base')
        {
            $redirect_url=site_url("base/get_code?scope_type=snsapi_userinfo&redirect_url=$redirect_url");
            redirect($redirect_url);
        }
        else
        {
            $wechat = new WechatAuth($this->app_id, $this->app_secret);
            $user_info=$wechat->getUserInfo($access_token);
            //保存用户信息
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
            if(!isset($user_info['subscribe'])) {
                unset($data['subscribe']);
            }
            //如果已存在，则做更新信息处理
            if($user_row) {
                $result=$this->user_model->update($data,array('openid'=>$openid));
            } else{
                $result=$this->user_model->insert($data);//调用user控制器保存用户信息
            }
            $session_data=array(
                'openid'=>$access_token['openid']
            );
            $_SESSION['user_info']=$session_data;
            redirect($redirect_url);
        }
    }
    /*
     * 退出登录
     */
    public function login_out()
    {
        $this->session->set_userdata('user_info',null);
        redirect(site_url('qfxz/index/'));
    }
    /*
     * 发送模板消息
     */
    public function template_send($order_info)
    {
        if(!$order_info)return false;
        $openid=$order_info['buyer_openid'];
        $wechat=new WechatAuth($this->app_id,$this->app_secret);
        $wechat->getAccessToken();
        $send_data=array(
            'touser'=>$openid,
            'template_id'=>'E8aqRSCyQxAaAwBYMQcK3ZyJtIAKIqYkgFwFu05CDTc',
            'topcolor'=>'#FF0000',
            'data'=>array(
                'first'=>array(
                    'value'=>'随喜您的功德！祝福您吉祥、如意、圆满！若有任何功德，全部回向给尽虚空遍法界一切众生，愿一切众生皆获得暂时安乐并究竟成佛！',
                    "color"=>"#173177",
                ),
                "orderMoneySum"=>array(
                    "value"=>($order_info['order_total_price']/100).'元',
                    "color"=>"#173177"
                ),
                "orderProductName"=>array(
                    "value"=>$order_info['product_name'],
                    "color"=>"#173177"
                ),
                "Remark"=>array(
                    "value"=>'一善念起 百念花开',
                    "color"=>"#173177"
                )
            ),
        );
        $result=$wechat->template($send_data);
        if($result['errcode']!=0){
            $this->add_error($result['errcode'],$result['errmsg'],site_url('base/template_send'));
        }
        return $result;
    }
    /*
     * 发送回向文
     */
    public function service_send($openid,$back_paper)
    {
        set_time_limit(0);
        $result=array('errcode'=>1,'errmsg'=>'openid不能为空！');
        if($openid=='')return $result;
        $this->load->model('admin/back_paper_item_model');
        $wechat=new WechatAuth($this->app_id,$this->app_secret);
        $wechat->getAccessToken();
        switch($back_paper['msgtype'])
        {
            case 'text':
                $result=$wechat->sendText($openid,$back_paper['content']);
                break;
            case 'image':
                $result=$wechat->sendImage($openid,$back_paper['media_id']);
                break;
            case 'voice':
                $result=$wechat->sendVoice($openid,$back_paper['media_id']);
                break;
            case 'video':
                $result=$wechat->sendVideo($openid,$back_paper['media_id'],$back_paper['title'],$back_paper['description']);
                break;
            case 'music':
                $result=$wechat->sendMusic($openid,$back_paper['title'],$back_paper['description'],$back_paper['musicurl'],$back_paper['hqmusicurl'],$back_paper['thumb_media_id']);
                break;
            case 'news':
                $back_paper_item=$this->back_paper_item_model->lists('*',array('back_paper_id'=>$back_paper['id']),'id ASC');
                $news_data=array();
                foreach ($back_paper_item as $item) {
                    $news_data[] =array(
                        'title'=>$item['title'],
                        'description'=>$item['description'],
                        'url'=>$item['url'],
                        'picurl'=>$this->img_url.$item['picurl'],
                    );
                }
                if($news_data){
                    $result=$wechat->messageCustomSend($openid,$news_data,'news');
                }
                break;
            case 'mpnews':
                $result=$wechat->sendNewsOnce($openid,$back_paper['media_id']);
                break;
        }
        if($result['errcode']!=0){
            $this->add_error($result['errcode'],$result['errmsg'],site_url('base/service_send'));
        }
        return $result;
    }
    /*
     * 写入邮件，通知义工
     */
    public function save_message($order_info,$product)
    {
        $this->load->model('admin/volunteer_product_model');
        $this->load->model('admin/message_model');
        $product_id=$order_info['product_id'];
        if($product['send_msg']==1)
        {
            $list=$this->volunteer_product_model->lists('*',array('product_id'=>$product_id),'id DESC',100,0);
            foreach($list as $item)
            {
                $message=$this->message_model->row(array('order_id'=>$order_info['id'],'volunteer_id'=>$item['volunteer_id']));
                if($message)
                {
                    continue;
                }
                $content="项目名称：<b style=\"color:red;\">$order_info[product_name]</b>
                            <br>功德主名字：<b style=\"color:red;\">$order_info[receiver_name]</b>
                            <br>联系电话：<b style=\"color:red;\">$order_info[receiver_mobile]</b>
                            <br>联系邮箱：<b style=\"color:red;\">$order_info[receiver_email]</b>";
                if($order_info['content']!='')
                {
                    $content.="<br>功德主所求愿望：<b style=\"color:red;\">$order_info[content]</b>";
                }
                if($order_info['other_name']!='')
                {
                    $content.="<br>其他信息：<b style=\"color:red;\">$order_info[other_name]</b>";
                }
                $content.="<br>下单时间：<b style=\"color:red;\">".date('Y年m月d日 H:i:s',strtotime($order_info['add_time']))."</b>";
                $data=array(
                    'title'=>$order_info['product_name'],
                    'volunteer_id'=>$item['volunteer_id'],
                    'order_id'=>$order_info['id'],
                    'content'=>$content,
                    'add_time'=>t_time(),
                );
                $this->message_model->insert($data);
            }
        }
    }
    /*
     * 记录错误信息
     * @param int $errcode 代号
     * @param string $errmsg 错误标题
     * @param string $content 内容
     */
    public function add_error($errcode,$errmsg,$content)
    {
        $this->load->model('admin/Sys_error_model');
        $data=array(
            'errcode'=>$errcode,
            'errmsg'=>$errmsg,
            'content'=>$content,
            'add_time'=>t_time(),
            'operate_ip'=>ip()
        );
        $this->sys_error_model->insert($data);
    }
}