<?php
date_default_timezone_set('Asia/Bangkok');
if(isset($_GET["rad_name"]))
{
   //$tungay_array    =explode("-",$_GET["tungay"]);
   //$tungay_curent   = $tungay_array[2].'-'.$tungay_array[1].'-'.$tungay_array[0];
   $tungay          = strtotime($_GET["tungay"]);
   $denngay         = strtotime($_GET["denngay"]);

   $khachhang_id    = $_GET["khachhang_id"];
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
            include("rad_khachang_name1.php");
            break;
      case 2 :
            include("rad_khachang_name2.php");
            break;
      case 3 :
            include("rad_khachang_name3.php");
            break;

      case 4 :
            include("rad_khachang_name4.php");
            break;

      case 5 :
            include("rad_khachang_name5.php");
            break;

       case 6 :
            include("rad_khachang_name6.php");
            break;

      default :
            include("rad_khachang_name7.php");
   }

 }
 }
 ?>