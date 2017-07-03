<?php
include("index_table.php");
?>

<table width="100%" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td class="boxRedInside" colspan="5"><div class="boxRedInside">Thống kê</div></td></tr></tbody></table>
<div class="panelAction" id="panelAction" style="height: 400px;">

   <div style="float: left; text-align: left; margin-top: 10px;">
       <fieldset style="width: 600px">
       <legend style="color: #000080; padding-bottom: 10px"><b>Thống kê khổ giấy</b></legend>
       <span style="float: left; width:100px">Khổ giấy</span>
    <select name="khogiay_id" id="khogiay_id" style="width:180px;" onchange="chonkhogiay(this.value)">
  	<option value="">-- Tất cả -- </option>
      <?php
            $rst_khogiay=$dbf->getDynamic("khogiay_category","status=1","title asc");
            $toal_khogiay = $dbf->totalRows($rst_khogiay);

            if($toal_khogiay >0)
            {

              while($rows_khogiay= $dbf->nextdata($rst_khogiay))
               {
                 $id_khogiay            = $rows_khogiay['id'];
                 $title_khogiay         = stripcslashes($rows_khogiay['title']);
                 echo '<option value="'.$id_khogiay.'">'.$title_khogiay.'</option>';

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


       <br/><br/><input type="button" name="cmdSearch" id="cmdSearch" value="Thống kê" />
                 <input type="hidden" name="chitiet_khogiay" id="chitiet_khogiay" class="chitiet_khogiay" value="" />
                 <input type="hidden" name="chitiet_rad" id="chitiet_rad" class="chitiet_rad" value="1" />
        </fieldset>


   </div>
    <div id="clear" style="clear: both"></div>
</div>

<script language="JavaScript" type="text/javascript">
/*<![CDATA[*/

function chonkhogiay(value)
{
  $('#chitiet_khogiay').val(value);
}

function setvalue(value)
{
  $('#chitiet_rad').val(value);
}

$('#cmdSearch').click(function (){
    var tungay      = $('#tungay').val();
    var denngay     = $('#denngay').val();
    var khogiay_id = $('#chitiet_khogiay').val();

    openBox('chitiet_content_thongkekg.php?tungay='+tungay+'&denngay='+denngay+'&khogiay_id='+khogiay_id+'',792,650);
});
/*]]>*/
</script>