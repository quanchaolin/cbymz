<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 数据库备份
 */
include_once 'Content.php';
include_once APPPATH.'libraries/Verify.php';
class Sys_databases extends Content
{
    function __construct()
    {
        $this->name = '数据库备份';
        $this->control = 'sys_databases';
        $this->list_view = 'sys_databases_list'; // 列表页
        $this->add_view = 'sys_databases_add'; // 添加页
        parent::__construct();
        $this->short_url='admin/sys_databases/';
        $this->baseurl = site_url('admin/sys_databases/');
        $this->load->model('admin/sys_databases_model', 'model');
        $this->load->dbutil();
    }

    // 首页
    public function index(){
        $url_forward = $this->baseurl . 'index?';
        // 查询条件
        $where = 'status!=-1 ';
        $keywords = trim($_REQUEST['keywords']);
        if ($keywords) {
            $data['keywords'] = $keywords;
            $url_forward .= "&keywords=" . rawurlencode($keywords);
            $keywords = $this->db->escape_like_str($keywords);

            $where .= " AND name like '%{$keywords}%' ";
        }

        // URL及分页
        $offset = intval($_GET['per_page']);
        $data['count'] = $this->model->count($where);
        $data['pages'] = $this->page_html($url_forward, $data['count']);
        $this->url_forward($url_forward . '&per_page=' . $offset);

        // 列表数据
        $list = $this->model->lists('*', $where, 'id DESC', $this->per_page, $offset);
        foreach($list as &$item)
        {
            $item['size']=$this->sizecount($item['size']);
        }
        $data['list'] = $list;
        $this->load->view('admin/'.$this->list_view, $data);
    }

    // 编辑
    public function edit()
    {
        $id = intval($this->input->post('id'));
        // 这条信息
        $value = $this->model->row($id);
        if(!$value)
        {
            echo json_encode(
                array(
                    'errcode'=>1,
                    'errmsg'=>'文件不存在！'
                )
            );exit;
        }
    }


    // 保存 添加和修改都是在这里
    public function save()
    {
        $id = intval($_POST['id']);
        $data = trims($_POST['value']);

        if (!Verify::isEmpty($data['name'])) {
            echo json_encode(
                array(
                    'errcode'=>1,
                    'errmsg'=>'文件名不能为空'
                )
            );exit;
        }
        $data['user_id'] = $this->uid;
        $data['update_time'] = t_time();
        $data['operator'] = $this->admin['username'];
        $data['operate_ip'] = ip();
        if ($id) { // 修改 ===========
            //检查是否重复
            $row=$this->model->row(array('name'=>$data['name'],'id !='=>$id));
            if($row)
            {
                echo json_encode(
                    array(
                        'errcode'=>2,
                        'errmsg'=>'文件名存在，请更换'
                    )
                );exit;
            }
            $this->model->update($data, $id);
            echo json_encode(
                array(
                    'errcode'=>0,
                    'errmsg'=>'修改成功!'
                )
            );exit;
        }
    }

    public function delete()
    {
        $id = $_GET['id'];
        $id_arr = $_POST['delete'];
        $data=array(
            'operator'=>$this->admin['username'],
            'operate_ip' => ip(),
            'update_time'=>t_time(),
            'status'=>'-1'
        );
        if (is_numeric($id)) {
            $this->model->update($data, $id);
        } elseif(is_array($id_arr)) {
            foreach($id_arr as $item)
            {
                $this->model->update($data, $item);
            }
        }
        show_msg('删除成功！', $this->admin['url_forward']);
    }
    /*
     * 数据库备份
     */
    public function backup()
    {
        $filename=date('YmdHis').'.zip';
        $save_path="data/".$filename;
        $prefs = array(
            'ignore'    => array(),         // List of tables to omit from the backup
            'format'    => 'zip',           // gzip, zip, txt
            'filename'  => 'sql.sql',      // File name - NEEDED ONLY WITH ZIP FILES
            'add_drop'  => TRUE,            // Whether to add DROP TABLE statements to backup file
            'add_insert'    => TRUE,            // Whether to add INSERT data to backup file
            'newline'   => "\n"             // Newline character used in backup file
        );
        // Backup your entire database and assign it to a variable
        $backup = $this->dbutil->backup($prefs);
        // Load the file helper and write the file to your server
        $this->load->helper('file');
        write_file($save_path, $backup);
        if(file_exists($save_path))
        {
            $size=filesize($save_path);
            $data=array(
                'save_name'=>$filename,
                'name'=>$filename,
                'save_path'=>$save_path,
                'type'=>'zip',
                'size'=>$size,
                'add_time'=>t_time(),
            );
            $this->model->insert($data);
            echo json_encode(
                array(
                    'errcode'=>0,
                    'errmsg'=>'数据库备份成功!'
                )
            );exit;
        }
        else
        {
            echo json_encode(
                array(
                    'errcode'=>1,
                    'errmsg'=>'数据库备份失败!'
                )
            );exit;
        }
    }
    /*
     * 下载
     */
    public function download()
    {
        $id=intval($this->input->get('id'));
        $row=$this->model->row(array('id'=>$id));
        if(!$row)
        {
            show_msg('数据不存在！');
        }
        //更新下载次数
        $this->model->update(array('downloads'=>$row['downloads']+1),array('id'=>$id));
        $this->load->helper('download');
        $save_path = $row['save_path'];
        if(!file_exists($save_path))
        {
            show_msg('文件不存在！');
        }
        force_download($save_path, NULL);
    }
    private function sizecount($filesize) {
        if($filesize >= 1073741824) {
            $filesize = round($filesize / 1073741824 * 100) / 100 . ' gb';
        } elseif($filesize >= 1048576) {
            $filesize = round($filesize / 1048576 * 100) / 100 . ' mb';
        } elseif($filesize >= 1024) {
            $filesize = round($filesize / 1024 * 100) / 100 . ' kb';
        } else {
            $filesize = $filesize . ' bytes';
        }
        return $filesize;
    }

}
