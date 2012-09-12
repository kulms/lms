<?php 

$sql = "SELECT * FROM modules_type ORDER BY id";
$modules = $user->db_loadList($sql);

// get the modules actually installed on the file system
//$modFiles = $user->readDirs( "modules" );

?>
<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />!-->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="30%">	
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td><img src="./modules/system/images/my_modules.png" border="0"></td>
			<td><h1><?php echo $user->_($strSystem_LabModule);?></h1></td>
		  </tr>
		</table>
	</td>
	<td align="right" width="25%" valign="bottom">
	</td>
	<td align="left" nowrap width="45%">

	</td>
  </tr>  
</table>
<br>
<table border="0" cellpadding="2" cellspacing="1" width="100%" class="tdborder1">
<tr align="center" class="boxcolor">
	<td colspan="2" class="main_white"><?php echo $user->_($strSystem_LabSubModule);?></td>
	<td class="main_white"><?php echo $user->_($strSystem_LabModuleStatus);?></td>
	<!--<th><?php //echo $user->_('Type');?></th>
	<td><?php //echo $user->_('Version');?></td>-->
	<td class="main_white"><?php echo $user->_($strSystem_LabModuleUrl);?></td>
	<td class="main_white"><?php echo $user->_($strSystem_LabModuleUrlAdmin);?></td>
	<td class="main_white"><?php echo $user->_($strSystem_LabModuleUrlSetup);?></td>
	<td class="main_white"><?php echo $user->_($strSystem_LabModuleInfo);?></td>
	<td class="main_white"><?php echo $user->_($strSystem_LabModulePicture);?></td>	
</tr>
<?php
// do the modules that are installed on the system
foreach ($modules as $row) {
	// clear the file system entry
	/*
	if (isset( $modFiles[$row['mod_directory']] )) {
		$modFiles[$row['mod_directory']] = '';
	}
	*/
	$query_string = "?m=$m&dosql=domodsql&a=viewmods&mod_id={$row['id']}";
	$s = '';
	
	$s .= '<td>';
	$s .= '<img src="./images/obj/contact.gif" border=0 />';
	$s .= '</td>';
	
	$s .= '<td width="1%" nowrap="nowrap">'.$row['name'].'</td>';
	
	$s .= '<td>';
	$s .= '<img src="./images/obj/dot'.($row['active'] ? 'green' : 'yellowanim').'.gif" width="12" height="12" />&nbsp;';
	$s .= '<a href="'.$query_string . '&cmd=toggle&">'.($row['active'] ? $user->_($strActive) : $user->_($strDisable)).'</a>';
	$s .= '</td>';
	
	$s .= '<td>'.$row['url'].'</td>';
	
	$s .= '<td>'.$row['url_admin'].'</td>';
	
	$s .= '<td>'.$row['url_setup'].'</td>';
	
	$s .= '<td>'.$row['info'].'</td>';
	
	$s .= '<td>'.$row['picture'].'</td>';
	
	echo "<tr bgcolor=\"#FFFFFF\">$s</tr>";
}
?>
</table>

</body>
</html>

