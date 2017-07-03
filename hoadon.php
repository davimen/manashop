<?php
include ("index_table.php");
//set_time_limit(0);
if (isset($_GET["delete"])) {
  $ngay = date('d');
  $thang = date('m');
  $nam = date('y');
  $datecreated = strtotime($nam . "-" . $thang . "-" . $ngay);
  $arrayid = $_POST["arrayid"];
  $arrayid_tmp = $arrayid;
  $arrayid = str_replace(",", "','", $arrayid);
  $arrayid = "'" . $arrayid . "'";
  $arrayid = str_replace("''", "'-1'", $arrayid);
  //lay hoa don
  $rs_mathang = $dbf->getDynamic("hoadon", "id in (" . $arrayid . ") and status=1", "datecreated desc ");
  $toal_mathang = $dbf->totalRows($rs_mathang);
  if ($toal_mathang > 0) {
    $tongsotienthongke = 0;
    while ($rows_mathang = $dbf->nextdata($rs_mathang)) {
      $array_mathang_id = explode("|o0o|", $rows_mathang["array_mathang_id"]);
      $array_soluong = explode("|o0o|", $rows_mathang["array_soluong"]);
      $array_is_dichvu = explode("|o0o|", $rows_mathang["array_is_dichvu"]);
      $array_khogiay_id = explode("|o0o|", $rows_mathang["array_khogiay_id"]);
      $array_dientich = explode("|o0o|", $rows_mathang["array_dientich"]);
      //luu de tinh
      for ($i = 0; $i < count($array_mathang_id); $i++) {
        if ($array_mathang_id[$i] != '' && $array_is_dichvu[$i] == 0) {
          //udate lai so luong
          $dbf->updateTable("mathang", array("quantity2" => "quantity2+" . $array_soluong[$i] . ""), "id = " . $array_mathang_id[$i]);
        }
      }
    }
  }
  $affect = $dbf->deleteDynamic("hoadon", " id in (" . $arrayid . ")");
  if ($affect > 0) {
    $html->redirectURL("/hoadon.php");
  }
}
$where = '1=1';
if (isset($_POST["cmdSearch"])) {
  $tungay = $_POST["tungay"];
  $_SESSION['tungay'] = $_POST["tungay"];
  $ngay_k = strtotime($tungay);
  $_SESSION['ngay_k'] = $ngay_k;
  $sohoadon = $_POST["sohoadon"];
  $_SESSION['sohoadon'] = $_POST["sohoadon"];
  $fullname_dv = $_POST["fullname_dv"];
  $_SESSION['fullname_dv'] = $fullname_dv;
  $thanhtoan_id = $_POST["thanhtoan_id"];
  $_SESSION['thanhtoan_id'] = $_POST["thanhtoan_id"];
}
else {
  if (!isset($_GET['PageNo'])) {
    $_SESSION['tungay'] = "";
    $_SESSION['ngay_k'] = "";
    $_SESSION['sohoadon'] = "";
    $_SESSION['khachang_id'] = "";
    $_SESSION['thanhtoan_id'] = "";
  }
}
if ($_SESSION['tungay'] != '') {
  $where .= ' and datecreated="' . $_SESSION['ngay_k'] . '" ';
}
if ($_SESSION['sohoadon'] != '') {
  $where .= ' and sohoadon="' . $_SESSION['sohoadon'] . '" ';
}
if ($_SESSION['fullname_dv'] != '') {
  $where .= ' and fullname_dv="' . $_SESSION['fullname_dv'] . '" ';
}
if ($_SESSION['thanhtoan_id'] != '') {
  $where .= ' and thanhtoan_id=' . $_SESSION['thanhtoan_id'] . ' ';
}
$PageSize = 100;
$function_permission = $_SESSION['permission'][$dbf->getValueOfQuery('SELECT id FROM sys_table WHERE table_name="hoadon"')];
?>
<script language="JavaScript" src="js/filterlist.js" type="text/javascript"></script>
<table width="100%" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td class="boxRedInside" colspan="5"><div class="boxRedInside">Hóa đơn</div></td></tr></tbody></table>
<div class="panelAction" id="panelAction" style="height:60px">
  <div style="float:left;width:16%;">
    <table cellspacing="1" cellpadding="1" id="panelTable">
	<tbody><tr>
        <td class="cellAction1"><a href="themhoadon.php" title="Insert"><img border="0" title="Thêm mới" src="themes/theme_default/images/new.jpg"></a></td>
        <td><a href="themhoadon.php" id="lnkaction" title="Insert">Thêm mới</a></td>
        <?php if ($function_permission["is_delete"]) { ?>
        <td class="cellAction1"><a onclick="return deleteCommon('hoadon.php?');" href="javascript:void(0);" title="Delete"><img border="0" title="Delete" src="themes/theme_default/images/b_delete.gif"></a></td><td><a onclick="return deleteCommon('hoadon.php?');" href="javascript:void(0);" id="lnkaction" title="Delete">Xóa</a></td>
        <?php } ?>
        </tr>
	</tbody></table>
   </div>
   <div style="float: right; text-align: left; width:82%;">
      Ngày<input type="text" style="width:100px;" onfocus="fo(this)" onblur="lo(this)" maxlength="12" value="<?php echo $_SESSION['tungay']; ?>" id="tungay" name="tungay" >
  	  <script type="text/javascript">
  		$(function() {
  			$('#tungay').datepicker({
  				changeMonth: true,
  				changeYear: true,
  				dateFormat: 'dd-mm-yy'
  			});
  		});
  	  </script>
       Mã phiếu: <input style="width:100px;" type="text" name="sohoadon" id="sohoadon" value="<?php echo $_SESSION['sohoadon']; ?>" />&nbsp;&nbsp;
       Khách hàng: <input style="width:100px;" type="text" name="fullname_dv" id="fullname_dv" value="<?php echo $fullname_dv ?>" />&nbsp;&nbsp;        
       HT thanh toán:
       <select name="thanhtoan_id" id="thanhtoan_id" style="width:140px;">
    	<option value="">-- Chọn hình thức thanh toán -- </option>
        <?php
        $rst_thanhtoan = $dbf->getDynamic("thanhtoan", "status=1", "id asc");
        $toal_thanhtoan = $dbf->totalRows($rst_thanhtoan);
        if ($toal_thanhtoan > 0) {
          while ($rows_thanhtoan = $dbf->nextdata($rst_thanhtoan)) {
            $id = $rows_thanhtoan['id'];
            $title = stripcslashes($rows_thanhtoan['title']);
            echo '<option ' . (($id == $_SESSION['thanhtoan_id']) ? "selected" : "") . ' value="' . $id . '">' . $title . '</option>';
          }
        }
        ?>
       </select>
       <input type="submit" name="cmdSearch" id="cmdSearch" value="Tìm kiếm" />
   </div>
    <div id="clear"></div>
