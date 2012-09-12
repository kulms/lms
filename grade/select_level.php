<?  	
		session_start();
		$session_id = session_id();		

		//require ("../include/global_login.php");
		
		$g_sql = "SELECT * FROM g_grade WHERE g_courses = $g_courses;";
		$g_query = mysql_query($g_sql);
		$g_result = mysql_fetch_array($g_query);
		//echo $g_eval_type;
		//print_progress("2", $g_result["g_grade_id"]);
?>		
<html>
<title>
</title>
<head>

<link href="../themes/<? echo $theme;?>/style/main.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<script language="javascript">
<!--
function newWindow(url,w,h,r,s)
 {
   var LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
  var TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
		
   var options = "width="+w+",height="+h+",";
   options += "resizable="+r+",scrollbars="+s+",status=yes,menubar=no,toolbar=no,location=no,directories=no,";
   options += "left="+LeftPosition+",top="+TopPosition;
 
   newWin = window.open(url, "wName", options);
   newWin.focus();
 }
//-->

</script>
<SCRIPT LANGUAGE='javascript' src='validate.js'></SCRIPT>
<script language="javascript"> 
function displayCB() { 
	switch (document.all.g_eval_type.selectedIndex) { 
	case 0: 		  
		  document.all.area.innerHTML = "";		 
		break; 
	case 1: 		  
		  document.all.area.innerHTML = "";		 
		break; 	
	case 2: 
		  document.all.area.innerHTML = "<?=$strGrade_LabStdscore;?> :&nbsp;&nbsp;&nbsp;<select name=\"z\" id=\"z\" class=\"text\">"+
									   "<option value=\"0\"><?=$strGrade_LabSelectStdscore;?></option>"+
									   "<option value=\"0.7\" >0.7 (<?=$strGrade_LabExcellent;?>)</option>"+
								       "<option value=\"0.9\" >0.9 (<?=$strGrade_LabVeryGood;?>)</option>"+
									   "<option value=\"1.1\" >1.1 (<?=$strGrade_LabGood;?>)</option>"+
									   "<option value=\"1.3\" >1.3 (<?=$strGrade_LabFairlyGood;?>)</option>"+
									   "<option value=\"1.5\" >1.5 (<?=$strGrade_LabFair;?>)</option>"+
									   "<option value=\"1.7\" >1.7 (<?=$strGrade_LabPoor;?>)</option>"+
									   "<option value=\"1.9\" >1.9 (<?=$strGrade_LabVeryPoor;?>)</option>"+
									   "</select>";
										
		break; 
		default : 		  
		  document.all.area.innerHTML = "";		 
			break; 	
		}
} 

var alphaChars="1234567890.";
function validRequired(formField,fieldLabel)
{
	var result = true;
	
	if (formField.value == "")
	{
		alert('Please enter a value for the "' + fieldLabel +'" field.');
		formField.focus();
		result = false;
	}
	
	return result;
}

function allDigits(str)
{
	return inValidCharSet(str,"0123456789");
}

function inValidCharSet(str,charset)
{
	var result = true;

	// Note: doesn't use regular expressions to avoid early Mac browser bugs	
	for (var i=0;i<str.length;i++)
		if (charset.indexOf(str.substr(i,1))<0)
		{
			result = false;
			break;
		}
	
	return result;
}

function validateForm(theForm)
{
	// Customize these calls for your form
	// Start ------->					
	if (theForm.g_eval_type.value.length == 1) {	
		if ((theForm.g_eval_type.value != "")) {
			if (!validNum(theForm.g_eval_type,"Select",true))
				return false;
		}
	} else {
					alert("You must select Type.");
					return false;	
			}				
	if (theForm.g_level_type.value.length == 1) {	
		if ((theForm.g_level_type.value != "")) {
			if (!validNum(theForm.g_level_type,"Select",true))
				return false;
		}
	} else {
					alert("You must select Level Type.");
					return false;	
			}
			
	if (theForm.g_eval_type.value.length == 1) {	
		if ((theForm.g_eval_type.value != 3)) {
			if ((theForm.g_level_type.value > 2)) {
				alert("You must select variable grading to process this level.");
				return false;
			} else {
				return true;
			}	
		}	
		
	}	
								
}

function validNum(formField,fieldLabel,required)
{
	var result = true;

	if (required && !validRequired(formField,fieldLabel))
		result = false;
  
 	if (result)
 	{
 		if (!allDigits(formField.value))
 		{
 			alert('Please enter a number for the "' + fieldLabel +'" field.');
			formField.focus();		
			result = false;
		}
	} 
	
	return result;
}

