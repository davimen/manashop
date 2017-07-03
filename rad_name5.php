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
$ngay_timkiem_t = explode("-", $_GET['tungay']);
$ngay_timkiem = $ngay_timkiem_t[0];
?>

<meta http-equiv="content-type" content="text/html;charset=utf-8"/>

<link rel="shortcut icon" type="image/x-icon"  href="images/favicon.ico"/>

<link rel="stylesheet"  type="text/css" href="themes/theme_default/style/style.pack.css"/>

<link rel="stylesheet"  type="text/css" href="css/ui.all.css"/>

<link rel="stylesheet"  type="text/css" href="style/jquery.Slidemenu.css"/>

<link rel="stylesheet" href="style/export_detail.css" type="text/css" />
<script language="JavaScript" src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$('#back-top').click(function() {
		$('body,html').animate({scrollTop:0},800);
	});
    $('#back-bottom').click(function() {
        $("html, body").animate({ scrollTop: $(document).height()-$(window).height() }, 800);
	});
});
</script>

<p id="back-top" style="visibility: visible; display: block;"><a href="javascript:void(0)"><span>Top</span></a></p>
<p id="back-bottom" style="visibility: visible; display: block;"><a href="javascript:void(0)"><span>Bottom</span></a></p>

<div class="swap">
<div class="panelView" id="panelView">
    <h4><?php echo $setting["title"] ?></h4>
    <center>
        <H1>THỐNG KẾ CHI TIẾT: TIỀN MẶT</H1>
        <p>Từ ngày:&nbsp;<?php echo $_GET['tungay']; ?>&nbsp;&nbsp; Đến ngày:&nbsp;<?php echo $_GET['denngay']; ?></p>
    </center>

<table cellspacing="1" cellpadding="1" id="mainTable" style="width: 100%">
<tr class="cell2">
        <td style="text-align: right" colspan="7"> Tổng số tiền:</td>
        <td style="text-align: left; color: red;font-size:14px;" colspan="2"><div class="price_total_lab"></div></td>
