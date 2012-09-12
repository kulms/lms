<?
session_start();
$session_id = session_id();
//require("online.php");
//		print($slogin."  here");
//		exit();
if($slogin != ""){
        $db="maxlearn";
        $email_host="nontri.ku.ac.th";
        $dbname="maxlearn";
        $path="course";
        // $realpath="/home/maxlearn/course";
		$realpath="D:\\Maxlearn\\course";
        // $conn=mysql_pconnect('localhost','maxlearn','max');
		$conn=@mysql_pconnect('localhost','root','root');
        mysql_select_db($db);

        if($oldsystem==1){
                  // $check=mysql_query("SELECT * FROM users WHERE login='".$slogin."' AND STRCMP(password,'".$spassword."')=0 AND active=1;");
				   $check=mysql_query("SELECT * FROM users WHERE login='".$slogin."' AND STRCMP(password,'".$spassword."')=0 AND active=1;");
        }else{
                   $check=mysql_query("SELECT * FROM users WHERE login='".$slogin."' AND password=MD5('".$spassword."') AND active=1;");
                 }
        $person=mysql_fetch_array($check);
         // require($realpath."/lang/english.inc.php");
		  require($realpath."\\lang\\english.inc.php");
        //online($session_id,time(),$session_id,$person["category"]);
} else {
?><meta http-equiv="refresh" content="0;url=http://<?php echo getenv("SERVER_NAME"); ?>/course/course/include/session_timeout.php"><?
}
?>