</script> 
</head>
<body>
<table width="100%" border="0" cellspacing="2" cellpadding="4" class="tdborder1">
  <tr>
    <td width="10%" class="tdLine" valign="top"><br>
     <? 
	 if($person["category"] != 3) {
	 print_progress("2", $g_result["g_grade_id"],$strGrade_LabProgress,$strGrade_LabSetRatio,$strGrade_LabInputScore,$strGrade_LabSetLevelType,$strGrade_LabSetScoreType,$strGrade_LabReport);
	 }
	 ?>
	</td>
    <td width="75%">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><h1><?=$strGrade_LabHeadSelectType;?></h1></td>
  </tr>
</table>
<?php
	 if($person["category"] != 3){
		$cat_lev_sql = "SELECT DISTINCT sl.g_eval_type_id, sl.g_level_type_id, et.g_eval_type_name, lt.g_level_type_name, lt.g_level_type_desc,sl.g_active
									   FROM g_score_level sl, g_eval_type et, g_level_type lt
									   WHERE sl.g_grade_id = ".$g_result["g_grade_id"]."
									   AND sl.g_eval_type_id = et.g_eval_type_id
									   AND sl.g_level_type_id = lt.g_level_type_id
									   ;";
	}else{
		$cat_lev_sql = "SELECT DISTINCT sl.g_eval_type_id, sl.g_level_type_id, et.g_eval_type_name, lt.g_level_type_name, lt.g_level_type_desc,sl.g_active
									   FROM g_score_level sl, g_eval_type et, g_level_type lt
									   WHERE sl.g_grade_id = ".$g_result["g_grade_id"]."
									   AND sl.g_eval_type_id = et.g_eval_type_id
									   AND sl.g_level_type_id = lt.g_level_type_id AND sl.g_active=1
									   ;";
									   
		$data_pre=mysql_query("SELECT * FROM g_grade WHERE g_grade_id= ".$g_result["g_grade_id"]." ");
		$g_view_raw=mysql_result($data_pre,0,'g_view_raw'); // คะแนนดิบ
		$g_grade_active=mysql_result($data_pre,0,'g_grade_active'); // อนุญาติให้ดู
	}
	//echo $cat_lev_sql;
$cat_lev_query = mysql_query($cat_lev_sql);							   
?>
<table width="100%" border="0" cellspacing="0" cellpadding="4" class="tdborder2">
  <tr class="boxcolor">
    <td align="center" class="main_white"><?=$strGrade_LabNo;?></td>
    <td align="center" class="main_white"><?=$strGrade_LabCatetype;?></td>
    <td align="center" class="main_white"><?=$strGrade_LabLeveltype;?></td>
    <td align="center" class="main_white"><?=$strGrade_LabGrade;?></td>
	<? if($person["category"] != 3){?>
    <td colspan="2" align="center" class="main_white">Action</td>
    <td align="center" class="main_white">Active</td>
	<? } ?>
  </tr>
  <?php
  $i=1;
  while($cat_lev_result=@mysql_fetch_array($cat_lev_query)){
  ?>
  <tr>
    <td align="center"><?php echo $i;?></td>
    <td align="center"><?php 
	//$cat_lev_result["g_eval_type_name"]
	
	switch ($cat_lev_result["g_eval_type_id"]) {							
									case 1:
										echo $strGrade_LabCriteria;
									break;
									case 2:
										echo $strGrade_LabGroupGrading;			
										break;
									case 3:
										echo $strGrade_LabVarGrading;			
										break;
									case 4:
										echo  $strGrade_LabTscore;			
										break;
								
									
									}	 
	
	?>
	
	
	
	
	</td>
    <td align="center" title="<?php echo $cat_lev_result["g_level_type_desc"];?>"><?php echo $cat_lev_result["g_level_type_name"];?></td>
    <td align="center"><a href="index.php?a=score_level&g_eval_type=<?php echo $cat_lev_result["g_eval_type_id"];?>&g_level_type=<?php echo $cat_lev_result["g_level_type_id"];?>"> 
      </a>
	  <? if($person["category"] == 3){
				  
				   if($g_grade_active ==1 || $g_grade_active ==2){?>
				  <a href="index.php?a=show_grade&g_eval_type=<?php echo $cat_lev_result["g_eval_type_id"];?>&g_level_type=<?php echo $cat_lev_result["g_level_type_id"];?>"><?php echo $strGrade_LabShowGrade ;?></a>
				  <? } else{
					 echo $strGrade_LabShowGrade ;
				   }?>
	   <? }else{ ?>
	  			<a href="index.php?a=show_grade&g_eval_type=<?php echo $cat_lev_result["g_eval_type_id"];?>&g_level_type=<?php echo $cat_lev_result["g_level_type_id"];?>"><?php echo $strGrade_LabShowGrade ;?></a>
	   <? }?>
	  </td>
   <? if($person["category"] != 3){?>
   <td align="center"><a href="index.php?a=score_level&g_eval_type=<?php echo $cat_lev_result["g_eval_type_id"];?>&g_level_type=<?php echo $cat_lev_result["g_level_type_id"];?>"><img src="../images/_edit-16.png" width="16" height="16" border="0"><?=$strEdit;?>  </a></td>
    <td align="center"><? $dosql_del="?dosql=do_grade_setactive&a=select_level&cmd=delete&eval_id=".$cat_lev_result["g_eval_type_id"]."&level_id=".$cat_lev_result["g_level_type_id"]."&grade_id=".$g_result["g_grade_id"].""?>
      <a href="#" onclick = "iconfirm('<? echo $dosql_del;?>','Do you want delete score level?')" > <img src="images/icon/_delete-16.png" width="16" height="16" border="0"> <?=$strDelete;?></a></td>
    <td align="center"><?php 
				if($cat_lev_result["g_active"]==0){
					$img="dotgrey";
					$active=$strGrade_LabInActive ;
					$setactive=0;
				}else{
				   $img="dotyellowanim";
				   $active=$strGrade_LabActive;
				   $setactive=1;
			   }
			  $dosql="?dosql=do_grade_setactive&a=select_level&cmd=setactive&setactive=".$setactive."&eval_id=".$cat_lev_result["g_eval_type_id"]."&level_id=".$cat_lev_result["g_level_type_id"]."&grade_id=".$g_result["g_grade_id"]." ";
	 ?>
      <img src="images/icon/<? echo $img;?>.gif" width="12" height="12"><a href="<? echo $dosql?>"><? echo $active;?></a></td>
	  <? }?>
  </tr>
  <?php
  	$i++;
  }
  ?>
