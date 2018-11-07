<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

/**
 * 数据库备份 模型
 */
include_once 'Base_model.php';

class Sys_databases_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'sys_databases';
    }
}
