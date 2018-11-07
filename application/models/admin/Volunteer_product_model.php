<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

/**
 * 义工项目管理
 */
include_once 'Base_model.php';

class Volunteer_product_model extends Base_model
{

    function __construct()
    {
        parent::__construct();

        $this->table = 'weixin_volunteer_product';
    }
}
