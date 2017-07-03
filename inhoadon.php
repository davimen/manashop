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

        $setting = $dbf->getInfoColum("setting",42);


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
          $nam          = $info_hoadon["nam"];
          $giotao          = $info_hoadon["giotao"];
          $sohoadon          = $info_hoadon["sohoadon"];
          $fullname_sell     = $info_hoadon["fullname_sell"];
          $khachang_id     = $info_hoadon["khachang_id"];

          $fullname_dv     = $info_hoadon["fullname_dv"];
          $address     = $info_hoadon["address"];
          $mst     = $info_hoadon["mst"];

          $thanhtoan_id     = $info_hoadon["thanhtoan_id"];
          $datcoc     = $info_hoadon["datcoc"];
          $info_thanhtoan   = $dbf->getInfoColum("thanhtoan",$thanhtoan_id);

          $nhanvien_id      = $info_hoadon["nhanvien_id"];
          //$nhanvien_quay_id = $info_hoadon["nhanvien_quay_id"];
          if($nhanvien_id)
          {
            $info_nhanvien = $dbf->getInfoColum("nhanvien",$nhanvien_id);
             $n_lapphieu =  $info_nhanvien["title"];
          }else
          {
              $n_lapphieu = "Việt Thái";
          }

          $array_mathang_id      = explode("|o0o|",$info_hoadon["array_mathang_id"]);
          $array_item_code      = explode("|o0o|",$info_hoadon["array_item_code"]);

          $array_hanghoa      = explode("|o0o|",$info_hoadon["array_hanghoa"]);
          $array_donvitinh    = explode("|o0o|",$info_hoadon["array_donvitinh"]);
          $array_soluong      = explode("|o0o|",$info_hoadon["array_soluong"]);
          $array_dongia       = explode("|o0o|",$info_hoadon["array_dongia"]);
          $array_giamgia      = explode("|o0o|",$info_hoadon["array_giamgia"]);
          $array_ghichu       = explode("|o0o|",$info_hoadon["array_ghichu"]);

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
      <link rel="stylesheet" href="style/inhoadon.css" type="text/css" />
      </head>
      <body>

<div class="div_wraper">
<div class="header">
    <div style="float:left; width:250px;"> 
    <image src="style/images/logo.png"> 
    </div>
	<div style="float:left; text-align:center;width:450px;padding-top: 20px"> 
		<h1 style="padding: 0px; margin: 0px;"><b><?=$setting['title']?></b></h1>
		<p style="padding: 0px; margin: 0px;"><b><?=$setting['address']?></b> 
		<br /><b>Tel:<?=$setting['phone']?></b></p>		
    </div> 
	<div style="clear:both;"></div>
</div>

<div class="center">
    <h1 class="title_hoadon">HÓA ĐƠN BÁN HÀNG</h1>
	<div style="float:left">Ngày:<?=$ngay."/".$thang."/20".$nam?>&nbsp;<?=$giotao?></div>
	<div style="float:right">
	Số phiếu: <span style="font: 18px;font-weight: bold"><?=$sohoadon?> </span><br/>
	</div>
<table cellspacing="1" cellpadding="1" class="mainForm" id="mainForm">
<tbody>

<td colspan="2" style="padding: 10px 0px 10px">
    <table class="table_dichvu" cellpadding="0" cellspacing="0" border="0">
        <?php
            $stt=1;
            $contiengiamgia=0;
			?>
			<tr class="th_header">
			    <td style="text-align: left" width='40'>STT</td>
				<td style="text-align: left" width='75'>Mã Hàng</td>
                <td style="text-align: left" width='75'>Tên Hàng</td>
                <td style="text-align: center" width='8'>Số Lượng</td>
                <td style="text-align: center" width='12'>Đơn Vị</td>
				<td style="text-align: center" width='50'>Đơn Giá</td>
                <td style="text-align: center" width='50' >Thành Tiền</td>
              </tr>
			<?php
            for ($i = 0; $i <$number_field_dichvu; $i++)
            {
               $congtienhang_thuc+=$array_soluong[$i]*$array_dongia[$i];
               $contiengiamgia+= $array_giamgia[$i] * $array_soluong[$i];
               if($array_soluong[$i])
               {

                $price_pecent = ($info_thanhtoan["pecent"]* (($array_soluong[$i]*$array_dongia[$i])- ($array_giamgia[$i]*$array_soluong[$i])))/100;

                $thanhtien_item = $price_pecent + (($array_soluong[$i]*$array_dongia[$i])- ($array_giamgia[$i]*$array_soluong[$i]));
            ?>
               <tr id="field_<?=$i?>">
			    <td style="text-align: left"><?=($i+1);?></td>
                <td style="text-align: left" width='75'><?=$array_item_code[$i]?></td>				
                <td style="text-align: left" width='75'><?=$array_hanghoa[$i]?></td>
                <td style="text-align: center" width='8'><?=$array_soluong[$i]?></td>
                <td style="text-align: center" width='12'><?=$array_donvitinh[$i]?></td>
				<td style="text-align: center" width='50'><?=$utl->format($thanhtien_item/$array_soluong[$i])?></td>
                <td style="text-align: center" width='50' ><?=$utl->format($thanhtien_item)?></td>
              </tr>
            <?
                $stt++;
                }
            }
        ?>

            <tr>
                <td style="border-top: 2px dotted #000;">Tổng cộng:</td><td colspan="6" align="right" style="border-top: 2px dotted #000; padding-right: 50px"><b><?=$utl->format($tongthanhtien_thuc)?></b></td>
            </tr>

            <?php if((int)$datcoc!=0){
              ?>
               <tr>
                <td>Đưa trước</td><td colspan="5" align="center"><b><?=$utl->format($datcoc)?></b></td>
               </tr>
               <tr>
                <td>Còn lại</td><td colspan="5" align="center"><b><?=$utl->format($tongthanhtien_thuc-$datcoc)?></b></td>
               </tr>
              <?php
            }
            ?>

    </table>
</td>
</tr>


</tbody>
</table>

<h2><center>Xin cảm ơn Quý khách !</center></h2>
<h3 style="float:left; padding:0px 50px; 50px;">Khách hàng <br><span style="font-weight:normal;">(Ký, họ tên)</span></h3>
<h3 style="float:right; padding:0px 50px; 50px;">Người Lập <br><span style="font-weight:normal;">(Ký, họ tên)</span></h3>
<div style="clear:both"></div>

</div>
</div>
<div class="clear"></div>
</body></html>