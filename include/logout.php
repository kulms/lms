<?php
session_start();
$session_id = session_id();
session_destroy();
//require("../include/global.php");
//require("../include/online.php");
//Logout($session_id);
//online($session_id,time(),$session_id,0,0);
//online_courses($session_id,0,0,time(),0);
header("Location: ../login1/ilogins.php");
?>

