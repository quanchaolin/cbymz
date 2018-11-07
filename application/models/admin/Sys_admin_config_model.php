<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/**
 * 网站配置模型
 */
include_once 'Base_model.php';

class Sys_admin_config_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'sys_admin_config';
    }
}
