<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

/**
 * 回向文模型
 */
include_once 'Base_model.php';

class Back_paper_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'weixin_back_paper';
    }
}
