<?php
include("index_table.php");
?>

<table width="100%" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td class="boxRedInside" colspan="5"><div class="boxRedInside">Hóa đơn</div></td></tr></tbody></table>
<div class="panelAction" id="panelAction" style="height: 30px;">

   <div style="float: left; text-align: left; height: 30px;">
       Từ ngày<input type="text" onfocus="fo(this)" onblur="lo(this)" maxlength="12" value="<?php echo date("d-m-Y",time())?>" id="tungay" name="tungay" >
  	  <script type="text/javascript">
  		$(function() {
  			$('#tungay').datepicker({
  				changeMonth: true,
  				changeYear: true,
  				dateFormat: 'dd-mm-y'
  			});
  		});
  	  </script>

      Đến ngày<input type="text" onfocus="fo(this)" onblur="lo(this)" maxlength="12" value="<?php echo date("d-m-Y",time())?>" id="denngay" name="denngay">
  	  <script type="text/javascript">
  		$(function() {
  			$('#denngay').datepicker({
  				changeMonth: true,
  				changeYear: true,
  				dateFormat: 'dd-mm-y'
  			});
  		});
  	  </script>
       <input type="submit" name="cmdSearch" id="cmdSearch" value="Thống kê" />
   </div>
    <div id="clear"></div>
</div>

<?php

if(isset($_POST["cmdSearch"]))
{

   $tungay= strtotime($_POST["tungay"]);
   $denngay= strtotime($_POST["denngay"]);
?>

<?php
   if($tungay>$denngay)
   {
     echo "<h3 style='text-align:left'>Vui lòng chọn số lại ngày (từ ngày <b>".$_POST["tungay"]."</b> đến ngày <b>".$_POST["denngay"]."). Dữ liệu không phù hợp</h3>";
   }else
   {

  //echo $where;

?>

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
    <td class="itemText">MST</td>
    <td class="itemText">Hình thức thanh toán</td>
    <td class="itemText">Thành tiền</td>
    <td class="itemCenter">Ngày tạo</td>
    <td class="itemCenter">Trạng thái</td>
    <td class="itemText">In Hóa Đơn</td>
    </tr>
    <?php

        $rs_hoadon=$dbf->getDynamic("hoadon","datecreated >= ".$tungay." and datecreated <= ".$denngay." and status=1","id desc ");
        $total_hoadon = $dbf->totalRows($rs_hoadon);
        if($total_hoadon>0)
        {
            $i=1;
            echo "<tr class='cell2')><td colspan='12'><div style='padding:10px 0px'> Có <b>".$total_hoadon."</b> hóa đơn từ ngày <b>".$_POST["tungay"]."</b> đến ngày <b>".$_POST["denngay"]."</b> </div> </td></tr>";
            $tongsotienthongke = 0;
            while($row_hoadon=$dbf->nextData($rs_hoadon)){
              $id = $row_hoadon['id'];
              $sohoadon = $row_hoadon['sohoadon'];
              $fullname_sell = stripcslashes($row_hoadon['fullname_sell']);
              $fullname_dv = stripcslashes($row_hoadon['fullname_dv']);
              $address = stripcslashes($row_hoadon['address']);

              $thanhtoan_id = stripcslashes($row_hoadon['thanhtoan_id']);
              $info_thanhtoan = $dbf->getInfoColum("thanhtoan",$thanhtoan_id);
              $tongsotien = stripcslashes($row_hoadon['tongsotien']);
              $tongsotienthongke+= $tongsotien;
              $ngay = stripcslashes($row_hoadon['ngay']);
              $thang = stripcslashes($row_hoadon['thang']);
              $nam = stripcslashes($row_hoadon['nam']);
              $ngaytao = $ngay."-".$thang."-".$nam;
              $status = stripcslashes($row_hoadon['status']);
    ?>
    <tr class="<?php echo (($i%2==0)?"cell2":"cell1")?>">
    <td class="itemCenter"><input type="checkbox" class="" style="" onclick="docheckone();" value="<?php echo $id?>" id="chk" name="chk"> </td>
    <td style="width:20px; color:#3F5F7F" class="itemCenter"><?php echo $i?></td>
    <td class="itemText"><?php echo $sohoadon?></td>
    <td class="itemText"><a href="themhoadon.php?edit=<?php echo $id?>" id="itemText"><?php echo $fullname_dv?></a></td>
    <td class="itemText"><a href="themhoadon.php?edit=<?php echo $id?>" id="itemText"><?php echo $address?></a></td>

    <td class="itemText"><a href="themhoadon.php?edit=<?php echo $id?>" id="itemText"><?php echo $info_thanhtoan['title']?></a></td>
    <td class="itemText"><a href="themhoadon.php?edit=<?php echo $id?>" id="itemText"><?php echo $utl->format($tongsotien)?></a></td>
    <td class="itemText"><a href="themhoadon.php?edit=<?php echo $id?>" id="itemText"><?php echo $ngaytao?></a></td>
    <td class="itemCenter"><a href="themhoadon.php?edit=<?php echo $id?>" id="itemText"><input type="checkbox" checked="<?php echo (($status==1)?"true":"false")?>" value="" disabled="" name=""></a></td>
    <td class="itemCenter"><a onclick="openBox('inhoadon.php?id=<?php echo $id?>',950,700);" href="javascript:void(0)" id="itemText"><span class="inhoadon">In hóa đơn</span></a></td>

    </tr>
        <?php
          $i++;
        }
      ?>
       <tr class="cell2">
        <td colspan="8" style="text-align: right"> Tổng số tiền:</td>
        <td colspan="4" style="text-align: left; color: red;font-size:16px;"><b><?php echo $utl->format($tongsotienthongke)?> VNĐ</b></td>

       </tr>
      <?php
      }else
      {
        echo "<tr class='cell2'><td colspan='12'><h3 style='text-align:left'> =>Không có dữ liệu</h3></td></tr>";
      }
    ?>
    </tbody>
    </table>
    <input type="hidden" value="" id="arrayid" name="arrayid">
    </div>
 <?php

 }
 }
 ?>