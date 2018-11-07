<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

/**
 * 消息管理
 */
include_once 'Base_model.php';

class Message_model extends Base_model
{

    function __construct()
    {
        parent::__construct();

        $this->table = 'weixin_message';
    }
}
