<?php

/**
 * 常用函数，通用函数
 */

/**
 * 显示信息
 *
 * @param string $message
 *            内容
 * @param string $url_forward
 *            跳转的网址
 * @param string $title
 *            标题
 * @param int $second
 *            停留的时间
 * @return
 *
 *
 *

 */

function show_msg($message, $url_forward = '', $title = '提示信息', $second = 3)
{
    include(APPPATH . 'views/admin/show_msg.php');
    exit();
}

/**
 * 取得文件扩展 不包括 点
 *
 * @param $filename 文件名
 * @return 扩展名
 */

function fileext($filename)

{

    // 获得文件扩展名

    $temp_arr = explode(".", $filename);

    $file_ext = array_pop($temp_arr);

    $file_ext = trim($file_ext);

    $file_ext = strtolower($file_ext);


    return $file_ext;

}

/**
 * 获取请求ip
 *
 * @return ip地址
 */

function ip()

{

    if (getenv('HTTP_CLIENT_IP') &&

        strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')

    ) {

        $ip = getenv('HTTP_CLIENT_IP');

    } elseif (getenv('HTTP_X_FORWARDED_FOR') &&

        strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')

    ) {

        $ip = getenv('HTTP_X_FORWARDED_FOR');

    } elseif (getenv('REMOTE_ADDR') &&

        strcasecmp(getenv('REMOTE_ADDR'), 'unknown')

    ) {

        $ip = getenv('REMOTE_ADDR');

    } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] &&

        strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')

    ) {

        $ip = $_SERVER['REMOTE_ADDR'];

    }

    return preg_match('/[\d\.]{7,15}/', $ip, $matches) ? $matches[0] : '';

}


/**
 * 写入缓存
 * $name 文件名
 * $data 数据数组
 *
 * @return ip地址
 */

function set_cache($name, $data)

{


    // 检查目录写权限

    if (@is_writable(APPPATH . 'cache/') === false) {

        return false;

    }

    file_put_contents(APPPATH . 'cache/' . $name . '.php',

        '<?php return ' . var_export($data, TRUE) . ';');

    return true;

}


/**
 * 获取缓存
 * $name 文件名
 *
 * @return array
 */

function get_cache($name)

{

    $ret = array();

    $filename = APPPATH . 'cache/' . $name . '.php';

    if (file_exists($filename)) {

        $ret = include $filename;

    }


    return $ret;

}


/**
 * 对数据执行 trim 去左右两边空格
 * mixed $data 数组或者字符串
 *
 * @return mixed
 */

function trims($data)

{

    if (is_array($data)) {

        foreach ($data as &$r) {

            $r = trims($r);

        }

    } else {

        $data = trim($data);

    }


    return $data;

}


/**
 * 时间处理
 */

function times($time, $type = 0)

{

    if ($type == 0) {

        return date('Y-m-d', $time);

    } else {

        return date('Y-m-d H:i:s', $time);

    }

}

/**
 * 后去加密后的 字符
 *
 * @param
 *            string
 * @return string
 */

function get_password($password)
{
    return md5('ddgfdgd5454_' . $password);
}

/**
 * 将数组转换为字符串
 *
 * @param array $data
 * @param bool $isformdata
 * @return string
 *

 */

function array2string($data, $isformdata = 1)

{

    if ($data == '')

        return '';

    if ($isformdata)

        $data = new_stripslashes($data);

    return (var_export($data, TRUE)); // addslashes

}

// 获取下拉框 选项信息

function getSelect($data, $value = '', $type = 'key')

{

    $str = '';

    foreach ($data as $k => $v) {

        if ($type == 'key') {

            $seled = ($value == $k && $value) ? 'selected="selected"' : '';

            $str .= "<option value=\"{$k}\" {$seled}>{$v}</option>";

        } else {

            $seled = ($value == $v && $value) ? 'selected="selected"' : '';

            $str .= "<option value=\"{$v}\" {$seled}>{$v}</option>";

        }

    }

    return $str;

}


// 显示友好的时间格式

function timeFromNow($dateline)

{

    if (empty($dateline)) return false;

    $seconds = time() - $dateline;

    if ($seconds < 60) {

        return "1分钟前";

    } elseif ($seconds < 3600) {

        return floor($seconds / 60) . "分钟前";

    } elseif ($seconds < 24 * 3600) {

        return floor($seconds / 3600) . "小时前";

    } elseif ($seconds < 48 * 3600) {

        return date("昨天 H:i", $dateline) . "";

    } else {

        return date('m-d', $dateline);

    }

}

/**
 * 格式化 时间处理
 */
