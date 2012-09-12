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
<table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="19%" valign="top" class="news"><div align="center"><img src="images/homework_logo.gif" width="48" height="47"  border="0"><br>
                  <?php echo $INFO_HOMEWORK;?><br>
          </div></td>
          <td width="3%">&nbsp;</td>
          <td width="78%" valign="top" class="news">
            <div align="left"> <?php echo $INFO_HOMEWORK."<br><br>";
				echo "<table width=\"80%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
				echo "<tr>";
				echo "<td align=\"left\" class=\"news\">$strSystem_ListReportCourses</td>";// Name of COURSES
				echo "<td align=\"left\" class=\"news\">$INFO_HOMEWORK</td>";  //name of Eval
				echo "<td align=\"left\" class=\"news\">$INFO_DEADLINE_TITLE</td>";
				echo "</tr>";
// หาวิชาที่อาจารย์ สอน  หรือ น.ศ.  ลงเรียน
$haveHw =0;
$sqlc ="SELECT DISTINCT wp.courses, c.name 
		FROM wp ,courses c 
		WHERE wp.users='$person[id]'
		AND wp.courses=c.id 
		AND c.active='1' 
		ORDER BY c.id ASC";
		
$rsc = mysql_query($sqlc);
//echo mysql_num_rows($rsc);
while($carr= mysql_fetch_array($rsc)){
			$CID = $carr[courses];			
			$CName = $carr[name]; 
			$sqlm = "SELECT m.id, m.name, hp.end_date,hp.hour,hp.minute 
						 FROM modules m,homework_prefs hp
						 WHERE m.modules_type='7'
						 AND m.courses ='$CID' 
						 AND hp.modules = m.id
						 AND hp.end_date > ".time()." 
						 AND m.active='1' 
						 ORDER BY hp.end_date ASC ;";
			//echo $sqlm;			 
			 $rsm = mysql_query($sqlm);
			 if(mysql_num_rows($rsm)> 0){
			 		$i=1;
					if($haveHw ==0){
							$haveHw  =1;
					}
			 		while($marr= mysql_fetch_array($rsm)){
											if($i==1){ 
													$col = "#FF0000"; 
													$sign  ="<img src=\"images/hot.gif\" align=\"absmiddle\">";
											 }else{   
													 $col = "#666666";  
													 $sign=""; }
												echo "<tr>";
												echo "<td align=\"left\"><img src=\"images/courses.gif\" align=\"absmiddle\" border=\"0\">$carr[name]</td>";// Name of COURSES
												echo "<td align=\"left\"><a href=\"courses/menu.php?id={$marr[id]}&courses=$CID&hw=1\" target=\"ws_menu\">$marr[name]</a></td>";  //name of MODULES
												echo "<td align=\"left\"><font color = $col>".date("d-m-Y",$marr[end_date])."</font>&nbsp;$sign</td>";
												echo "</tr>";
										$i++;
									}	
				 }
}
		echo "</table>";
if($haveHw ==0){
		echo "$INFO_NotHaveHomework";
}
?> </div></td>
        </tr>
    </table>
</body>
</html>
