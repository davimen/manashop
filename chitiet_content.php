<?php
date_default_timezone_set('Asia/Bangkok');
if (isset($_GET["rad_name"])) {
  $tungay = strtotime($_GET["tungay"]);
  $denngay = strtotime($_GET["denngay"]);
  $rad_name = $_GET["rad_name"];
  ?>



  <?php
  if ($tungay > $denngay) {
    echo "<h3 style='text-align:left'>Vui lòng chọn số lại ngày (từ ngày <b>" . $_GET["tungay"] . "</b> đến ngày <b>" . $_GET["denngay"] . "). Dữ liệu không phù hợp</h3>";
  }
  else {
    switch ($rad_name) {
      case 1 :
        include ("rad_name1.php");
        break;
      case 2 :
        include ("rad_name2.php");
        break;
      case 3 :
        include ("rad_name3.php");
        break;
      case 4 :
        include ("rad_name4.php");
        break;
      case 5 :
        include ("rad_name5.php");
        break;
      case 6 :
        include ("rad_name6.php");
        break;
      default :
        include ("rad_name7.php");
    }
  }
}
?>