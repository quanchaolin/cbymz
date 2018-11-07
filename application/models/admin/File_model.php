<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

/*
 * 视频素材理模型
 * @author qcl 2016-05-03
 */
include_once 'Base_model.php';
class File_model extends Base_model
{
    /**
     *构造函数
     */
    function __construct()
    {
        parent::__construct();

        $this->table = 'wx_file';
    }
}
