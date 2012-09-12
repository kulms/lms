<?   require("../include/global_login.php");  ?>
<html>
<head>
<title>Apply to course</title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<?   include("../include/page_update.js");  ?>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874"></head>
<body bgcolor="#ffffff"><p>&nbsp;</p>
 <table width="90%" border="1" cellspacing="0" cellpadding="5"  align="center" bordercolor="#CCCCCC">
  <tr>
    <td colspan="6">
      <div align="center"><font color="#993300" face="MS Sans Serif, Microsoft Sans Serif" size="1">
	  <b>Available Courses </b></font></div>
    </td>
  </tr>
  <tr>
    <td><div align="center" class="res">Course ID</font></div></td>
    <td><div align="center" width="5%" class="res">Section (หมู่)</font></div></td>
    <td><div align="center" class="res">Course Name</font></div></td>
    <td><div align="center" class="res">Course Admin</font></div></td>
    <td><div align="center" width="6%" class="res">Apply Status</font></div></td>
    <td><div align="center" width="5%">&nbsp;</div></td>
  </tr>

<? // $getcourse=mysql_query("SELECT id,name,applyopen,fullname,users,section FROM courses WHERE active=1 and name <> '' and fullname <> '' ORDER BY name;");
	$getcourse=mysql_query("SELECT *  FROM courses WHERE active=1 and name <> '' and fullname <> '' ORDER BY name;");
 while($row=mysql_fetch_array($getcourse))
  {
        $open=$row["applyopen"];

        switch($open)
		{
			case 1:
					$td="Open";
					break;
			case 0:
					$td="<font color=\"#0000cc\"> Approve </font>";
					break;
			case -1:
					$td="<font color=\"#660000\"> Close </font>";
					break;
			default:
					$td="Open";
					break;
        }    //end switch
?>
<tr>
<td class="info" align="center"><? echo $row["name"]; ?></td>
<td class="info" align="center" width="5%">
<? if ($row["section"] == "") 
		{
				$row["section"] = "&nbsp;";
		}
		echo $row["section"]; ?></td>
<td class="info" align="center">
      <? echo $row["fullname"]."<br>".$row["fullname_eng"]; ?></td>
<? $result=mysql_query("SELECT firstname,surname,email FROM users WHERE id=".$row["users"].";"); ?>
<td class="info" align="center"><a href="mailto:<? echo @mysql_result($result,0,"email"); ?>"><?
      echo @mysql_result($result,0,"firstname"); 
	  if(@mysql_result($result,0,"surname")!=""  || @mysql_result($result,0,"surname")!=null){
      	echo "&nbsp;&nbsp;".@mysql_result($result,0,"surname");
	   }else{   	echo @mysql_result($result,0,"surname"); }  ?></a>
</td>
<td class="info" align="center" width="6%"><? echo $td; ?></td>
<td class="info" align="center" width="5%"><?
	   if ($open == '-1')
		 {  
			?><font color="red">close </font><?
		 } 
	    $membered=mysql_query("SELECT courses,users FROM wp WHERE courses=".$row["id"]." AND users=".$person["id"].";");
		if (mysql_num_rows($membered)>=1 && $open!='-1') 
		{ 
		   ?><font color="cccccc">applied</font><?
		}
		if(mysql_num_rows($membered)==0 && $open!='-1') 
		 {  
			?><a href="application.php?courses=<? echo $row["id"]; ?>">apply</a><?
		 } ?>
</td>
<? } // end while loop
  ?>
</table>
</body>
</html>