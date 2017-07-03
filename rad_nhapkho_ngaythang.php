<?php
@ session_start();
if (empty($_SESSION["user_login"])) {
  session_unregister("user_login");
  echo "<script>window.location.href='login.php'</script>";
  exit;
}

include str_replace('\\', '/', dirname(__FILE__)) . '/content_spaw/spaw.inc.php';
include str_replace('\\', '/', dirname(__FILE__)) . '/class/class.DEFINE.php';
include str_replace('\\', '/', dirname(__FILE__)) . '/class/class.HTML.php';
include str_replace('\\', '/', dirname(__FILE__)) . '/class/class.JAVASCRIPT.php';
include str_replace('\\', '/', dirname(__FILE__)) . '/class/class.UTILITIES.php';
include str_replace('\\', '/', dirname(__FILE__)) . '/class/class.CSS.php';
include str_replace('\\', '/', dirname(__FILE__)) . '/class/class.SINGLETON_MODEL.php';
include str_replace('\\', '/', dirname(__FILE__)) . '/class/simple_html_dom.php';
include str_replace('\\', '/', dirname(__FILE__)) . '/class/class.BUSINESSLOGIC.php';
include str_replace('\\', '/', dirname(__FILE__)) . '/class/template.php';
include str_replace('\\', '/', dirname(__FILE__)) . '/Cache_Lite/Lite/Function.php';
$html = SINGLETON_MODEL::getInstance("HTML");
$js = SINGLETON_MODEL::getInstance("JAVASCRIPT");
$css = SINGLETON_MODEL::getInstance("CSS");
$utl = SINGLETON_MODEL::getInstance("UTILITIES");
$dbf = SINGLETON_MODEL::getInstance("BUSINESSLOGIC");
$html->docType();
$setting = $dbf->getInfoColum("setting", 1);

$array_nhacungcap = array();
$rst_nhacungcap = $dbf->getDynamic("nhacungcap", "status=1", "id asc");
  while ($rows_nhacungcap = $dbf->nextdata($rst_nhacungcap)) {
     $array_nhacungcap[$rows_nhacungcap['id']] = $rows_nhacungcap;
     }


if ($mathang_id != '') {
    $mathang = $dbf->getInfoColum("mathang", $mathang_id);
    $namemathang = $mathang["item_name"];
}
else {
  $namemathang = 'Tất cả';
}
?>

<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
<link rel="shortcut icon" type="image/x-icon"  href="images/favicon.ico"/>
<link rel="stylesheet"  type="text/css" href="themes/theme_default/style/style.pack.css"/>
<link rel="stylesheet"  type="text/css" href="css/ui.all.css"/>
<link rel="stylesheet"  type="text/css" href="style/jquery.Slidemenu.css"/>
<link rel="stylesheet" href="style/export_detail.css" type="text/css" />
<div class="swap">

<div class="panelView" id="panelView">
    <h4><?php echo $setting["title"] ?></h4>
    <center>
            <H1>THỐNG KÊ NHẬP KHO</H1>
            <p style="padding: 0px; margin: 0px;">Từ ngày:&nbsp;<?php echo $_GET['tungay']; ?>&nbsp;&nbsp; Đến ngày:&nbsp;<?php echo $_GET['denngay']; ?></p>

    </center>

<h3 style="padding: 0px; margin: 0px 0px 5px;">Mặt hàng : <i><?php echo $namemathang; ?></i></h3>

