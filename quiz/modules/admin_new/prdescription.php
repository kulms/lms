<? 
require("../include/global_login.php");
include('classes/config.inc.php');
//require("header.php");

$template= new Template(C_SKIN);	
$template->set_filenames(array('body' =>'prdescription.html',));
		$template->assign_vars(array('NAME'=>($type==1)?"P:Percentage Description":"R:discrimination power Description",
														 'CLOSE'=>$strClose,
															 'Theme'=>$theme,
																
									));	 
																
																 

	if($type==1){
			$template->assign_block_vars('pp', array());
																
	}else{			
			$template->assign_block_vars('rr', array());
	}	
	


$template->pparse('body');											
?>