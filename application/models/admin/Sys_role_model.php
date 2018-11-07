<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

/**
 * 系统角色表 模型
 */
include_once 'Base_model.php';

class Sys_role_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'sys_role';
    }
}
