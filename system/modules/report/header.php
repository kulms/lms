<? require ("../include/global_login.php"); 
	require_once ($user->getModuleClass( $realpath, 'users' ));	  
	  $permission = Permission::lookupPermission($user->getUserId());
	 $report = new Report(''); 	
	 if($user_type =="" || $users_category !="" ){
		$report->cat_id = $users_category;	
	}else{
		$report->cat_id = $user_type;
	}
		if($courses != "")
			$course="&courses=$courses";

?>
<script language="javascript">
function UserType()
{
		var f=document.header;
		var  id=document.all.user_type.value ;
	  	id = document.all.users_category.selectedIndex;
		//alert(id);
	 	f.submit();
}
</script>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>

<body>
<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />!-->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="30%">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="6%"><img src="./modules/report/images/my_report.png" border="0"></td>
          <form action="?m=report&a=process" method="post">
            <td width="94%"><h1><?php echo $user->_($strSystem_LabReport);?>&nbsp;&nbsp; &nbsp;&nbsp;
                    <input type="submit" value="<?php echo $user->_($strSystem_LabReport);?>" name="process" class="button">
                    <input type="hidden" name="courses" value="<? echo $courses?>">
            </h1></td>
          </form>
        </tr>
    </table></td>
  </tr>
</table>
<table width="90%"  border="0" cellspacing="0" cellpadding="0" align="center">
<form action="?m=report&a=all" name="header" method="post">
  <tr>
    <td height="31"><?php echo $user->_($strSystem_LabUserType);?> : 
      <select name="users_category" style="font-size:10px" onchange="UserType();">
        <option value="0" <? if($report->getCatId()==0) echo "selected";?> ><?php echo $user->_($strSystem_LabUserTypeAll);?></option>
         <? if($courses ==""){?>
		<option value="1" <? if($report->getCatId()==1) echo "selected";?>><?php echo $user->_($strSystem_LabUserTypeAdmin);?></option>
         <? }?>
		 <option value="2" <? if($report->getCatId()==2) echo "selected";?>><?php echo $user->_($strSystem_LabUserTypeInstructor);?></option>
        <option value="3" <? if($report->getCatId()==3) echo "selected";?>><?php echo $user->_($strSystem_LabUserTypeStudent);?></option>
        </select>
			<input type="hidden" name="user_type" value="<?php if($report->getCatId()!=0) { echo $report->getCatId(); } else { echo "0";}?>" >
			</td><input type="hidden" name="courses" value="<? echo $courses?>">
  </tr>
  </form>
</table>
<table width="90%" cellpadding="3" cellspacing="0" border="0" align="center">
  <tr>
 <? if($permission->getSysPAdminSuper()==1) { 
 ?>
    <td class="nav" align="left">
    <font color="#000000"><strong><?php echo $user->_($strSystem_RMenuHeader);?></strong>
&nbsp;:  <a href="?m=report&a=all&user_type=<? echo $report->getCatId();?><? echo $course?>"><? echo $user->_($strSystem_RMenuAll);?></a> | 
<a href="?m=report&a=courses&user_type=<? echo $report->getCatId();?><? echo $course?>"><? echo $user->_($strSystem_RMenuCourse);?></a> | 
<a href="?m=report&a=modules&user_type=<? echo $report->getCatId();?><? echo $course?>"><? echo $user->_($strSystem_RMenuModules);?></a> |
<a href="?m=report&a=login&user_type=<? echo $report->getCatId();?><? echo $course?>"><? echo $user->_($strSystem_RMenuLogin);?></a> | 
<a href="?m=report&a=logout&user_type=<? echo $report->getCatId();?><? echo $course?>"><? echo $user->_($strSystem_RMenuLogout);?></a>   
<? } else { 
?>
<td class="nav" align="left">
      <font color="#000000"><font color="#000000"></font>
      <font color="#000000"><font color="#000000"><strong><?php echo $user->_($strSystem_RMenuHeader);?></strong></font></font>&nbsp;:  <a href="?m=report&a=all<? echo $course?>"><? echo $user->_($strSystem_RMenuAll);?></a> | 
<a href="?m=report&a=courses<? echo $course?>"><? echo $user->_($strSystem_RMenuCourse);?></a> | 
<a href="?m=report&a=modules<? echo $course?>"><? echo $user->_($strSystem_RMenuModules);?></a>
<? if($permission->getSysPAdminReport()==1 && $courses =="") { ?>
 | <a href="?m=report&a=login<? echo $course?>"><? echo $user->_($strSystem_RMenuLogin);?></a> | 
<a href="?m=report&a=logout<? echo $course?>"><? echo $user->_($strSystem_RMenuLogout);?></a>   
<? }
}?>
</font> </td>
  </tr>
</table>
</body>
</html>
