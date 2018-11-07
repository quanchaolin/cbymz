<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

/**
 * 权限节点表 模型
 */
include_once 'Base_model.php';

class Sys_acl_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'sys_acl';
    }
}
