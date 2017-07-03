<?php
include ("index_table.php");
?>

<script language="JavaScript" src="js/filterlist.js" type="text/javascript"></script>
<form name="frm" id="frm" action="">
<table width="100%" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td class="boxRedInside" colspan="5"><div class="boxRedInside">Thống kê</div></td></tr></tbody></table>

<div class="panelAction" id="panelAction" style="height: 400px;">



   <div style="float: left; text-align: left; margin-top: 10px;">

       <fieldset style="width: 600px">

       <legend style="color: #000080; padding-bottom: 10px"><b>Thống kê theo khách hàng</b></legend>

       <span style="float: left; width:100px">Khách hàng</span>

    <select name="khachang_id" id="khachang_id" style="width:180px;" onchange="chonkhachhang(this.value)" size="10">

  	<option value="">-- Tất cả -- </option>

      <?php
      $rst_group = $dbf->getDynamic("city_vietnam", "status=1", "title asc");
      $toal_group = $dbf->totalRows($rst_group);
      if ($toal_group > 0) {
        while ($rows_group = $dbf->nextdata($rst_group)) {
          $id_group = $rows_group['id'];
          $title_group = $rows_group['title'];
          echo '<option value="group|' . $id_group . '">' . $title_group . '</option>';
          $rst_khachhang = $dbf->getDynamic("khachang", "tinhthanh_id=" . $id_group . " and status=1", "title asc");
          $toal_khachhang = $dbf->totalRows($rst_khachhang);
          if ($toal_khachhang > 0) {
            while ($rows_khachhang = $dbf->nextdata($rst_khachhang)) {
              $id_khachhang = $rows_khachhang['id'];
              $title_khachhang = stripcslashes($rows_khachhang['title']);
              $tinhthanh_id_khachhang = stripcslashes($rows_khachhang['tinhthanh_id']);
              $address_khachhang = stripcslashes($rows_khachhang['address']);
              $mst_khachhang = stripcslashes($rows_khachhang['mst']);
              $email_khachhang = stripcslashes($rows_khachhang['email']);
              echo '<option value="' . $id_khachhang . '">=>' . $title_khachhang . '</option>';
            }
          }
        }
      }
      ?>
  </select>
       <SCRIPT TYPE="text/javascript">
             var myfilter = new filterlist(document.getElementById("khachang_id"));
       </SCRIPT>
       <span style="float: right; margin: 68px 119px 0px 0px;">
       <=> <input type="text" onKeyUp="myfilter.set(this.value)" value="<?php echo $fullname_dv; ?>" class="nd2" onblur="lo(this);" onfocus="fo(this);" id="fullname_dv" name="fullname_dv" style="width: 150px">
       </span>
        <div class="clear"></div>

       <br /><span style="float: left; width:100px">Từ ngày</span><input type="text" onfocus="fo(this)" onblur="lo(this)" maxlength="12" value="<?php echo date("d-m-Y", time()) ?>" id="tungay" name="tungay" >

  	  <script type="text/javascript">

  		$(function() {

  			$('#tungay').datepicker({

  				changeMonth: true,

  				changeYear: true,

  				dateFormat: 'dd-mm-yy'

  			});

  		});

  	  </script>



      Đến ngày<input type="text" onfocus="fo(this)" onblur="lo(this)" maxlength="12" value="<?php echo date("d-m-Y", time()) ?>" id="denngay" name="denngay">

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
            <br>
            <input onclick="setvalue(this.value)" class="rad_name" type="radio" name="rad_name" id="rad_name6" value="6" /> <b>Theo chuyển khoản</b>
            <!--<input onclick="setvalue(this.value)" class="rad_name" type="radio" name="rad_name" id="rad_name7" value="7" /> <b>Theo thu nợ tiền mặt</b>!-->




       <br/><br/><input type="button" name="cmdSearch" id="cmdSearch" value="Tìm kiếm" />

                 <input type="hidden" name="chitiet_khachhang" id="chitiet_khachhang" class="chitiet_khachhang" value="" />

                 <input type="hidden" name="chitiet_rad" id="chitiet_rad" class="chitiet_rad" value="1" />

        </fieldset>





   </div>

    <div id="clear" style="clear: both"></div>

</div>



<script language="JavaScript" type="text/javascript">

/*<![CDATA[*/



function chonkhachhang(value)

{

  $('#chitiet_khachhang').val(value);

}



function setvalue(value)

{

  $('#chitiet_rad').val(value);

}



$('#cmdSearch').click(function (){

    var tungay      = $('#tungay').val();

    var denngay     = $('#denngay').val();

    var rad_name = $('#chitiet_rad').val(); // retrieve the value

    var khachhang_id = $('#chitiet_khachhang').val();





    openBox('chitiet_content_khachhang.php?tungay='+tungay+'&denngay='+denngay+'&khachhang_id='+khachhang_id+'&rad_name='+rad_name+'',792,650);

});

/*]]>*/

</script>
</form>