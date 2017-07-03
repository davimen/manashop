<?php
include("index_table.php");
//set_time_limit(0);

if(isset($_GET["delete"])){
  $ngay         = date('d');
  $thang        = date('m');
  $nam          = date('y');
  $datecreated  =strtotime($nam."-".$thang."-".$ngay);

  $arrayid = $_POST["arrayid"];
  $arrayid_tmp=$arrayid;
  $arrayid=str_replace(",","','",$arrayid);

  $arrayid="'".$arrayid."'";
  $arrayid=str_replace("''","'-1'",$arrayid);

  $affect=$dbf->deleteDynamic("log_nhanvienxh"," id in (".$arrayid.")");
  if($affect>0)
   {
     $html->redirectURL("/log_nhanvienxh.php");
   }
}

if(isset($_POST["cmdthemlog"]))
{

    $isvalue = true;
    $add_nhanvien_id= $_POST["add_nhanvien_id"];
    $mathang_id_p   = $_POST["mathang"];
    $quantity       = $_POST["quantity"];
    $price          = $_POST["price"];
    $note           = $_POST["note"];

    $ngay         = date('d');
    $thang        = date('m');
    $nam          = date('Y');
    $datecreated  = strtotime($nam."-".$thang."-".$ngay);
    //$datecreated = time();

    if($add_nhanvien_id=='')
    {
       $isvalue= false;
       $msg = "Vui lòng chọn nhân viên";
    }

    if($mathang_id_p=='')
    {
       $isvalue= false;
       $msg = "Vui lòng chọn sản phẩm";
    }

    if((int)$quantity==0)
    {
       $isvalue= false;
       $msg.= "\n Vui lòng nhập số lượng bằng số";
    }

    if((int)$price==0)
    {
       $isvalue= false;
       $msg.= "\n Vui lòng nhập số tiền bằng số";
    }

    if($isvalue){
        $array_col = array("mathang_id" => $mathang_id_p, "quantity" => $quantity, "price"=>$price,"note"=>$note,"nhanvien_id" => $add_nhanvien_id, "date" => $datecreated);
        $affect = $dbf->insertTable("log_nhanvienxh", $array_col);
    }
}

if(isset($_POST["cmdcapnhatlog"]))
{

    $isvalue = true;
    $id_log= (int) $_GET["edit"];
    $add_nhanvien_id= $_POST["add_nhanvien_id"];
    $mathang_id_p = $_POST["mathang"];
    $quantity = $_POST["quantity"];
    $price          = $_POST["price"];
    $note           = $_POST["note"];


    if($add_nhanvien_id=='')
    {
       $isvalue= false;
       $msg = "Vui lòng chọn nhân viên";
    }

    if($mathang_id_p=='')
    {
       $isvalue= false;
       $msg = "Vui lòng chọn sản phẩm";
    }

    if((int)$quantity==0)
    {
       $isvalue= false;
       $msg.= "\n Vui lòng nhập số lượng bằng số";
    }

    if((int)$price==0)
    {
       $isvalue= false;
       $msg.= "\n Vui lòng nhập số tiền bằng số";
    }

    if($isvalue){
        $array_col = array("mathang_id" => $mathang_id_p, "price"=>$price,"note"=>$note, "nhanvien_id" => $add_nhanvien_id, "quantity" => $quantity);
        $dbf->updateTable("log_nhanvienxh",$array_col , "id = " . $id_log);
    }
}

if (isset ($_GET["edit"]) && $_GET["edit"] != '') {
  $info_lognv  = $dbf->getInfoColum("log_nhanvienxh", (int) $_GET["edit"]);
  if ($info_lognv == - 1) {
    $html->redirectURL("/log_nhanvienxh.php");
  }
}


$array_mathang = array();
$rst_mathang = $dbf->getDynamic("mathang", "status=1", "item_code asc");
$toal_mathang = $dbf->totalRows($rst_mathang);
if ($toal_mathang > 0) {
  while ($rows_mathang = $dbf->nextdata($rst_mathang)) {
    $id = $rows_mathang['id'];
    //$item_code = stripcslashes($rows_mathang['item_code']);
    //$item_name = stripcslashes($rows_mathang['item_name']);
    //$item_price = stripcslashes($rows_mathang['price']);
    //$array_mathang[$id]= $item_code." | ". $item_name ." | ".$item_price;
    $array_mathang[$id] = $rows_mathang;
  }
}

