<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/**
 * 角色
 */
include_once 'Base_model.php';

class Admin_privilege_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'weixin_privilege';
    }

    

}
