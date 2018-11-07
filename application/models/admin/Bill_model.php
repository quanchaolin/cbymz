<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

/**
 * 商品分类 模型
 */
include_once 'Base_model.php';

class Bill_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'weixin_bill';
    }
    /*
     * 返回总数目
     * @param string $where 条件
     */
    public function get_count($where='')
    {
        $order_table='weixin_order';
        if($where!=''){
            $where=" WHERE 1=1 $where";
        }
        $sql="SELECT a.* FROM $this->table AS a LEFT JOIN $order_table AS b ON a.out_trade_no=b.trans_id $where";
        $query=$this->db->query($sql);
        return $query->num_rows();
    }
    public function get_lists($where='',$order='a.trade_time DESC',$limit=20,$offset=0)
    {
        $order_table='weixin_order';
        if($where!=''){
            $where=" WHERE 1=1 $where";
        }
        $sql="SELECT a.*,b.* FROM $this->table AS a LEFT JOIN $order_table AS b ON a.out_trade_no=b.trans_id $where ORDER BY $order LIMIT $offset,$limit";
        $query=$this->db->query($sql);
        return $query->result_array();
    }
}
