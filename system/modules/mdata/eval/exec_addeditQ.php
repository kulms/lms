<? 
require("../eval/include/eval.class.php");
$evaluate= new  Evaluate('','','');


if($q_id==""){
	//INSERT
//	 InsertQuestion($evaluate,$alt_id,$g_id,$question,$cat_id,$std_q,$active){
	$evaluate->InsertQuestion($evaluate,$_POST["alt"],0,$_POST["q"],$cat_id,1,$act);
	//$evaluate->InsertQuestion($evaluate,$_POST["alt"],0,$_POST["q"],0,$choice,1,$act);
	$text="Insert  Complete !!";
}else{
	$text="Update  Complete !!";
	if($choice ==0)
		$evaluate->updateQuestion($q_id,0,$_POST["q"],$act);
	else
		$evaluate->updateQuestion($q_id,$_POST["alt"],$_POST["q"],$act);
}
?>

<html>
<head>
	<link rel="STYLESHEET" type="text/css" href="../main.css">
	<META HTTP-EQUIV="Refresh" CONTENT="1;URL=?m=mdata&m1=eval&a=index">
</head>
<body bgcolor="#ffffff">
<p>&nbsp;</p>
<div align="center" class="h3"><b><? echo $text ?></b></div>
</body>
</html>