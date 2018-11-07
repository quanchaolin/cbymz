<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * 微信账单
 */
include_once 'Content.php';
class Bill extends Content
{
    public $order_status=array(
        0=>'待付款',
        1=>'已付款',
        2=>'付款失败'
    );
    function __construct()
    {
        $this->name = '微信账单';
        $this->control = 'bill';
        $this->list_view = 'bill_list'; // 列表页
        $this->add_view = 'bill_add'; // 添加页
        parent::__construct();
        $this->baseurl = site_url('admin/bill/');
        $this->load->model('admin/bill_model', 'model');
    }
    // 首页
    public function index(){
        $url_forward = $this->baseurl . 'index?';
        // 查询条件
        $where = '';
        $start_date=trim($this->input->get_post('start_date'));
        if($start_date)
        {
            $data['start_date']=$start_date;
            $url_forward.="&start_date=".rawurlencode($start_date);
            $start_date=$this->db->escape_like_str($start_date);
            $where.=" AND a.trade_time>='$start_date'";
        }
        $end_date=trim($this->input->get_post('end_date'));
        if($end_date)
        {
            $data['end_date']=$end_date;
            $url_forward.="&end_date=".rawurlencode($end_date);
            $end_date=$this->db->escape_like_str($end_date);
            $where.=" AND a.trade_time<='$end_date'";
        }
        $status=$this->input->get_post('status');
        $data['status']=$status;
        if($status!='' && $status!='all')
        {
            $url_forward.="&status=".rawurlencode($status);
            $status=$this->db->escape_like_str($status);
            $where.=" AND b.status=$status";
        }

        // URL及分页
        $offset = intval($_GET['per_page']);
        $data['count'] = $this->model->get_count($where);
        $data['pages'] = $this->page_html($url_forward, $data['count']);
        $this->url_forward($url_forward . '&per_page=' . $offset);

        // 列表数据
        $list = $this->model->get_lists($where, 'a.trade_time DESC', $this->per_page, $offset);
        foreach($list as &$item)
        {
            $item['order_total_price']=$item['order_total_price']/100;
            $status_text=$this->order_status[$item['status']];
            $item['status_text']=$status_text;
            $item['product_price']=$item['product_price']/100;
        }
        $data['list'] = $list;
        $this->load->view('admin/'.$this->list_view, $data);
    }

    /**
     *  数据导入
     * @param string $file excel文件
     * @param string $sheet
     * @return string   返回解析数据
     * @throws PHPExcel_Exception
     * @throws PHPExcel_Reader_Exception
     */
    public function importExecl(){
        $file=$this->input->post('filename');
        if($file=='')
        {
            response_msg(1,'请选择文件！');
        }
        $sheet=0;
        $file = iconv("utf-8", "gb2312", $file);   //转码
        if(empty($file) OR !file_exists($file)) {
            die('file not exists!');
        }

        $objRead = new PHPExcel_Reader_Excel2007();   //建立reader对象
        if(!$objRead->canRead($file)){
            $objRead = new PHPExcel_Reader_Excel5();
            if(!$objRead->canRead($file)){
                die('No Excel!');
            }
        }
        $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');

        $obj = $objRead->load($file);  //建立excel对象
        $currSheet = $obj->getSheet($sheet);   //获取指定的sheet表
        $columnH = $currSheet->getHighestColumn();   //取得最大的列号
        $columnCnt = array_search($columnH, $cellName);
        $rowCnt = $currSheet->getHighestRow();   //获取总行数

        $data = array();
        for($_row=6; $_row<=$rowCnt; $_row++){  //读取内容
            for($_column=0; $_column<=$columnCnt; $_column++){
                $cellId = $cellName[$_column].$_row;
                $cellValue = $currSheet->getCell($cellId)->getValue();
                //$cellValue = $currSheet->getCell($cellId)->getCalculatedValue();  #获取公式计算的值
                if($cellValue instanceof PHPExcel_RichText){   //富文本转换字符串
                    $cellValue = $cellValue->__toString();
                }
                if($cellName[$_column]=='A')
                {
                    $cellValue=excelTime($cellValue);
                }
                $cellValue=str_replace('`','',$cellValue);
                $cellValue=trim($cellValue);

                $data[$_row][$cellName[$_column]] = $cellValue;
            }
        }
        foreach($data as $item)
        {
            $insert_data=array(
                'trade_time'=>$item['A'],
                'transaction_id'=>$item['B'],
                'out_trade_no'=>$item['C'],
                'openid'=>$item['H'],
                'trade_type'=>$item['I'],
                'total_fee'=>$item['L'],
                'trade_status'=>$item['J'],
                'add_time'=>t_time(),
            );
            $this->model->insert($insert_data);
        }
        response_msg(0,'success');
    }
}
