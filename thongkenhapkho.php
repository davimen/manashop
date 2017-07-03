<?php
include("index_table.php");
?>

<table width="100%" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td class="boxRedInside" colspan="5"><div class="boxRedInside">Thống kê</div></td></tr></tbody></table>
<div class="panelAction" id="panelAction" style="height: 400px;">

   <div style="float: left; text-align: left; margin-top: 10px;">
       <fieldset style="width: 600px">
       <legend style="color: #000080; padding-bottom: 10px"><b>Thống kê nhập kho</b></legend>
       <span style="float: left; width:100px">Mặt hàng</span>
       <select name="mathanh_id" id="mathanh_id" style="width:180px;" onchange="chonmathang(this.value)">
  	   <option value="">-- Tất cả -- </option>
      <?php
            $rst_mathang=$dbf->getDynamic("mathang","status=1","item_name asc");
            $toal_mathang = $dbf->totalRows($rst_mathang);

            if($toal_mathang >0)
            {

              while($rows_mathang= $dbf->nextdata($rst_mathang))
               {
                 $id_mathang            = $rows_mathang['id'];
                 $title_mathang         = stripcslashes($rows_mathang['item_name']);
                 $item_code                  = stripcslashes($rows_mathang['item_code']);
                 echo '<option value="'.$id_mathang.'">'.$item_code."-".$title_mathang.'</option>';

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

       <br/><br/><input type="button" name="cmdSearch" id="cmdSearch" value="Tìm kiếm" />
                 <input type="hidden" name="chitiet_mathang" id="chitiet_mathang" class="chitiet_mathang" value="" />

        </fieldset>


   </div>
    <div id="clear" style="clear: both"></div>
</div>

<script language="JavaScript" type="text/javascript">
/*<![CDATA[*/

function chonmathang(value)
{
  $('#chitiet_mathang').val(value);
}

function setvalue(value)
{
  $('#chitiet_rad').val(value);
}

$('#cmdSearch').click(function (){
    var tungay      = $('#tungay').val();
    var denngay     = $('#denngay').val();
    var mathang_id = $('#chitiet_mathang').val();
    openBox('chitiet_nhapkho.php?tungay='+tungay+'&denngay='+denngay+'&mathang_id='+mathang_id+'',792,650);
});
/*]]>*/
</script>