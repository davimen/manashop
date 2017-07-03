<?php
        @session_start();
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


         $isvalue     = true;
         $nhanvien_id = $_GET["nhanvien_id"];
         $price       = $_GET["price"];
         $thang       = $_GET["thang"];
         $int_ngay    = $_GET["int_ngay"];
         $nam         = $_GET["nam"];

    if($nhanvien_id=='')
    {
       $isvalue= false;
       $msg.= "Vui lòng chọn nhân viên <br/>";
    }else
    {
      $info_nhanvien = $dbf->getInfoColum("nhanvien",$nhanvien_id);
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

?>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<link rel="shortcut icon" type="image/x-icon"  href="images/favicon.ico"/>
<link rel="stylesheet"  type="text/css" href="themes/theme_default/style/style.pack.css"/>
<link rel="stylesheet"  type="text/css" href="css/ui.all.css"/>
<link rel="stylesheet"  type="text/css" href="style/jquery.Slidemenu.css"/>
<link rel="stylesheet" href="style/export_detail.css" type="text/css" />

<style type="text/css">
/*<![CDATA[*/
.ngay {
   float:left;
   width: 100px;
   text-align:right;
}
.nghi {
  float:left;
  width: 100px;
  height:15px;
  margin-bottom:5px;
  border:1px solid #000;
  background: red;
  color: #fff;
  text-align: center;
}
.dilam {
  float:left;
  width: 100px;
  height:15px;
  margin-bottom:5px;
  border:1px solid #000;
  background: #0066CC;
  color: #fff;
  text-align: center;
}
.tang
{
    float:left;
    width: 100px;
    height:15px;
    margin-bottom:5px;
    border:1px solid #000;
    background: #FF3399;
    color: #000;
    text-align: center;
}

/*]]>*/
</style>

<div class="swap">

 <div class="panelView" id="panelView">
    <h4><?php echo $setting["title"] ?></h4>
    <?php if($isvalue) {?>
    <center>
            <H1>CHI TIẾT LƯƠNG CỦA <?php echo '"'.$info_nhanvien['title'].'"'; ?></H1>
            <p>Tháng:&nbsp;<?php echo $thang; ?>/<?php echo $_GET['nam'];?></p>

    <?php
       $d="";
       $ca = 0;
       $stt = 1;
       $total_salary=0;
       $price_ca = (int)$price/30;

       for($i=1;$i<=$int_ngay;$i++)
       {
          if($i<10)
          {
            $d= "0".$i;
          }else
          {
            $d = $i;
          }
          $datecreated = $d."-".$thang."-".$nam;
          echo "<div class='ngay'><b>".$datecreated."</b>: </div>";
          $datecreated = strtotime($datecreated);

          $rs_ngaynghi = $dbf->getDynamic("leavelist","FROM_UNIXTIME(datecreated,'%Y-%m-%d') ='".date("Y-m-d",$datecreated)."' and nhanvien_id = ".$nhanvien_id." and status=1","id desc");
          $total_ngaynghi = $dbf->totalRows($rs_ngaynghi);

          if($total_ngaynghi>0)
          {
               $rows_ngaynghi= $dbf->nextdata($rs_ngaynghi);
               $type_id = $rows_ngaynghi['type_id'];

                 if($type_id==1)
                 {
                  $total_salary+= $price_ca;
                  echo "<div class='nghi'> Nghỉ<img src='no.png' width='20' align='absmiddle'> </div>";
                 }
                 else
                 {
                    $total_salary-= $price_ca;
                    echo "<div class='tang'> Làm thêm<img src='check.png' width='20'align='absmiddle'></div>";

                 }
          }
          else
          {
             echo "<div class='dilam'><img src='check.png' alt='' width='20'></div>";
          }
          echo "<div class='clear'></div>";

          $stt++;

    }


    echo "<hr/>";
    if($total_salary < 0)
    {
       $total_salary_c = 0 - ((int)$total_salary);
       echo "<h2>Số tiền cộng thêm là: <span style='color:red'><b>".$utl->format($total_salary_c)." <sup>đ</sup></b></span></h2>";
    }else
    {
      if($total_salary!=0)
      {
      echo "<h2>Số tiền bị trừ là: <span style='color:red'><b>".$utl->format($total_salary)." <sup>đ</sup></b></span></h2>";
      }
    }

    $thang       = $_GET["thang"];
    $int_ngay    = $_GET["int_ngay"];
    $nam         = $_GET["nam"];
    $from_date = $nam."-".$thang."-01";
    $from_to = $nam."-".$thang."-".$int_ngay;

    $from_date = strtotime($from_date);
    $from_to = strtotime($from_to);
    $rs_phatsinh = $dbf->getDynamic("phatsinh","nhanvien_id = ".$nhanvien_id." and FROM_UNIXTIME(datecreated,'%Y-%m-%d') >='".date("Y-m-d",$from_date)."' and FROM_UNIXTIME(datecreated,'%Y-%m-%d') <='".date("Y-m-d",$from_to)."'","id desc");
    $total_phatsinh = $dbf->totalRows($rs_phatsinh);

    if($total_phatsinh>0)
    {
        $totalprice = 0;
        $totalkm   = 0;
        while($row_phatsinh=$dbf->nextData($rs_phatsinh)){

          $totalprice+= $row_phatsinh["price"];
          $totalkm+=$row_phatsinh["km"];
          }


    }
    ?>
    <table cellspacing="1" cellpadding="1" id="mainTable">
    <tbody>
    <tr><td colspan="3"><h1>Chi phí phát sinh</h1></td></tr>
    <tr class="titleBottom">
        <td class="itemCenter">No.</td>
        <td class="itemText">KM</td>
        <td class="itemText">Tiền</td>
    </tr>

    <tr class="cell2">
        <td class="itemCenter">1</td>
        <td class="itemText"><?php echo $totalkm;?></td>
        <td class="itemText"><?php echo $utl->format($totalprice);?></td>
    </tr>

    </tbody>
    </table>

   <?php


    $rs_luong = $dbf->getDynamic("luong","month = ".(int)$thang." and year = ".(int)$nam."  and nhanvien_id = ".$nhanvien_id."","id desc");
    $total_luong = $dbf->totalRows($rs_luong);
    if($total_luong>0)
    {
    ?>

    <table cellspacing="1" cellpadding="1" id="mainTable">
    <tbody>
    <tr class="titleBottom">

    <td class="itemCenter">STT</td>
    <td class="itemText">Nhân viên</td>
    <td class="itemText">Tiền</td>
    <td class="itemText">Tháng/năm</td>
    <td class="itemText">Ghi chú</td>
    <td class="itemText">Ngày tạo</td>

    </tr>
    <?php

            $i=1;
            $total_rice_luong = 0;
            while($row_luong=$dbf->nextData($rs_luong)){
              $id = $row_luong['id'];
              $nhanvien_id_list_luong = $row_luong['nhanvien_id'];
              $price_luong  = $utl->format($row_luong["price"]);
              $month_luong  = $row_luong["month"];
              $year_luong   = $row_luong["year"];
              $note_luong  = $row_luong["title"];
              $datecreated_luong = date("d-m-Y",$row_luong["datecreated"]);
              $total_rice_luong+= $row_luong["price"];


    ?>
    <tr class="<?php echo (($i%2==0)?"cell2":"cell1")?>">

        <td style="width:20px; color:#3F5F7F" class="itemCenter"><?php echo $i?></td>
        <td class="itemText"><?php echo $arraynhanvien[$nhanvien_id_list_luong];?></td>
        <td class="itemText"><?php echo $price_luong;?></td>
        <td class="itemText"><?php echo $month_luong."/".$year_luong;?></td>
        <td class="itemText"><?php echo $note_luong;?></td>
        <td class="itemText"><?php echo $datecreated_luong ?></td>
     </tr>
        <?php
          $i++;
        }
      ?>

    </tbody>
    </table>

   <?php
      echo "<h2>Số tiền được cộng thêm: <span style='color:red'><b>".$utl->format($total_rice_luong)." VNĐ</b></span></h2>";
    }
    echo "<h2>Tiền lương Tháng ".$thang." (".$int_ngay." ngày) của ".$arraynhanvien[$nhanvien_id]." là: <span style='color:red'><b>".$utl->format($price-$total_salary+$total_rice_luong+ $totalprice)." <sup>đ</sup></b></span></h2>";
    ?>



    </center>
    <?php }else { ?>
    <center>
            <H1>CHI TIẾT LƯƠNG CỦA <?php echo $info_nhanvien['title'] ?></H1>
            <p><?php echo $msg;?></p>
    </center>
    <?php } ?>
 </div>
</div>