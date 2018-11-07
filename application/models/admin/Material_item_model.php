<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

/**
 * 素材管理
 */
include_once 'Base_model.php';

class Material_item_model extends Base_model
{

    function __construct()
    {
        parent::__construct();

        $this->table = 'weixin_material_item';
    }
}
