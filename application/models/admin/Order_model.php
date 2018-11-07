<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

/**
 * 订单管理
 */
include_once 'Base_model.php';

class Order_model extends Base_model
{

    function __construct()
    {
        parent::__construct();

        $this->table = 'weixin_order';
    }
    public function row_lately($where)
    {
        $this->db->from($this->table);
        $this->db->where($where);
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        return $query->row_array();
    }
}
