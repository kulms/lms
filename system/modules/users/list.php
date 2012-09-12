<?php  

$users = new Users('', '', '', '', '',  
				   '', '', '', '', '', 
				   '', '', ''
				   );


if (empty($page)){
   $page=1;
}
if (empty($stub)){
   $stub=99;
}				   
// Pull First Letters
$let = ":";
/*
$sql = "SELECT DISTINCT UPPER(SUBSTRING(login, 1, 1)) AS L FROM users";
$arr = $users->db_loadList($sql);
foreach( $arr as $L ) {
    $let .= $L['L'];
}
*/

$sql = "SELECT DISTINCT UPPER(SUBSTRING(firstname, 1, 1)) AS L FROM users";
$arr = $user->db_loadList($sql);
foreach( $arr as $L ) {
    $let .= @strpos($let, $L['L']) ? '' : $L['L'];
}

/*
$sql = "SELECT DISTINCT UPPER(SUBSTRING(surname, 1, 1)) AS L FROM users";
$arr = $users->db_loadList($sql);
foreach( $arr as $L ) {
    $let .= strpos($let, $L['L']) ? '' : $L['L'];
}	   
*/

$a2z = "\n<table cellpadding=\"2\" cellspacing=\"1\" border=\"0\">";
$a2z .= "\n<tr>";
$a2z .= '<td width="100%" align="right">' . $user->_($strShow). ' : </td>';
$a2z .= '<td><a href="./index.php?m=users&a=list&stub=0">' . $user->_('All') . '</a></td>';
for ($c=65; $c < 91; $c++) {
	$cu = chr( $c );
	$cell = strpos($let, "$cu") > 0 ?
		"<a href=\"?m=users&a=list&stub=$cu\">$cu</a>" :
		"<font color=\"#999999\">$cu</font>";
	$a2z .= "\n\t<td>$cell</td>";
}
$a2z .= "\n<tr>";
$a2z .= '<td width="100%" align="right">' . $user->_(''). ': </td>';
for ($c=161; $c < 188; $c++) {
	$cu = chr( $c );
	$cell = strpos($let, "$cu") > 0 ?
		"<a href=\"?m=users&a=list&stub=$cu\">$cu</a>" :
		"<font color=\"#999999\">$cu</font>";
	$a2z .= "\n\t<td>$cell</td>";
}
$a2z .= "\n<tr>";
$a2z .= '<td width="100%" align="right">' . $user->_(''). ': </td>';
for ($c=188; $c < 207; $c++) {
	$cu = chr( $c );
	$cell = strpos($let, "$cu") > 0 ?
		"<a href=\"?m=users&a=list&stub=$cu\">$cu</a>" :
		"<font color=\"#999999\">$cu</font>";
	$a2z .= "\n\t<td>$cell</td>";
}

$a2z .= "\n</tr>\n</table>";

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="30%">	
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			
          <td><img src="./modules/users/images/helix-setup-users.png" border="0"></td>
			<td><h1><?php echo $user->_($strSystem_LabUser);?></h1></td>
		  </tr>
		</table>
	</td>
	<td align="right" width="25%" valign="bottom">
	<form name="frmSearch" method="post" action="?m=users&a=list">
		<input type="hidden" name="search" value="1" />
		<input type="text" name="where" class="text" size="20" />		
		<input type="submit" value="<?php echo $user->_($strSearch);?>" class="button" />
	</form>	
	</td>
	<td align="left" nowrap width="45%">
	<?php echo $a2z;?>
	</td>
  </tr>  
</table>
<!--
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="75%" height="30">&nbsp;</td>
    <td width="12%">
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right">
	 <form name="frmImp" method="post" action="?m=users&a=import">
                 <input type="submit" name="Submit" value="<?php //echo $user->_($strSystem_LabImpUser);?>" class="button">			  
     </form>
	</td>
  </tr>
</table>
	</td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td width="13%">
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
			   <form name="frmAdd" method="post" action="?m=users&a=addedit">
                 <input type="submit" name="Submit" value="<?php echo $user->_($strSystem_LabNewUser);?>" class="button">			  
             </form>
	</td>
  </tr>
</table>

	</td>
  </tr>
