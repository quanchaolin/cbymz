<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by cbymz.
 * User: 2450718148@qq.com
 * Date: 2018/5/26
 * Time: 17:25
 */
class Upgrade extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $this->load->view('upgrade');
    }
}