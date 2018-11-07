<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

/**
 * 微信支付管理
 */
include_once 'Base_model.php';

class Wxpay_back_model extends Base_model
{

    function __construct()
    {
        parent::__construct();

        $this->table = 'weixin_wxpay_back';
    }
}
