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
$a2z .= '<td><a href="./index.php?m=users&stub=0">' . $user->_('All') . '</a></td>';
for ($c=65; $c < 91; $c++) {
	$cu = chr( $c );
	$cell = strpos($let, "$cu") > 0 ?
		"<a href=\"?m=users&stub=$cu\">$cu</a>" :
		"<font color=\"#999999\">$cu</font>";
	$a2z .= "\n\t<td>$cell</td>";
}
$a2z .= "\n<tr>";
$a2z .= '<td width="100%" align="right">' . $user->_(''). ': </td>';
for ($c=161; $c < 188; $c++) {
	$cu = chr( $c );
	$cell = strpos($let, "$cu") > 0 ?
		"<a href=\"?m=users&stub=$cu\">$cu</a>" :
		"<font color=\"#999999\">$cu</font>";
	$a2z .= "\n\t<td>$cell</td>";
}
$a2z .= "\n<tr>";
$a2z .= '<td width="100%" align="right">' . $user->_(''). ': </td>';
for ($c=188; $c < 207; $c++) {
	$cu = chr( $c );
	$cell = strpos($let, "$cu") > 0 ?
		"<a href=\"?m=users&stub=$cu\">$cu</a>" :
		"<font color=\"#999999\">$cu</font>";
	$a2z .= "\n\t<td>$cell</td>";
}

$a2z .= "\n</tr>\n</table>";

?>

<!--<link rel="stylesheet" type="text/css" href="./style/<?php// echo $uistyle;?>/faq.css" media="all" />-->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="30%"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="8%"><img src="./modules/users/images/helix-setup-users.png" border="0"></td>
          <td width="92%"><h1><?php echo $user->_($strSystem_LabUser);?></h1></td>
        </tr>
      </table></td>
  </tr>
</table>

<?		
		//$row = $research->SelectAllResearch($user->getUserId());
		//$research->ShowTableAll($row,$user,$uistyle);
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="6%">&nbsp;</td>
    <td width="6%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><img src="./modules/users/images/user_new.png" border="0"></td>
        </tr>
      </table></td>
    <td width="34%"><h2><?php echo $user->_('สร้างผู้ใช้ใหม่ (New User)');?></h2></td>
    <td width="2%">&nbsp;</td>
    <td width="7%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><img src="./modules/users/images/user_list.png" border="0"></td>
        </tr>
      </table></td>
    <td width="45%"><h2><?php echo $user->_('รายการผู้ใช้ (Users List)');?></h2></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><a href="?m=users&a=addedit"><?php echo $user->_('เพิ่มผู้ใช้ใหม่ (Add new User)');?></a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><a href="?m=users&a=list"><?php echo $user->_('ดูรายการผู้ใช้ (View Users List)');?></a></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><img src="./modules/users/images/user_file.png" border="0"></td>
        </tr>
      </table></td>
    <td><h2><?php echo $user->_('สร้างผู้ใช้ใหม่จากแฟ้มข้อมูล (New User From File)');?></h2></td>
    <td>&nbsp;</td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><!--<img src="./modules/users/images/user_config.png" border="0">--></td>
        </tr>
      </table></td>
    <td><h2><?php //echo $user->_('User Configulation');?></h2></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><a href="?m=users&a=import"><?php echo $user->_('เพิ่มผู้ใช้ใหม่จากแฟ้มข้อมูล (Add new users from file)');?></a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><a href="#"><?php //echo $user->_('Edit user configulation');?></a></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
