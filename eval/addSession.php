<?  session_start();

//echo $g_name,$g_id;
		$_SESSION[g_id] =$_POST[g_id];
		$_SESSION[g_name] =$_POST[g_name];
		$_SESSION[num_C]=$_POST[num_C];
		$_SESSION[num_F] =$_POST[num_F];
		session_register("g_name");
		session_register("num_C");
		session_register("num_F");
		session_register("g_id");
		
		//echo "====".$_SESSION[g_id] ,		$_SESSION[g_name] ;
		
header("Location: addChoice.php");

		
	?>