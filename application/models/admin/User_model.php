<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

/**
 * 用户管理
 */
include_once 'Base_model.php';

class User_model extends Base_model
{

    function __construct()
    {
        parent::__construct();

        $this->table = 'weixin_user';
    }
}
