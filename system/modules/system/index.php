


<?php  
/*
$users = new Users('', '', '', '', '',  
				   '', '', '', '', '', 
				   '', '', '', '', ''
				   );
*/
?>

<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />
<link rel="stylesheet" type="text/css" href="./themes/red/style/main.css" >!-->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="30%">	
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td><img src="./modules/system/images/my_computer.png" border="0"></td>
			<td><h1><?php echo $user->_($strSystem_LabSystem);?></h1></td>
		  </tr>
		</table>
	</td>
	<td align="right" width="25%" valign="bottom">
	</td>
	<td align="left" nowrap width="45%">

	</td>
  </tr>  
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="7%">&nbsp;</td>
    <td width="93%">&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><img src="./modules/system/images/my_modules.png" border="0"></td>
        </tr>
      </table></td>
    <td><h2><?php echo $user->_($strSystem_LabModule);?></h2></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td><a href="?m=system&a=viewmods"><?php echo $user->_($strSystem_LabViewModule);?></a></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <!--
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><img src="./modules/system/images/rdf2.png" border="0"></td>
        </tr>
      </table></td>
    <td><h2><?php echo $user->_('System Language');?></h2></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $user->_('translation management');?></td>
  </tr>
  -->
  
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><img src="./modules/system/images/gnome-hint.png" border="0"></td>
        </tr>
      </table></td>
    <td><h2><?php echo $user->_($strSystem_LabDisplay);?></h2></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><a href="?m=system&a=themesetup"><?php echo $user->_($strSystem_LabDisplaySetup);?></a></td>
  </tr>  
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><img src="./modules/system/images/my_backup.png" border="0"></td>
        </tr>
      </table></td>
    <td><h2><?php echo $user->_($strSystem_LabBackup);?></h2></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><a href="./modules/system/backup.php"><?php echo $user->_($strSystem_LabBackupDb);?></a></td>
  </tr>
 
 
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><img src="./modules/system/images/rdf3.png" border="0"></td>
        </tr>
      </table></td>
    <td><h2><?php echo $user->_($strSystem_LabNews);?></h2></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><a href="?m=system&a=news"><?php echo $user->_($strSystem_LabNewsAnnounce);?></a></td>
  </tr>
 
 
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><img src="./modules/system/images/rdf2.png" border="0"></td>
        </tr>
      </table></td>
    <td><h2><?php echo $user->_($strSystem_LabFirstpage);?></h2></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><a href="?m=system&a=controlpage"><?php echo $user->_($strSystem_LabControlFirstpage);?></a></td>
  </tr>
 
 
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 
 
 
  <!--
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><img src="./modules/system/images/my_advert.png" border="0"></td>
        </tr>
      </table></td>
    <td><h2><?php echo $user->_('System Advertisting');?></h2></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><a href="#"><?php echo $user->_('Advertisting Banner');?></a></td>
  </tr>
  -->
</table>
<?		
		//$row = $research->SelectAllResearch($user->getUserId());
		//$research->ShowTableAll($row,$user,$uistyle);
?>

