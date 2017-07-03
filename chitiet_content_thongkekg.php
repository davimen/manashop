<?php

if(isset($_GET["tungay"]))
{
   //$tungay_array    =explode("-",$_GET["tungay"]);
   //$tungay_curent   = $tungay_array[2].'-'.$tungay_array[1].'-'.$tungay_array[0];
   $tungay          = strtotime($_GET["tungay"]);
   $denngay         = strtotime($_GET["denngay"]);
   $khogiay_id    = $_GET["khogiay_id"];

?>

<?php
   if($tungay>$denngay)
   {
     echo "<h3 style='text-align:left'>Vui lòng chọn số lại ngày (từ ngày <b>".$_GET["tungay"]."</b> đến ngày <b>".$_GET["denngay"]."). Dữ liệu không phù hợp</h3>";
   }else
   {

    include("chitiet_thongke_khogiay.php");

 }
 }
 ?>