$array_nhanvien = array();
$rst_nhanvien = $dbf->getDynamic("nhanvien","is_nvxh =1 and status=1","title asc");
$toal_nhanvien = $dbf->totalRows($rst_nhanvien);
if ($toal_nhanvien > 0) {
  while ($rows_nhanvien = $dbf->nextdata($rst_nhanvien)) {
    $id = $rows_nhanvien['id'];
    $fullname = stripcslashes($rows_nhanvien['title']);
    $array_nhanvien[$id]= $fullname;
  }
}


$where ='1=1';
if(isset($_POST["cmdSearch"]))
{

   $tungay = $_POST["tungay"];
   $_SESSION['tungay']= $_POST["tungay"];

   $denngay = $_POST["denngay"];
   $_SESSION['denngay']= $denngay;


}else
{
  if(!isset($_GET['PageNo']))
  {
      $_SESSION['tungay']="";
      $_SESSION['denngay']="";
  }
}

if($_SESSION['tungay']!='')
{
     $where.=' and date >= "'.strtotime($_SESSION['tungay']).'" ';
}

if($_SESSION['denngay']!='')
{
     $where.=' and date <= "'.strtotime($_SESSION['denngay']).'" ';
}
if($_SESSION["user_login"]["role_id"]!=4 && $_SESSION["user_login"]["role_id"]!=11)
{
     $where.=' and nhanvien_id='.$_SESSION["user_login"]["id"].'';
}

$PageSize=100;
$function_permission = $_SESSION['permission'][$dbf->getValueOfQuery('SELECT id FROM sys_table WHERE table_name="log_nhanvienxh"')];
//print_r($function_permission);

?>
<table width="100%" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td class="boxRedInside" colspan="5"><div class="boxRedInside">Log Nhân Viên Xuất Hình</div></td></tr></tbody></table>
<div class="panelAction" id="panelAction" style="height:90px">
  <div style="float:left;width:16%;">
    <table cellspacing="1" cellpadding="1" id="panelTable">
	<tbody><tr>
        <td><a href="log_nhanvienxh.php" id="lnkaction" title="Insert">Thêm mới</a></td>
        <?php if($function_permission["is_delete"]){?>
        <td class="cellAction1"><a onclick="return deleteCommon('log_nhanvienxh.php?');" href="javascript:void(0);" title="Delete"><img border="0" title="Delete" src="themes/theme_default/images/b_delete.gif"></a></td><td><a onclick="return deleteCommon('log_nhanvienxh.php?');" href="javascript:void(0);" id="lnkaction" title="Delete">Xóa</a></td>
        <?php } ?>
        </tr>
	</tbody></table>
   </div>
   <div class="clear"></div>
   <div style="float: right; text-align: left; width:100%; margin-top: 15px">
     NV xuất hình
    <input type="hidden" name="chitiet_nhanvien" id="chitiet_nhanvien" class="chitiet_nhanvien" value="" />
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

                 echo '<option '.(($id_nhanvien==$add_nhanvien_id)?"selected":"").'  value="'.$id_nhanvien.'">'.$title_nhanvien.'</option>';

               }
            }
        ?>
  </select>

      <?php

          if(!isset($_SESSION['tungay']) || $_SESSION['tungay']=="")
          {
             $_SESSION['tungay'] = date('d-m-Y',time());
          }
       ?>
      Từ ngày<input type="text" onfocus="fo(this)" onblur="lo(this)" maxlength="12" value="<?php echo $_SESSION['tungay'];?>" id="tungay" name="tungay" >
  	  <script type="text/javascript">
  		$(function() {
  			$('#tungay').datepicker({
  				changeMonth: true,
  				changeYear: true,
  				dateFormat: 'dd-mm-yy'
  			});
  		});
  	  </script>
      <?php
          if(!isset($_SESSION['denngay']) || $_SESSION['denngay']=="")
          {
            $_SESSION['denngay'] = date('d-m-Y',time());
          }
       ?>
      Đến Ngày<input type="text" onfocus="fo(this)" onblur="lo(this)" maxlength="12" value="<?php echo $_SESSION['denngay'];?>" id="denngay" name="denngay" >
  	  <script type="text/javascript">
  		$(function() {
  			$('#denngay').datepicker({
  				changeMonth: true,
  				changeYear: true,
  				dateFormat: 'dd-mm-yy'
  			});
  		});
  	  </script>
       <input type="button" name="cmdSearch" id="cmdSearch" value="Thống kê" />
   </div>
    <div id="clear"></div>
</div>

<div class="panelView" id="panelView">

