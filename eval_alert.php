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
          <td width="19%" valign="top" class="news"><div align="center"><img src="images/eval_logo.gif" width="48" height="47"  border="0"><br>
                  <?php echo $INFO_EVAL_title;?><br>
          </div></td>
          <td width="3%">&nbsp;</td>
          <td width="78%" valign="top" class="news">
            <div align="left"> <?php echo $INFO_EVAL."<br><br>";
				echo "<table width=\"80%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
				echo "<tr>";
				echo "<td align=\"left\" class=\"news\">$strSystem_ListReportCourses</td>";// Name of COURSES
				echo "<td align=\"left\" class=\"news\">$INFO_EVAL_title</td>";  //name of Eval
				echo "<td align=\"left\" class=\"news\">$INFO_EVAL_dead</td>";
				echo "</tr>";
$today =  date("Y-m-d H:i:s");
 
		$sql = "SELECT  c.id as cid,c.name as cname,m.id as mid,m.name as mname,s.end_date 
						FROM modules m,eval_q_set s ,wp w, courses c
						WHERE  w.users='$person[id]'  
						AND w.courses=c.id  AND  c.id=m.courses  AND m.modules_type ='8' AND s.modules_id = m.id AND s.end_date >='$today ' AND m.active='1' GROUP BY s.modules_id ORDER BY m.created ASC";
		$rs = mysql_query($sql);
			while($arr=mysql_fetch_array($rs)){
						$sql2 = "SELECT ans_id
									FROM eval_usrd_answers   
									WHERE modules_id='$arr[mid]'
									AND users_id='$person[id]';";
						$rs2 = mysql_query($sql2);
						$num = mysql_num_rows($rs2);
						if($num ==0 || $num ==''){
										$had_e =1;
												echo "<tr>";
												echo "<td align=\"left\"><img src=\"images/courses.gif\" align=\"absmiddle\" border=\"0\">".$arr[cname]."</td>";// Name of COURSES
												echo "<td align=\"left\"><a href=\"courses/menu.php?id={$arr[mid]}&courses={$arr[cid]}&eval=1\" target=\"ws_menu\">".$arr[mname]."</a></td>";  //name of Eval
												echo "<td align=\"left\">".substr($arr[end_date],8,2)."-".substr($arr[end_date],5,2)."-".substr($arr[end_date],0,4)."</td>";
												echo "</tr>";
							}

		}//for
		if($had_e !=1){
						echo "<tr>";
						echo "<td align=\"left\" colspan=\"3\">$INFO_EVAL_NOT</td>";// Not have Evaluate
						echo "</tr>";
		}
				echo "</table>";
?> </div></td>
        </tr>
    </table>
</body>
</html>
