<?php

if(isset($_GET["rad_name"]))
{
   //$tungay_array    =explode("-",$_GET["tungay"]);
   //$tungay_curent   = $tungay_array[2].'-'.$tungay_array[1].'-'.$tungay_array[0];
   $tungay          = strtotime($_GET["tungay"]);
   $denngay         = strtotime($_GET["denngay"]);
   $nhanvien_id     = $_GET["nhanvien_id"];
   $rad_name        = $_GET["rad_name"];
?>

<?php
   if($tungay>$denngay)
   {
     echo "<h3 style='text-align:left'>Vui lòng chọn số lại ngày (từ ngày <b>".$_GET["tungay"]."</b> đến ngày <b>".$_GET["denngay"]."). Dữ liệu không phù hợp</h3>";
   }else
   {


    switch ($rad_name) {
      case 1 :
            include("rad_nhanvienquay_name1.php");
            break;
      case 2 :
            include("rad_nhanvienquay_name2.php");   ;
            break;
      case 3 :
            include("rad_nhanvienquay_name3.php");   ;
            break;
      case 4 :
            include("rad_nhanvienquay_name4.php");   ;
            break;
      default :
            include("rad_nhanvienquay_name5.php");
   }

 }
 }
 ?>