<?php
if (isset ($_GET["edit"]) && $_GET["edit"] != '')
{

?>

<fieldset>
    <legend style="color: #000080"><b>Cập nhật Log Công Việc</b></legend>
    <?php
    if(isset($msg) && $msg !='')
    {
       echo "<div style='color:red'>".$msg."</div>";
    }
    ?>

    NV xuất hình

    <select name="add_nhanvien_id" id="add_nhanvien_id" style="width:180px;">
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

                 echo '<option '.(($id_nhanvien==$add_nhanvien_id)?"selected":"").'  value="'.$id_nhanvien.'">'.$title_nhanvien.'</option>';

               }
            }
        ?>
  </select>

    Mặt hàng
    <input type="hidden" name="mathang" id="mathang" value="<?php echo $info_lognv['mathang_id']; ?>" />
    <input type="hidden" name="price_mathang" id="price_mathang" value="<?php echo $array_mathang[$info_lognv['mathang_id']]['price']?>" />
    <select style="width:180px;" name="mathang_show" onchange="setprice(this.value)">
         <option value="">--Chọn--</option>
         <?php
         foreach($array_mathang as $key=>$value)
         {
            $item_code = stripcslashes($array_mathang[$key]['item_code']);
            $item_name = stripcslashes($array_mathang[$key]['item_name']);
            $item_price = stripcslashes($array_mathang[$key]['price']);
            $name_select= $item_code." | ". $item_name ." | ".$utl->format($item_price)." VNĐ";
            $value_key = $key."|".$item_price;

           echo "<option ".(($info_lognv['mathang_id']==$key)?"Selected":"")." value=".$value_key.">".$name_select."</option>";
         }
         ?>
    </select>
    Số lượng: <input name="quantity" type="text" id="quantity" onchange="setprice2(this.value)" value="<?php echo $info_lognv['quantity']; ?>" style="width:50px" />
    Thành tiền: <input name="price" id="price" type="text" value="<?php echo $info_lognv['price']; ?>" style="width:100px" />
    <textarea name="note" id="note" style="width: 400px; height: 50px;"><?php echo $info_lognv['note']; ?></textarea>
    <br/><input type="submit" name="cmdcapnhatlog" value="Cập nhật" />

</fieldset>
<?php
}
else
{


?>

<fieldset>
    <legend style="color: #000080"><b>Thêm Log Công Việc</b></legend>
    <?php
    if(isset($msg) && $msg !='')
    {
       echo "<div style='color:red'>".$msg."</div>";
    }
    ?>

    NV xuất hình

    <select name="add_nhanvien_id" id="add_nhanvien_id" style="width:180px;">
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

                 echo '<option '.(($id_nhanvien==$add_nhanvien_id)?"selected":"").'  value="'.$id_nhanvien.'">'.$title_nhanvien.'</option>';

               }
            }
        ?>
  </select>

    Mặt hàng
    <input type="hidden" name="mathang" id="mathang" value="<?php echo $mathang_id_p; ?>" />
    <input type="hidden" name="price_mathang" id="price_mathang" value="<?php echo $array_mathang[$mathang_id_p]['price']?>" />
    <select style="width:180px;" name="mathang_show" onchange="setprice(this.value)">
       <option value="">--Chọn--</option>
       <?php
       foreach($array_mathang as $key=>$value)
       {
          $item_code = stripcslashes($array_mathang[$key]['item_code']);
          $item_name = stripcslashes($array_mathang[$key]['item_name']);
          $item_price = stripcslashes($array_mathang[$key]['price']);
          $name_select= $item_code." | ". $item_name ." | ".$utl->format($item_price)." VNĐ";
          $value_key = $key."|".$item_price;
          echo "<option ".(($mathang_id_p==$key)?"Selected":"")." value=".$value_key.">".$name_select."</option>";
       }
       ?>
    </select>
    Số lượng: <input name="quantity" id="quantity" type="text" onchange="setprice2(this.value)" value="<?php echo $quantity; ?>" style="width:50px" />
    Thành tiền: <input name="price" id="price" type="text" value="<?php echo $price; ?>" style="width:100px" /> <br />
    Ghi Chú: <br />
    <textarea name="note" id="note" style="width: 400px; height: 50px;"><?php echo $note; ?></textarea>
    <br/>
    <input type="submit" name="cmdthemlog" value="Thêm" />
</fieldset>
<?php
}
?>

