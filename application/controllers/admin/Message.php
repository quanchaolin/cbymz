<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 消息管理
 */
include_once 'Content.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Message extends Content
{
    public $send_weixin=array(0=>'未发送',1=>'发送成功',2=>'发送失败');
    public $send_email=array(0=>'未发送',1=>'发送成功',2=>'发送失败');
    public $type;
    function __construct()
    {
        $this->name = '消息管理';
        $this->control = 'message';
        $this->list_view = 'message_list'; // 列表页
        $this->add_view = 'message_add'; // 添加页
        parent::__construct();
        $this->baseurl = site_url('admin/message/');
        $this->load->model('admin/message_model', 'model');
        $this->load->model('admin/volunteer_model');
        $this->load->model('admin/order_model');
        $this->type=trim($this->input->get('type'));
    }

    // 首页
    public function index(){
        $url_forward = $this->baseurl . 'index?';
        // 查询条件
        $where = 'status!=-1 ';
        //查阅判断
        $read_where=' AND read_flag=0';
        if($this->type=='read')
        {
            $read_where=' AND read_flag=1';
        }
        else if($this->type=='all')
        {
            $read_where=' AND (read_flag=0 OR read_flag=1)';
        }
        $where.=$read_where;
        if($this->admin['role_id']==3)
        {
            $volunteer_where=array('status'=>1,'user_id'=>$this->uid);
            $volunteer_count=$this->volunteer_model->count($volunteer_where);
            $volunteer_list=$this->volunteer_model->lists('id',$volunteer_where,'id DESC',$volunteer_count,0);
            $volunteer_str='';
            foreach($volunteer_list as $key=>$val)
            {
                if($key>1)
                {
                    $volunteer_str.=',';
                }
                $volunteer_str.=$val['id'];
            }
            if($volunteer_str!='')
            {
                $where.=" AND volunteer_id IN($volunteer_str)";
            }
        }
        $keywords = trim($_REQUEST['keywords']);
        if ($keywords) {
            $data['keywords'] = $keywords;
            $url_forward .= "&keywords=" . rawurlencode($keywords);
            $keywords = $this->db->escape_like_str($keywords);
            $where .= " AND title like '%{$keywords}%' ";
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
            $row=$this->volunteer_model->row(array('id'=>$item['volunteer_id']));
            $item['volunteer_name']=$row['name'];
            $item['send_weixin_str']=$this->send_weixin[$item['send_weixin']];
            $item['send_email_str']=$this->send_email[$item['send_email']];
        }
        $data['list'] = $list;
        $this->load->view('admin/'.$this->list_view, $data);
    }

    // 添加
    public function add()
    {
        $count= $this->volunteer_model->count(array('status='=>1));
        $data['volunteer'] = $this->volunteer_model->lists('id,name',array('status='=>1),'id DESC',$count,0);
        $this->load->view('admin/'.$this->add_view, $data);
    }

    // 编辑
    public function edit()
    {
        $id = $_GET['id'];
        // 这条信息
        $value = $this->model->row($id);
        $data['value'] = $value;
        $count= $this->volunteer_model->count(array('status='=>1));
        $data['volunteer'] = $this->volunteer_model->lists('id,name',array('status='=>1),'id DESC',$count,0);

        $this->load->view('admin/' . $this->add_view, $data);
    }

    // 保存 添加和修改都是在这里
    public function save()
    {
        $id = intval($_POST['id']);
        $data = trims($_POST['value']);

        if ($data['title']=='') {
            response_msg(1,'标题不能为空！');
        }
        if ($data['volunteer_id']=='') {
            response_msg(2,'义工姓名不能为空！');
        }
        $data['update_time'] = t_time();
        $data['operator']=$this->admin['username'];
        $data['operate_ip']=ip();
        if ($id) { // 修改 ===========
            $data['update_time'] = t_time();
            $this->model->update($data, $id);
            response_msg(0,'修改成功!');
        } else { // ===========添加 ===========
            $data['add_time'] = t_time();
            $this->model->insert($data);
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
    public function detail()
    {
        $id = $_GET['id'];
        // 这条信息
        $where='status=1 AND id='.$id;
        $pre_where="status=1 AND id<$id";
        $next_where="status=1 AND id>$id";
        if($this->admin['role_id']==3)
        {
            $volunteer_where=array('status'=>1,'user_id'=>$this->uid);
            $volunteer_list=$this->volunteer_model->lists('id',$volunteer_where);
            $volunteer_str='';
            foreach($volunteer_list as $key=>$val)
            {
                if($key>1)
                {
                    $volunteer_str.=',';
                }
                $volunteer_str.=$val['id'];
            }
            if($volunteer_str!='')
            {
                $where.=" AND volunteer_id IN($volunteer_str)";
                $pre_where.=" AND volunteer_id IN($volunteer_str)";
                $next_where.=" AND volunteer_id IN($volunteer_str)";
            }
        }
        $value=$this->model->row($where);
        if(!$value)
        {
            show_msg('消息不存在，请检查！');
        }
        $pre_value=$this->model->row($pre_where);
        $next_value=$this->model->row($next_where);
        $update_data=array(
            'read_flag'=>1,
            'read_time'=>t_time(),
            'update_time'=>t_time(),
        );
        $this->model->update($update_data,$id);
        $data['value'] = $value;
        $data['pre_value'] = $pre_value;
        $data['next_value'] = $next_value;
        $this->load->view('admin/message_detail', $data);
    }
    public function batch_delete()
    {
        $list = $_POST['list'];
        if(!$list)
        {
            response_msg(1,'错误操作！');
        }
        $data=array('update_time'=>t_time(),'status'=>'-1')  ;

        foreach($list as $item)
        {
            $this->model->update($data, $item);
        }
        response_msg(0,'删除成功!');
    }
    public function batch_read()
    {
        $list = $_POST['list'];
        if(!$list)
        {
            response_msg(1,'错误操作！');
        }
        $data=array('update_time'=>t_time(),'read_time'=>t_time(),'read_flag'=>'1')  ;

        foreach($list as $item)
        {
            $this->model->update($data, $item);
        }
        response_msg(0,'success');
    }
    /*
     * 异步获取数据
     */
    public function ajax_list()
    {
        $where = "status=1 AND read_flag=0";
        if($this->admin['role_id']==3)
        {
            $volunteer_where=array('status'=>1,'user_id'=>$this->uid);
            $volunteer_count=$this->volunteer_model->count($volunteer_where);
            $volunteer_list=$this->volunteer_model->lists('id',$volunteer_where,'id DESC',$volunteer_count,0);
            $volunteer_str='';
            foreach($volunteer_list as $key=>$val)
            {
                if($key>1)
                {
                    $volunteer_str.=',';
                }
                $volunteer_str.=$val['id'];
            }
            if($volunteer_str!='')
            {
                $where.=" AND volunteer_id IN($volunteer_str)";
            }
        }
        $count = $this->model->count($where);
        $list = $this->model->lists('id,title,add_time', $where, 'id DESC', 10, 0);
        foreach($list as &$item)
        {
            $item['add_time']=timeFromNow(strtotime($item['add_time']));
        }
        $data['count']=$count;
        $data['list'] = $list;
        echo json_encode(
            array(
                'errcode'=>0,
                'errmsg'=>'success',
                'data'=>$data
            )
        );exit;
    }
    public function send_weixin()
    {
        $id=intval($this->input->post('id'));
        $value=$this->model->row(array('id'=>$id));
        if(!$value)
        {
            response_msg(1,'消息不存在!');
        }
        //义工信息
        $user=$this->volunteer_model->row(array('id'=>$value['volunteer_id']));
        $openid=$user['openid'];
        if($openid=='')
        {
            response_msg(2,'义工openid不存在!');
        }
        //订单信息
        $order=$this->order_model->row(array('id'=>$value['order_id']));
        $product_price=$order['order_total_price']/100;
        $content="功德主名字:$order[receiver_name]；联系电话:$order[receiver_mobile];联系邮箱:$order[receiver_email];功德主所求愿望:$order[content];其他信息:$order[other_name];";
        $access_token=TokenUtil::getToken();
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$access_token";
        $data='   {
           "touser":"'.$openid.'",
           "template_id":"nC7Lwg1PQI3AhbWywKQEnUNVp10YsVG1YEshnVNqa2w",
           "data":{
                   "first": {
                       "value":"用户心愿单下单通知！",
                       "color":"#173177"
                   },
                   "keyword1":{
                       "value":"慈悲圆满洲",
                       "color":"#173177"
                   },
                   "keyword2": {
                       "value":"'.$order['product_name'].'",
                       "color":"#173177"
                   },
                   "keyword3": {
                       "value":"'.$value['add_time'].'",
                       "color":"#173177"
                   },
                   "keyword4": {
                       "value":"'.$product_price.'元",
                       "color":"#173177"
                   },
                   "keyword5": {
                       "value":"付款成功",
                       "color":"#173177"
                   },
                   "remark":{
                       "value":"'.$content.'",
                       "color":"#173177"
                   }
           }
       }';
        $result=TokenUtil::https_post($url,$data);
        if($result['errcode']==0)
        {
            $this->model->update(array('send_weixin'=>1),array('id'=>$id));
        }
        else
        {
            $this->model->update(array('send_weixin'=>0),array('id'=>$id));
        }
        echo json_encode(
        array(
                'errcode'=>$result['errcode'],
                'errmsg'=>$result['errmsg']
            )
        );exit;
    }
    public function send_email()
    {
        $id=intval($this->input->post('id'));
        $value=$this->model->row(array('id'=>$id));
        if(!$value)
        {
            response_msg(1,'消息不存在!');
        }
        $user=$this->volunteer_model->row(array('id'=>$value['volunteer_id']));
        $value['email']=$user['email'];
        $value['username']=$user['name'];
        $result=$this->_email($value);
        if($result)
        {
            $this->model->update(array('send_email'=>1),array('id'=>$id));
            response_msg(0,'邮箱发送成功!');
        }
        else
        {
            $this->model->update(array('send_email'=>0),array('id'=>$id));
            response_msg(2,'邮箱发送失败!');
        }
    }
    public function _email($value=array())
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
            $mail->addReplyTo('2450718148@qq.com', 'manager');
            $mail->addCC('2450718148@qq.com');
            $mail->addBCC('bcc@example.com');

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
                echo $mail->ErrorInfo;exit;
            }
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }
}
