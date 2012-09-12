<? require ("../include/global_login.php");

//mysql_subquery
//copyright 1999 avi bryant, all rights reserved
//feel free to use this and modify it as you see fit
function sub($result){
	if($result == 0)
		return "()";
	else{
		$row = mysql_fetch_row($result);
		$strResult = "( $row[0]";       
		while($row = mysql_fetch_row($result))
			$strResult = "$strResult , $row[0]";
			$strResult = "$strResult )";
			return $strResult;
		}
}

function mysql_subquery($query){
	$substart = strpos($query, "(");
	if($substart != false){
		$subend = strrpos($query, ")");
		$before = substr($query, 0, $substart);
		$after = substr($query, $subend+1, -1);
		$subquery = substr($query, $substart+1, $subend-$substart-1);
		$subresult = mysql_subquery($subquery);
		$subtext = sub($subresult);
		return mysql_query($before . $subtext . $after);
	}else return mysql_query($query);
}
$test= mysql_subquery("SELECT firstname,surname FROM users WHERE id IN(SELECT m.users FROM modules m, wp WHERE wp.courses=$courses AND m.id=wp.modules);");
?>
<?while($row=mysql_fetch_array($test)){
	echo $row["firstname"]." ".$row["surname"]."<br>";
}?><br>
