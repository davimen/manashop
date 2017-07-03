<?php
    @ session_start();
    if (empty($_SESSION["user_login"])) {
      unset($_SESSION["user_login"]);
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

?>
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
<?php
 $token = rand(100000,999999);

 $page = ($_GET["page"]);
 $tungay = ($_GET["tungay"]);
 $denngay = ($_GET["denngay"]);
 $khachhang_id = $_GET["khachhang_id"];
 $rad_name = $_GET["rad_name"];

 if($khachhang_id!="")
 {
     $khachhang = $dbf->getInfoColum("khachang",$khachhang_id);
     $email = $khachhang["email"];
     $hovaten_khachhang = $khachhang["title"];
 }


 $url = "http://".$_SERVER["HTTP_HOST"]."/".$page."?tungay=".$tungay."&denngay=".$denngay."&khachhang_id=".$khachhang_id."&rad_name=".$rad_name."&token=".$token;

 if(isset($_POST['cmdsendmail']) && $_POST['cmdsendmail']!='' )

 {

   $msg="";
   $email = $_POST['email'];
   $subject = stripcslashes($_POST['subject']);
   $noidung = stripcslashes($_POST['noidung']);
   $token_post = stripcslashes($_POST['token']);
   $isvalue = true;

   if($email=='')
   {

      $msg.= "Vui lòng nhập mail người nhận";
      $isvalue = false;
   }

   if($subject=='')
   {

      $msg.= "Vui lòng nhập tiêu đề mail";
      $isvalue = false;
   }

   if($noidung=='')
   {
      $msg.= "Vui lòng nhập nội dung mail";
      $isvalue = false;
   }

   if($isvalue)

   {

      include("class.phpmailer.php");
       $arraySMTPSERVER=array("host"=>"mail.giaiphaptoiuu.net","user"=>"info@giaiphaptoiuu.net","password"=>"H0eq8fIC","from"=>"http://giaiphapthongminh.net");

      //khoi tao website
      $mail = new PHPMailer();
      $SMTP_Host = $arraySMTPSERVER["host"];
      $SMTP_Port = 25;


      //******************************************************************************/
      $SMTP_UserName = $arraySMTPSERVER["user"];
      $SMTP_Password = $arraySMTPSERVER["password"];
      $from = $SMTP_UserName;
      $fromName = "VIỆT THÁI";



      $to = $email;
      $mail->IsSMTP();
      $mail->Host     = $SMTP_Host;
      $mail->SMTPAuth = true;
      $mail->Username = $SMTP_UserName;
      $mail->Password = $SMTP_Password;
      $mail->From     = $from;
      $mail->FromName = $fromName;
      $mail->AddAddress($to);
      $mail->AddReplyTo($from, $fromName);


      $mail->WordWrap = 50;
      $mail->IsHTML(true);
      $mail->Subject  =  $subject;
      $mail->Body     =  $noidung;



       $mail->AltBody  =  "This is the text-only body";
       if(!$mail->Send())	{
           $msg.= "Gửi mail bị lỗi. Xin vui lòng thực hiện lại";
           $arraySendmail = array("status"=>"Thất bại","khachhang"=>$subject,"email"=>$email,"content"=>$noidung,"token"=>$token_post,"datecreated"=>time());
           $affect = $dbf->insertTable("sendkhachhang", $arraySendmail);
       }
       else
       {

            $msg.= "Gửi mail thành công";
            //insert database
            $arraySendmail = array("status"=>"Thành công","khachhang"=>$subject,"email"=>$email,"content"=>$noidung,"token"=>$token_post,"datecreated"=>time());
            $affect = $dbf->insertTable("sendkhachhang", $arraySendmail);
       }
   }
 }

?>



<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">

tinyMCE.init({

		// General options

		mode : "textareas",

		theme : "simple"

	});

</script>



<div style="width:780px; height: 580px; overflow-y:hidden; overflow-x:hidden; position: relative ">

<div style="height: auto; padding: 0px 10px 0px;">

<form name="frmsendmail" id="frmsendmail" action="" method="post">

  <div style="color: red; padding: 5px 0px 5px; min-height: 30px;"><?php echo $msg; ?></div>

  <p>
        <label style="float: left; width:100px">Email:</label>
        <input type="email" name="email" value="<?=$email?>" required />
        <input type="hidden" value="<?=$token?>" name="token" />
  </p>



 <label style="float: left; width:100px">Tiêu đề: </label><input type="text" class="validate[required]" name="subject" id="subject" style="width:600px;" value="<?php echo $title;?>" required>

 <h3>Nội dụng</h3>

 <textarea class="validate[required]" id="noidung" name="noidung" style=" width:770px; height: 340px; font-size: 12px">
    <h1>Dear <?php echo (($hovaten_khachhang!="")?$hovaten_khachhang:"Khách Hàng");?>, </h1>
    Click vào link này để xem nội dung: <br>
    <p><?=$url?></p>
 </textarea>

 <div style="text-align: center; padding: 10px 0px 0px; margin: 0px;">
    <input type="submit" name="cmdsendmail" id="cmdsendmail" value="Sendmail" />
 </div>

</form>
</div>
</div>