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
		
    <td><a href="index.php?a=select_level"><?php echo "Show Grade";?></a></td>		
		</td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	
  <td>&nbsp; </td>
</tr></table>
