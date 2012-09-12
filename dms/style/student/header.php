<html>
<head>
	<meta name="Version" content="<?php //echo @$AppUI->getConfig( 'version' );?>" />
	<meta http-equiv="Content-Type" content="text/html;charset=tis-620" />
	<title><?php //echo @$AppUI->getConfig( 'page_title' );?></title>
	<!--<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/main.css" media="all" />-->
	<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css" />
</head>

<body>
<table width="100%" cellpadding="3" cellspacing="0" border="0">
<tr>
	<th background="../themes/<?php echo $theme;?>/images/titlegrad.jpg"  class="BColor" align="left"><strong><?php echo "Welcome to Document Management System for Dissertation and Research Publication (For Student)";?></strong></th>
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
      <?
		$cutcode=substr(@$user->getLogin(),0,1);
		switch($cutcode)
		{
		case "g":
			?>
      <a href="./index.php">Home</a> | <a href="index.php?m=thesis">Thesis / Independant 
      Study</a> | <a href="index.php?m=search">Search</a></td>
			<?
			break;
		case "b":			
			?>
				<a href="./index.php">Home</a> | <a href="index.php?m=project">Project</a>
				 | <a href="index.php?m=search">Search</a></td>
			<?
			break;
		default:
		?>
				<a href="./index.php">Home</a> | <a href="index.php?m=project">Project</a> | <a href="index.php?m=thesis">Thesis</a>
				 | <a href="index.php?m=search">Search</a></td>
		<?			
		}
		?>
	<!--<a href="./index.php">Home</a> | <a href="index.php?m=project">Project</a> | <a href="index.php?m=thesis">Thesis</a></td>-->
		<form name="frm_new" method=GET action="./index.php">
<?php
	echo '        <td nowrap="nowrap" align="right">';
	$newItem = array( ""=>'- New Item -' );
	switch($cutcode)
		{
		case "g":
			$newItem["thesis"] = "Thesis/Independant Study";
			break;
		case "b":			
			$newItem["project"] = "Project";
			break;
		default:
			$newItem["project"] = "Project";	
			$newItem["thesis"] = "Thesis";
			break;	
		}	
	
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
