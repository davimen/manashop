<?php
include("index_table.php");
date_default_timezone_set('Asia/Bangkok');
$nhanvien_id_login = $_SESSION["user_login"]["group_id"];
$infonhanvien = $dbf->getInfoColum("nhanvien", $nhanvien_id_login);
if (isset ($_GET["edit"]) && $_GET["edit"] != '') {
  $info_lognv  = $dbf->getInfoColum("phatsinh", (int) $_GET["edit"]);
  if ($info_lognv == - 1) {
    $html->redirectURL("/phatsinh.php");
  }
  $datecreated = date("d-m-y",$info_lognv["datecreated"]);
  $term = $URL=explode("-",$datecreated);
  $info_lognv['ngay'] = $term[0];
  $info_lognv['thang'] = $term[1];
  $info_lognv['nam'] = $term[2];
}else
{
  $ngay = date('d');
  $thang = date('m');
  $nam = date('y');
  $giotao = date('H') . ":" . date('i') . ":" . date('s');
}
if(isset($_GET["delete"])){
  $arrayid = $_POST["arrayid"];
  $arrayid_tmp=$arrayid;
  $arrayid=str_replace(",","','",$arrayid);
  $arrayid="'".$arrayid."'";
  $arrayid=str_replace("''","'-1'",$arrayid);
  $affect=$dbf->deleteDynamic("phatsinh"," id in (".$arrayid.")");
  if($affect>0)
   {
     $html->redirectURL("/phatsinh.php");
   }
}
if(isset($_POST["cmdthemlog"]))
{
    $isvalue      = true;
    $ngay         = $_POST["ngay"];
    $thang        = $_POST["thang"];
    $nam          = $_POST["nam"];
    $giotao       = $_POST["giotao"];
    $datecreated  = strtotime($nam."-".$thang."-".$ngay);
    $nhanvien_id  = $_POST["nhanvien_id"];
    $title        = $_POST["title"];
    $price        = $_POST["price"];
    $km           = $_POST["km"];
    $loai = 1;
    $note = $_POST["note"];
    if($_SESSION["user_login"]["role_id"]!=12)
     {
        if($nhanvien_id_login!=$nhanvien_id)
        {
           $isvalue= false;
           $msg.= "Bạn không có quyền thêm. Vui lòng nhập nhân viên <br/>";
        }
     }
    if($ngay=='')
    {
       $isvalue= false;
       $msg.= "Vui lòng nhập ngày <br/>";
    }
    if($thang=='')
    {
       $isvalue= false;
       $msg.= "Vui lòng nhập tháng <br/>";
    }
    if($nam=='')
    {
       $isvalue= false;
       $msg.= "Vui lòng nhập năm <br/>";
    }
    if($nhanvien_id=='')
    {
       $isvalue= false;
       $msg.= "Vui lòng nhập nhân viên <br/>";
    }
    if($title=='')
    {
       $isvalue= false;
       $msg.= "Vui lòng nhập tiêu đề <br/>";
    }
    if($isvalue){
        $array_col = array("nhanvien_id" => $nhanvien_id,"title" => $title, "price" => $price,"km" => $km, "note" => $note, "datecreated" => $datecreated, "giotao"=>$giotao);
        $affect = $dbf->insertTable("phatsinh", $array_col);
    }
}
if(isset($_POST["cmdcapnhatlog"]))
{
    $isvalue = true;
    $id_log =  (int) $_GET["edit"];
    $ngay         = $_POST["ngay"];
    $thang        = $_POST["thang"];
    $nam          = $_POST["nam"];
    $giotao       = $_POST["giotao"];
    $datecreated  = strtotime($nam."-".$thang."-".$ngay);
    $nhanvien_id = $_POST["nhanvien_id"];
    $km     = $_POST["km"];
    $title  = $_POST["title"];
    $price  = $_POST["price"];
    $note   = $_POST["note"];
    if($_SESSION["user_login"]["role_id"]!=12)
     {
        if($nhanvien_id_login!=$nhanvien_id)
        {
           $isvalue= false;
           $msg.= "Bạn không có quyền sửa <br/>";
        }
     }
    if($ngay=='')
    {
       $isvalue= false;
       $msg.= "Vui lòng nhập ngày <br/>";
    }
    if($thang=='')
    {
       $isvalue= false;
       $msg.= "Vui lòng nhập tháng <br/>";
    }
    if($nam=='')
    {
       $isvalue= false;
       $msg.= "Vui lòng nhập năm <br/>";
    }
    if($nhanvien_id=='')
    {
       $isvalue= false;
       $msg.= "Vui lòng nhập nhân viên <br/>";
    }
    if($title=='')
    {
       $isvalue= false;
       $msg.= "Vui lòng nhập tiêu đề <br/>";
    }
    if($isvalue){
        $array_col = array("nhanvien_id" => $nhanvien_id,"title" => $title, "price" => $price, "km"=>$km, "note"=>$note,"datecreated" => $datecreated, "giotao"=>$giotao);
        $dbf->updateTable("phatsinh",$array_col , "id = " . $id_log);
    }
}
$where ='1=1';
if(isset($_POST["cmdSearch"]))
{
   $nhanvien_id_search = $_POST["nhanvien_id_search"];
   $_SESSION['nhanvien_id_search']= $_POST["nhanvien_id_search"];
   $tungay = $_POST["tungay"];
   $_SESSION['tungay']= $_POST["tungay"];
   $denngay = $_POST["denngay"];
   $_SESSION['denngay']= $denngay;
   $note = $_POST["note"];
   $_SESSION['note']= $note;
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
     $where.=' and nhanvien_id = "'.$_SESSION['nhanvien_id_search'].'" ';
}
if($_SESSION['tungay']!='')
{
     $where.=' and datecreated >= "'.strtotime($_SESSION['tungay']).'" ';
}
if($_SESSION['denngay']!='')
{
     $where.=' and datecreated <= "'.strtotime($_SESSION['denngay']).'" ';
}
$PageSize=100;
$function_permission = $_SESSION['permission'][$dbf->getValueOfQuery('SELECT id FROM sys_table WHERE table_name="phatsinh"')];
//print_r($function_permission);
?>
<table width="100%" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td class="boxRedInside" colspan="5"><div class="boxRedInside">Chi phí phát sinh</div></td></tr></tbody></table>
<div class="panelAction" id="panelAction" style="height:130px">
  <div style="text-align: left">
    <table cellspacing="1" cellpadding="1" id="panelTable">
	<tbody><tr>
        <td width="80"><img border="0" title="Thêm mới" src="themes/theme_default/images/new.jpg">&nbsp;<a href="phatsinh.php?insert" title="Insert">Thêm mới</a></td>
        <td width="80"><img src="themes/theme_default/images/check.jpg" border="0" title="Thêm">&nbsp;<a href="phatsinh.php?thongke" title="Thống kê">Thống kê</a></td>
        <?php if($function_permission["is_delete"]){?>
        <td class="cellAction1"><a onclick="return deleteCommon('phatsinh.php?');" href="javascript:void(0);" title="Delete"><img border="0" title="Delete" src="themes/theme_default/images/b_delete.gif"></a></td><td><a onclick="return deleteCommon('phatsinh.php?');" href="javascript:void(0);" id="lnkaction" title="Delete">Xóa</a></td>
        <?php } ?>
        </tr>
	</tbody>
    </table>
   </div>
       <div class="clear"></div>
       <?php if(!isset($_GET["insert"]) && !isset($_GET["edit"]))  { ?>
       <h1 style="color: red; font-size: 16px">Thông Kê</h1>
        <fieldset>
        <legend style="color: #000080"><b>Thông tin</b></legend>
       <div style="float: left; text-align: left; width:95%;">
       <?php
            if($_SESSION["user_login"]["role_id"]!=12)
            {
        ?>
           Nhân viên:
        <select name="nhanvien_id_search" id="nhanvien_id_search">
        <option value="">-- Chọn nhân viên -- </option>
     <?php
        $rst_group = $dbf->getDynamic("nhanvien", "status=1", "title asc");
        $toal_group = $dbf->totalRows($rst_group);
        if ($toal_group > 0) {
          while ($rows_group = $dbf->nextdata($rst_group)) {
            $id_group = $rows_group['id'];
            $title_group = $rows_group['title'];
            echo '<option '.(($nhanvien_id_search==$id_group)?"selected":"").' value="'.$id_group.'">' . $title_group . '</option>';
          }
        }
     ?>
     </select>
     <?php }  ?>
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
           <input type="submit" name="cmdSearch" id="cmdSearch" value="Tìm kiếm" />
       </div>
    </fieldset>
    <div id="clear"></div>
    <?php } ?>
