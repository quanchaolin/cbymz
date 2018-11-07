<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

/**
 * 部门表 模型
 */
include_once 'Base_model.php';

class sys_dept_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'sys_dept';
    }
}
