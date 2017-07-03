<?php
//ob_start();
session_start();
    include str_replace('\\','/',dirname(__FILE__)).'/class/class.DEFINE.php';
	include str_replace('\\','/',dirname(__FILE__)).'/class/class.DBFUNCTION.php';
	include str_replace('\\','/',dirname(__FILE__)).'/class/class.SINGLETON_MODEL.php';
	$dbf=SINGLETON_MODEL :: getInstance("DBFUNCTION");

if(!empty($_SESSION["user_login"])) {
	session_destroy();
	unset($_SESSION["user_login"]);
	echo "<script>window.location.href='login.php'</script>";
		
}
else
{
    //header( "Location: login.php" );
    echo "<script>window.location.href='login.php'</script>";
}
//ob_end_flush();

?>