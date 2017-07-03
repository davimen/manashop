<?php
include("index_table.php");

if(isset($_GET["delete"])){

  $arrayid = $_POST["arrayid"];
  $arrayid_tmp=$arrayid;
  $arrayid=str_replace(",","','",$arrayid);

  $arrayid="'".$arrayid."'";
  $arrayid=str_replace("''","'-1'",$arrayid);

  $affect=$dbf->deleteDynamic("luong"," id in (".$arrayid.")");
  if($affect>0)
   {
     $html->redirectURL("/tinhluong.php");
   }
}


$thang = date('m');
$nam   = date('Y');

  $arraycalam = array();
  $rs_calam=$dbf->getDynamic("calam","1=1","id asc");
  $toal_calam = $dbf->totalRows($rs_calam);
  if($toal_calam >0)
  {

    while($rows_calam= $dbf->nextdata($rs_calam))
     {
         $arraycalam[$rows_calam['id']] =  $rows_calam['title'];

     }
  }
if(isset($_POST["cmdaddPrice"] ))
{

   $isvalue2        = true;
   $nhanvien_id_2   = $_POST["nhanvien_id_2"];
   $add_price       = $_POST["add_price"];
   $add_thang       = $_POST["add_thang"];
   $add_nam         = $_POST["add_nam"];
   $note            = $_POST["note"];
   $datecreated     = strtotime(date('Y-m-d',time()));


   if($nhanvien_id_2=="")
   {
      $isvalue2= false;
      $msg2.= "Vui lòng chọn nhân viên <br/>";
   }


    if($add_price=='')
    {
       $isvalue2= false;
       $msg2.= "Vui lòng nhập tiền cần thêm <br/>";
    }
    if($add_thang=='')
    {
       $isvalue2= false;
       $msg2.= "Vui lòng chọn tháng<br/>";
    }

    if($add_nam=='')
    {
       $isvalue2= false;
       $msg2.= "Vui lòng nhập năm<br/>";
    }

    if($isvalue2)
    {
        $array_col = array("title" => $note,"nhanvien_id"=>$nhanvien_id_2, "price" => $add_price,"month"=>$add_thang,"year"=>$add_nam,"datecreated" => $datecreated);
        $affect = $dbf->insertTable("luong", $array_col);
        $msg2="Thêm thành công";
    }

}

if(isset($_POST["cmdSearch"]))
{
   $isvalue     = true;
   //$nhanvien_id = $_POST["nhanvien_id"];
   $nhanvien_id = $_POST["id_nhanvien"];
   $price       = $_POST["price"];
   $thang       = $_POST["thang"];
   $thangngay   = explode("|",$thang);
   $nam         = $_POST["nam"];

   if($nhanvien_id=='')
    {
       $isvalue= false;
       $msg.= "Vui lòng chọn nhân viên <br/>";
    }
    if($price=='')
    {
       $isvalue= false;
       $msg.= "Vui lòng nhập tiền lương của nhân viên <br/>";
    }
    if($thang=='')
    {
       $isvalue= false;
       $msg.= "Vui lòng chọn tháng cần tính lương<br/>";
    }

    if($nam=='')
    {
       $isvalue= false;
       $msg.= "Vui lòng nhập năm cần tính lương<br/>";
    }

}