<table cellspacing="1" cellpadding="1" id="mainTable">
<tbody>
    <tr class="titleBottom">
    <td class="itemCenter">
        <input type="checkbox" onclick="docheck(this.checked,0);" value="1" id="chkall" name="chkall">
    </td>
    <td class="itemCenter">STT</td>
    <td class="itemText">Nhân viên</td>
    <td class="itemText">Mặt hàng</td>
    <td class="itemText">Số Lượng</td>
    <td class="itemText">Thành tiền</td>
    <td class="itemText">Ghi chú</td>
    <td class="itemText">Ngày tạo</td>
    </tr>
    <?php
        $url="/log_nhanvienxh.php?";
        if(!isset($_POST['cmdSearch']))
        {
        $mang = $dbf->paging("log_nhanvienxh","".$where."","id desc",$url,$PageNo,$PageSize,$Pagenumber,$ModePaging);
        $rs_hoadon = $mang[0];
        }
        else
        {
          $rs_hoadon= $dbf->getDynamic("log_nhanvienxh","".$where."","id desc ");
        }
        $total_hoadon = $dbf->totalRows($rs_hoadon);
        if($total_hoadon>0)
        {
            $i=1;
            $total_price = 0;
            while($row_hoadon=$dbf->nextData($rs_hoadon)){
              $id = $row_hoadon['id'];
              $mathang_id  = $row_hoadon["mathang_id"];
              $quantity    = $row_hoadon["quantity"];
              $nhanvien_id = $row_hoadon["nhanvien_id"];
              $price = $row_hoadon["price"];
              $note = $row_hoadon["note"];
              $ngaytao = date("d-m-Y",$row_hoadon["date"]);
              $total_price+=$price;

    ?>
    <tr class="<?php echo (($i%2==0)?"cell2":"cell1")?>">
        <td class="itemCenter"><input type="checkbox" class="" style="" onclick="docheckone();" value="<?php echo $id?>" id="chk" name="chk"> </td>
        <td style="width:20px; color:#3F5F7F" class="itemCenter"><?php echo $i?></td>
        <td class="itemText"><a href="log_nhanvienxh.php?edit=<?php echo $id?>" id="itemText"><?php echo $array_nhanvien[$nhanvien_id];?></a></td>
        <td class="itemText"><a href="log_nhanvienxh.php?edit=<?php echo $id?>" id="itemText"><?php echo $array_mathang[$mathang_id]["item_name"];?></a></td>
        <td class="itemText"><a href="log_nhanvienxh.php?edit=<?php echo $id?>" id="itemText"><?php echo $quantity;?></a></td>
        <td class="itemText"><a href="log_nhanvienxh.php?edit=<?php echo $id?>" id="itemText"><?php echo $utl->format($price);?></a></td>
        <td class="itemText"><a href="log_nhanvienxh.php?edit=<?php echo $id?>" id="itemText"><?php echo $note;?></a></td>
        <td class="itemText"><a href="log_nhanvienxh.php?edit=<?php echo $id?>" id="itemText"><?php echo $ngaytao;?></a></td>
     </tr>
        <?php
          $i++;
        }

        if(isset($_POST['cmdSearch']))
        {

      ?>
         <tr class="cell2">
            <td colspan="5"><b>TỔng số tiền:</b> </td>
            <td colspan="3"><span style="color: red"><?php echo $utl->format($total_price);?> VNĐ</span></td>
         </tr>
      <?php
        }else
        {
      ?>

        <tr class="cell2">
            <td colspan="13"><?php echo $mang[1]?></td>
         </tr>

      <?php
        }
        }
      ?>
    </tbody>
    </table>
    <input type="hidden" value="" id="arrayid" name="arrayid">
    </div>

    <script language="JavaScript" type="text/javascript">
    /*<![CDATA[*/
    function setprice (value)
    {

      var data = value.split("|");
      document.getElementById('mathang').value = data[0];
      document.getElementById('price_mathang').value = data[1];

      var quanlity = document.getElementById('quantity').value;
      var price = parseInt(data[1]) * parseInt(quanlity);
      document.getElementById('price').value = price;
    }

    function setprice2 (value)
    {
      var price_current = document.getElementById('price_mathang').value;
      var price = parseInt(price_current) * parseInt(value);
      document.getElementById('price').value = price;
    }

    /*]]>*/
    </script>

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
          var nhanvien_id = $('#chitiet_nhanvien').val();
          openBox('chitiet_content_log_nhanvienxh.php?tungay='+tungay+'&denngay='+denngay+'&nhanvien_id='+nhanvien_id+'',1500,650);
      });
      /*]]>*/
      </script>