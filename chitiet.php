<?php
include("index_table.php");
?>

<table width="100%" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td class="boxRedInside" colspan="5"><div class="boxRedInside">Hóa đơn</div></td></tr></tbody></table>
<div class="panelAction" id="panelAction" style="height: 400px;">

   <div style="float: left; text-align: left; margin-top: 10px;">
       <fieldset style="width: 620px">
            <legend style="color: #000080"><b>Thông kê chi tiết</b></legend>
       <br />Từ ngày<input type="text" onfocus="fo(this)" onblur="lo(this)" maxlength="12" value="<?php echo date("d-m-Y",time())?>" id="tungay" name="tungay" >
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



            <br/><br/><input onclick="setvalue(this.value)" class="rad_name" type="radio" name="rad_name" id="rad_name1" value="1" checked /> <b>Theo hóa đơn</b>
            <input onclick="setvalue(this.value)" class="rad_name" type="radio" name="rad_name" id="rad_name2" value="2" /> <b>Theo mặt hàng</b>
            <input onclick="setvalue(this.value)" class="rad_name" type="radio" name="rad_name" id="rad_name3" value="3" /> <b>Theo công nợ</b>
            <input onclick="setvalue(this.value)" class="rad_name" type="radio" name="rad_name" id="rad_name4" value="4" /> <b>Theo đặt cọc</b>
            <input onclick="setvalue(this.value)" class="rad_name" type="radio" name="rad_name" id="rad_name5" value="5" /> <b>Theo tiền mặt</b>
            <br>
            <input onclick="setvalue(this.value)" class="rad_name" type="radio" name="rad_name" id="rad_name6" value="6" /> <b>Theo chuyển khoản</b>
            <!--<input onclick="setvalue(this.value)" class="rad_name" type="radio" name="rad_name" id="rad_name7" value="7" /> <b>Theo thu nợ tiền mặt</b>!-->


       <br/><br/><input type="button" name="cmdSearch" id="cmdSearch" value="Tìm kiếm" />
                 <input type="hidden" name="chitiet_rad" id="chitiet_rad" class="chitiet_rad" value="1" />
        </fieldset>


   </div>
    <div id="clear" style="clear: both"></div>
</div>

<script language="JavaScript" type="text/javascript">
/*<![CDATA[*/

function setvalue(value)
{
  $('#chitiet_rad').val(value);
}


$('#cmdSearch').click(function (){
    var tungay      = $('#tungay').val();
    var denngay     = $('#denngay').val();
    var rad_name = $('#chitiet_rad').val(); // retrieve the value

    openBox('chitiet_content.php?tungay='+tungay+'&denngay='+denngay+'&rad_name='+rad_name+'',792,650);
});
/*]]>*/
</script>