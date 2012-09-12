<?php 
##
## Activate a module entry
##
$cmd = $_GET('cmd');
$mod_id = intval($_GET('mod_id'));
//$mod_directory = dPgetParam( $_GET, 'mod_directory', '0' );

$system = System::lookupSystem($mod_id);
/*
$obj = new CModule();
if ($mod_id) {
	$obj->load( $mod_id );
} else {
	$obj->mod_directory = $mod_directory;
}


$ok = include_once( "{$AppUI->cfg['root_dir']}/modules/$obj->mod_directory/setup.php" );

if (!$ok) {
	if ($obj->mod_type != 'core') {
		$AppUI->setMsg( 'Module setup file could not be found', UI_MSG_ERROR );
		$AppUI->redirect();
	}
}
eval( "\$setup = new {$config['mod_setup_class']}();" );
*/
switch ($cmd) {
	case 'toggle':
	// just toggle the active state of the table entry
		$system->system_active = 1 - $system->getSystemActive();
		$system->update($system);
		break;
	case 'toggleMenu':
	// just toggle the active state of the table entry
		$obj->mod_ui_active = 1 - $obj->mod_ui_active;
		$obj->store();
		$AppUI->setMsg( 'Module menu state changed', UI_MSG_OK );
		break;
	case 'install':
	// do the module specific stuff
		$AppUI->setMsg( $setup->install() );
		$obj->bind( $config );
	// add to the installed modules table
		$obj->install();
		$AppUI->setMsg( 'Module installed', UI_MSG_OK );
		break;
	case 'remove':
	// do the module specific stuff
		$AppUI->setMsg( $setup->remove() );
	// remove from the installed modules table
		$obj->remove();
		$AppUI->setMsg( 'Module removed', UI_MSG_ALERT );
		break;
	case 'upgrade':
		$AppUI->setMsg( $setup->upgrade() );
		break;
	default:
		$AppUI->setMsg( 'Unknown Command', UI_MSG_ERROR );
		break;
}
$AppUI->redirect();
?>