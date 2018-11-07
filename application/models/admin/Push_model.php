<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

/**
 * 消息推送模型
 */
include_once 'Base_model.php';

class Push_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'weixin_push';
    }
}
