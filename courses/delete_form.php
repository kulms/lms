<? require("../include/global_login.php"); ?>


<html>
<head>
<SCRIPT LANGUAGE="JavaScript">
function deleteCourse(){
if (confirm("Are you sure want to delete?")) {
alert ("Delete....");
}
}
</SCRIPT>
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
        <title>Delete course</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874"></head>
<body>
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"
height="53" class="bg1">
  <tr><td class="menu" align="center">
        <b>DELETE COURSE</b> 
		<br>
</td></tr>
</table>
<table border="0" cellpadding="5" cellspacing="5" align="center">

<form action="deletecourse.php">

<input type="hidden" name="flag" value="true">
<?
$check=mysql_query("SELECT id,name,fullname,section from courses WHERE users=".$person["id"].";");
while($row=mysql_fetch_array($check)){
?>
<tr>
 <td class="main" colspan="2">
<input type="radio" name="delete" value="<? echo $row["id"]; ?>" >
<? echo $row["name"]; ?>
<? if ($row["section"] != "") {
?> หมู่ <? echo $row["section"]; ?> <? } ?>
( <? echo $row["fullname"]; ?> )
</td></tr>
<? } ?>
<tr><td>

<input type="submit" name="submit" value=" D e l e t e " onSubmit="deleteCourse();" class="button">
<input type="reset" value="   R e s e t  "  class="button">

</td></tr>

</form>

</table>
</body>
</html>