</tr>
<tbody>
    <tr class="titleBottom">
     <td class="itemText">STT</td>
    <td class="itemText">Số HĐ</td>
    <td class="itemText">Khách Hàng</td>
    <td class="itemCenter">Địa chỉ</td>
    <td class="itemText">Hình thức thanh toán (Triết khấu)%</td>
    <td class="itemText">Đặt cọc</td>
    <td class="itemText">Tiền nợ</td>
    <td class="itemText">Thành tiền</td>
    <td class="itemCenter">Ngày tạo</td>
    </tr>

    <?php
    $rs_hoadon = $dbf->getDynamic("hoadon", "((datecreated >= " . $tungay . " and datecreated <= " . $denngay . ") or (dateupdated >= " . $tungay . " and dateupdated <= " . $denngay . ")) and (thanhtoan_id=8  or thanhtoan_id=5 or thanhtoan_id=11) and status=1", "datecreated asc ");
    $total_hoadon = $dbf->totalRows($rs_hoadon);
    if ($total_hoadon > 0) {
      $number_row = 1;
      $tongtieno = 0;
      $tongsotienthongke = 0;
      $tongsotienthongke_all = 0;
      $tongsotienthongke_datcoc = 0;
      $tongsotienthongke_trano = 0;
      $stt_hodon = 0;
      while ($row_hoadon = $dbf->nextData($rs_hoadon)) {
        $id = $row_hoadon['id'];
        $sohoadon = $row_hoadon['sohoadon'];
        $fullname_sell = stripcslashes($row_hoadon['fullname_sell']);
        $fullname_dv = stripcslashes($row_hoadon['fullname_dv']);
        $address = stripcslashes($row_hoadon['address']);
        $mst = stripcslashes($row_hoadon['mst']);
        $thanhtoan_id = stripcslashes($row_hoadon['thanhtoan_id']);
        $info_thanhtoan = $dbf->getInfoColum("thanhtoan", $thanhtoan_id);
        $datcoc = stripcslashes($row_hoadon['datcoc']);
        $nhanvien_id = stripcslashes($row_hoadon['nhanvien_id']);
        $info_nhanvien = $dbf->getInfoColum("nhanvien", $nhanvien_id);
        $ngay = stripcslashes($row_hoadon['ngay']);
        $tongsotien = $row_hoadon['tongsotien'];
        $conlai = (int) $tongsotien - (int) $datcoc;
        $datecreated = $row_hoadon['datecreated'];
        $dateupdated = $row_hoadon['dateupdated'];
        if ($thanhtoan_id == 8) {
          $tongsotienmat += $datcoc;
          $tongsotienthongke += $datcoc;
          $tongsotien = $datcoc;
        }
        else {
          if ($tungay == $denngay) {
            if ($datecreated != $dateupdated) {
              if ($dateupdated != 0 && $dateupdated == $tungay) {
                $tongsotienmat += $conlai;
                $tongsotienthongke += $conlai;
                $tongsotien = $conlai;
                $tongsotienthongke_trano += $conlai;
              }
              else {
                if ($dateupdated > 0) {
                  if ($dateupdated > $tungay) {
                    $tongsotienmat += $datcoc;
                    $tongsotienthongke += $datcoc;
                    $tongsotien = $datcoc;
                  }
                  else {
                    if ($datecreated >= $tungay) {
                      $tongsotienmat += $tongsotien;
                      $tongsotienthongke += $tongsotien;
                    }
                    else {
                      $tongsotienmat += $conlai;
                      $tongsotienthongke += $conlai;
                      $tongsotien = $conlai;
                      $tongsotienthongke_trano += $conlai;
                    }
                  }
                }
                else { //tien mat luon
                  $tongsotienmat += $tongsotien;
                  $tongsotienthongke += $tongsotien;
                }
              }
            }
            else {
                //ngày tạo và ngày cập nhật bằng nhau hoặc ngày cập nhật bằng 0
                //echo $row_hoadon['sohoadon'];
              $tongsotienmat += $tongsotien;
              $tongsotienthongke += $tongsotien;
            }
          }
          else {
            //ngay tim kien nam trong khoang thoi gian
            if ($datecreated >= $tungay && $dateupdated <= $denngay) {
              $tongsotienmat += $tongsotien;
              $tongsotienthongke += $tongsotien;
            }
            else
              if ($datecreated >= $tungay && $dateupdated > $denngay) {
                $tongsotienmat += $datcoc;
                $tongsotienthongke += $datcoc;
                $tongsotien = $datcoc;
              }
              else {
                $tongsotienmat += $conlai;
                $tongsotienthongke += $conlai;
                $tongsotien = $conlai;
                $tongsotienthongke_trano += $conlai;
            }
          }
        }
        $tongsotienthongke_datcoc += $datcoc;
        $array_mathang_id = explode("|o0o|", $row_hoadon["array_mathang_id"]);
        $array_item_code = explode("|o0o|", $row_hoadon["array_item_code"]);
        $array_hanghoa = explode("|o0o|", $row_hoadon["array_hanghoa"]);
        $array_donvitinh = explode("|o0o|", $row_hoadon["array_donvitinh"]);
        $array_soluong = explode("|o0o|", $row_hoadon["array_soluong"]);
        $array_dongia = explode("|o0o|", $row_hoadon["array_dongia"]);
        $array_giamgia = explode("|o0o|", $row_hoadon["array_giamgia"]);
        $array_ghichu = explode("|o0o|", $row_hoadon["array_ghichu"]);
        $number_field_dichvu = count($array_soluong);
        $ngay = stripcslashes($row_hoadon['ngay']);
        $thang = stripcslashes($row_hoadon['thang']);
        $nam = stripcslashes($row_hoadon['nam']);
        $giotao = stripcslashes($row_hoadon['giotao']);
        $ngaytao = $ngay . "-" . $thang . "-" . $nam . ":" . $giotao;
        $status = stripcslashes($row_hoadon['status']);
        $stt_hodon++;
        ?>

    <tr class="<?php echo (($i % 2 == 0) ? "cell2" : "cell1") ?>">



    <td style="width:20px; color:#3F5F7F" class="itemCenter"><?php echo $number_row ?></td>

    <td class="itemText"><?php echo $sohoadon ?></td>

    <td class="itemText"><?php echo $fullname_dv ?></td>

    <td class="itemText"><?php echo $address ?></td>

    <td class="itemText"><?php echo $info_thanhtoan['title'] ?>(<?php echo $info_thanhtoan['pecent'] ?>)%</td>

    <td class="itemText"><?php echo $utl->format($datcoc) ?></td>

    <td class="itemText">

            <?php
            if ($thanhtoan_id == 8) {
              echo $utl->format($tongsotien - $datcoc);
            }
            else {
              echo 0;
            }
            ?>

    </td>

    <td class="itemText"><?php echo $utl->format($tongsotien); ?></td>

    <td class="itemText"><?php echo "Ngày tạo: " . date('d-m-Y', $datecreated); ?><?php echo (($dateupdated > 0) ? "<br/>Cập nhật:" . date('d-m-Y', $dateupdated) : ""); ?></td>

    </tr>

    <tr class="<?php echo (($i % 2 == 0) ? "cell2" : "cell1") ?>">

        <td colspan="9" style="background: none">

             <table class="table_dichvu">

                  <?php
                  $stt = 1;
                  $contiengiamgia = 0;
                  for ($i = 0; $i < $number_field_dichvu; $i++) {
                    $congtienhang_thuc += $array_soluong[$i] * $array_dongia[$i];
                    $contiengiamgia += $array_giamgia[$i];
                    if ($array_soluong[$i]) {
                      ?>

                    <tr id="field_<?= $i ?>">

                      <td style="text-align: left"><?= $array_item_code[$i] ?></td>

                      <td style="text-align: left"><?= $array_hanghoa[$i] ?></td>

                      <td style="text-align: center"><?= $array_soluong[$i] ?></td>

                      <td style="text-align: center"><?= $array_donvitinh[$i] ?></td>

                      <td style="text-align: center"><?= $array_giamgia[$i] ?></td>

                      <td style="text-align: center"><?= $utl->format($array_soluong[$i] * $array_dongia[$i]) ?></td>

                    </tr>

                          <?
                          $stt++;
                        }
                      }
                      ?>

                      <?php
                      if ($contiengiamgia != 0) {
                        ?>

                     <tr>

                      <td colspan="5" style="text-align: right">Giảm giá</td><td align="center"><b><?php echo $utl->format($contiengiamgia); ?></b></td>

                     </tr>

                          <?php
                        }
                        ?>

                  <tr>

                      <td colspan="5" style="text-align: right">Thành tiền</td><td align="center"><b><?php echo $utl->format($tongsotien); ?></b>

                  </td>

                  </tr>

             </table>

        </td>

    </tr>

            <?php
            $number_row++;
          }
          ?>

      <tr class="cell2">

        <td colspan="6" style="text-align: right">Tổng tiền đặt cọc</td>
        <td style="text-align: left; color: red;font-size:14px;"><b><?php echo $utl->format($tongsotienthongke_datcoc) ?> </b></td>
        <td style="text-align: right"> Tổng tiền tiền mặt:</td>
        <td style="text-align: left; color: red;font-size:14px;"><b><?php echo $utl->format($tongsotienmat) ?> </b></td>

       </tr>

        <?php
        $tongsotienthongke_datcoc_all += $tongsotienthongke_datcoc;
      }
      else {
        echo "<tr class='cell2'><td colspan='12'><h3 style='text-align:left'> =>Không có dữ liệu</h3></td></tr>";
      }
      ?>

     <tr class="cell2">
       <td colspan='6' style="text-align: right"> Tiền mặt thu từ nợ là:</td>
       <td colspan='3' style="text-align: left; color: red;font-size:14px;"><b><?php echo $utl->format($tongsotienthongke_trano) ?> VNĐ</b></td>
     </tr>

     <tr class="cell2">
       <td colspan='6' style="text-align: right"> Tiền mặt trực tiếp:</td>
       <td colspan='3' style="text-align: left; color: red;font-size:14px;"><b><?php echo $utl->format($tongsotienthongke - $tongsotienthongke_trano) ?> VNĐ</b></td>
     </tr>

    <tr class="cell2">
       <td colspan='6' style="text-align: right"> TỔNG TIỀN MẶT LÀ:</td>
       <td colspan='3' style="text-align: left; color: red;font-size:14px;"><b><?php echo $utl->format($tongsotienthongke) ?> VNĐ</b></td>
     </tr>

        <script>
            var price_total_lab = "<?php echo $utl->format($tongsotienthongke); ?>";
            $(".price_total_lab").html('<b>'+price_total_lab+'</b> <sup>đ</sup>');
          </script>

    </tbody>
    </table>
    <input type="hidden" value="" id="arrayid" name="arrayid">
    </div>
</div>