function t_time($time = 0, $type = 1)
{
    if ($time == 0) $time = time();
    if ($type == 0) {
        return date('Y-m-d', $time);  //0
    } else if ($type == 1) {
        return date('Y-m-d H:i:s', $time); //1
    } else if ($type == 2) {
        return date('Y年m月d日', $time); //2
    }
}

/**
 *  计算两个日期间隔的天数
 */
function diffBetweenTwoDays ($day1, $day2)
{
    $second1 = strtotime($day1);
    $second2 = strtotime($day2);
    if ($second1 < $second2) {
        $tmp = $second2;
        $second2 = $second1;
        $second1 = $tmp;
    }
    return ceil(($second1 - $second2)/86400);
}

// 统一格式，输出 json
function t_json($data = array(), $code = 0, $msg = 'ok')
{
    $result = array(
        'code' => strval($code),
        'msg' => $msg,
        'time' => t_time(),
        'data' => $data,
    );
    if (isset($_GET['dump'])) {
        dump($result);
        return;
    }
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
    exit;
}

// 统一格式，输出 json
function t_error($code = 1, $msg = 'error message', $data = array())
{
    return t_json($data, $code, $msg);
}


//检查邮箱是否有效

function isemail($email)

{

    return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);

}


//根据IP定位 获取城市

function getCityCode()

{

    $temp = json_decode(file_get_contents('http://api.map.baidu.com/location/ip?ak=EFb35215c1d4b7b98a89a896ac91c025&coor=bd09ll'));


    return $temp->content->address_detail->city_code;

}


// 异步执行

// async_request('192.168.1.223','/web/test2.php?a=onNzZjt7c1wLTcdpp-HBnaLQKbwI');

function async_request($host, $file, $method = 'get')
{


    $fp = fsockopen($host, 80, $errno, $errstr, 30);

    if (!$fp) {

        echo "$errstr ($errno)<br />\n";

    } else {

        $out = "GET $file / HTTP/1.1\r\n";

        $out .= "Host: www.example.com\r\n";
        $out .= "Connection: Close\r\n\r\n";
        fwrite($fp, $out);
        /*忽略执行结果
         while (!feof($fp)) {
        echo fgets($fp, 128);
        }*/
        fclose($fp);
    }
}


function dump($var, $vardump = true)
{
    print "<pre>";
    ($vardump) ? (print_r($var)) : (var_dump($var));
    print "</pre>";
}

/**
 * 获取一个随机字符串MD5格式
 *
 * @param
 *
 * @return string
 */
function t_rand_str($str='')
{
    return md5($str.microtime() . 'fdsfsdfs567' . rand());
}

/**
 * uniqid - 官方是这样说的：
 * Gets a prefixed unique identifier based on the current time in microseconds.
 */
function build_order_no()
{
    return date('YmdHis').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}
/*
 * 检查时间
 * $start_time开始时间
 * $end_time 结束时间
 */
function check_time($start_time,$end_time)
{
    $today=strtotime(date('Y-m-d'));
    $start=strtotime($start_time);
    $end=strtotime($end_time);
    if($start_time=='0000-00-00 00:00:00' && $end_time=='0000-00-00 00:00:00')
    {
        return true;
    }
    elseif($start<=$today && $end>=$today)
    {
        return true;
    }
    return false;
}
/*
 * 构造返回信息
 * @param $data
 */
function response_msg($msg,$errmsg='',$list=array())
{
    $data=array();
    if(!is_array($msg))
    {
        $errcode=$msg;
        $msg=array(
            $errcode,
            $errmsg,
            $list
        );
    }
    list(
        $data['errcode'],
        $data['errmsg'],
        $data['data']
        )=$msg;
    echo json_encode($data);exit;
}
function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
}
/**
 * POST 请求
 * @param string $url
 */
function  https_post($url,$data=array())
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    if (curl_errno($curl)) {
        return 'Errno'.curl_error($curl);
    }
    curl_close($curl);
    return  json_decode($result,true);
}
/*
 * 获得当前的URL地址
 */
function cur_page_url() {
    $pageURL = 'http';
    if (!empty($_SERVER['HTTPS'])) {$pageURL .= "s";}
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}
/**
 * 是否是AJAx提交的
 * @return bool
 */
function isAjax(){
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
        return true;
    }else{
        return false;
    }
}
/*
 * @parse $config_name 配置值
 * 获取设置值
 */
