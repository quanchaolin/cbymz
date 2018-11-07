<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//error_reporting(E_ERROR);
include_once('Common.php');
class Rxysh extends Common
{
    public $id=1;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/order_model');
        $this->load->model('admin/product_model');
        $this->baseurl = site_url('rxysh/');
    }
    public function index()
    {
        $list=$this->order_model->lists('buyer_nick,buyer_openid,order_total_price,add_time',array('status'=>1,'product_id'=>$this->id),'id DESC',100,0);
        foreach($list as &$item)
        {
            $item['order_total_price']=$item['order_total_price']/100;
            $buyer_nick=$item['buyer_nick'];
            $item['add_time']=date('Y年m月d日',strtotime($item['add_time']));
            if(mb_strlen($buyer_nick,'utf8')==2) {
                $item['buyer_nick']= $this->cut_str($buyer_nick, 1, 0).'**';
            }
            else {
                $item['buyer_nick']= $this->cut_str($buyer_nick, 1, 0).'**'.$this->cut_str($buyer_nick, 1, -1);
            }
        }
        //最近订单
        $order=$this->order_model->row_lately(array('buyer_openid'=>$this->openid,'product_id'=>1));
        //商品信息
        $value=$this->product_model->row(array('id'=>$this->id));
        //分享的信息
        $share_data=$this->get_share($this->baseurl.'index');
        $data['signPackage']=$share_data['signPackage'];
        $data['news']=$share_data['news'];

        $data['list']=$list;
        $data['openid']=$this->openid;
        $data['value']=$value;
        $data['order']=$order;
        $this->load->view('rxysh',$data);
    }

    //将用户名进行处理，中间用星号表示
    private function cut_str($string, $sublen, $start = 0, $code = 'UTF-8')
    {
        if($code == 'UTF-8') {
            $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
            preg_match_all($pa, $string, $t_string);
            if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen));
            return join('', array_slice($t_string[0], $start, $sublen));
        }
        else {
            $start = $start*2;
            $sublen = $sublen*2;
            $strlen = strlen($string);
            $tmpstr = '';
            for($i=0; $i< $strlen; $i++)
            {
                if($i>=$start && $i< ($start+$sublen))
                {
                    if(ord(substr($string, $i, 1))>129)
                    {
                        $tmpstr.= substr($string, $i, 2);
                    }
                    else
                    {
                        $tmpstr.= substr($string, $i, 1);
                    }
                }
                if(ord(substr($string, $i, 1))>129) $i++;
            }
            //if(strlen($tmpstr)< $strlen ) $tmpstr.= "...";
            return $tmpstr;
        }
    }
}