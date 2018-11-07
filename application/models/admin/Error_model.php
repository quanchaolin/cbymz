<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

/**
 * 错误信息 模型
 */
include_once 'Base_model.php';

class Error_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'weixin_error';
    }
}