?>
<table width="100%" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td class="boxRedInside" colspan="5"><div class="boxRedInside">Tính lương nhân viên</div></td></tr></tbody></table>
<div class="panelAction" id="panelAction" style="height:60px">
  <?php
    if(isset($msg) && $msg !='')
    {
       echo "<div style='color:red'>".$msg."</div>";
    }
    ?>
   <div class="msg_error" id="msg_error" style='color:red'></div>
   <select name="nhanvien_id" onchange="setluong(this.value)" id="nhanvien_id" style="width:150px;">
  	<option value="">-- Nhân viên -- </option>
      <?php
            $arraynhanvien = array();
            $rst_nhanvien=$dbf->getDynamic("nhanvien","status=1","id asc");
            $toal_nhanvien = $dbf->totalRows($rst_nhanvien);

            if($toal_nhanvien >0)
            {

              while($rows_nhanvien= $dbf->nextdata($rst_nhanvien))
               {
                 $id    = $rows_nhanvien['id'];
                 $title = stripcslashes($rows_nhanvien['title']);
                 $luong = $rows_nhanvien['price'];
                 $arraynhanvien[$id]= $title;
                 echo '<option '.(($id==$nhanvien_id)?"selected":"").' value="'.$id.'|'.$luong.'">'.$title.'</option>';

               }
            }
        ?>
     </select>
     <input type="hidden" name="id_nhanvien" id="id_nhanvien" value="" />

     Tiền lương: <input name="price" id="price" type="text" value="<?php echo $price; ?>" style="width:100px"  onkeypress="return nhapso(event,'price')" />
     Tháng : <select name="thang" id="thang">
                <option value="">-- Chọn Tháng --</option>
                <?php
                    $t="";
                    for($i = 1; $i < 13; $i++) {
                          $day = cal_days_in_month(CAL_GREGORIAN, $i, $nam);
                          if($i<10)
                          {
                            $t= "0".$i;
                          }else
                          {
                            $t= $i;
                          }
                          echo "<option ".(($thang==$i)?"selected":"")." value=".$t."|".$day.">Tháng ".$t."</option>";
                     }

                ?>
     </select>
     /<input name="nam" id="nam" type="text" value="<?php echo $nam; ?>" style="width:50px"  />
     <input type="button" name="cmdSearch" id="cmdSearch" value="Tính lương" />
</div>
<div class="panelAction" id="panelAction" style="height:100px">
<h1 style="font-size: 14px; color:  red">Nhập Thêm các khoản khác</h1>
<fieldset style="border: 1px solid blue">
    <legend style="color: #000080"><b>Thông tin</b></legend>
        <?php
          if(isset($msg2) && $msg2 !='')
            {
               echo "<div style='color:red'>".$msg2."</div>";
            }

        ?>

        <select name="nhanvien_id_2" id="nhanvien_id_2" style="width:150px;">
    	<option value="">-- Nhân viên -- </option>
        <?php
              $arraynhanvien = array();
              $rst_nhanvien=$dbf->getDynamic("nhanvien","status=1","id asc");
              $toal_nhanvien = $dbf->totalRows($rst_nhanvien);

              if($toal_nhanvien >0)
              {

                while($rows_nhanvien= $dbf->nextdata($rst_nhanvien))
                 {
                   $id    = $rows_nhanvien['id'];
                   $title = stripcslashes($rows_nhanvien['title']);
                   $luong = $rows_nhanvien['price'];
                   $arraynhanvien[$id]= $title;
                   echo '<option '.(($id==$nhanvien_id2)?"selected":"").' value="'.$id.'">'.$title.'</option>';

                 }
              }
          ?>
       </select>
       Tiền: <input name="add_price" id="add_price" type="text" value="" style="width:100px"  onkeypress="return nhapso(event,'price')" />
       Tháng : <select name="add_thang">
                  <option value="">-- Chọn Tháng --</option>
                  <?php
                      $t="";
                      for($i = 1; $i < 13; $i++) {
                            $day = cal_days_in_month(CAL_GREGORIAN, $i, $nam);
                            if($i<10)
                            {
                              $t= "0".$i;
                            }else
                            {
                              $t= $i;
                            }
                            echo "<option ".(($thang==$i)?"selected":"")." value=".$t.">Tháng ".$t."</option>";
                       }

                  ?>
       </select>
     /<input name="add_nam" id="add_nam" type="text" value="<?php echo $nam; ?>" style="width:50px"  />
     Ghi chú: <input type="text" name="note" id="note" value="" />

     <input type="submit" name="cmdaddPrice" id="cmdaddPrice" value="Thêm" />

