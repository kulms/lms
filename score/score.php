<?
		$sql = "INSERT INTO evaluate VALUES ($belong, ".$person["id"].", $h_score1, $h_score2, $h_score3, '".$h_com1."', '".$h_com2."', '".$h_com2."',
						$f_score1, $f_score2, $f_score2, '".$f_com1."', '".$f_com2."', '".$f_com2."');";
		mysql_query($sql);
		header("Location: index.php?courses=$courses");
?>