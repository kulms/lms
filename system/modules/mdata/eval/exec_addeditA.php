<? 
require("../eval/include/eval.class.php");
$evaluate= new  Evaluate('','',-1);


if($alt_id==""){
	//INSERT
	$evaluate->Insert_Alt($evaluate,$alt1,$alt2,$alt3,$alt4,$alt5,$res1,$res2,$res3,$res4,$res5);
	$text="Insert alternatives  complete !!";
}else{
	$text="Update  alternatives  complete !!";
	$sql="UPDATE  eval_usrd_alternatives SET alt1='$alt1',alt2='$alt2',alt3='$alt3',alt4='$alt4',alt5='$alt5',res1=$res1,res2=$res2,res3=$res3,res4=$res4,res5=$res5 WHERE alt_id=".$alt_id."";
	$data_sql=mysql_query($sql);
}
?>

<html>
<head>
	<link rel="STYLESHEET" type="text/css" href="../main.css">
	<META HTTP-EQUIV="Refresh" CONTENT="1;URL=?m=mdata&m1=eval&a=list_alt">
</head>
<body bgcolor="#ffffff">
<p>&nbsp;</p>
<div align="center" class="h3"><b><? echo $text ?></b></div>
</body>
</html>