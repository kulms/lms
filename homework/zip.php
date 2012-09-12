<?php 
session_start();
require ("../include/global_login.php");
require("../include/online.php");
require_once ("./classes/User.php");
require_once ("./classes/UserStorage.php");
require_once( "./includes/main_functions.php" );
require_once('pclzip.lib.php');
	
$user = UserStorage::lookupById($person["login"]);

session_register( 'user' ); 

//online_courses($session_id,$person["id"],$courses,time(),1);

switch ($user->getCategory()) {
    case 0:
        $uistyle = "admin";
		$id = $modules;	
        break;
    case 1:
        $uistyle = "admin";
		$id = $modules;	
        break;
    case 2:
        $uistyle = "teacher";
		$id = $modules;	
        break;
	case 3:
        $uistyle = "student";
		$id = $modules;	
		break;
	default:
        $uistyle = "guest";
		$id = $modules;	
	}

	

//require "./style/$uistyle/header.php";
//require "./style/$uistyle/footer.php";	

$filezip=$person['id']."_".$hw_id;
//$list=$realpath."/files/homework/ansfiles/".$hw_id."/";
$list="/data/httpd_course/files/homework/ansfiles/".$hw_id."/";

//echo $list;
//$v_list = $archive->add($filename,PCLZIP_OPT_ADD_PATH, 'Data', PCLZIP_OPT_REMOVE_PATH, $allpath);

$destinationPath="/data/httpd_course/files/homework/zipfiles/";
//if(!(@opendir($allpath))) mkdir ("$allpath", 0777);
$archive = new PclZip($destinationPath.$filezip.".zip");
$list = $archive->add($list,
                            PCLZIP_OPT_REMOVE_PATH, "/data/httpd_course/files/homework/ansfiles");

$v_list = $archive->create($list);

//$archive = new PclZip($filezip.'.zip');
//$v_list = $archive->add($list,PCLZIP_OPT_ADD_PATH, '', PCLZIP_OPT_REMOVE_PATH, $allpath);
//$v_list = $archive->add($list);

//copy($filezip.".zip", $realpath."/homework/ansfiles/".$filezip.".zip");

//header('Content-type: application/zip');
//header('Content-Disposition: attachment; filename="filezip.zip"');
//readfile($filezip.".zip");

//unlink($filezip.".zip"); 
require "./style/$uistyle/header.php";
require "./style/$uistyle/footer.php";	

?>
<LINK REL=STYLESHEET TYPE="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
<table border="0" cellpadding="2" cellspacing="0" width="100%" class="tdborder2">	
  <tr>
    <td width="16%">Homework Answer : </td>
    <td width="84%"><a href="../download.php?m=hwzip&id=<?php echo $hw_id; ?>&filename=<? echo $filezip.".zip";?>&courses=<?php echo $courses; ?>"><< DOWNLOAD >></a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><label>
      <input type="button" value="<? echo "Back"; ?>" onClick="history.back()" class="button">
    </label></td>
  </tr>
</table>

<? 
/*
session_start();
$session_id = session_id();
require ("../include/global_login.php");
require("../include/online.php");
require_once ("./classes/User.php");
require_once ("./classes/UserStorage.php");
require_once( "./includes/main_functions.php" );
	
$user = UserStorage::lookupById($person["login"]);

session_register( 'user' ); 

//online_courses($session_id,$person["id"],$courses,time(),1);

switch ($user->getCategory()) {
    case 0:
        $uistyle = "admin";
        break;
    case 1:
        $uistyle = "admin";
        break;
    case 2:
        $uistyle = "teacher";
        break;
	case 3:
        $uistyle = "student";
		break;
	default:
        $uistyle = "guest";
	}

require "./style/$uistyle/header.php";
require "./style/$uistyle/footer.php";	   
*/
?>
<?
/*
	$assginfo=mysql_query("SELECT * FROM homework WHERE id=$hw_id;");
	$hwans=mysql_query("SELECT * FROM homework_ans WHERE refid=$hw_id AND modules=$modules ORDER BY time;"); 
*/
?>
<!--14/7/2548
<link href="../themes/<?php echo $theme;?>/style/main.css" rel="stylesheet" type="text/css">
<table  width="100%" cellspacing="1" cellpadding="2" border="0" align="center" class="tdborder2">
  <tr> 
    <td COLSPAN="6">&nbsp; </td>
  </tr>
  <tr  class="boxcolor"> 
    <td align="center"  class="Bcolor"><b>Number</b></td>
    <td align="center" class="Bcolor"><b>ID.</b></td>
    <td align="center" class="Bcolor"><b>Name</b></td>
    <td align="center" class="Bcolor"><b></b></td>   
  </tr>
  <?  	
  $number=1;
  $str_zip = "";
if (mysql_num_rows($hwans) != 0)
{   
	while($row=mysql_fetch_array($hwans))
	{  
	$userinfo=mysql_query("SELECT login,firstname,surname,email FROM users WHERE id=".$row["users"].";"); ?>
	  <tr bgcolor="#FFFFFF"> 
		<td align="center" class="hilite"><b><? echo $number++; ?></b></td>
		<td align="center" class="hilite"><b><a href="mailto:<? echo @mysql_result($userinfo,0,"email");  ?>"><? echo @mysql_result($userinfo,0,"login"); ?></a></b></td>
		<td class="hilite"><b><? echo  @mysql_result($userinfo,0,"firstname")." ".@mysql_result($userinfo,0,"surname"); ?></b></td>
		<td align="center" class="hilite">       
		  <?  
		  
		  if ($row["file"] != "")
		  { 
		  $str_zip .= $realpath."/files/homework/ansfiles/".$hw_id."/".$row["file"]." ";		  
		  ?>
		  <a href="../files/homework/ansfiles/<? echo $hw_id; ?>/<? echo $row["file"]; ?>">
		  <b><? echo $row["file"]; 
		  } 		  
		  ?>
		  </b></a></td>    
  </tr>
		  <?    	
	} // end  while
	//echo $str_zip."<br>";
	
	$allpath=$realpath."/files/homework/zipfiles/".$hw_id;
	if(!(@opendir($allpath))) mkdir ("$allpath", 0777);
	$zipfile = $allpath."/ans.zip";	
	//echo $zipfile;	
	exec("zip".$zipfile." ".$str_zip);	
			  
}   // end   if                
 ?>
</table>
<center>
	<form>
    	<div class="hilite"> 
      <input name="Button" type="button" value="&lt;&lt; Back" onClick="history.back()" class="button">
    	</div>
	</form>
  <table  width="100%" cellspacing="1" cellpadding="2" border="0" align="center" class="tdborder2">
    <tr> 
      <td width="12%">&nbsp;</td>
      <td width="88%">&nbsp; </td>
    </tr>
    <tr class="boxcolor"> 
      <td align="left"  class="Bcolor"><b>Zip File</b></td>
      <td align="left" class="hilite"> 
        <?  		  		
		  ?>
        <a href="../files/homework/zipfiles/<? echo $hw_id; ?>/<? echo "ans.zip" ?>"> 
        <b><? echo "ANS.ZIP"; 		  
		  ?> </b></a></td>
    </tr>
    <?  	
  
if (mysql_num_rows($hwans) != 0)
{   
	?>
    <?    						  
}   // end   if                
 ?>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp; </td>
    </tr>
  </table>
</center>
</body>
</html>
-->