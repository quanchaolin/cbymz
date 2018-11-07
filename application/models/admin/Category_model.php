<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

/**
 * 商品分类 模型
 */
include_once 'Base_model.php';

class Category_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'weixin_category';
    }
}