</table>
<? 
	 if($person["category"] != 3) {
?> 
<form name="select_type" method="post" action="?a=score_level" onSubmit="return validateForm(this)">
	<input type = "hidden" name ="grade_id" value = "<? echo $g_result["g_grade_id"] ?>">	
    <input type="hidden" name="dosql" value="do_grade_select_level" />
  <table width="603" border="0" align="center" cellpadding="2" cellspacing="0" class="tdborder1">
    <tr class="boxcolor"> 
      <th colspan="2"  class="Bcolor"><?=$strGrade_LabSelectType;?></th>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td  align="left" class="hilite"> <input name="type" type="submit" id="insert_dept" value="<?=$strSave;?>" class="button"> 
        <input name="resetfac" type="reset" id="resetfac2" value="<?=$strReset;?>" class="button">	
      </td>
      <td align="right">&nbsp;</td>
    </tr>
    <tr> 
      <td width="187" align="right"><?=$strGrade_LabType;?>	 : </td>
      <td width="404"> 
        <?
	$sql = "SELECT g_eval_type_id, g_eval_type_name FROM g_eval_type;";
    
	$result = mysql_query($sql);
  
					echo "<select name=\"g_eval_type\"  onchange=\"displayCB();\" class=\"text\">";
		            echo "<option value=\"-1\">$strGrade_LabSelectType</option>";
                  while ($row = mysql_fetch_array($result)) {
                    
							switch ($row[0]) {							
									case 1:
										$displaygrade = $strGrade_LabCriteria;
									break;
									case 2:
										$displaygrade = $strGrade_LabGroupGrading;			
										break;
									case 3:
										$displaygrade = $strGrade_LabVarGrading;			
										break;
									case 4:
										$displaygrade = $strGrade_LabTscore;			
										break;
								
									
									}	 
					
						 echo "<option value=\"$row[0]\" >$displaygrade</option>";
	
		     
                              }
		echo "</select>";
                  
			?>
			
      </td>
    </tr>
    <tr> 
      <td width="187" align="right"><?=$strGrade_LabLevel;?> : </td>
      <td width="404"> 
        <?
	$sql = "SELECT g_level_type_id, g_level_type_name, g_level_type_desc FROM g_level_type;";
    
	$result = mysql_query($sql);
  
					echo "<select name=\"g_level_type\" class=\"text\">";
		            echo "<option value=\"-1\">$strGrade_LabSelectLevel</option>";
                  while ($row = mysql_fetch_array($result)) {
                     
					 echo "<option value=\"$row[0]\" >$row[1]</option>";
	
		     
                              }
		echo "</select>";
                  
			?>
      </td>
    </tr>
    <tr> 
      <td align="right">&nbsp;</td>
      <td><div id="area"></div></td>
    </tr>
    <tr> 
      <td align="right">&nbsp;</td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
          <?
	  mysql_data_seek($result, 0);
	  while ($row = mysql_fetch_array($result)) {
	  ?>
          <tr> 
            <td><?php echo $row["g_level_type_desc"];?></td>
          </tr>
          <?
		 }
	  ?>
        </table></td>
    </tr>
    <tr> 
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<?
}
?>
	</td>
  </tr>
</table>
</body>
</html>