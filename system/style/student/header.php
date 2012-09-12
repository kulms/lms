<html>
<head>
	<meta name="Version" content="<?php //echo @$AppUI->getConfig( 'version' );?>" />
	<meta http-equiv="Content-Type" content="text/html;charset=tis-620" />
	<title><?php echo @$user->_('M@xLearn');?></title>
<!--	<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/main.css" media="all" />!-->
<link rel="stylesheet" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css" >

</head>

<body>
<table width="100%" cellpadding="3" cellspacing="0" border="0">
<tr>
	<th   background="../themes/<?php echo $theme;?>/images/titlegrad.jpg"  align="left" class="Bcolor"><?php echo $user->_($strSystem_Header);?></th>
</tr>
<tr>
	<td class="nav" align="left">
	<table width="100%" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		
    <td> 
      <?php
	  //echo $user->getModuleClass( $realpath, 'users' );
	  require_once ($user->getModuleClass( $realpath, 'users' ));	  
	  $permission = Permission::lookupPermission($user->getUserId());
		/*
		$links = array();
		foreach ($nav as $module) {
			//if (!getDenyRead( $module['mod_directory'])) {
				$links[] = '<a href="?m='.$module['mod_directory'].'">'.$AppUI->_($module['mod_ui_name']).'</a>';
			//}
		}
		echo implode( ' | ', $links );
		echo "\n";
		*/
		?>
      <?php
			if($permission->getSysPAdminSuper()==1) {
		?>
      <a href="./index.php"><?php echo $user->_($strSystem_MenuHome);?></a> | <a href="index.php?m=users"><?php echo $user->_($strSystem_MenuUser);?></a> 
      | <a href="index.php?m=system"><?php echo $user->_($strSystem_MenuSystem);?></a> 
      | <a href="index.php?m=mdata"><?php echo $user->_($strSystem_MenuMaster);?></a> 
      | <a href="index.php?m=courses"><?php echo $user->_($strSystem_MenuCourses);?></a> 
	  | <a href="index.php?m=report&a=all"><?php echo $user->_($strSystem_MenuReport);?></a>
      <?php
	  	} else {
	   ?>
      <a href="./index.php"><?php echo $user->_($strSystem_MenuHome);?></a> 
      <?php
			if($permission->getSysPAdminUsers()==1) {
			?>
      | <a href="index.php?m=users"><?php echo $user->_($strSystem_MenuUser);?></a> 
      <?php } 
			if($permission->getSysPAdminSystem()==1) {
			?>
      | <a href="index.php?m=system"><?php echo $user->_($strSystem_MenuSystem);?></a> 
      <?php } 
			if($permission->getSysPAdminMData()==1) {
			?>
      | <a href="index.php?m=mdata"><?php echo $user->_($strSystem_MenuMaster);?></a> 
      <?php }
			if($permission->getSysPAdminCourses()==1) {
			?>
      | <a href="index.php?m=courses"><?php echo $user->_($strSystem_MenuCourses);?></a> 
      <?php } 
	   if($permission->getSysPAdminReport()==1) {
			?>
      | <a href="index.php?m=report&all"><?php echo $user->_($strSystem_MenuReport);?></a> 
	  <? }
	   	}
	   ?>
    </td>		
		</td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	
  <td>&nbsp; </td>
</tr></table>
