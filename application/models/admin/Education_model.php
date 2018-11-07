<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/**
 * 教育背景
 */
include_once 'Base_model.php';

class Education_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'weixin_education';
    }
}
