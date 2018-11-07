<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

/**
 * 每日一善红包类型管理
 */
include_once 'Base_model.php';

class Packet_type_model extends Base_model
{

    function __construct()
    {
        parent::__construct();

        $this->table = 'weixin_packet_type';
    }
}
