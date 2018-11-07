<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');
/**
 * Created by cbymz.
 * User: 2450718148@qq.com
 * Date: 2018/7/22
 * Time: 23:02
 */
include_once ('Base_model.php');
class Time_task_model extends Base_model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'weixin_timed_task';
    }
}