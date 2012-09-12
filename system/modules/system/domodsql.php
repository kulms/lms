<?php 
##
## Activate a module entry
##
$cmd = $_GET['cmd'];
$mod_id = intval($_GET['mod_id']);

$system = System::lookupSystem($mod_id);

switch ($cmd) {
	case 'toggle':
	// just toggle the active state of the table entry
		$system->system_active = 1 - $system->getSystemActive();
		$system->update($system);		
		break;
	case 'install':	
	// add to the installed modules table
		$system->install();
		break;
	case 'remove':
	// remove from the installed modules table
		$system->remove();
		break;
	case 'upgrade':
		$system->upgrade();
		break;
	default:
		$user->setMsg( 'Unknown Command', UI_MSG_ERROR );
		break;
}

?>