</table>
-->
<?		
		//$row = $research->SelectAllResearch($user->getUserId());
		//$research->ShowTableAll($row,$user,$uistyle);
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	  <td>
		<?php if(($tab == 1) || $tab == '') {?>
		<table border="0" cellpadding="0" cellspacing="0">
				<td height="28" valign="middle" width="3">
				<img src="images/tabSelectedLeft.png" width="3" height="28" border="0" alt="" /></td>
				<td valign="middle" nowrap="nowrap"  background="images/tabSelectedBg.png">&nbsp;<a href="?m=users&a=list&tab=1"><?php echo $user->_($strSystem_LabActiveUser);?></a>&nbsp;</td>
				<td valign="middle" width="3"><img src="images/tabSelectedRight.png" width="3" height="28" border="0" alt="" /></td>
				<td width="3" class="tabsp"><img src="images/shim.gif" height="1" width="3" /></td>
				<td height="28" valign="middle" width="3"><img src="images/tabLeft.png" width="3" height="28" border="0" alt="" /></td>
				<td valign="middle" nowrap="nowrap"  background="images/tabBg.png">&nbsp;<a href="?m=users&a=list&tab=0"><?php echo $user->_($strSystem_LabInactiveUser);?></a>&nbsp;</td>
				<td valign="middle" width="3"><img src="images/tabRight.png" width="3" height="28" border="0" alt="" /></td>
				<td width="3" class="tabsp"><img src="images/shim.gif" height="1" width="3" /></td>
	    </table>
			<?php } else { ?>
			<table border="0" cellpadding="0" cellspacing="0">
				<td height="28" valign="middle" width="3">
				<img src="images/tabLeft.png" width="3" height="28" border="0" alt="" /></td>
				
          <td valign="middle" nowrap="nowrap"  background="images/tabBg.png">&nbsp;<a href="?m=users&a=list&tab=1"><?php echo $user->_($strSystem_LabActiveUser);?></a>&nbsp;</td>
				<td valign="middle" width="3"><img src="images/tabRight.png" width="3" height="28" border="0" alt="" /></td>
				<td width="3" class="tabsp"><img src="images/shim.gif" height="1" width="3" /></td>
				<td height="28" valign="middle" width="3"><img src="images/tabSelectedLeft.png" width="3" height="28" border="0" alt="" /></td>
				
          <td valign="middle" nowrap="nowrap"  background="images/tabSelectedBg.png">&nbsp;<a href="?m=users&a=list&tab=0"><?php echo $user->_($strSystem_LabInactiveUser);?></a>&nbsp;</td>
				<td valign="middle" width="3"><img src="images/tabSelectedRight.png" width="3" height="28" border="0" alt="" /></td>
				<td width="3" class="tabsp"><img src="images/shim.gif" height="1" width="3" /></td>
			</table>
            <?php } ?>
</td>
	</tr>
	<tr>
		<td width="100%" colspan="9" class="tabox">
		<!--  in class Users -->
		<?php
		if($tab == '') 
		{
			$tab = 1;
		}
		if($orderby == '') 
		{
			$orderby = "id";
		}
		//if($search == 1) {			
			//$row = $users->SearchUsers($where,$page);
			//$row_page = $users->SelectUsersPerPage($row,$page);
			//$users->ShowTableAll($row_page,$user,$uistyle,$tab,$page,$stub);
		//} else {
			if($tab==1) {
				if ($stub == 99){
					$stubed = 0;
				} else {
					if (strlen($stub) == 3){
						$stubed = 1;
					} else {				
						$stubed = 2;
					}	
				}
				switch ($stubed) {							
						case 0:										
							if($search==1)
								$row = $users->SearchUsers($where,$page);
							else
								$row = $users->SelectAllUsers($tab,$orderby,$page);
							if($page == 1) {							
								$row_page = $users->SelectUsersPerPage($row,$page);
								$users->ShowTableAll($row_page,$user,$uistyle,$tab,$page,$stub);							
							} else {							
								$row_page = $users->SelectUsersPerPage($row,$page);
								$users->ShowTableAll($row_page,$user,$uistyle,$tab,$page,$stub);
							}
							$users->ShowSeqTable($row,$orderby,$page,$stub,$tab);																																		
							break;
						case 1:						
							if($search==1)
								$row = $users->SearchUsers($where,$page);
							else
								$row = $users->SelectAllUsers($tab,$orderby,$page);
							$row_page = $users->SelectUsersPerPage($row,$page);
							$users->ShowTableAll($row_page,$user,$uistyle,$tab,$page,$stub);
							$users->ShowSeqTable($row,$orderby,$page,$stub,$tab);																																		
							break;
						case 2:
							$row = $users->SearchUsers($stub,$page);
							$row_page = $users->SelectUsersPerPage($row,$page);
							$users->ShowTableAll($row_page,$user,$uistyle,$tab,$page,$stub);			
							$users->ShowSeqTable($row,$orderby,$page,$stub,$tab);																																		
							break;
				}
			} else {
				if($search==1)
					$row = $users->SearchUsers($where,$page);
				else
					$row = $users->SelectAllUsers($tab,$orderby,$page);
				$row_page = $users->SelectUsersPerPage($row,$page);
				$users->ShowTableAll($row_page,$user,$uistyle,$tab,$page,$stub);			
				$users->ShowSeqTable($row,$orderby,$page,$stub,$tab);																																		
			} // End if tab == 1			
		//} // End if search == 1	
		?>
		<!--  in class Users -->
</td>
</tr>
</table> 
