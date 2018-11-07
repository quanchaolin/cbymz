<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include 'Base.php';
include_once (APPPATH.'libraries/WechatAuth.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Message extends Base
{
    public $table;

    public function __construct()
    {
        parent::__construct();
        $this->baseurl = site_url('message/');
        $this->load->model('admin/message_model', 'model');
        $this->load->model('admin/volunteer_model');
        $this->load->model('admin/error_model');
    }

    /*
     * 主页
     */
    public function index()
    {
        $sign='qclwel888';
        $get_sign=trim($this->input->get('sign'));
        if($sign!=$get_sign)
        {
            $error_data=array(
                'errcode'=>'500',
                'errmsg'=>'认证错误！',
                'content'=>site_url('message/index'),
                'add_time'=>t_time()
            );
            $this->error_model->insert($error_data);
            response_msg(1,'认证错误！');
        }
        $where="status!=-1 AND send_email=0";
        $list=$this->model->lists('*',$where,'id ASC',1,0);
        foreach($list as $item)
        {
            $this->send_email($item);
        }
    }
    /*
     * 早晚课
     */
    public function push_mpnews()
    {
        set_time_limit(0);
        $this->load->model('admin/user_model');
        $this->load->model('admin/push_model');
        $this->load->model('admin/push_item_model');
        $this->load->model('admin/push_record_model');

        $sign='qclwel888';
        $get_sign=trim($this->input->get('sign'));
        $id=intval($this->input->get('id'));
        if($sign!=$get_sign)
        {
            $error_data=array(
                'errcode'=>'500',
                'errmsg'=>'认证错误！',
                'content'=>site_url('message/push_mpnews'),
                'add_time'=>t_time()
            );
            $this->error_model->insert($error_data);
            response_msg(1,'认证错误！');
        }
        $row=$this->push_model->row(array('id'=>$id,'status'=>1));
        if(!$row) {
            response_msg(2,'数据不存在！');
        }
        $list=$this->user_model->lists('openid',array('subscribe'=>1),'subscribe_time ASC',10000,0);
        $total=0;
        $total_success=0;
        $wechat=new WechatAuth($this->app_id,$this->app_secret);
        $wechat->getAccessToken();
        foreach($list as $val){
            $openid=$val['openid'];
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
                    $back_paper_item=$this->push_item_model->lists('*',array('push_id'=>$row['id']),'id ASC');
                    $news_data=array();
                    foreach ($back_paper_item as $item) {
                        $picurl=$item['picurl'];
                        if(!preg_match("/http:/i",$item['picurl']) && !preg_match("/https:/i",$item['picurl'])){
                            $picurl=$this->img_url.$item['picurl'];
                        }
                        $news_data[] =array(
                            'title'=>$item['title'],
                            'description'=>$item['description'],
                            'url'=>$item['url'],
                            'picurl'=>$picurl
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
        $this->push_record_model->insert($insert_data);
        response_msg($result['errcode'],$result['errmsg']);
    }
    /*
     * 邮件发送处理
     * @param array $value 配置值
     */
    private function send_email($value)
    {
        if($value['send_email']==1)
        {
            return false;
        }
        $this->model->update(array('send_email'=>1,'update_time'=>t_time()),array('id'=>$value['id']));
        $user=$this->volunteer_model->row(array('id'=>$value['volunteer_id']));
        $value['email']=$user['email'];
        $value['username']=$user['name'];
        $result=$this->_email($value);
        if($result) {
            return true;
        }
        else {
            $this->model->update(array('send_email'=>2,'update_time'=>t_time()),array('id'=>$value['id']));
            return false;

        }
    }
    private function _email($value)
    {
        $username=get_admin_config('email_username');
        $password=get_admin_config('email_password');
        $host=get_admin_config('email_host');
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $host;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $username;                 // SMTP username
            $mail->Password = $password;                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            //$mail->Port = 465;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom($username, '慈悲圆满洲');
            $mail->addAddress(trim($value['email']), $value['username']);     // Add a recipient
            /*$mail->addReplyTo('2450718148@qq.com', 'manager');
            $mail->addCC('2450718148@qq.com');
            $mail->addBCC('bcc@example.com');*/

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $value['title'];
            $mail->Body    = $value['content'];
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $status=$mail->send();
            if ($status)
            {
                //echo 'Message has been sent';
                return true;
            }
            else{
                $error_data=array(
                    'openid'=>$value['email'],
                    'order_id'=>'',
                    'errcode'=>'100',
                    'errmsg'=>'邮箱发送失败！',
                    'content'=>$mail->ErrorInfo,
                    'add_time'=>t_time()
                );
                $this->error_model->insert($error_data);
            }
        } catch (Exception $e) {
            $error_data=array(
                'openid'=>$value['email'],
                'order_id'=>'',
                'errcode'=>'100',
                'errmsg'=>'邮箱发送失败！',
                'content'=>$mail->ErrorInfo,
                'add_time'=>t_time()
            );
            $this->error_model->insert($error_data);
            echo 'Message could not be sent.';
        }
    }
}