<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

/**
 * 角色与权限关系对应表 模型
 */
include_once 'Base_model.php';

class Sys_role_acl_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'sys_role_acl';
    }
}
