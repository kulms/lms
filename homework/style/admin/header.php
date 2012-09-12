<html>
<head>
	<meta name="Version" content="<?php //echo @$AppUI->getConfig( 'version' );?>" />
	<meta http-equiv="Content-Type" content="text/html;charset=tis-620" />
	<title><?php //echo @$AppUI->getConfig( 'page_title' );?></title>
	<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/main.css" media="all" />!-->
<link rel="stylesheet" type="text/css" href="../../../themes/<?php echo $theme;?>/style/main.css" >
</head>

<body>
<table width="100%" cellpadding="3" cellspacing="0" border="0">
<tr>
	<td background="../themes/<?php echo $theme;?>/images/titlegrad.jpg"  align="left" class="banner"><strong><?php echo "Welcome to Homework Management System (For Student)";?></strong></td>

	</tr>
<tr>
	<td class="nav" align="left">
	<table width="100%" cellpadding="0" cellspacing="0" width="100%">
	<tr>		
    <td>&nbsp;
	</td>	  
	  <!--
	  <? //echo "modules:".$modules;?>
		<form name="frm_new" method=POST action="./edit.php?modules=<? //if($modules != 0) { echo $modules;} else { echo $id;}?>&id=0">
<?php
/*
	echo '        <td nowrap="nowrap" align="right">add : ';
	$newItem = array( ""=>'- New Item -' );
	$newItem["1"] = "Questions Text";
	$newItem["2"] = "Questions URL";
	$newItem["3"] = "Questions File";

	echo arraySelect( $newItem, 'add', 'style="font-size:10px" onChange="f=document.frm_new;mod=f.add.options[f.add.selectedIndex].value;if(mod) f.submit();"', '', true);

	echo "</td>\n";
	echo "        <input type=\"hidden\" name=\"a\" value=\"addedit\" />\n";
	//echo '<input type="hidden" name="ids" value=\"$ids\" />';
	//echo '<input type="hidden" name="modules" value="'.$id.'" />';
	echo '<input type="hidden" name="courses" value="'.$courses.'" />';
*/
?>
		</form>
		-->
		</td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	
  <td>&nbsp; </td>
</tr></table>
