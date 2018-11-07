<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

/**
 * 商品分组管理
 */
include_once 'Base_model.php';

class Product_group_model extends Base_model
{

    function __construct()
    {
        parent::__construct();

        $this->table = 'weixin_product_group';
    }
}
