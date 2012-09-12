<?php 

$sql = "SELECT * FROM maxlearn_config";
$config = $user->db_loadList($sql);

// get the modules actually installed on the file system
//$modFiles = $user->readDirs( "modules" );

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="30%">	
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td><img src="./modules/system/images/rdf2.png" border="0"></td>
			<td><h1><?php echo $user->_($strSystem_LabFirstpage);?></h1></td>
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
<table border="0" cellpadding="2" cellspacing="1" width="40%" class="tdborder1">
<tr align="center" class="boxcolor">
	<td class="main_white" nowrap><?php echo $user->_($strSystem_LabSubModule);?></td>
	<td class="main_white"><?php echo $user->_($strSystem_LabModuleStatus);?></td>
	</tr>
<?php
// do the modules that are installed on the system
$menu = array("Homework","Calendar","Evaluate","Message","Quiz","Webboard","News");

foreach ($config as $row) {
  $rs = array($row["notify_Homework"],$row["notify_Calendar"],$row["notify_Evaluate"]
 			 ,$row["notify_Message"],$row["notify_Quiz"],$row["notify_Webboard"],$row["notify_News"]);
  
 }
	
  for($i=0;$i<sizeof($menu);$i++){
	
	$query_string = "?m=$m&dosql=doconfig&a=controlpage&active=".$rs[$i]."&menu=".$menu[$i];
	$s = '';
	
	
	
	$s .= '<td width="1%" nowrap="nowrap">'.$menu[$i].'</td>';
	
	$s .= '<td>';
	$s .= '<img src="./images/obj/dot'.($rs[$i] ? 'green' : 'yellowanim').'.gif" width="12" height="12" />&nbsp;';
	$s .= '<a href="'.$query_string . '&cmd=toggle">'.($rs[$i] ? $user->_($strActive) : $user->_($strDisable)).'</a>';
	$s .= '</td>';
	
	
	echo "<tr bgcolor=\"#FFFFFF\">$s</tr>";
}
?>
</table>

</body>
</html>

