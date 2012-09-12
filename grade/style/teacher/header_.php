<html>
<head>
	<meta name="Version" content="<?php //echo @$AppUI->getConfig( 'version' );?>" />
	<meta http-equiv="Content-Type" content="text/html;charset=tis-620" />
	<title><?php echo @$user->_('M@xLearn');?></title>
	<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/main.css" media="all" />
</head>

<body>
<table width="100%" cellpadding="3" cellspacing="0" border="0">
<tr>
	<th bgcolor="#990000"  align="left"><font color="#FFFFFF"><strong><?php echo "Welcome To System & User Management";?></strong></font></th>
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
		  <a href="./index.php">Home</a> 
		  | <a href="index.php?m=users">Users</a> 
		  | <a href="index.php?m=system">System</a> 
		  | <a href="index.php?m=mdata">Master Data</a> 
		  | <a href="index.php?m=courses">Courses</a> 
	  <?php
	  	} else {
	   ?>
	   	  <a href="./index.php">Home</a> 
		  <?php
			if($permission->getSysPAdminUsers()==1) {
			?>		
		  | <a href="index.php?m=users">Users</a> 
		  	<?php } 
			if($permission->getSysPAdminSystem()==1) {
			?>		
		  | <a href="index.php?m=system">System</a> 
		  <?php } 
			if($permission->getSysPAdminMData()==1) {
			?>		
		  | <a href="index.php?m=mdata">Master Data</a> 
		  <?php }
			if($permission->getSysPAdminCourses()==1) {
			?>		
		  | <a href="index.php?m=courses">Courses</a> 
		  <?php } 
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