</div>
<div class="panelView" id="panelView">
<?php if(!isset($_POST["cmdSearch"])) { ?>
<?php
if(isset ($_GET["edit"]) && $_GET["edit"] != '')
{
?>
<fieldset>
    <legend style="color: #000080"><b>Cập nhật chi phí phát sinh</b></legend>
    <?php
    if(isset($msg) && $msg !='')
    {
       echo "<div style='color:red'>".$msg."</div>";
    }
    ?>
    <table>
        <tr>
            <td class="boxGrey">Ngày</td>
            <td class="boxGrey2">
            <input type="text" value="<?php echo $info_lognv["ngay"];?>" class="nd2" onblur="lo(this);" onfocus="fo(this);" id="ngay" name="ngay" style="width:40px;"> /
            <input type="text" value="<?php echo $info_lognv["thang"];?>" class="nd2" onblur="lo(this);" onfocus="fo(this);" id="thang" name="thang" style="width:40px;">/
            <input type="text" value="<?php echo $info_lognv["nam"];?>" class="nd2" onblur="lo(this);" onfocus="fo(this);" id="nam" name="nam" style="width:40px;">
            <span>Giờ:</span>
            <input type="text" value="<?php echo $info_lognv["giotao"];?>" class="nd2" onblur="lo(this);" onfocus="fo(this);" id="giotao" name="giotao" style="width:80px;">
            </td>
            </tr>
     </table>
     <?php
     if($_SESSION["user_login"]["role_id"]!=12)
     {
     ?>
     Nhân viên:
        <select name="nhanvien_id" id="nhanvien_id" required>
        <option value="">-- Chọn nhân viên -- </option>
     <?php
        $rst_group = $dbf->getDynamic("nhanvien", "status=1", "title asc");
        $toal_group = $dbf->totalRows($rst_group);
        if ($toal_group > 0) {
          while ($rows_group = $dbf->nextdata($rst_group)) {
            $id_group = $rows_group['id'];
            $title_group = $rows_group['title'];
            echo '<option '.(($info_lognv["nhanvien_id"]==$id_group)?"selected":"").' value="'.$id_group.'">' . $title_group . '</option>';
          }
        }
     ?>
     </select>
     <?php } else { ?>
     Nhân viên:<span><b><?php echo $infonhanvien["title"];?></b></span>
             <input name="nhanvien_id" required type="hidden" value="<?php echo $nhanvien_id_login; ?>"/>
     <?php }?>
     Nơi giao: <input name="title" required type="text" value="<?php echo $info_lognv["title"]; ?>" style="width:200px" />
     Km: <input name="km" id="km" required type="text" value="<?php echo $info_lognv["km"]; ?>" style="width:50px" onkeypress="return nhapso(event,'km')" />
     Tiền Chành: <input name="price" id="price" type="text" value="<?php echo $info_lognv["price"]; ?>" style="width:100px"  onkeypress="return nhapso(event,'price')" />
     <br />
     Ghi chú:  <input name="note" type="text" value="<?php echo $info_lognv["note"]; ?>" style="width:200px" /><br />
     <input type="submit" name="cmdcapnhatlog" value="Cập nhật" />
</fieldset>
  <script>
      $("#panelAction").css({"height":"30px"});
  </script>
<?php
}
else
{
?>
<?php if(isset($_GET["insert"]))  { ?>
<h1 style="color: red; font-size: 16px">Thêm chi phí phát sinh</h1>
<fieldset>
    <legend style="color: #000080"><b>Thông tin</b></legend>
    <?php
    if(isset($msg) && $msg !='')
    {
       echo "<div style='color:red'>".$msg."</div>";
    }
    ?>
    <table>
        <tr>
            <td class="boxGrey">Ngày</td>
            <td class="boxGrey2">
            <input type="text" value="<?php echo $ngay;?>" class="nd2" onblur="lo(this);" onfocus="fo(this);" id="ngay" name="ngay" style="width:40px;"> /
            <input type="text" value="<?php echo $thang;?>" class="nd2" onblur="lo(this);" onfocus="fo(this);" id="thang" name="thang" style="width:40px;">/
            <input type="text" value="<?php echo $nam;?>" class="nd2" onblur="lo(this);" onfocus="fo(this);" id="nam" name="nam" style="width:40px;">
            <span>Giờ:</span>
            <input type="text" value="<?php echo $giotao;?>" class="nd2" onblur="lo(this);" onfocus="fo(this);" id="giotao" name="giotao" style="width:80px;">
            </td>
            </tr>
     </table>
     <?php
     if($_SESSION["user_login"]["role_id"]!=12)
     {
     ?>
     Nhân viên:
        <select name="nhanvien_id" id="nhanvien_id" required>
        <option value="">-- Chọn nhân viên -- </option>
     <?php
        $rst_group = $dbf->getDynamic("nhanvien", "status=1", "title asc");
        $toal_group = $dbf->totalRows($rst_group);
        if ($toal_group > 0) {
          while ($rows_group = $dbf->nextdata($rst_group)) {
            $id_group = $rows_group['id'];
            $title_group = $rows_group['title'];
            echo '<option '.(($nhanvien_id==$id_group)?"selected":"").' value="'.$id_group.'">' . $title_group . '</option>';
          }
        }
     ?>
     </select>
     <?php } else { ?>
     Nhân viên:<span><b><?php echo $infonhanvien["title"];?></b></span>
             <input name="nhanvien_id" required type="hidden" value="<?php echo $nhanvien_id_login; ?>"/>
     <?php }?>
     Nơi giao:  <input name="title" type="text" value="<?php echo $title; ?>" style="width:200px" required />
     Km: <input name="km" id="km" type="text" required value="<?php echo $km; ?>" style="width:50px" onkeypress="return nhapso(event,'km')" />
     Tiền chành: <input name="price" id="price" type="text" value="<?php echo $price; ?>" style="width:100px"  onkeypress="return nhapso(event,'price')" />
     <br />
     Ghi chú:  <input name="note" type="text" value="<?php echo $note; ?>" style="width:200px" />
     <br />
     <input type="submit" name="cmdthemlog" value="Thêm Mới phát sinh"  style="margin-left: 100px; background: red; color: #fff; border: 1px solid #ccc"/>
</fieldset>
  <script>
      $("#panelAction").css({"height":"30px"});
  </script>
<?php } ?>
<?php
}
}
?>
<table cellspacing="1" cellpadding="1" id="mainTable">
<tbody>
     <tr class="cell2" style="background: red; color: #fff">
        <td colspan="5" align="right"><span id="totalkm"></span></td>
        <td colspan="3" align="left"><span id="totalprice"></span></td>
     </tr>
     <tr class="cell2">
        <td colspan="13"><?php echo $mang[1]?></td>
     </tr>

    <tr class="titleBottom">
    <td class="itemCenter">
        <input type="checkbox" onclick="docheck(this.checked,0);" value="1" id="chkall" name="chkall">
    </td>
    <td class="itemCenter">STT</td>
    <td class="itemText">Nhân viên</td>
    <td class="itemText">Nơi giao</td>
    <td class="itemText">Km</td>
    <td class="itemText">Tiền chành</td>
    <td class="itemText">Ghi chú</td>
    <td class="itemText">Ngày tạo</td>
    </tr>
    <?php
        $array_nhanvien = array();
        $rst_group = $dbf->getDynamic("nhanvien", "status=1", "title asc");
        $toal_group = $dbf->totalRows($rst_group);
        if ($toal_group > 0) {
          while ($rows_group = $dbf->nextdata($rst_group)) {
            $id_group = $rows_group['id'];
            $array_nhanvien[$id_group] = $rows_group;
          }
        }
        $url="/phatsinh.php?";
        if($_SESSION["user_login"]["role_id"]!=12)
        {
            if(isset($_POST["cmdSearch"]))
            {
              $mang[0] = $dbf->getDynamic("phatsinh","".$where."","id desc");
            }else
            {
              $mang = $dbf->paging("phatsinh","".$where."","id desc",$url,$PageNo,$PageSize,$Pagenumber,$ModePaging);
            }
        }else
        {
            $mang = $dbf->paging("phatsinh","".$where." and nhanvien_id=".$nhanvien_id_login."","id desc",$url,$PageNo,$PageSize,$Pagenumber,$ModePaging);
        }
        $rs_hoadon = $mang[0];
        $total_hoadon = $dbf->totalRows($rs_hoadon);
        if($total_hoadon>0)
        {
            $i=1;
            $totalprice = 0;
            $totalkm   = 0;
            while($row_hoadon=$dbf->nextData($rs_hoadon)){
              $id = $row_hoadon['id'];
              $title  = $row_hoadon["title"];
              $price    = $utl->format($row_hoadon["price"]);
              $loai = $row_hoadon["loai"];
              $note = $row_hoadon["note"];
              $datecreated = date("d-m-Y",$row_hoadon["datecreated"]);
              $giotao = $row_hoadon["giotao"];
              $km= $row_hoadon["km"];
              $totalprice+= $row_hoadon["price"];
              $totalkm+=$row_hoadon["km"];
    ?>
    <tr class="<?php echo (($i%2==0)?"cell2":"cell1")?>">
        <td class="itemCenter"><input type="checkbox" class="" style="" onclick="docheckone();" value="<?php echo $id?>" id="chk" name="chk"> </td>
        <td style="width:20px; color:#3F5F7F" class="itemCenter"><?php echo $i?></td>
        <td class="itemText"><a href="phatsinh.php?edit=<?php echo $id?>" id="itemText"><?php echo $array_nhanvien[$row_hoadon['nhanvien_id']]["title"]?></a></td>
        <td class="itemText"><a href="phatsinh.php?edit=<?php echo $id?>" id="itemText"><?php echo $title;?></a></td>
        <td class="itemText"><a href="phatsinh.php?edit=<?php echo $id?>" id="itemText"><?php echo $km;?></a></td>
        <td class="itemText"><a href="phatsinh.php?edit=<?php echo $id?>" id="itemText"><?php echo $price; ?></a><sup>đ</sup></td>
        <td class="itemText"><a href="phatsinh.php?edit=<?php echo $id?>" id="itemText"><?php echo $note;?></a></td>
        <td class="itemText"><a href="phatsinh.php?edit=<?php echo $id?>" id="itemText"><?php echo $datecreated.":".$giotao;?></a></td>
     </tr>
        <?php
          $i++;
        }
        ?>
         <tr class="cell2" style="background: red; color: #fff">
            <td colspan="5" align="right"><b><?php echo $totalkm;?> KM</b></td>
            <td colspan="3" align="left"><b><?php echo $utl->format($totalprice);?></b><sup>đ</sup></td>
         </tr>
         <tr class="cell2">
            <td colspan="13"><?php echo $mang[1]?></td>
         </tr>

         <script>
            var totalkm = "<?php echo $totalkm; ?>";
            var totalprice = "<?php echo $utl->format($totalprice); ?>";
            $("#totalkm").html('<b>'+totalkm+'</b> <sup>KM</sup>');
            $("#totalprice").html('<b>'+totalprice+'</b> <sup>đ</sup>');
            </script>
      <?php
        }
      ?>
    </tbody>
    </table>
    <input type="hidden" value="" id="arrayid" name="arrayid">
    </div>
    <script>
        function formatprice(x) {
            if(isNaN(x))return "";
            n= x.toString().split('.');
            return n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",")+(n.length>1?"."+n[1]:"");
        }
        jQuery("#price").change(function(){
          var price = jQuery("#price").val();
          price = formatprice(price);
          //confirm(price+" vnd ?");
          jQuery(".ms_price").remove();
          jQuery("#price").after( "<span class='ms_price' style='color:red;'>&nbsp;&nbsp;<b>"+price+" </b><sup>đ</sup> ?</span>" );
        })
    </script>