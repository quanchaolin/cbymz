<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

/**
 * 系统管理员与角色关系对应表 模型
 */
include_once 'Base_model.php';

class Sys_role_user_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'sys_role_user';
    }
}
