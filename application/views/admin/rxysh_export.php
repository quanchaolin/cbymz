<?php
/** Error reporting */
error_reporting(E_ALL);
/** PHPExcel */
$date=date('Y-m-d');
include_once FCPATH.'vendor/phpoffice/phpexcel/Classes/PHPExcel.php';

/** PHPExcel_Writer_Excel2003用于创建xls文件 */
include_once FCPATH.'vendor/phpoffice/phpexcel/Classes/PHPExcel/Writer/Excel5.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// 设置属性
$objPHPExcel->getProperties()->setCreator('日行一善心愿单');
$objPHPExcel->getProperties()->setLastModifiedBy('日行一善心愿单');
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

/*转换编码格式
function convertUTF8($str)
{
    if(empty($str)) return '';
    return  iconv("UTF-8","gb2312",$str);
}*/

// 往单元格里添加数据
$objPHPExcel->setActiveSheetIndex(0);

$num=count($list);
//设置行高度
for($i=1;$i<=$num+2;$i++){
    $objPHPExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(20);
}
//设置每个H、I单元格水平右对齐，
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('H1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('I1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


//设置列宽度
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);

//设置字体样式
$objPHPExcel->getActiveSheet()->SetCellValue('A1', '用户昵称');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', '项目名称');
$objPHPExcel->getActiveSheet()->SetCellValue('C1','功德主名字');
$objPHPExcel->getActiveSheet()->SetCellValue('D1','联系电话');
$objPHPExcel->getActiveSheet()->SetCellValue('E1','供灯会供');
$objPHPExcel->getActiveSheet()->SetCellValue('F1','放生护生');
$objPHPExcel->getActiveSheet()->SetCellValue('G1','供养僧人');
$objPHPExcel->getActiveSheet()->SetCellValue('H1','助印经书');
$objPHPExcel->getActiveSheet()->SetCellValue('I1','总金额');
$objPHPExcel->getActiveSheet()->SetCellValue('J1','时间');


foreach($list as $key=>$value):
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.($key+2),$value['buyer_nick']);
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.($key+2),$value['product_name']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.($key+2),$value['receiver_name']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.($key+2),$value['receiver_mobile']);
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.($key+2),$value['packet_type'][1]);
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.($key+2),$value['packet_type'][2]);
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.($key+2),$value['packet_type'][3]);
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.($key+2),$value['packet_type'][4]);
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.($key+2),$value['order_total_price']);
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.($key+2),$value['add_time']);

endforeach;

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('日行一善心愿单');

// Save Excel 2007 file
//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
$objWriter->save(str_replace('.php', '.xls', __FILE__));
header("Pragma: public");
header("Expires: 0");
header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
header("Content-Type:application/force-download");
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");

header("Content-Type:application/octet-stream");
header("Content-Type:application/download");
header("Content-Disposition:attachment;filename=日行一善心愿单$date.xls");
header("Content-Transfer-Encoding:binary");

$objWriter->save("php://output");


