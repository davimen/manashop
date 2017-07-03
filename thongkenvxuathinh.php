<?php
include("index_table.php");
?>

<table width="100%" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td class="boxRedInside" colspan="5"><div class="boxRedInside">Thống kê</div></td></tr></tbody></table>
<div class="panelAction" id="panelAction" style="height: 400px;">

   <div style="float: left; text-align: left; margin-top: 10px;">
       <fieldset style="width: 600px">
       <legend style="color: #000080; padding-bottom: 10px"><b>Thống kê theo NV xuất hình</b></legend>
       <span style="float: left; width:100px">NV xuất hình</span>
    <select name="nhanvien_id" id="nhanvien_id" style="width:180px;" onchange="chonnhanvien(this.value)">
  	<option value="">-- Tất cả -- </option>
      <?php
            $rst_nhanvien=$dbf->getDynamic("nhanvien","is_nvxh =1 and status=1","title asc");
            $toal_nhanvien = $dbf->totalRows($rst_nhanvien);

            if($toal_nhanvien >0)
            {

              while($rows_nhanvien= $dbf->nextdata($rst_nhanvien))
               {
                 $id_nhanvien            = $rows_nhanvien['id'];
                 $title_nhanvien         = stripcslashes($rows_nhanvien['title']);
                 $tinhthanh_id_nhanvien  = stripcslashes($rows_nhanvien['tinhthanh_id']);
                 $address_nhanvien       = stripcslashes($rows_nhanvien['address']);
                 $mst_nhanvien           = stripcslashes($rows_nhanvien['mst']);
                 $email_nhanvien         = stripcslashes($rows_nhanvien['email']);

                 echo '<option value="'.$id_nhanvien.'">'.$title_nhanvien.'</option>';

               }
            }
        ?>
  </select>
        <div class="clear"></div>
       <br /><span style="float: left; width:100px">Từ ngày</span><input type="text" onfocus="fo(this)" onblur="lo(this)" maxlength="12" value="<?php echo date("d-m-Y",time())?>" id="tungay" name="tungay" >
  	  <script type="text/javascript">
  		$(function() {
  			$('#tungay').datepicker({
  				changeMonth: true,
  				changeYear: true,
  				dateFormat: 'dd-mm-yy'
  			});
  		});
  	  </script>

      Đến ngày<input type="text" onfocus="fo(this)" onblur="lo(this)" maxlength="12" value="<?php echo date("d-m-Y",time())?>" id="denngay" name="denngay">
  	  <script type="text/javascript">
  		$(function() {
  			$('#denngay').datepicker({
  				changeMonth: true,
  				changeYear: true,
  				dateFormat: 'dd-mm-yy'
  			});
  		});
  	  </script>

            <div class="clear"></div>

            <br/><br/><input onclick="setvalue(this.value)" class="rad_name" type="radio" name="rad_name" id="rad_name1" value="1" checked /> <b>Theo hóa đơn</b>
            <input onclick="setvalue(this.value)" class="rad_name" type="radio" name="rad_name" id="rad_name2" value="2" /> <b>Theo mặt hàng</b>
            <input onclick="setvalue(this.value)" class="rad_name" type="radio" name="rad_name" id="rad_name3" value="3" /> <b>Theo công nợ</b>
            <input onclick="setvalue(this.value)" class="rad_name" type="radio" name="rad_name" id="rad_name4" value="4" /> <b>Theo đặt cọc</b>
            <input onclick="setvalue(this.value)" class="rad_name" type="radio" name="rad_name" id="rad_name5" value="5" /> <b>Theo tiền mặt</b>
            <br/><br/><input type="button" name="cmdSearch" id="cmdSearch" value="Tìm kiếm" />
                 <input type="hidden" name="chitiet_nhanvien" id="chitiet_nhanvien" class="chitiet_nhanvien" value="" />
                 <input type="hidden" name="chitiet_rad" id="chitiet_rad" class="chitiet_rad" value="1" />
        </fieldset>
   </div>
    <div id="clear" style="clear: both"></div>
</div>

<script language="JavaScript" type="text/javascript">
/*<![CDATA[*/

function chonnhanvien(value)
{
  $('#chitiet_nhanvien').val(value);
}

function setvalue(value)
{
  $('#chitiet_rad').val(value);
}

$('#cmdSearch').click(function (){
    var tungay      = $('#tungay').val();
    var denngay     = $('#denngay').val();
    var rad_name = $('#chitiet_rad').val(); // retrieve the value
    var nhanvien_id = $('#chitiet_nhanvien').val();
    openBox('chitiet_content_nhanvien2.php?tungay='+tungay+'&denngay='+denngay+'&nhanvien_id='+nhanvien_id+'&rad_name='+rad_name+'',792,650);
});
/*]]>*/
</script>