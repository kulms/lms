<?php 

$cmd = $_GET['cmd'];
$menu = $_GET['menu'];
$set = 1 - intval($_GET['active']);

switch ($cmd) {
	case 'toggle':
		$sql = "UPDATE maxlearn_config SET 
			   notify_$menu = ".$set."" ;	
		
		mysql_query($sql);		
		break;
	
	default:
		$user->setMsg( 'Unknown Command', UI_MSG_ERROR );
		break;
}

?>