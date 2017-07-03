<?php

   $tungay          = strtotime($_GET["tungay"]);
   $denngay         = strtotime($_GET["denngay"]);
   $nhanvien_id     = $_GET["nhanvien_id"];

?>

<?php
   if($tungay>$denngay)
   {
     echo "<h3 style='text-align:left'>Vui lòng chọn số lại ngày (từ ngày <b>".$_GET["tungay"]."</b> đến ngày <b>".$_GET["denngay"]."). Dữ liệu không phù hợp</h3>";
   }else
   {
     include("rad_log_nhanvienxh.php");
   }

?>