function get_admin_config($config_name)
{
    $value='';
    $config=get_cache('admin_config');
    if(empty($config) || !isset($config_name[$config_name]))
    {
        $CI=&get_instance();
        $CI->load->model('admin/sys_admin_config_model');
        $config=$CI->sys_admin_config_model->row(array('status'=>1,'config_name'=>$config_name));
        $value=$config['value'];
    }
    else
    {
        $value=$config[$config_name];
    }
    return $value;
}
/*
 * excel时间转换
 */
function excelTime($date, $time = false)
{
    if (function_exists('GregorianToJD')) {
        if (is_numeric($date)) {
            $jd = GregorianToJD(1, 1, 1970);
            $gregorian = JDToGregorian($jd + intval($date) - 25569);
            $date = explode('/', $gregorian);
            $date_str = str_pad($date [2], 4, '0', STR_PAD_LEFT)
                . "-" . str_pad($date [0], 2, '0', STR_PAD_LEFT)
                . "-" . str_pad($date [1], 2, '0', STR_PAD_LEFT)
                . ($time ? " 00:00:00" : '');
            return $date_str;
        }
    } else {
        $date = $date > 25568 ? $date + 1 : 25569;
        /*There was a bug if Converting date before 1-1-1970 (tstamp 0)*/
        $ofs = (70 * 365 + 17 + 2) * 86400;
        $date = date("Y-m-d", ($date * 86400) - $ofs) . ($time ? " 00:00:00" : '');
    }
    return $date;
}
/**
 * 下载远程图片
 * @param string $url 图片的绝对url
 * @param string $filepath 文件的完整路径（包括目录，不包括后缀名,例如/www/images/test） ，此函数会自动根据图片url和http头信息确定图片的后缀名
 * @return mixed 下载成功返回一个描述图片信息的数组，下载失败则返回false
 */
function downloadImage($url, $filepath) {
    //服务器返回的头信息
    $responseHeaders = array();
    //原始图片名
    $originalfilename = '';
    //图片的后缀名
    $ext = '';
    $ch = curl_init($url);
    //设置curl_exec返回的值包含Http头
    curl_setopt($ch, CURLOPT_HEADER, 1);
    //设置curl_exec返回的值包含Http内容
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //设置抓取跳转（http 301，302）后的页面
    if (ini_get('open_basedir') == '' && ini_get('safe_mode' == 'Off')) {
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    }
    //设置最多的HTTP重定向的数量
    curl_setopt($ch, CURLOPT_MAXREDIRS, 2);

    //服务器返回的数据（包括http头信息和内容）
    $html = curl_exec($ch);
    //获取此次抓取的相关信息
    $httpinfo = curl_getinfo($ch);
    curl_close($ch);
    if ($html !== false) {
        //分离response的header和body，由于服务器可能使用了302跳转，所以此处需要将字符串分离为 2+跳转次数 个子串
        $httpArr = explode("\r\n\r\n", $html, 2 + $httpinfo['redirect_count']);
        //倒数第二段是服务器最后一次response的http头
        $header = $httpArr[count($httpArr) - 2];
        //倒数第一段是服务器最后一次response的内容
        $body = $httpArr[count($httpArr) - 1];
        $header.="\r\n";

        //获取最后一次response的header信息
        preg_match_all('/([a-z0-9-_]+):\s*([^\r\n]+)\r\n/i', $header, $matches);
        if (!empty($matches) && count($matches) == 3 && !empty($matches[1]) && !empty($matches[1])) {
            for ($i = 0; $i < count($matches[1]); $i++) {
                if (array_key_exists($i, $matches[2])) {
                    $responseHeaders[$matches[1][$i]] = $matches[2][$i];
                }
            }
        }
        //获取图片后缀名
        if (0 < preg_match('{(?:[^\/\\\\]+)\.(jpg|jpeg|gif|png|bmp)$}i', $url, $matches)) {
            $originalfilename = $matches[0];
            $ext = $matches[1];
        } else {
            if (array_key_exists('Content-Type', $responseHeaders)) {
                if (0 < preg_match('{image/(\w+)}i', $responseHeaders['Content-Type'], $extmatches)) {
                    $ext = $extmatches[1];
                }
            }
        }
        //保存文件
        if (!empty($ext)) {
            $filepath .= ".$ext";
            //如果目录不存在，则先要创建目录
            $local_file = fopen($filepath, 'w');
            if (false !== $local_file) {
                if (false !== fwrite($local_file, $body)) {
                    fclose($local_file);
                    $sizeinfo = getimagesize($filepath);
                    return array('filepath' => realpath($filepath), 'width' => $sizeinfo[0], 'height' => $sizeinfo[1], 'orginalfilename' => $originalfilename, 'filename' => pathinfo($filepath, PATHINFO_BASENAME));
                }
            }
        }
    }
    return false;
}








