<?php  

$courses = new Courses('', '', '', '', '',  
				   '', '', '', 
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

$sql = "SELECT DISTINCT UPPER(SUBSTRING(fullname, 1, 1)) AS L FROM courses";
$arr = $user->db_loadList($sql);
foreach( $arr as $L ) {
    $let .= $L['L'];
}


$sql = "SELECT DISTINCT UPPER(SUBSTRING(fullname_eng, 1, 1)) AS L FROM courses";
$arr = $user->db_loadList($sql);
foreach( $arr as $L ) {
	$let .= $L['L'];
    //$let .= strpos($let, $L['L']) ? '' : $L['L'];
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
$a2z .= '<td><a href="./index.php?m=courses&stub=0">' . $user->_('All') . '</a></td>';
for ($c=65; $c < 91; $c++) {
	$cu = chr( $c );
	$cell = strpos($let, "$cu") > 0 ?
		"<a href=\"?m=courses&stub=$cu\">$cu</a>" :
		"<font color=\"#999999\">$cu</font>";
	$a2z .= "\n\t<td>$cell</td>";
}
$a2z .= "\n<tr>";
$a2z .= '<td width="100%" align="right">' . $user->_(''). ': </td>';
for ($c=161; $c < 188; $c++) {
	$cu = chr( $c );
	$cell = strpos($let, "$cu") > 0 ?
		"<a href=\"?m=courses&stub=$cu\">$cu</a>" :
		"<font color=\"#999999\">$cu</font>";
	$a2z .= "\n\t<td>$cell</td>";
}
$a2z .= "\n<tr>";
$a2z .= '<td width="100%" align="right">' . $user->_(''). ': </td>';
for ($c=188; $c < 207; $c++) {
	$cu = chr( $c );
	$cell = strpos($let, "$cu") > 0 ?
		"<a href=\"?m=courses&stub=$cu\">$cu</a>" :
		"<font color=\"#999999\">$cu</font>";
	$a2z .= "\n\t<td>$cell</td>";
}

$a2z .= "\n</tr>\n</table>";

?>

<!--<link rel="stylesheet" type="text/css" href="./style/<?php echo //$uistyle;?>/faq.css" media="all" />!-->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="30%">	
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="11%"><img src="./modules/courses/images/my_courses.png" border="0"></td>
			<td width="89%"><h1><?php echo $user->_($strSystem_LabCourses);?></h1></td>
		  </tr>
		</table>
	</td>
	<td align="right" width="25%" valign="bottom">
	<form name="frmSearch" method="post" action="?m=courses">
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

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%">&nbsp;</td>
	<!--
    <td width="50%" align="right"><form name="frmAdd" method="post" action="?m=courses&a=addedit">
        <input type="submit" name="Submit" value="<?php echo $user->_('new course');?>" class="button">
      </form></td>
	-->  
  </tr>
</table>

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
				<img src="../themes/<?php echo $theme;?>/images/tabSelectedLeft.png" width="3" height="28" border="0" alt="" /></td>
				<td valign="middle" nowrap="nowrap"  background="../themes/<?php echo $theme;?>/images/tabSelectedBg.png">&nbsp;<a href="?m=courses&tab=1"><?php echo $user->_($strSystem_LabActiveCourses);?></a>&nbsp;</td>
				<td valign="middle" width="3"><img src="../themes/<?php echo $theme;?>/images/tabSelectedRight.png" width="3" height="28" border="0" alt="" /></td>
				<td width="3" class="tabsp"><img src="./images/shim.gif" height="1" width="3" /></td>
				<td height="28" valign="middle" width="3"><img src="../themes/<?php echo $theme;?>/images/tabLeft.png" width="3" height="28" border="0" alt="" /></td>
				
          <td valign="middle" nowrap="nowrap"  background="../themes/<?php echo $theme;?>/images/tabBg.png">&nbsp;<a href="?m=courses&tab=1"><?php echo $user->_($strSystem_LabInactiveCourses);?></a>&nbsp;</td>
				<td valign="middle" width="3"><img src="../themes/<?php echo $theme;?>/images/tabRight.png" width="3" height="28" border="0" alt="" /></td>
				<td width="3" class="tabsp"><img src="./images/shim.gif" height="1" width="3" /></td>
			</table>
			<?php } else { ?>
			<table border="0" cellpadding="0" cellspacing="0">
				<td height="28" valign="middle" width="3">
				<img src="../themes/<?php echo $theme;?>/images/tabLeft.png" width="3" height="28" border="0" alt="" /></td>
				
          <td valign="middle" nowrap="nowrap"  background="../themes/<?php echo $theme;?>/images/tabBg.png">&nbsp;<a href="?m=courses&tab=1"><?php echo $user->_($strSystem_LabActiveCourses);?></a>&nbsp;</td>
				<td valign="middle" width="3"><img src="../themes/<?php echo $theme;?>/images/tabRight.png" width="3" height="28" border="0" alt="" /></td>
				<td width="3" class="tabsp"><img src="./images/shim.gif" height="1" width="3" /></td>
				<td height="28" valign="middle" width="3"><img src="../themes/<?php echo $theme;?>/images/tabSelectedLeft.png" width="3" height="28" border="0" alt="" /></td>
				
          <td valign="middle" nowrap="nowrap"  background="../themes/<?php echo $theme;?>/images/tabSelectedBg.png">&nbsp;<a href="?m=courses&tab=1"><?php echo $user->_($strSystem_LabInactiveCourses);?></a>&nbsp;</td>
				<td valign="middle" width="3"><img src="../themes/<?php echo $theme;?>/images/tabSelectedRight.png" width="3" height="28" border="0" alt="" /></td>
				<td width="3" class="tabsp"><img src="./images/shim.gif" height="1" width="3" /></td>
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
			$orderby = "name";
		}
		if($search == 1) {			
			$row = $courses->SearchCourses($where,$page);
			$courses->ShowTableAll($row,$user,$uistyle,$tab,$page);
		} else {
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
							$row = $courses->SelectAllCourses($tab,$orderby,$page);
							if($page == 1) {							
								$row_page = $courses->SelectCoursesPerPage($tab,$orderby,$page);
								$courses->ShowTableAll($row_page,$user,$uistyle,$tab,$page);							
							} else {							
								$row_page = $courses->SelectCoursesPerPage($tab,$orderby,$page);
								$courses->ShowTableAll($row_page,$user,$uistyle,$tab,$page);
							}
							$courses->ShowSeqTable($row,$page);																																		
							break;
						case 1:						
							$row = $courses->SelectAllCourses($tab,$orderby,$page);
							$courses->ShowTableAll($row,$user,$uistyle,$tab,$page);
							break;
						case 2:
							$row = $courses->SearchCourses($stub,$page);
							$courses->ShowTableAll($row,$user,$uistyle,$tab,$page);						
							break;
				}
			} else {
				$row = $courses->SelectAllCourses($tab,$orderby,$page);				
				$courses->ShowTableAll($row,$user,$uistyle,$tab,$page);
			} // End if tab == 1			
		} // End if search == 1	
		?>
		<!--  in class Users -->
</td>
</tr>
</table>
