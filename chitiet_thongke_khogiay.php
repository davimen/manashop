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

        if($khogiay_id!='')
        {
           $khogiay = $dbf->getInfoColum("khogiay_category",$khogiay_id);
           $namekhogiay = $khogiay["title"];
        }else
        {
           $namekhogiay = 'Tất cả';
        }
       
?>
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
<link rel="shortcut icon" type="image/x-icon"  href="images/favicon.ico"/>
<link rel="stylesheet"  type="text/css" href="themes/theme_default/style/style.pack.css"/>
<link rel="stylesheet"  type="text/css" href="css/ui.all.css"/>
<link rel="stylesheet"  type="text/css" href="style/jquery.Slidemenu.css"/>
<link rel="stylesheet" href="style/export_detail.css" type="text/css" />
<div class="swap">

<div class="panelView" id="panelView">
    <h4><?php echo $setting["title"] ?></h4>
    <center>
            <H1>THỐNG KÊ THEO KHỔ GIẤY</H1>
            <p style="padding: 0px; margin: 0px;">Từ ngày:&nbsp;<?php echo $_GET['tungay']; ?>&nbsp;&nbsp; Đến ngày:&nbsp;<?php echo $_GET['denngay'];?></p>
    </center>
<h3 style="padding: 0px; margin: 0px 0px 5px; text-align: left">Khổ giấy:<?php echo $namekhogiay;?></h3>
<table cellspacing="1" cellpadding="1" id="mainTable" style="width: 100%">
 <?php
            if($khogiay_id!='')
            {
               $rst_khogiay=$dbf->getDynamic("khogiay_category","id = ".(int)$khogiay_id." and status=1","id asc");
            }else
            {
              $rst_khogiay=$dbf->getDynamic("khogiay_category","status=1","id asc");
            }
            $toal_khogiay = $dbf->totalRows($rst_khogiay);

            if($toal_khogiay >0)
            {


              while($rows_khogiay= $dbf->nextdata($rst_khogiay))
              {
                 $id_khogiay    = $rows_khogiay['id'];
                 $title_khogiay = stripcslashes($rows_khogiay['title']);




 ?>
<tbody>
    <tr class="cell1">
        <td colspan="5"><h2 style="text-align: left">Khổ Giấy:<i><?php echo $title_khogiay ?></i>&nbsp;<a target="_blank" href="mngMain.php?table_name=log_khogiay&khogiay_id=<?php echo $id_khogiay;?>">=>Click xem chi tiết</a></h2> </td>
    </tr>
    <tr class="titleBottom">
        <td class="itemText">STT</td>
        <td class="itemText">Khổ giấy</td>
        <td class="itemText">Diện tích (Cm2)</td>
        <td class="itemText">Ngày nhập</td>
        <td class="itemCenter">Ghi chú</td>
    </tr>
    <?php

        $rs_kg=$dbf->getDynamic("khogiay","datecreated >= ".$tungay." and datecreated <= ".$denngay." and khogiay_id='".$id_khogiay."' and status=1","id desc ");
        $total_kh = $dbf->totalRows($rs_kg);
        if($total_kh>0)
        {
            $number_row=1;
            $tongsoluong = 0;
            while($row_kg=$dbf->nextData($rs_kg)){
              $id           = $row_kg['id'];
              $title        = $row_kg['title'];
              $quantity     = stripcslashes($row_kg['quantity']);
              $note         = stripcslashes($row_kg['note']);
              $datecreated  = stripcslashes($row_kg['datecreated']);
              $tongsoluong+=$quantity;

    ?>
    <tr class="<?php echo (($i%2==0)?"cell2":"cell1")?>">

    <td style="width:20px; color:#3F5F7F" class="itemCenter"><?php echo $number_row?></td>
    <td class="itemText"><?php echo $title?></td>
    <td class="itemText"><?php echo $utl->format($quantity)?></td>
    <td class="itemText"><?php echo date('d-m-Y',$datecreated)?></td>
    <td class="itemText"><?php echo $note?></td>

    </tr>

        <?php
          $number_row++;
        }
      ?>
       <tr class="cell2">
        <td colspan="3" style="text-align: right"> Tổng số lượng (Cm2): <b style="color: red"><?php echo $utl->format($tongsoluong)?></b></td>
        <td colspan="1" style="text-align: "> Đã dùng:
        <?php
        // lay so luong
        $rs_logkg=$dbf->getDynamic("log_khogiay","datecreated >= ".$tungay." and datecreated <= ".$denngay." and khogiay_id='".$id_khogiay."'","id desc ");
        $total_logkg = $dbf->totalRows($rs_logkg);

        if($total_logkg>0)
        {
            $tongdientich = 0;
            while($row_logkg=$dbf->nextData($rs_logkg))
            {
              $dientich      = $row_logkg['dientich'];
              $tongdientich+=($dientich);
            }

         $conlai = $tongsoluong - $tongdientich;
        ?>
         <b style="color: red"><?php echo $utl->format($tongdientich);?></b>
        <?php
        }else
        {
          $conlai = $tongsoluong;
          ?>
           <b style="color: red">0</b>
          <?php
        }


        ?>
        </td>
        <td colspan="1" style="text-align: left"> Còn lại:<b style="color: red;"><?php echo $utl->format($conlai);?></b></td>
       </tr>
      <?php
      }else
      {
        echo "<tr class='cell2'><td colspan='5'><h3 style='text-align:left'> =>Không có dữ liệu</h3></td></tr>";
      }
    ?>
    </tbody>

    <?php
            }
            }// end if nhan vien
    ?>

    </table>
    <input type="hidden" value="" id="arrayid" name="arrayid">
    </div>
</div>