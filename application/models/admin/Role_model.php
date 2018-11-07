<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/**
 * 角色
 */
include_once 'Base_model.php';

class Role_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'weixin_role';
    }

    /**
     *  格式化列表
     *
     * @return array 一维数组
     */
    function list_format()
    {
        $result = [];
        $list = $this->lists_sql("SELECT * FROM {$this->table} LIMIT 1000");
        foreach ($list as $row) {
            $result[$row['id']] = $row['title'];
        }
        return $result;
    }


}
