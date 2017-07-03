<?php
        session_start();
        if(empty($_SESSION["user_login"])) {
        session_unregister("user_login");
		echo "<script>window.location.href='login.php'</script>";
        exit;
    	}
        include str_replace('\\','/',dirname(__FILE__)).'/content_spaw/spaw.inc.php';
        include str_replace('\\','/',dirname(__FILE__)).'/class/class.DEFINE.php';
        include str_replace('\\','/',dirname(__FILE__)).'/class/class.HTML.php';
        include str_replace('\\','/',dirname(__FILE__)).'/class/class.JAVASCRIPT.php';
        include str_replace('\\','/',dirname(__FILE__)).'/class/class.UTILITIES.php';
        include str_replace('\\','/',dirname(__FILE__)).'/class/class.CSS.php';
        include str_replace('\\','/',dirname(__FILE__)).'/class/class.SINGLETON_MODEL.php';
        include str_replace('\\','/',dirname(__FILE__)).'/class/simple_html_dom.php';
        include str_replace('\\','/',dirname(__FILE__)).'/class/class.BUSINESSLOGIC.php';
        include str_replace('\\','/',dirname(__FILE__)).'/class/template.php';
    	include str_replace('\\','/',dirname(__FILE__)).'/Cache_Lite/Lite/Function.php';

        $html=SINGLETON_MODEL::getInstance("HTML");
    	$js=SINGLETON_MODEL::getInstance("JAVASCRIPT");
    	$css=SINGLETON_MODEL::getInstance("CSS");
        $utl=SINGLETON_MODEL::getInstance("UTILITIES");
        $dbf=SINGLETON_MODEL::getInstance("BUSINESSLOGIC");
    	$html->docType();

        $setting = $dbf->getInfoColum("setting",1);

if(isset($_GET["id"]) && $_GET["id"]!='' )
{
   $info_hoadon = $dbf->getInfoColum("hoadon",(int)$_GET["id"]);
   //print_r($info_hoadon);
   if($info_hoadon==-1)
   {
     echo "<h1>Hóa Đơn Bị Lỗi. Vui Lòng Xem lại đường dẫn</h1>";
   }else
   {
          $ngay         = $info_hoadon["ngay"];
          $thang        = $info_hoadon["thang"];
          if(strlen($thang)==1)
          {
            $thang="0".$thang;
          }
          $nam          = $info_hoadon["nam"];
          $sohoadon          = $info_hoadon["sohoadon"];
          $fullname_sell     = $info_hoadon["fullname_sell"];
          $khachang_id     = $info_hoadon["khachang_id"];

          $fullname_dv     = $info_hoadon["fullname_dv"];
          $address     = $info_hoadon["address"];
          $mst     = $info_hoadon["mst"];

          $thanhtoan_id     = $info_hoadon["thanhtoan_id"];
          $info_thanhtoan = $dbf->getInfoColum("thanhtoan",$thanhtoan_id);

          $array_hanghoa      = explode("|o0o|",$info_hoadon["array_hanghoa"]);
          $array_donvitinh    = explode("|o0o|",$info_hoadon["array_donvitinh"]);
          $array_soluong      = explode("|o0o|",$info_hoadon["array_soluong"]);
          $array_dongia       = explode("|o0o|",$info_hoadon["array_dongia"]);

          $tax     = $info_hoadon["tax"];
          $tienthueGTGT_thuc  = $info_hoadon["tienthueGTGT"];
          $tongthanhtien_thuc = $info_hoadon["tongsotien"];
          $tienbangchu        = $info_hoadon["tienbangchu"];
          $status =  $info_hoadon["status"];
          $number_field_dichvu = count($array_soluong);
   }
}
?>

<html>
      <head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
      <meta http-equiv='Content-Language' content='en-us' />
      <title>Hóa Đơn Giá Trị Gia Tăng</title>
      <link rel="stylesheet" href="style/inhoadon.css" type="text/css" />
      </head>
      <body>

<div class="div_wraper">
<div class="header">
           <span class="ngay"><?php echo $ngay?></span><span class="thang"><?php echo $thang?></span><span class="nam"><?php echo $nam?> </span>
</div>
<div class="center">

<div class="thongtin">
    <div class="fullname_sell"><?php echo $fullname_sell?></div>
    <div class="fullname_dv"><?php echo $fullname_dv?> </div>
    <div class="mst"><?php echo $mst?> </div>
    <div class="address"> <?php echo $address?></div>
    <div class="thanhtoan"> <?php echo $info_thanhtoan["title"]?> </div>
</div>

<div class="mucsanpham">
    <?php
        $stt=1;
        for ($i = 0; $i <$number_field_dichvu; $i++)
        {
           $congtienhang_thuc+=$array_soluong[$i]*$array_dongia[$i];
           if($array_soluong[$i])
           {

        ?>
          <div class="field_sp" id="field_<?php echo $i?>">
              <div class="stt">0<?php echo $stt?></div>
              <div class="hanghoa"><?php echo $array_hanghoa[$i]?></div>
              <div class="donvitinh"><?php echo $array_donvitinh[$i]?></div>
              <div class="soluong"><?php echo $array_soluong[$i]?></div>
              <div class="dongia"><?php echo $utl->format($array_dongia[$i])?></div>
              <div class="thanhtien"><?php echo $utl->format($array_soluong[$i]*$array_dongia[$i])?> </div>
              <div class="clear"></div>
          </div>
        <?php
            $stt++;
            }
        }
    ?>
</div>

<div class="tongket">

  <div class="tax">
        <?php echo $tax?>
  </div>
  <span id="congtienhang" class="price"><?php echo $utl->format($congtienhang_thuc)." VNĐ"?></span>
  <span id="tienthueGTGT" class="price"><?php echo $utl->format($tienthueGTGT_thuc)." VNĐ"?></span>
  <span id="tongthanhtien" class="price"><?php echo $utl->format($tongthanhtien_thuc)." VNĐ"?></span>
  <div class="tienbangchu">
    <?php echo $tienbangchu?>
  </div>
</div>
</div>

</div>
<div class="clear"></div>
</body></html>