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
        $ngay = strtotime($_GET['ngay']);
        $denngay = strtotime($_GET['denngay']);

?>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<link rel="shortcut icon" type="image/x-icon"  href="images/favicon.ico"/>
<link rel="stylesheet"  type="text/css" href="themes/theme_default/style/style.pack.css"/>
<link rel="stylesheet"  type="text/css" href="css/ui.all.css"/>
<link rel="stylesheet"  type="text/css" href="style/jquery.Slidemenu.css"/>
<link rel="stylesheet" href="style/export_detail.css" type="text/css" />
<div class="swap">

<div class="panelView" id="panelView">
    <h4><?php echo $setting["title"] ?></h4>
    <center>
            <H1>CHI TIẾT LOG DOANH THU</H1>
            <p>Ngày:&nbsp;<?php echo $_GET['ngay']; ?> - Đến ngày:&nbsp;<?php echo $_GET['denngay']; ?></p>
    </center>
<table cellspacing="1" cellpadding="1" id="mainTable" style="width: 100%">
<tbody>
    <tr class="titleBottom">
    <td class="itemText">STT</td>
    <td class="itemText">Nội dung</td>
    <td class="itemCenter">Ngày ghi </td>
    </tr>
    <?php

        $rs_hoadon=$dbf->getDynamic("log_doanhthu","datecreated >= ".$ngay." and datecreated <= ".$denngay."","id desc");
        $total_hoadon = $dbf->totalRows($rs_hoadon);
        if($total_hoadon>0)
        {
            $number_row=1;
            $i=1;
            $tongsotienthongke = 0;
            while($row_hoadon=$dbf->nextData($rs_hoadon)){
              $id = $row_hoadon['id'];
              $content_log = $row_hoadon['content_log'];
              $datecreated = date('d-m-Y',$row_hoadon['datecreated']);
              $thoigian = $row_hoadon['thoigian'];
    ?>
              <tr class="<?php echo (($i%2==0)?"cell2":"cell1")?>">
                  <td style="width:20px; color:#3F5F7F" class="itemCenter"><?php echo $number_row?></td>
                  <td class="itemText"><?php echo $content_log;?></td>
                  <td class="itemText"><?php echo $datecreated?> vào lúc <?php echo $thoigian?></td>
              </tr>


        <?php
            $i++;
            $number_row ++;
        }//end if
        }//end while
        ?>

    </tbody>
    </table>

    </div>
</div>