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
							 ->setTitle("Office 2007 XLSX Nhomhang List")
							 ->setSubject("Office 2007 XLSX Nhomhang List")
							 ->setDescription("Nhomhang List for Office 2007 XLSX.")
							 ->setKeywords("")
							 ->setCategory("");


// Add some data
$objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'STT')
                    ->setCellValue('B1', 'Nhóm cha')
		            ->setCellValue('C1', 'Tên nhóm')
                    ;

        $sheet = $objPHPExcel->getActiveSheet();
        $row = 2;
        $rst_mathang=$dbf->getDynamic("mathang_category","1=1","id asc");
        if($dbf->totalRows($rst_mathang)>0)
        {
        $array_ponser = array();
        while($mathang= $dbf->nextdata($rst_mathang))
        {
			$parentid = $mathang['parentid'];
			$title_nhomcha = "";
			if($parentid)
			{
			  $infoParent = $dbf->getInfoColum('mathang_category',$parentid);
              $title_nhomcha = 	$infoParent["title"];		  
			}	
			
			$sheet->setCellValue('A' . $row, $row-1);
			$sheet->setCellValue('B' . $row, stripcslashes($title_nhomcha));
			$sheet->setCellValue('C' . $row, stripcslashes($mathang['title']));       
			$row++;
		}
        }

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Nhomhang List');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
$file_name = 'NhomhangList_' . date('YmdHis') .'.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$file_name.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>