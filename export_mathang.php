<?php

/** Error reporting */
error_reporting(0);
session_start();
if(empty($_SESSION["user_login"])) {
        session_unregister("user_login");
		echo "<script>window.location.href='login.php'</script>";
        exit;
}


include str_replace('\\','/',dirname(__FILE__)).'/class/class.DEFINE.php';
include str_replace('\\','/',dirname(__FILE__)).'/class/class.HTML.php';
include str_replace('\\','/',dirname(__FILE__)).'/class/class.JAVASCRIPT.php';
include str_replace('\\','/',dirname(__FILE__)).'/class/class.UTILITIES.php';
include str_replace('\\','/',dirname(__FILE__)).'/class/class.CSS.php';
include str_replace('\\','/',dirname(__FILE__)).'/class/class.SINGLETON_MODEL.php';
include str_replace('\\','/',dirname(__FILE__)).'/class/simple_html_dom.php';
include str_replace('\\','/',dirname(__FILE__)).'/class/class.BUSINESSLOGIC.php';
include str_replace('\\','/',dirname(__FILE__)).'/class/template.php';
include str_replace('\\','/',dirname(__FILE__)).'/Cache_Lite/Lite/Function.php';
$dbf = new BUSINESSLOGIC();


/** Include PHPExcel */
require_once 'PHPExcel/Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Thuy TQ")
							 ->setLastModifiedBy("Thuy TQ")
							 ->setTitle("Office 2007 XLSX Mathang List")
							 ->setSubject("Office 2007 XLSX Mathang List")
							 ->setDescription("Mathang List for Office 2007 XLSX.")
							 ->setKeywords("")
							 ->setCategory("");


// Add some data
$objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'STT')
                    ->setCellValue('B1', 'Mã Số')
		            ->setCellValue('C1', 'Tên hàng')
		            ->setCellValue('D1', 'Nhóm Hàng')
                    ->setCellValue('E1', 'Đơn Vị')
                    ->setCellValue('F1', 'Đơn giá gốc')
                    ->setCellValue('G1', 'Triết khấu')
                    ->setCellValue('H1', 'Giá bán')
                    ->setCellValue('I1', 'Tồn kho')

                    ;

        $sheet = $objPHPExcel->getActiveSheet();
        $row = 2;
        $rst_mathang=$dbf->getDynamic("mathang","1=1","id asc");
        if($dbf->totalRows($rst_mathang)>0)
        {
        $array_ponser = array();
        while($mathang= $dbf->nextdata($rst_mathang))
        {
            $type_id = $mathang['type_id'];
			$title_nhomcha = "";
			if($type_id)
			{
			  $infoParent = $dbf->getInfoColum('mathang_category',$type_id);
              $title_nhomcha = 	$infoParent["title"];
			}

            $sheet->setCellValue('A' . $row, $row-1);
			$sheet->setCellValue('B' . $row, stripcslashes($mathang['item_code']));
			$sheet->setCellValue('C' . $row, stripcslashes($mathang['item_name']));
            $sheet->setCellValue('D' . $row, stripcslashes($title_nhomcha));
            $sheet->setCellValue('E' . $row, stripcslashes($mathang['unit']));
            $sheet->setCellValue('F' . $row, stripcslashes($mathang['price_goc']));
            $sheet->setCellValue('G' . $row, stripcslashes($mathang['price_trietkhau']));
            $sheet->setCellValue('H' . $row, stripcslashes($mathang['price']));
            $sheet->setCellValue('I' . $row, stripcslashes($mathang['quantity']));
			$row++;
		}
        }

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('mathang List');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
$file_name = 'MathangList_' . date('YmdHis') .'.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$file_name.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>