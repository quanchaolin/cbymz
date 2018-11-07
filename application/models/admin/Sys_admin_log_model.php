<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

/**
 * admin 访问日志 后台日志
 */
include_once 'Base_model.php';

class Sys_admin_log_model extends Base_model
{

    function __construct()
    {
        parent::__construct();

        $this->table = 'sys_admin_log';
    }

    // 保存访问记录
    public function logs()
    {
        $data = array(
            'user_id' => intval($_SESSION['admin']['id']),
            'url' => uri_string(),
            'user_agent' => $this->agent->platform() . '/' . $this->agent->browser() . $this->agent->version(),
            'add_time' => t_time(),
            'ip' => $this->input->ip_address(),
        );
        return $this->insert($data);
    }


}