<table cellspacing="1" cellpadding="1" id="mainTable" style="width: 100%">

 <?php
 if ($mathang_id != '')
 {
     $rst_mathang = $dbf->getDynamic("mathang", "id = '" . (int) $mathang_id . "' and status=1", "id asc");
 }
 else {
   $rst_mathang = $dbf->getDynamic("mathang", "status=1", "id asc");
 }

 $toal_mathang = $dbf->totalRows($rst_mathang);
 if ($toal_mathang > 0) {
   $tongsotienthongke_all = 0;
   $array_mathang = array();
   while ($rows_mathang = $dbf->nextdata($rst_mathang)) {
     $array_mathang[$rows_mathang['id']] = $rows_mathang;
     }
     }

     ?>

     <tr class="titleBottom">
        <td class="itemText">STT</td>
        <td class="itemText">Mặt hàng</td>
        <td class="itemText">Code</td>
        <td class="itemText">Đơn giá</td>
        <td class="itemText">Số lượng nhập</td>
        <td class="itemText">Nhà cung cấp</td>
        <td class="itemText">Ngày nhập</td>
        <td class="itemText">Thành tiền</td>
      </tr>

        <?php
        if ($mathang_id != '')
         {
             $rs_nhapkho = $dbf->getDynamic("nhapkho", "datecreated >= " . $tungay . " and datecreated <= " . $denngay . " and mathang_id='" . $rows_mathang['id'] . "' and status=1", "datecreated asc");
         }
         else
         {
           $rs_nhapkho = $dbf->getDynamic("nhapkho", "datecreated >= " . $tungay . " and datecreated <= " . $denngay . " and status=1", "datecreated asc");
         }


        $total_nhapkho = $dbf->totalRows($rs_nhapkho);
        if ($total_nhapkho > 0) {
          $number_row = 1;
          $tongsotienthongke = 0;
          $ngay_tem = "";
          while ($row_nhapkho = $dbf->nextData($rs_nhapkho)) {
                $id                 = $row_nhapkho['id'];
                $mathang_id_kho     = $row_nhapkho['mathang_id'];
                $quantity           = $row_nhapkho['quantity'];
                $nhacungcap_id      = $row_nhapkho['nhacungcap_id'];
                $status             = stripcslashes($row_nhapkho['status']);
                $datecreated        = date("d-m-Y",stripcslashes($row_nhapkho['datecreated']));
                if($ngay_tem=="")
                {
                   $ngay_tem = $row_nhapkho['datecreated'];
                   echo '<tr class="cell1">
                            <td colspan="8"><h4>Ngày nhập: '.$datecreated.'</h5></td>
                          </tr>';
                }else
                {
                    if($ngay_tem!=$row_nhapkho['datecreated'])
                    {
                        $ngay_tem = $row_nhapkho['datecreated'];
                        echo '<tr class="cell1">
                            <td colspan="8"><h4>Ngày nhập:'.$datecreated.'</h5></td>
                          </tr>';
                    }
                }

                $tongsotienthongke+= $array_mathang[$mathang_id_kho]["price"] * $quantity;
          ?>

    <tr class="<?php echo (($i % 2 == 0) ? "cell2" : "cell1") ?>">
        <td style="width:20px; color:#3F5F7F" class="itemCenter"><?php echo $number_row ?></td>
        <td class="itemText"><?php echo $array_mathang[$mathang_id_kho]["item_name"] ?></td>
        <td class="itemText"><?php echo $array_mathang[$mathang_id_kho]["item_code"] ?></td>
        <td class="itemText"><?php echo $utl->format($array_mathang[$mathang_id_kho]["price"]); ?></td>
        <td class="itemText"><?php echo $quantity ?></td>
        <td class="itemText"><?php echo $array_nhacungcap[$nhacungcap_id]["title"]; ?></td>
        <td class="itemText"><?php echo $datecreated ?></td>
        <td class="itemText"><?php echo $utl->format($array_mathang[$mathang_id_kho]["price"]*$quantity); ?></td>
    </tr>
      <?php
         $number_row++;
      }
      ?>

       <tr class="cell2">
          <td colspan="7" style="text-align: right"> Tổng số:</td>
          <td colspan="1" style="text-align: left; color: red;font-size:14px;"><b><?php echo $utl->format($tongsotienthongke) ?> VNĐ</b></td>
       </tr>

         <?php
          }
          else {
            echo "<tr class='cell2'><td colspan='8'><h3 style='text-align:left'> =>Không có dữ liệu</h3></td></tr>";
          }
          ?>

    </table>
    <input type="hidden" value="" id="arrayid" name="arrayid">
    </div>
</div>