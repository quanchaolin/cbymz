<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/**
 * 用户笔记
 */
include_once 'Base_model.php';

class Note_model extends Base_model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'weixin_note';
    }
}