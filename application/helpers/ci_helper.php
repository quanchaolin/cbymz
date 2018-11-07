<?php

/**
 * 本项目特有的函数，结合CI用的函数
 * by tangjian
 */


// 返回模型 API下
function model($model_name)
{
    $CI = &get_instance();
    $CI->load->model('api/' . $model_name);
    return $CI->{$model_name};
}


// 获取配置元素 ，配置必须是数组的
function config($config, $key)
{
    $CI = &get_instance();
    $array = $CI->config->item($config);
    return $array[$key];
}

// 去掉html符号， 除指定字段外
function html_escape_move($data, $move_arr = array())
{
    if ($move_arr) {
        foreach ($data as $key => &$value) {
            if (!in_array($key, $move_arr)) {
                $value = html_escape($value);
            }
        }
    }

    return $data;
}

// 获取配置元素 ，配置必须是数组的
function side_show($controller_name, $mothed='')
{
    $CI = &get_instance();
    if($mothed) {
        if($CI->uri->segment(2) == $controller_name && $CI->uri->segment(3) == $mothed) {
            return 'layui-this';
        } else {
            return '';
        }
    } else {
        return $CI->uri->segment(2) == $controller_name ? 'layui-this' : '';
    }

}

/**
 * 查询是否有权限
 * @param string 权限标识
 * @param string 权限类型 read、write、del
 * echo string
 */
function permission($priv_sign,$type)
{
    $ci = &get_instance();
    $res = false;
    // 超级管理 显示
    $admin = $ci->session->userdata('admin');
    if($admin['role_id'] != 1){
        // 查看是否有权限
        $ci->load->model('admin/role_model');
        $ci->load->model('admin/admin_privilege_model','priv_model');
        $result = $ci->role_model->row(array('id'=>$admin['role_id']));
        $priv = $ci->priv_model->row(array('priv_sign'=>$priv_sign));
        if(!empty($priv)){
            switch ($type) {
                case 'read':
                    $priv_read = explode(',', $result['priv_read']);
                    if(in_array($priv['id'], $priv_read)){
                        $res = true;
                    }
                    break;
                case 'write':
                    $priv_write = explode(',', $result['priv_write']);
                    if(in_array($priv['id'], $priv_write)){
                        $res = true;
                    }
                    break;
                case 'del':
                    $priv_del = explode(',', $result['priv_del']);
                    if(in_array($priv['id'], $priv_del)){
                        $res = true;
                    }
                    break;
            }
        }
    }else {
        $res = true;
    }


    return $res;
}


// 获取列表
function getCategoryChild($catid = 0)
{
    $CI = &get_instance();
    $CI->load->model('category_model');
    $list = $CI->category_model->get_child($catid);
    return $list;
}


// 获取列表

function getCategoryName($catid)
{
    $CI = &get_instance();
    $CI->load->model('category_model');
    $list = $CI->category_model->get_name($catid);
    return $list;
}

/**
* 格式化数组，id为key,name为value;
*
*/
function list_format($list)
{
    $result = [];
    foreach ($list as $row) {
        $result[$row['id']] = $row['name'];
    }
    return $result;
}
