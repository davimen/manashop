<?php
include("index_table.php");

if(isset($_POST['cmdBangiao']))
{
  $ngay  = date('d');
  $thang = date('m');
  $nam   = date('y');
  $date_bangiao = strtotime($nam . "-" . $thang . "-" . $ngay);
  $ngay_bangiao = $ngay . "-" . $thang . "-" . date('Y');
  //delete ngay hom nay
  $dbf->deleteDynamic("bangiao","date_bangiao=".$date_bangiao."");

  $rst_no_datcoc=$dbf->getDynamic("hoadon","thanhtoan_id in (6,8)","");
  $toal_no_datcoc = $dbf->totalRows($rst_no_datcoc);
  if($rst_no_datcoc >0)
  {
    while($rows_no_datcoc= $dbf->nextdata($rst_no_datcoc))
    {
       $array_col = array("hoadon_id" => $rows_no_datcoc["id"],"ngay" => $rows_no_datcoc["ngay"], "thang" => $rows_no_datcoc["thang"], "nam" => $rows_no_datcoc["nam"], "giotao" => $rows_no_datcoc["giotao"], "sohoadon" => $rows_no_datcoc["sohoadon"], "fullname_sell" => $rows_no_datcoc["fullname_sell"], "khachang_id" => $rows_no_datcoc["khachang_id"], "fullname_dv" => $rows_no_datcoc["fullname_dv"], "address" => $rows_no_datcoc["address"], "mst" => $rows_no_datcoc["mst"], "thanhtoan_id" => $rows_no_datcoc["thanhtoan_id"], "datcoc" => $rows_no_datcoc["datcoc"], "nhanvien_id" => $rows_no_datcoc["nhanvien_id"], "nhanvien_quay_id" => $rows_no_datcoc["nhanvien_quay_id"], "array_mathang_id" => $rows_no_datcoc["array_mathang_id"], "array_item_code" => $rows_no_datcoc["array_item_code"], "array_hanghoa" => $rows_no_datcoc["array_hanghoa"], "array_is_dichvu" => $rows_no_datcoc["array_is_dichvu"], "array_donvitinh" => $rows_no_datcoc["array_donvitinh"], "array_soluong" => $rows_no_datcoc["array_soluong"], "array_dongia" => $rows_no_datcoc["array_dongia"], "array_giamgia" => $rows_no_datcoc["array_giamgia"], "array_ghichu" => $rows_no_datcoc["array_ghichu"], "array_khogiay_id" => $rows_no_datcoc["array_khogiay_id"], "array_dientich" => $rows_no_datcoc["array_dientich"], "tongtiendonvi" => $rows_no_datcoc["tongtiendonvi"], "tax" => $rows_no_datcoc["tax"], "tienthueGTGT" => $rows_no_datcoc["tienthueGTGT"], "tongsotien" => $rows_no_datcoc["tongsotien"], "tienbangchu" => $rows_no_datcoc["tienbangchu"], "order_week" => $rows_no_datcoc["order_week"], "datecreated" => $rows_no_datcoc["datecreated"], "status" => $rows_no_datcoc["status"],"date_bangiao"=>$date_bangiao);
       $dbf->insertTable("bangiao", $array_col);
       unset($array_col);
    }
  }

 ?>
     <script language="JavaScript" type="text/javascript">
     /*<![CDATA[*/
       openBox('chitiet_bangiao.php?ngay=<?php echo $ngay_bangiao ?>',792,650);
     /*]]>*/
     </script>
 <?php
}

?>

<table width="100%" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td class="boxRedInside" colspan="5"><div class="boxRedInside">Bàn Giao</div></td></tr></tbody></table>
<div class="panelAction" id="panelAction" style="height: 400px;">

   <div style="float: left; text-align: left; margin-top: 10px;">
       <fieldset style="width: 620px">
            <legend style="color: #000080"><b>Bàn Giao</b></legend>
       <br />Ngày<input type="text" onfocus="fo(this)" onblur="lo(this)" maxlength="12" value="<?php echo date("d-m-Y",time())?>" id="tungay" name="tungay" >
  	  <script type="text/javascript">
  		$(function() {
  			$('#tungay').datepicker({
  				changeMonth: true,
  				changeYear: true,
  				dateFormat: 'dd-mm-yy'
  			});
  		});
  	  </script>


       <br/><br/><input type="submit" name="cmdBangiao" id="cmdBangiao" value="Bàn Giao Hôm nay" />
        <input type="button" name="cmdChitietBangiao" id="cmdChitietBangiao" value="Xem Lại Bàn Giao" />
        </fieldset>


   </div>
    <div id="clear" style="clear: both"></div>
</div>

<script language="JavaScript" type="text/javascript">
/*<![CDATA[*/



$('#cmdChitietBangiao').click(function (){
    var tungay      = $('#tungay').val();
    openBox('chitiet_bangiao.php?ngay='+tungay+'',792,650);
});
/*]]>*/
</script>