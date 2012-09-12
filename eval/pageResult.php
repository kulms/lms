<?  session_start();

if(isset($_POST[pback])){
		$gb = $_REQUEST[gg]-1;
		header("Location: result_eval.php?gg=$gb&m_id=$_REQUEST[m_id]#QT");
}
if(isset($_POST[pnext])){
		$gb = $_REQUEST[gg]+1;
		header("Location: result_eval.php?gg=$gb&m_id=$_REQUEST[m_id]#QT");
}
	?>