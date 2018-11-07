<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

/**
 * 模型 基类，其他模型需要先继承本类
 */
class Base_model extends CI_Model
{
    public $table = ''; // 数据库表名称

    function __construct()
    {
        parent::__construct();
    }

    // 设置数据库表
    function set_table($table)
    {
        $this->table = $table;
    }

    // ====================================
    /**
     * 获取一条记录
     *
     * @return array 一维数组
     */
    function row($where = array())
    {
        return $this->table_row($this->table, $where);
    }

    /**
     * 获取一条记录,指定表名
     *
     * @return array 一维数组
     */
    function table_row($table, $where = array())
    {
        if (is_numeric($where)) {
            $this->db->where('id', $where);
        } else {
            $this->db->where($where);
        }
        $query = $this->db->get($table, 1);
        return $query->row_array();
    }

    /**
     * 获取一条记录
     *
     * @param string sql
     * @return array 一维数组
     */
    function row_sql($sql)
    {
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    /**
     * 获取多条记录
     *
     * @return array 二维数组
     */
    function lists($field = '*', $where = array(), $order = 'id DESC', $limit = 20, $offset = 0)
    {
        return $this->table_lists($this->table, $field, $where, $order, $limit, $offset);
    }

    /**
     * 获取多条记录，指定表名
     *
     * @return array 二维数组
     */
    function table_lists($table, $field = '*', $where = array(), $order = 'id DESC', $limit = 20, $offset = 0)
    {
        $query = $this->db->select($field)->from($table)->where($where)->order_by($order)->limit($limit, $offset)->get();
        return $query->result_array();
    }

    /**
     * 获取多条记录
     *
     * @return array 二维数组
     */
    function lists_sql($sql)
    {
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    /**
     *  查询记录总数
     *
     * @param string $where
     * @return int
     */
    function count($where = array())
    {
        return $this->table_count($this->table, $where);
    }

    /**
     *  查询记录总数
     *
     * @param string $where
     * @return int
     */
    function count_sql($sql, $data)
    {
        $query = $this->db->query($sql, $data);
        $row = $query->row_array();
        if (isset($row)) {
            return $row['total'];
        } else {
            return 0;
        }
    }

    /**
     *  查询记录总数, 指定表名
     *
     * @param string $where
     * @return int
     */
    function table_count($table, $where = array())
    {
        $this->db->where($where);
        $this->db->from($table);
        return $this->db->count_all_results();
    }

    /**
     * 插入一条记录
     *
     * @param array $data
     * @return int
     */
    function insert($data)
    {
        return $this->table_insert($this->table, $data);
    }

    /**
     * 插入一条记录, 指定表名
     *
     * @param array $data
     * @return int
     */
    function table_insert($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    /**
     * 更新一条记录
     *
     * @return int
     */
    function update($data, $where = array())
    {
        return $this->table_update($this->table, $data, $where);
    }

    /**
     * 更新一条记录, 指定表名
     *
     * @return int
     */
    function table_update($table, $data, $where = array())
    {
        if (is_numeric($where)) {
            $this->db->where('id', $where);
        } else {
            $this->db->where($where);
        }
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    /**
     * 删除一条或多条记录
     *
     * @param mix $where 整数或者数组 3,array(3,4,5), array('catid'=>1)
     * @return int
     */
    function delete($where = array())
    {
        return $this->table_delete($this->table, $where);
    }

    /**
     * 删除一条或多条记录
     *
     * @param mix $where 整数或者数组 3,array(3,4,5), array('catid'=>1)
     * @return int
     */
    function table_delete($table, $where = array())
    {
        if (is_array($where)) {
            if (isset($where[0])) { // 根据id删除多条
                $id_str = implode(",", $where);
                $this->db->query("delete from $table where id in ($id_str)");
            } else { // 根据条件删除多条
                $this->db->where($where);
                $this->db->delete($table);
            }
        } else { // 根据id删除单条
            $this->db->where('id', $where);
            $this->db->delete($table);
        }
        return $this->db->affected_rows();
    }

// =============================================

    /**
     * 更新访问量
     *
     * @param int $id
     * @return array 二维数组
     */
    function update_visit($id)
    {
        $this->db->set('visit', 'visit+1', FALSE);
        $this->db->where('id', $id);
        $this->db->update($this->table);
        return $this->db->affected_rows();
    }

    /**
     * 修改审核状态
     *
     * @param int $status
     * @param int $id
     * @return array int
     */
    function update_status($status, $id)
    {
        return $this->update(array('status' => $status), $id);
    }

}
