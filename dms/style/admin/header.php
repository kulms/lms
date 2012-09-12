<html>
<head>
	<meta name="Version" content="<?php //echo @$AppUI->getConfig( 'version' );?>" />
	<meta http-equiv="Content-Type" content="text/html;charset=tis-620" />
	<title><?php //echo @$AppUI->getConfig( 'page_title' );?></title>
	<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/main.css" media="all" />
</head>

<body>
<table width="100%" cellpadding="3" cellspacing="0" border="0">
<tr>
	<th background="style/<?php echo $uistyle;?>/images/titlegrad.jpg" class="banner" align="left"><strong><?php echo "Welcome to Document Management System for Dissertation and Research Publication (For Teacher)";?></strong></th>
</tr>
<tr>
	<td class="nav" align="left">
	<table width="100%" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		
    <td> 
      <?php
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
      <a href="./index.php">Home</a> | <a href="index.php?m=research">Research</a> 
      | <a href="index.php?m=publication">Publication</a> | <a href="index.php?m=book">Book</a> 
      | <a href="index.php?m=search">Search</a></td>
		<form name="frm_new" method=GET action="./index.php">
<?php
	echo '        <td nowrap="nowrap" align="right">';
	$newItem = array( ""=>'- New Item -' );
	$newItem["research"] = "Research";
//	$newItem["journal"] = "Journal";
//	$newItem["proceedind"] = "Proceeding";
//	$newItem["presentation"] = "Presentation";
	$newItem["publication"] = "Publication";
	$newItem["book"] = "Book";

	echo arraySelect( $newItem, 'm', 'style="font-size:10px" onChange="f=document.frm_new;mod=f.m.options[f.m.selectedIndex].value;if(mod) f.submit();"', '', true);

	echo "</td>\n";
	echo "        <input type=\"hidden\" name=\"a\" value=\"addedit\" />\n";
	

//build URI string
	if (isset( $company_id )) {
		echo '<input type="hidden" name="company_id" value="'.$company_id.'" />';
	}
	if (isset( $task_id )) {
		echo '<input type="hidden" name="task_parent" value="'.$task_id.'" />';
	}
	if (isset( $file_id )) {
		echo '<input type="hidden" name="file_id" value="'.$file_id.'" />';
	}
?>
		</form>
		</td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	
  <td>&nbsp; </td>
</tr></table>
