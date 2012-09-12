<?
require("classes/grade.class.php");
@setcookie('ModuleID');
$grade=New Grade();
 if (isset($insert) && strlen($g_score_name)!=0) {
         
		 $chkscr = true;
		 
		 if($g_name!=0) {
           
		   $check = mysql_query("select distinct g_max_score from g_score_type 
		                                                 where g_score_type_g_id = ".$g_name."");

		     
			if (mysql_num_rows($check) !=0) { 
			           
					   $rs = mysql_fetch_array($check);
			       
				         if($rs[0] !=  $g_score) {
					        
				             $chkscr = false; 
								
						echo "<script language='javascript'>alert('max score group is $rs[0]');location.href='?id=$id&courses=$g_courses';</script>";
					            
							
							}
			             
					}
			
			
			}

       if($chkscr) {
			if($ModuleName != ""){
				$g_modules_id=$m_id;
				$sql=mysql_query("SELECT modules_type FROM modules WHERE id =".$m_id."");
				$module_type=mysql_result($sql,0,'modules_type');
			}
			else{
				$g_modules_id=0;
				$module_type=0;
			}
	
			mysql_query("INSERT INTO g_score_type (g_grade_id,g_modules_id,g_score_type_g_id,g_modules_type,g_score_type_name,g_max_score,g_users,g_lastupdate) 
						 VALUES (".$id.",".$g_modules_id.",".$g_name.",".$module_type.",'".$g_score_name."',".$g_score." ,".$person["id"].", ".time().")");
					
	    }
 
 }//end submit

 $sql ="select tg.g_score_type_g_name,t.g_score_type_g_id,t.g_score_type_id,t.g_score_type_name,
			t.g_max_score from g_score_type t LEFT JOIN g_score_type_group tg
			 on t.g_score_type_g_id = tg.g_score_type_g_id
			where t.g_grade_id = ".$id."
			order by t.g_score_type_g_id DESC,t.g_score_type_name";
	
	
        $result = @mysql_query($sql);
  

$gd_score= $grade->check_score($id);
		
		//print_progress("0", $id);
?>

<html>
<title>
</title>
<head>

<link href="../themes/<? echo $theme;?>/style/main.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<SCRIPT LANGUAGE='javascript' src='validate.js'></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="classes/form.js"></SCRIPT>

<script LANGUAGE="javascript">

function check()
{
     var score;
	
	score=<?echo $gd_score?>;
	
	
	 if (score !=100 ) {
	
			alert("total score not equal 100");
			
			return false;		
	 
			}
	
	
	location.href="?a=std_score&gid=<? echo $id;?>";
	
	return true;

}

/*---- nok create 28/03/05 -- */
function  NewWin(gid){
	window.open("sel_module.php?gid="+gid, "qWindow", "ScreenX=200,ScreenY=70,width=650,height=580,status=no,toolbar=no,menubar=no,scrollbars=yes");
}
/*--end nok create --*/
</script>
</head>
<body>
<table width="100%" border="0" cellspacing="2" cellpadding="4" class="tdborder1">
  <tr>
    <td width="10%" class="tdLine" valign="top"><br><? print_progress("0", $id,$strGrade_LabProgress,$strGrade_LabSetRatio,$strGrade_LabInputScore,$strGrade_LabSetLevelType,$strGrade_LabSetScoreType,$strGrade_LabReport);?></td>
    <td width="75%">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="50%">	
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>			
				<td ><h1><?php echo $strGrade_LabSetRatio  ;?></h1></td>
			  </tr>
			</table>
		</td>
		<td align="right" width="25%" valign="bottom">
			
		</td>	
	  </tr>  
	</table>
	<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tdborder1">
	  <tr> 
		<td colspan="5" align="center"><font color="#666600"><b><font color="#FF0000">***</font></b></font> 
		  <b> </b><font color="#666600"><b><font color="#FF0000">***</font></b></font></td>
	  </tr>
	  <tr align="center" class="boxcolor"> 
		<td width="6%" class="main_white" ><?=$strGrade_LabNo;?></td>
		<td width="45%"  class="main_white"><?=$strGrade_LabScoreName;?></td>
		<td width="24%"  class="main_white"><?=$strGrade_LabGroup;?></td>
		
		<td width="17%" class="main_white"><?=$strGrade_LabScore;?></td>
		
		<td width="8%"   class="main_white">Action</td>
	  </tr>
	<?
	  $i=1;
	
	
	 
	 while ($row = mysql_fetch_array($result)) { ?>
	  <tr bgcolor="#FFFFFF"> 
		<td align="center"><? echo $i;?></td>
		<td align="center">
			<? echo $row["g_score_type_name"];?>
			
		</td>
	   <td align="center">
			<? 
		$g_id= $row["g_score_type_g_id"];
		
		if ($g_id==0){
				echo "-";
					
			}else{
				echo $row["g_score_type_g_name"];
				}
			?>
		</td>
		<td align="center">
			<? 
			echo $row["g_max_score"];
			
			
			?>
		</td>
		
		<td align="center">
			<a href="?a=edit_scoretype&id=<? echo $row["g_score_type_id"]; ?>&courses=<?echo $g_courses;?>&gid=<? echo $id;?>" target="_self">
				<img src="images/icon/_edit-16.png" border="0" alt="edit">
			</a> 
			<a href="#" onclick = "iconfirm('?a=del_scoretype&id=<? echo $row["g_score_type_id"]; ?>&del=score&gid=<? echo $id; ?>&courses=<? echo $courses?>','Do you want delete score?')">
			<img src="images/icon/_cancel-16.png" border="0" alt="delete">
		</a>
				
		</td>
	  </tr>
	<?
	$i++;
	}
	?>
	<tr class="boxcolor"><td colspan="3" bgcolor="#FFFFFF"></td>
	
	<td class="Bcolor"><? echo $strGrade_LabTotal." = ".$gd_score;?></td>
	<td bgcolor="#FFFFFF"></td>
	</tr>
	</table><br>
	<div align="right"><input type="button" value="<?=$strGrade_BtnNext;?>" class="button" onclick="return check(this);"></div>
	<br>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	 
	</table>
	
	<form name="insert_gname" method="post" action="?a=main" onsubmit=" return validateForm(this);">
	
	  <table width="603" border="0" align="center" cellpadding="2" cellspacing="0" class="tdborder2">
		<tr class="boxcolor"> 
		  <th colspan="2"  class="Bcolor"><?=$strGrade_LabAdd ;?></th>
		</tr>
		<tr bgcolor="#FFFFFF"> 
		  <td  align="left" class="hilite"> 
			<input name="insert" type="submit" value="<?=$strSave;?>" class="button"> 
		  <input name="reset" type="reset"  value="<?=$strReset;?>" class="button" onClick="DeleteCookie('ModuleID');">	  
		   <input name="id" type="hidden" value="<? echo $id;?>" > 
		  </td>
	   <td align="right"><a href="#" onClick="newWindow('?a=create_group',400,200,'no','no')"><?=$strGrade_LabCreateGroup;?></a> |&nbsp;<a href="#" onClick="newWindow('?a=show_group',400,200,'no','yes')"><?=$strGrade_LabShowGroup;?></a></td>
		</tr>
		<tr> 
		  <td width="187" align="right"><?=$strGrade_LabGroup;?> : 
		  </td>
		  <td width="404">
			<?
		$sql = "select g_score_type_g_id,g_score_type_g_name from g_score_type_group where 
					   g_users = ".$person["id"]." order by g_score_type_g_name ";
		
		$result = mysql_query($sql);
	  
						echo "<select name=\"g_name\" class=\"text\">";
						echo "<option value=\"0\">$strGrade_LabSelectGroup</option>";
					  while ($row = mysql_fetch_array($result)) {
						 
						 echo "<option value=\"$row[0]\" >$row[1]</option>";
		
				 
								  }
			echo "</select>";
					  
				?>	  
		  </td>
		</tr>
		<tr> 
		  <td align="right"><?=$strGrade_LabScoreName;?> :</td>
		  <td><input name="g_score_name" type="text" size="35" maxlength="200" class="text"></td>
		</tr>
		<tr> 
		  <td align="right"><?=$strGrade_LabMaxScore ;?> : </td>
		  <td> <input name="g_score" type="text"  size="5" maxlength="3" class="text"> 
		  </td>
		</tr>
	  <!-- nok create 25/03/05 -->
    <tr>
      <td align="right">&nbsp;</td>
      <td><input name="ModuleName" type="text" class="text"  onFocus="blur();">
      <input  type="hidden" name="m_id">
      <a href="#" onClick="newWindow('?a=sel_module&courses=<? echo $courses;?>&form=insert_gname',600,580,'no','no','yes')"><?=$strGrade_SelectModule;?></a> </td>
    </tr>
	
	<!--  end nok create-->
	  
	  
	  </table>
	</form>
	</td>
  </tr>
</table>

</body>
</html>