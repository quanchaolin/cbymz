<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

/**
 * 公众号菜单
 */
include_once 'Base_model.php';

class Mp_menu_text_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'weixin_mp_menu_text';
    }
}
