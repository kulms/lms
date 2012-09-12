<?
	session_start();
	$session_id = session_id();		

	require ("../include/global_login.php");
	
	require_once ("./classes/User.php");
	require_once ("./classes/UserStorage.php");
	require_once( "./includes/main_functions.php" );

		
	$user = UserStorage::lookupById($person["login"]);
	
	session_register( 'user' ); 		
	
	switch ($user->getCategory()) {
		case 0:
			$uistyle = "admin";
			break;
		case 1:
			$uistyle = "admin";
			break;
		case 2:
			$uistyle = "teacher";
			break;
		case 3:
			$uistyle = "student";
			break;
		default:
			$uistyle = "guest";
		}

$users=mysql_query("SELECT * from users WHERE id=".$person["id"]);
?>
<html>
<head>
<script type="text/javascript" language="JavaScript" src="../createlogin/AutoSelect.js"></script>
<script language="JavaScript">
	function BrowserInfo()
	{	  this.screenWidth = screen.availWidth;
		  this.screenHeight = screen.availHeight;
	}
</script>
<script language='javascript'> 
		function iconfirm(in_url)
		{
				if( confirm("Do you really want to delete this Department and its major ?") )
					{   
						document.location =in_url; 
					 }
		}
		
		function callDepartment(f){
		//var f = window.document.user.fac.value;
		window.open('showdept.php?facid='+f,'department','status=no,top=0,left=100,scrollbars=1,height=600,width=800');
}

function callmajor(){
		var f = window.document.user.fac.value;
		var d = window.document.user.dept.value;
		window.open('showmajor.php?facid='+f+'&deptid='+d,'major','status=no,top=0,left=100,scrollbars=1,height=600,width=800');
}

</script>
<title>Resources</title>
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
<!--<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/main.css" media="all" />
<link rel="stylesheet" type="text/css" href="./style/<?php echo $uistyle;?>/faq.css" media="all" />!-->
<meta http-equiv="Content-Type" content="text/html; charset=tis-620"></head>
<body bgcolor="#ffffff">
<div align="center">
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"
	    height="53" class="bg1">
          <tr> 
            <td class="menu" align="center"> <b>E-Courseware Center</b> 
            </td>
          </tr>
        </table><br>
	 <!--
	  <table border="0" cellpadding="0" cellspacing="0" width="60%">
		<tr> 
		  <td class="res" width="464">
		  <img src="../images/resources.gif" width=20 height=16 alt="" border="0" align="top"> E-Courseware Center</td>		
		  <td class="res" width="1"><a href="edit.php?id=0&folder=true"> </a> </td>
		</tr>
		<tr>
		  <td class="res" colspan="2">&nbsp; </td>
		</tr>
	  </table>
	  -->
	  <form action="index.php" method="post" name="user">
  <table width="80%" class="std" border="0" cellspacing="0" cellpadding="2">
    <tr>
      <td>
	  

          <table align="center" width="100%" cellpadding="2" cellspacing="0" border="0" class="tdborder2">
            <?
					if($person["category"]==2){
			  ?>
            <?	 }	 ?>
            <tr> 
              <td width="358">&nbsp; </td>
              <td width="615" class="info"><font color="red"><b>***</b></font> 
                <b>หากไม่เลือกจะแสดงทั้งหมด</b><font color="red"> <b>***</b></font></td>
            </tr>
            <tr> 
        <td align="right" class="hilite"><?php echo $strPersonal_LabFac;?> : </td>
        <td align="left" class="hilite">
		
		<?php 
		//    dept_id  fac_id  major_id 
		//$fac_db =  @mysql_result($users,0,"fac_id"); 
		//$fac_db =  @mysql_result($users,0,"fac_id"); 
		$fac_db = $fac;
		$rs = mysql_query("select  FAC_NAME,NAME_ENG  from ku_faculty  where id='$fac_db'");
	 	if($fac_db !="" && $fac_db !=-1) $fname =  @mysql_result($rs,0,"FAC_NAME")." [".@mysql_result($rs,0,"NAME_ENG")."]";  ?> 
		  <input type="text" name="facname"  value="<?=$fname?>"  readonly class="text" size="45">
		<input type="hidden" name="fac"  value="<?=$fac_db?>" id="fac">
		 <input type="button" class="button" name="fac_select" value="Select"  onClick="window.open('showfaculty.php','faculty','status=no,top=0,left=100,scrollbars=1,height=600,width=800');">
		
        </td>
      </tr>
