<?php
ob_start("zlib output compression");
session_start();
error_reporting(0);
if (empty($_SESSION["user_login"])) {
  session_unregister("user_login");
  echo "<script>window.location.href='login.php'</script>";
  exit;
}
include str_replace('\\', '/', dirname(__FILE__)) . '/content_spaw/spaw.inc.php';
include str_replace('\\', '/', dirname(__FILE__)) . '/class/class.DEFINE.php';
include str_replace('\\', '/', dirname(__FILE__)) . '/class/class.HTML.php';
include str_replace('\\', '/', dirname(__FILE__)) . '/class/class.JAVASCRIPT.php';
include str_replace('\\', '/', dirname(__FILE__)) . '/class/class.UTILITIES.php';
include str_replace('\\', '/', dirname(__FILE__)) . '/class/class.CSS.php';
include str_replace('\\', '/', dirname(__FILE__)) . '/class/class.SINGLETON_MODEL.php';
include str_replace('\\', '/', dirname(__FILE__)) . '/class/simple_html_dom.php';
include str_replace('\\', '/', dirname(__FILE__)) . '/class/class.BUSINESSLOGIC.php';
include str_replace('\\', '/', dirname(__FILE__)) . '/class/template.php';
include str_replace('\\', '/', dirname(__FILE__)) . '/Cache_Lite/Lite/Function.php';
$html = SINGLETON_MODEL::getInstance("HTML");
$js = SINGLETON_MODEL::getInstance("JAVASCRIPT");
$css = SINGLETON_MODEL::getInstance("CSS");
$utl = SINGLETON_MODEL::getInstance("UTILITIES");
$dbf = SINGLETON_MODEL::getInstance("BUSINESSLOGIC");
$html->docType();
$id = $_GET["edit"];
if ((int) $id) {
  $info_hoadon = $dbf->getInfoColum("hoadon", (int) $id);
  $thanhtoan_id = $info_hoadon["thanhtoan_id"];
}
//print_r($info_hoadon);
?>

<link rel="stylesheet"  type="text/css" href="themes/theme_default/style/style.pack.css"/>

<link rel="stylesheet"  type="text/css" href="css/ui.all.css"/>
<script language="JavaScript" src="js/adminLib.js" type="text/javascript"></script>
<script language="JavaScript" src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script>
       function chonthanhtoan(id){
           if(id==8) {
             $(".div_datcoc").show();
           }else
           {
              $("#datcoc").val(0);
              $(".div_datcoc").hide();
           }
        }
    </script>


<table width="100%" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td class="boxRedInside" colspan="5"><div class="boxRedInside">Sửa hình thức thanh toán</div></td></tr></tbody></table>

<div class="panelAction" id="panelAction" style="height:100px">

       <?php
       if (isset($_POST["cmdSuathanhtoan"])) {
         $id_hoadon    = $_POST["id_hoadon"];
         $thanhtoan_id = $_POST["thanhtoan_id"];
         $datcoc       = (int)$_POST["datcoc"];
         $ngay         = date('d');
         $thang        = date('m');
         $nam          = date('y');
         if (($thanhtoan_id == 5 && $info_hoadon["thanhtoan_id"] == 6) || ($thanhtoan_id == 5 && $info_hoadon["thanhtoan_id"] == 8) || ($thanhtoan_id == 5 && $info_hoadon["thanhtoan_id"] == 11) || ($thanhtoan_id == 11 && $info_hoadon["thanhtoan_id"] == 6) || ($thanhtoan_id == 11 && $info_hoadon["thanhtoan_id"] == 8))
         {
           $dateupdated = strtotime($nam . "-" . $thang . "-" . $ngay);
         }
         else {
           $dateupdated = $info_hoadon["dateupdated"];
         }

          if($thanhtoan_id!=8)
         {
            $arrayUpdate = array("thanhtoan_id" => $thanhtoan_id, "dateupdated" => $dateupdated);
         }else
         {
            $arrayUpdate = array("thanhtoan_id" => $thanhtoan_id,"datcoc"=>$datcoc, "dateupdated" => $dateupdated);
         }

         if ($dbf->updateTable("hoadon", $arrayUpdate , "id = " . $id_hoadon)) {
           $info_thanhtoan = $dbf->getInfoColum("thanhtoan", (int) $thanhtoan_id);
           echo "<div style='color:red'><b>Cập nhật thành công</b></div>";
           ?>

                <script language="JavaScript" type="text/javascript">

                /*<![CDATA[*/

                //alert('Cập nhật thành công');

               // parent.window.location.reload();

               // parent.document.forms["frm"].submit();

               // parent.$.fancybox.close();

                  parent.document.getElementById("tt_<?php echo $id_hoadon ?>").innerHTML="<?php echo $info_thanhtoan['title'] ?>";

                /*]]>*/

                </script>

               <?php
             }
             else {
               echo "<div style='color:red'><b>Cập nhật thất bại. Vui lòng thực hiện lại</b></div>";
             }
           }
           ?>

       HT thanh toán: Khách hàng : <b><?php echo $info_hoadon["fullname_dv"] ?></b>

       <form name="frmthanhtoan" action="" method="post">

       <select name="thanhtoan_id" id="thanhtoan_id" style="width:100px;" onchange="chonthanhtoan(this.value)">

        <?php
        $rst_thanhtoan = $dbf->getDynamic("thanhtoan", "status=1", "id asc");
        $toal_thanhtoan = $dbf->totalRows($rst_thanhtoan);
        if ($toal_thanhtoan > 0) {
          while ($rows_thanhtoan = $dbf->nextdata($rst_thanhtoan)) {
            $id = $rows_thanhtoan['id'];
            $title = stripcslashes($rows_thanhtoan['title']);
            echo '<option ' . (($id == $thanhtoan_id) ? "selected" : "") . ' value="' . $id . '">' . $title . '</option>';
          }
        }
        ?>

       </select>
       <div class="div_datcoc" style="display: <?= (($thanhtoan_id == 8) ? "block" : "none") ?>">
         <input onkeypress="return nhapso(event,'datcoc')" type="text" name="datcoc" id="datcoc" value="<?php echo $info_hoadon["datcoc"]; ?>" /> <sup>đ</sup>
       </div>
       <input type="hidden" name="id_hoadon" id="id_hoadon" value="<?php echo $info_hoadon["id"]; ?>">

       <input type="submit" name="cmdSuathanhtoan" id="cmdSuathanhtoan" value="Sửa" />

       </form>
</div>