</div>
<div class="panelView" id="panelView">
<table cellspacing="1" cellpadding="1" id="mainTable">
<tbody>
    <tr class="titleBottom">
    <td class="itemCenter">
        <input type="checkbox" onclick="docheck(this.checked,0);" value="1" id="chkall" name="chkall">
    </td>
    <td class="itemCenter">STT</td>
    <td class="itemText">Số HĐ</td>
    <td class="itemText">Khách hàng</td>
    <td class="itemCenter">Địa chỉ</td>
    <!--<td class="itemText">MST</td>!-->
    <td class="itemText">Hình thức thanh toán</td>
    <td class="itemText">Đặt cọc</td>
    <td class="itemText">Còn lại</td>
    <td class="itemText">Thành tiền</td>
    <td class="itemText">Ngày tạo</td>
    <td class="itemText">Ngày cập nhật</td>
    <td class="itemCenter">Trạng thái</td>
    <td class="itemText">In Hóa Đơn</td>
    </tr>
    <?php
    $url = "/hoadon.php?";
    if ($where == '1=1') {
      $mang = $dbf->paging("hoadon", "status=1", "id desc", $url, $PageNo, $PageSize, $Pagenumber, $ModePaging);
    }
    else {
    //$rs_hoadon = $dbf->getDynamic("hoadon","".$where." and status=1 ","id desc limit 0,80");
      $mang = $dbf->paging("hoadon", "" . $where . " and status=1 ", "id desc", $url, $PageNo, $PageSize, $Pagenumber, $ModePaging);
    }
    $rs_hoadon = $mang[0];
    //$mang = $dbf->paging("hoadon","".$where." and status=1 ","id desc",$url,$PageNo,$PageSize,$Pagenumber,$ModePaging);
    $rs_hoadon = $mang[0];
    $rs_thanhtoan = $dbf->getDynamic("thanhtoan", "status=1 ", "id desc");
    while ($row_thanhtoan = $dbf->nextData($rs_thanhtoan)) {
      $info_thanhtoan[$row_thanhtoan['id']] = $row_thanhtoan['title'];
    }
    //print_r($info_thanhtoan);
    //die();
    $total_hoadon = $dbf->totalRows($rs_hoadon);
    if ($total_hoadon > 0) {
      $i = 1;
      while ($row_hoadon = $dbf->nextData($rs_hoadon)) {
        $id = $row_hoadon['id'];
        $sohoadon = $row_hoadon['sohoadon'];
        $fullname_sell = stripcslashes($row_hoadon['fullname_sell']);
        $fullname_dv = stripcslashes($row_hoadon['fullname_dv']);
        $address = stripcslashes($row_hoadon['address']);
        $mst = stripcslashes($row_hoadon['mst']);
        $khachang_id = stripcslashes($row_hoadon['khachang_id']);
        $thanhtoan_id = stripcslashes($row_hoadon['thanhtoan_id']);
        //$info_thanhtoan = $dbf->getInfoColum("thanhtoan",$thanhtoan_id);
        $datcoc = stripcslashes($row_hoadon['datcoc']);
        //$nhanvien_id = stripcslashes($row_hoadon['nhanvien_id']);
        //$info_nhanvien = $dbf->getInfoColum("nhanvien",$nhanvien_id);
        $tongsotien = stripcslashes($row_hoadon['tongsotien']);
        $giotao = stripcslashes($row_hoadon['giotao']);
        $ngay = stripcslashes($row_hoadon['ngay']);
        $thang = stripcslashes($row_hoadon['thang']);
        $nam = stripcslashes($row_hoadon['nam']);
        //$ngaytao = $ngay."-".$thang."-20".$nam.":".$giotao;
        $ngaytao     = date("d-m-Y", $row_hoadon["datecreated"]);
        $ngaycapnhat = $row_hoadon["dateupdated"];
        if($ngaycapnhat)
        {
           $ngaycapnhat = date("d-m-Y", $ngaycapnhat);
        }else
        {
           $ngaycapnhat = "";
        }
        $status = stripcslashes($row_hoadon['status']);
        if ((int) $datcoc != 0 || $datcoc == "") {
          $conlai = $tongsotien - $datcoc;
        }
        else {
          $conlai = 0;
        }
        if ($thanhtoan_id == 5) {
          $conlai = 0;
        }
        ?>
    <tr class="<?php echo (($i % 2 == 0) ? "cell2" : "cell1") ?>">
    <td class="itemCenter"><input type="checkbox" class="" style="" onclick="docheckone();" value="<?php echo $id ?>" id="chk" name="chk"> </td>
    <td style="width:20px; color:#3F5F7F" class="itemCenter"><?php echo $i ?></td>
    <td class="itemText"><?php echo $sohoadon ?></td>
    <td class="itemText"><a href="themhoadon.php?edit=<?php echo $id ?>" id="itemText">
        <?php echo $fullname_dv; ?></a>
            <?php
            if ($info_thanhtoan[$thanhtoan_id] == "Nợ" || $info_thanhtoan[$thanhtoan_id] == "Đặt cọc") {
              ?>
             <img src="images/hot.gif" alt="" width="30" height="32" align="absmiddle" />
              <?php
            }
            ?>
    </td>
    <td class="itemText"><a href="themhoadon.php?edit=<?php echo $id ?>" id="itemText"><?php echo $address ?></a></td>
    <!--<td class="itemCenter"><a href="themhoadon.php?edit=<?php //echo $id?>" id="itemText"><?php //echo $mst?></a></td>!-->
    <td class="itemText">
              <a href="themhoadon.php?edit=<?php echo $id ?>" id="itemText"><span id="tt_<?php echo $id ?>"> <?php echo $info_thanhtoan[$thanhtoan_id] ?></span></a>
              &nbsp;&nbsp;<a style="color: red;" class="suathanhtoan" href="suathanhtoan.php?edit=<?php echo $id ?>">[Sửa]</a>
    </td>
    <td class="itemText"><a href="themhoadon.php?edit=<?php echo $id ?>" id="itemText"><?php echo $utl->format($datcoc) ?></a></td>
    <td class="itemText"><a href="themhoadon.php?edit=<?php echo $id ?>" id="itemText"><?php echo $utl->format($conlai) ?></a></td>
    <td class="itemText"><a href="themhoadon.php?edit=<?php echo $id ?>" id="itemText"><?php echo $utl->format($tongsotien) ?></a></td>
    <td class="itemText"><a href="themhoadon.php?edit=<?php echo $id ?>" id="itemText"><?php echo $ngaytao ?>&nbsp;<?php echo $giotao; ?></a></td>
    <td class="itemText"><a href="themhoadon.php?edit=<?php echo $id ?>" id="itemText"><?php echo $ngaycapnhat ?></a></td>
    <td class="itemCenter"><a href="themhoadon.php?edit=<?php echo $id ?>" id="itemText"><input type="checkbox" checked="<?php echo (($status == 1) ? "true" : "false") ?>" value="" disabled="" name=""></a></td>
    <td class="itemCenter"><a onclick="openBox('inhoadon.php?id=<?php echo $id ?>',800,500);" href="javascript:void(0)" id="itemText"><span class="inhoadon">In hóa đơn</span></a></td>
    </tr>
            <?php
            $i++;
          }
          ?>
         <tr class="cell2">
            <td colspan="13"><?php echo $mang[1] ?></td>
         </tr>
        <?php
      }
      ?>
    </tbody>
    </table>
    <input type="hidden" value="" id="arrayid" name="arrayid">
    </div>
<script type="text/javascript">
//<![CDATA[
    $(document).ready(function() {
        $(".suathanhtoan").fancybox({
        'titleShow'		: false,
        'width'				: 300,
        'height'			: 150,
        'autoScale'			: false,
        'overlayOpacity'    : 0.8,
        'overlayColor'      : '#000',
        'transitionIn'	: 'none',
        'transitionOut'	: 'none',
        'type'				: 'iframe'
        });
        });
 //]]>
</script>