<?php

/** Error reporting */
error_reporting(0);
session_start();
if(empty($_SESSION["user_login"])) {
        session_unregister("user_login");
		echo "<script>window.location.href='login.php'</script>";
        exit;
}

$table = $_GET["table"];

switch ($table) {
      case 'mathang_category' :
        include ("export_nhomhang.php");
        break;     
      case 'mathang' :
        include ("export_mathang.php");
		break; 
    }

?>