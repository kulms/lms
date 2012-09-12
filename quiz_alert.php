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
          <td width="19%" valign="top" class="news"><div align="center"><img src="images/quiz_logo.gif" width="48" height="47" border="0"><br>
                  <?php echo $INFO_Quiz; ?><br>
          </div></td>
          <td width="3%">&nbsp;</td>
          <td width="78%" valign="top" class="news">
            <div align="left"><?php echo $INFO_Quiz."<br><br>";
				echo "<table width=\"80%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
				echo "<tr>";
				echo "<td align=\"left\" class=\"news\">$strSystem_ListReportCourses</td>";// Name of COURSES
				echo "<td align=\"left\" class=\"news\">$INFO_Quiz</td>";  //name of Eval
				echo "<td align=\"left\" class=\"news\">$strPersonal_msg_Date</td>";
				echo "</tr>";
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
			$sqlm = "SELECT m.id, m.name, q.end_date
						 FROM modules m, q_module_prefs q
						 WHERE m.modules_type='5'
						 AND m.courses ='$CID' 
						 AND q.module_id = m.id
						 AND q.end_date > ".time()." 
						 AND m.active='1' 
						 ORDER BY q.end_date ASC ";
			 $rsm = mysql_query($sqlm);
			 if(mysql_num_rows($rsm)> 0){
			 		$i=1;
					if($haveQz ==0){
							$haveQz  =1;
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
												echo "<td align=\"left\"><a href=\"courses/menu.php?id={$marr[id]}&courses=$CID&quiz=1\" target=\"ws_menu\">$marr[name]</a></td>";  //name of MODULES
												echo "<td align=\"left\"><font color = $col>".date("d-m-Y",$marr[end_date])."</font>&nbsp;$sign</td>";
												echo "</tr>";
										$i++;
									}	
				 }
}
		echo "</table>";
if($haveQz==0){
		echo "$INFO_NotHaveQz";
}
?></div></td>
        </tr>
    </table>
</body>
</html>
