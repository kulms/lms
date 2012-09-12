<?require("../include/global_login.php");?>
<html>
<head>
        <title>Apply to course</title>
        <link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
        <body bgcolor="#ffffff">
 <table width="90%" border="1" cellspacing="0" cellpadding="5"  align="center" bordercolor="#CCCCCC">
  <tr>
    <td colspan="6">
      <div align="center"><font color="#993300" face="MS Sans Serif, Microsoft Sans Serif" size="1"><b>Available
        Courses </b></font></div>
    </td>
  </tr>
  <tr>
    <td>
      <div align="center"><font color="#990099" face="MS Sans Serif, Microsoft Sans Serif" size="1">Course ID</font></div>
    </td>
    <td>
      <div align="center" width="5%"><font color="#990099" face="MS Sans Serif, Microsoft Sans Serif" size="1">Section (หมู่)</font></div>
    </td>
    <td>
      <div align="center"><font color="#990099" face="MS Sans Serif, Microsoft Sans Serif" size="1">Course Name</font></div>
    </td>
    <td>
      <div align="center"><font color="#990099" face="MS Sans Serif, Microsoft Sans Serif" size="1">Course Admin</font></div>
    </td>
    <td>
      <div align="center" width="6%"><font color="#990099" face="MS Sans Serif, Microsoft Sans Serif" size="1">Apply Status</font></div>
    </td>
  </tr>
        <?
$getcourse=mysql_query("SELECT id,name,applyopen,fullname,users,section FROM courses WHERE active=1 ORDER BY name;");
while($row=mysql_fetch_array($getcourse)){
        $open=$row["applyopen"];

        switch($open){
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
        }//end switch
?>
<tr>
<td class="info" align="center"><?echo $row["name"]; ?></td>
<td class="info" align="center" width="5%"><? if ($row["section"] == "") {
$row["section"] = "&nbsp;";
}
echo $row["section"]; ?></td>
<td class="info" align="center"><?echo $row["fullname"]; ?></td>
<? $result=mysql_query("SELECT firstname,surname,email FROM users WHERE id=".$row["users"].";"); ?>
<td class="info" align="center"><a href="mailto:<? echo mysql_result($result,0,"email"); ?>">
<? echo mysql_result($result,0,"firstname"); ?>
 <? echo mysql_result($result,0,"surname");
?></a>
</td>
<td class="info" align="center" width="6%"><?echo $td ?></td>
<?
}?>
</table>
</body>
</html>