<?php
date_default_timezone_set('Asia/Bangkok');
$tungay          = strtotime($_GET["tungay"]);
$denngay         = strtotime($_GET["denngay"]);
$mathang_id      = $_GET["mathang_id"];

if($tungay>$denngay)
{
 echo "<h3 style='text-align:left'>Vui lòng chọn số lại ngày (từ ngày <b>".$_GET["tungay"]."</b> đến ngày <b>".$_GET["denngay"]."). Dữ liệu không phù hợp</h3>";
}else
{
    include("rad_nhapkho_ngaythang2.php");
}
 ?>