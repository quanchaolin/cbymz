<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
// 自定义 全局变量 by qcl
$config['http_host']='http://'.$_SERVER['HTTP_HOST'].'/';
$config['img_url']='http://www.awakingall.cn/';
// 性别
$config['sex'] = array(0=>'未知',1 => '男性',2 => '女性');
// 数据表的 状态
$config['status'] = array(0 => '待审核', 1 => '正常',2=>'锁定');

$config['packet_type']=array(
    1=>'供灯会供',
    2=>'放生护生',
    3=>'供养僧人',
    4=>'助印经书'
);
$config['pay_type']=array(
    1=>'日行一善',
    2=>'般若增妙圣香',
    3=>'除垢圣泉熏香',
    4=>'祈福消灾',
    5=>'木雅佐钦大圆满吉祥金刚萨埵寺修缮',
    6=>'拉萨芒康吉日寺修缮',
    7=>'念经超度',
    8=>'供养荟供法会'
);
$config['msgtype']=array(
    'text'=>'文本消息',
    'image'=>'图片消息',
    'voice'=>'语音消息',
    'video'=>'视频消息',
    'music'=>'音乐消息',
    'news'=>'图文消息（点击跳转到外链）',
    'mpnews'=>'图文消息'
);
/* End of file config.php */
/* Location: ./application/config/config.php */