<? //if($dept =="-1"){   // Dept
//$dept_db =  @mysql_result($users,0,"dept_id"); 
$dept_db =  $dept; 
$rs2 = @mysql_query("select  NAME_THAI,NAME_ENG  from ku_department  where id='$dept_db'");
	if($dept_db !="" && $dept_db !=-1) $dname =  @mysql_result($rs2,0,"NAME_THAI")." [".@mysql_result($rs2,0,"NAME_ENG")."]";  ?> 

      <tr> 
        <td align="right" class="hilite"><?php echo $strPersonal_LabDep;?> : </td>
        <td align="left" class="hilite"> 
			<input type="text" name="deptname"  value="<?=$dname?>"  readonly=""class="text" size="45">
		<input type="hidden" name="dept"  value="<?=$dept_db?>" id="dept">
		 <!--<input type="button" class="button" name="dept_select" value="Select"  onClick="callDepartment('<?=$fac_db?>');">-->
		 		 <input type="button" class="button" name="fac_select" value="Select"  onClick="window.open('showdept.php?facid=<? echo $fac;?>','faculty','status=no,top=0,left=100,scrollbars=1,height=600,width=800');">

        </td>
      </tr>
<?  //}  ?>

<? //if($dept_db !="" && $dept_db !=-1){   // major
 //$major_db =  @mysql_result($users,0,"major_id"); 
 $major_db =  $major; 
$rsm = @mysql_query("select  NAME_THAI,NAME_ENG  from ku_major  where id='$major_db'");
	 if($major_db !="" && $major_db !="no")   $mname =  @mysql_result($rsm,0,"NAME_THAI")." [".@mysql_result($rsm,0,"NAME_ENG")."]";  ?> 
      <tr> 
        <td align="right" class="hilite">สาขาวิชา : </td>
        <td align="left" class="hilite"> 
		<input type="text" name="majorname"  value="<?=$mname?>"  readonly=""class="text" size="45">
		<input type="hidden" name="major"  value="<?=$major_db?>" id="major">
		 <!--<input type="button" class="button" name="major_select" value="Select"  onClick="callmajor(<?=$dept_db?>);">-->
		 		 		 <input type="button" class="button" name="fac_select" value="Select"  onClick="window.open('showmajor.php?deptid=<? echo $dept?>&facid=<? echo $fac?>','faculty','status=no,top=0,left=100,scrollbars=1,height=600,width=800');">

        </td>
   </tr>
        <?php		
		
//		} 
		?>
            <?	if($tmpFact !="")					
				echo $tmpFact;
			else
				echo ("<script language= \"javascript\">
						  function selFac()
							{
							}
							</script>");
?>
            
            <?	 if($tmpDept!="")
				echo($tmpDept);
	     else
				echo ("<script language= \"javascript\">
					  function selDept()
						{
						}
						</script>");
	?>
            
            <tr bgcolor="#FFFFFF"> 
              <td  align="center"  class="hilite">&nbsp; </td>
              <td  class="hilite"><input type="button" class="button" name="show_res" value="Show Content"  onClick="location.href('show_res.php?dept=<? echo $dept?>&fac=<? echo $fac?>&major=<? echo $major?>');">
			    <? if (($person["category"] == 2) or ($person["category"] == 1)) { ?>
			  <input type="button" class="button" name="show_report" value="Show Report"  onClick="location.href('show_report.php?dept=<? echo $dept?>&fac=<? echo $fac?>&major=<? echo $major?>');">
			  <? } ?>
			   </td>
            </tr>
          </table>
      
	  </td>
    </tr>
  </table>
  </form>
</div>
</body>
</html>