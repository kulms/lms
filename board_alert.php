<?
	require("include/global_login.php");
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="themes/<?php echo $theme;?>/style/main.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 00px;
}
-->
</style></head>

<body>
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  bgcolor="#FFFFFF">
        <!--  Calendar-->
        <tr>
          <td width="19%" valign="top" class="news"><div align="center"><img src="images/webbo.gif" width="48" height="47" border="0"><br>
                  <?php echo $INFO_Webboard; ?><br>
          </div></td>
          <td width="3%">&nbsp;</td>
          <td width="78%" valign="top" class="news">
            <div align="left"><?php echo $INFO_Webboard."<br><br>";
				echo "<table width=\"60%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";

// หาวิชาที่อาจารย์ สอน  หรือ น.ศ.  ลงเรียน
$haveQz =0;
$sqlc ="SELECT DISTINCT wp.courses, c.name 
		FROM wp ,courses c 
		WHERE wp.users='$person[id]'
		AND wp.courses=c.id 
		AND c.active='1' 
		ORDER BY c.id ASC";
		
$rsc = mysql_query($sqlc);
while($carr= mysql_fetch_array($rsc)){
			$CID = $carr[courses];
			$CName = $carr[name]; 
			$sqlm = "SELECT m.id, m.name
						 FROM modules m
						 WHERE m.modules_type='4'
						 AND m.courses ='$CID' 
						 AND m.active='1' 
						 ORDER BY m.updated DESC ";
			 $rsm = mysql_query($sqlm);
			 if(mysql_num_rows($rsm)> 0){
					if($haveQz ==0){
							$haveQz  =1;
					}
			 		while($marr= mysql_fetch_array($rsm)){
												echo "<tr>";
												echo "<td align=\"left\"><img src=\"images/courses.gif\" align=\"absmiddle\" border=\"0\">$carr[name]</td>";// Name of COURSES
												echo "<td align=\"left\"><a href=\"courses/menu.php?id={$marr[id]}&courses=$CID&webb=1\" target=\"ws_menu\">$marr[name]</a></td>";  //name of MODULES
												echo "</tr>";
					}
			 }
}
		echo "</table>";
if($haveQz==0){
		echo "$INFO_NotHaveWeb";
}
?></div></td>
        </tr>
    </table>
</body>
</html>