</fieldset>
</div>
<div class="">
<table cellspacing="1" cellpadding="1" id="mainTable">
<tbody>
    <tr class="titleBottom">
    <td class="itemCenter">
        <input type="checkbox" onclick="docheck(this.checked,0);" value="1" id="chkall" name="chkall">
    </td>
    <td class="itemCenter">STT</td>
    <td class="itemText">Nhân viên</td>
    <td class="itemText">Tiền</td>
    <td class="itemText">Tháng/năm</td>
    <td class="itemText">Ghi chú</td>
    <td class="itemText">Ngày tạo</td>
    <td class="cellAction1"><a onclick="return deleteCommon('tinhluong.php?');" href="javascript:void(0);" title="Delete"><img border="0" title="Delete" src="themes/theme_default/images/b_delete.gif"></a>&nbsp;&nbsp;<a style="color: #fff; float: right; text-decoration: none" onclick="return deleteCommon('tinhluong.php?');" href="javascript:void(0);" id="lnkaction" title="Delete">Xóa</a></td>
    </tr>
    <?php
        $url="/tinhluong.php?table_name=luong&";
        $mang = $dbf->paging("luong","1=1","id desc",$url,$PageNo,$PageSize,$Pagenumber,$ModePaging);

        $rs_hoadon = $mang[0];
        $total_hoadon = $dbf->totalRows($rs_hoadon);
        if($total_hoadon>0)
        {
            $i=1;
            while($row_hoadon=$dbf->nextData($rs_hoadon)){
              $id = $row_hoadon['id'];
              $nhanvien_id_list = $row_hoadon['nhanvien_id'];
              $price  = $utl->format($row_hoadon["price"]);
              $month  = $row_hoadon["month"];
              $year   = $row_hoadon["year"];
              $note  = $row_hoadon["title"];
              $datecreated = date("d-m-Y",$row_hoadon["datecreated"]);


    ?>
    <tr class="<?php echo (($i%2==0)?"cell2":"cell1")?>">
        <td class="itemCenter"><input type="checkbox" class="" style="" onclick="docheckone();" value="<?php echo $id?>" id="chk" name="chk"> </td>
        <td style="width:20px; color:#3F5F7F" class="itemCenter"><?php echo $i?></td>
        <td class="itemText"><?php echo $arraynhanvien[$nhanvien_id_list];?></td>
        <td class="itemText"><?php echo $price;?></td>
        <td class="itemText"><?php echo $month."/".$year;?></td>
        <td class="itemText"><?php echo $note;?></td>
        <td class="itemText"><?php echo $datecreated ?></td>
        <td class="itemText"><a onclick="return deleteCommon('tinhluong.php?');" href="javascript:void(0);" title="Delete"><img border="0" title="Delete" src="themes/theme_default/images/b_delete.gif"></a></td>
     </tr>
        <?php
          $i++;
        }
      ?>
         <tr class="cell2">
            <td colspan="13"><?php echo $mang[1]?></td>
         </tr>
      <?php
        }
      ?>
    </tbody>
    </table>
    <input type="hidden" value="" id="arrayid" name="arrayid"> 
 </div>

<script language="JavaScript" type="text/javascript">
/*<![CDATA[*/
function setluong(value)
{
   var data = value.split("|");
   document.getElementById("id_nhanvien").value = data[0];
   document.getElementById("price").value = data[1]

}

$('#cmdSearch').click(function (){

   var isvalue     = true;
   var nhanvien_id = $('#id_nhanvien').val();
   var price       = $('#price').val();
   var thang       = $('#thang').val();
   var thangngay   = thang.split("|")
   var nam         = $('#nam').val();
   var msg = "";

    if(nhanvien_id=='')
    {
       isvalue= false;
       msg+= "Vui lòng chọn nhân viên <br/>";
    }
    if(price=='')
    {
       isvalue= false;
       msg+= "Vui lòng nhập tiền lương của nhân viên <br/>";
    }
    if(thang=='')
    {
       isvalue= false;
       msg+= "Vui lòng chọn tháng cần tính lương<br/>";
    }

    if(nam=='')
    {
       isvalue= false;
       msg+= "Vui lòng nhập năm cần tính lương<br/>";
    }

    if(isvalue)
    {
    var nhanvien_id = $('#id_nhanvien').val();
    var price       = $('#price').val();
    var thang       = $('#thang').val();
    var thangngay   = thang.split("|")
    var nam         = $('#nam').val();
    openBox('tinhluong_chitiet.php?nhanvien_id='+nhanvien_id+'&price='+price+'&thang='+thangngay[0]+'&int_ngay='+thangngay[1]+'&nam='+nam+'',792,650);
    }else
    {
       $('#msg_error').html(msg);
    }

});

/*]]>*/
</script>