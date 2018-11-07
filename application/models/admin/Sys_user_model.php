<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

/**
 * 系统管理员 模型
 */
include_once 'Base_model.php';

class Sys_user_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'sys_user';
    }
    // 更新登录次数和时间
    function update_logins($uid)
    {
        if (empty($uid)) return 0;

        $this->db->set('logins', 'logins+1', FALSE);
        $this->db->set('lastlog_time', t_time());
        $this->db->where('id', $uid);
        $this->db->update($this->table);

        return $this->db->affected_rows();
    }

    /**
     *  格式化列表
     *
     * @return array 一维数组
     */
    function list_format($field = '*')
    {
        $result = [];
        $list = $this->lists_sql("SELECT {$field} FROM {$this->table} LIMIT 1000");
        foreach ($list as $row) {
            $result[$row['id']] = $row;
        }
        return $result;
    }

    /**
     * 为列表附加上商品信息
     *
     * @return array 一维数组
     */
    function append_list($list)
    {
        $admin_list = $this->list_format();

        foreach ($list as &$value) {
            $value['username'] = $admin_list[$value['user_id']]['username'];
            $value['true_name'] = $admin_list[$value['user_id']]['true_name'];
        }

        return $list;
    }

    /**
     * 获取一条记录, 同时更新查看次数
     *
     * @return array 一维数组
     */
    function append_one($value)
    {
        $admin_list = $this->list_format();

        $value['username'] = $admin_list[$value['user_id']]['username'];
        $value['true_name'] = $admin_list[$value['user_id']]['true_name'];

        return $value;
    }
}
