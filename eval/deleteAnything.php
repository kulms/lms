<?  
		require("../include/global_login.php");
		include("./include/var.inc.php");
		include('include/config.inc.php');
		require("include/eval.class.php");
		session_start();
		
$evaluate= new  Evaluate($_SESSION[module_id],$_SESSION[course],$person['id']);

if($_GET[g_id] !=""){
		
		$evaluate->DeleteAny($_GET[g_id],'');
		$evaluate->DeleteAnswer($evaluate,$_GET[g_id]);

}else if($_GET[q_id] !=""){

		$evaluate->DeleteAny('',$_GET[q_id]);
		$evaluate->DeleteAnswer($evaluate,$_GET[q_id]);

}
		
		header("Location: t_index.php?grp_id={$_REQUEST[grp_id]}");
		
?>