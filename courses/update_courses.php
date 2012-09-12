<form name="form">
<input type="hidden" name="action" value="save">
<table width="48%"  border="0">
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="51%"><input type="text" name="id"  ></td>
    <td width="49%"><input type="submit" name="submit" value="submit">&nbsp;</td>
  </tr>
</table>
</form>
<? 
require("../include/global_login.php");

$sql="SELECT * FROM `courses` WHERE year <= 47  AND semester < 3  ";
$data_sql=mysql_query($sql);
while($row=mysql_fetch_array($data_sql)){
	//echo $row['id'].",";
	mysql_query("DELETE FROM login_course  WHERE courses=".$row['id']);
}

i
/*f($action=="save"){
	echo $id;
	$ID=explode(",",$id);
	for($i=0;$i<count($ID);$i++){
	$sql="SELECT * 
FROM `wp47` 
WHERE 1 AND `courses` =".$ID[$i];
	
	$data_sql=mysql_query($sql);
	while($row=mysql_fetch_array($data_sql)){
		$sql="INSERT INTO `wp` VALUES (".$row['id'].", ".$row['courses'].", ".$row['cases'].", ".$row['groups'].", ".$row['folders'].", ".$row['modules'].", ".$row['users'].", ".$row['admin'].", ".$row['active'].", ".$row['temp'].") ";
		//echo $sql;
		mysql_query($sql);
	}
	}
	echo "<SCRIPT LANGUAGE=\"JavaScript\">document.form.id.focus();</SCRIPT>";
}*/
?>