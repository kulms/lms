<?  
		require("../include/global_login.php");
		include('include/config.inc.php');
		include("config.inc.php");
		include("include/content.class.php");
		session_start();
		
$content= new Content($module_id,$course,$person['id']);

if($less_id !=""){
		$content->DeleteLesson($content,$less_id,$config['homepath']);
		
		 if($pop ==1){?>
					<script  language="javascript">
					 self.close();  
					opener.window.location.reload();
					</script> 
				<? }else{
							header("Location: t_index.php");
		  }
		//header("Location: t_index.php");
		
}
?>