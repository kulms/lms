<?
	    include("../include/global_login.php");
		include("./include/var.inc.php");
		//$modules == insert ใหม่
		//id == module เก่า มา update
		
	if(isset($modules)) $id = $modules;
	//echo "modules===".$modules ;
		//echo "id===".$id ;
// UPDATE***** 
$sql_mn = mysql_query("SELECT name FROM modules  WHERE id='$id' ");
$modn=mysql_fetch_array($sql_mn);
 $md_name =  $modn[0] ;
 $sql="SELECT  e.eval_type,e.info,e.courses_id,e.semester,e.year,e.start_date,e.end_date,e.show_std,e.show_rs
				FROM eval_q_set  e
				WHERE  e.modules_id='$id'";
$rs = mysql_query($sql);  
$have =mysql_num_rows($rs);  
     while($row=mysql_fetch_array($rs)){
	 		$eval_type =$row[eval_type];
			$info = $row[info];
			$courses_id = $row[courses_id];
			$semester = $row[semester] ;
			$year= $row[year];
			$start_date =$row[start_date];
			$end_date =$row[end_date];
			$show_std = $row[show_std];
			$show_rs = $row[show_rs];
	 }

?><html>
<head>
<title>Create  evaluation</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link rel="STYLESHEET" type="text/css" href="../themes/<? echo $theme ?>/style/main.css">

<script language="Javascript" src="./js/mmopenwindow.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript" src="./calendar/cal.js"></script>
<script language="JavaScript" type="text/javascript" src="./calendar/cal_conf.js"></script>
<script language="JavaScript" type="text/javascript" src="./js/admin_sel_course.js"></script>
<script language="javascript">
function iconfirmdel(a){
				if( confirm("คุณต้องการลบ " + a +" ใช่หรือไม่ ?") ){   
							return true;   //document.location =in_url; 
				 }else{
						 return false;
				 }
}
</script>
</head>
<body>
<br>
<table width="95%" border="0" align="center" cellpadding="1" cellspacing="1" class="tdborder1">
  <tr class="boxcolor"> 
    <td height="24">
	<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0"  class="tdborder1">
 <tr class="boxcolor">
    <td height="24"  class="bwhite"><? echo $Create_TITLE ?></td>
  </tr>
	</table>
	</td>
  </tr>
</table>
<br>
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="1"  class="tdborder1">
  <form name="createFrm" method="post" action="addMod.php?modules=<? echo $id ?>">
    <tr  class="tdbackground2"> 
      <td height="30" colspan="2" align="center"><b><? echo $INFO_EVAL_title." ".$md_name?></b> </td>
    </tr>
    <tr align="center" class="tdbackground3"> 
      <td colspan="2" align="right">&nbsp;</td>
    </tr>
    <tr align="center"  class="tdbackground_white">
      <td align="right"><? echo $EVAL_NEW_NAME?> :  </td>
      <td align="left"> &nbsp;
      <input name="eval_name" type="text" size="30" value="<? echo $md_name?>"></td>
    </tr>
    <tr align="center"  class="tdbackground_white"> 
      <td width="280" align="right"><? echo $Eval_semester ?> :</td>
      <td align="left"> &nbsp; <select name="semester" id="semester">
          <option value="1"<? if($semester==1) { echo " selected";  } ?>>1</option>
          <option value="2"<? if($semester==2) { echo " selected";  } ?>>2</option>
          <option value="3"<? if($semester==3) { echo " selected";  } ?>>3</option>
        </select></td>
    </tr>
    <tr align="center"  class="tdbackground_white"> 
      <td align="right"><? echo $Eval_year?> :  </td>
      <td align="left"> &nbsp; <input name="year" type="text" id="year" size="4" maxlength="4" value="<? echo $year; ?>"></td>
    </tr>
    <tr align="center"  valign="baseline"  class="tdbackground_white"> 
      <td align="right"><? echo $Eval_startDate?> : </td>
      <td align="left"><div id="cal1">&nbsp;
        <input name="start_date" type="text" id="start_date" value="<? echo strtok($start_date," "); ?>" size="10" maxlength="10"  onFocus="this.blur(); showCal('Date1')">          
        &nbsp; <a href="javascript:showCal('Date1')"><img src="calendar/date.gif" style="cursor:pointer;cursor:hand" title="Click to select date"  onMouseOver="window.status='Click to select date';return true" onmouseout="window.status='';return true"  width="19" height="17" border="0"></a></div></td>
    </tr>
    <tr align="center"  valign="baseline"  class="tdbackground_white"> 
      <td align="right"><? echo $Eval_endDate?> : </td>
      <td align="left"><div id="cal2">&nbsp; 
          <input name="end_date" type="text" id="end_date" value="<? echo  strtok($end_date," "); ?>"  size="10" maxlength="10"  onFocus="this.blur(); showCal('Date2')">
          &nbsp; <a href="javascript:showCal('Date2')"><img src="calendar/date.gif" style="cursor:pointer;cursor:hand" title="Click to select date"  onMouseOver="window.status='Click to select date';return true" onmouseout="window.status='';return true"  width="19" height="17" border="0"></a></div></td>
    </tr>
    <tr align="center"  valign="baseline"  class="tdbackground_white">
      <td align="right"><? echo $Eval_descripe?> : </td>
      <td align="left">&nbsp;<textarea name="info" cols="40" rows="4" id="info"><? echo $info; ?></textarea></td>
    </tr>
    <tr align="center"  class="tdbackground_white">
      <td align="right"><? echo $EVAL_Cat ?> :</td>
      <td align="left"><input name="eval_type" type="radio" value="1"  <? if($eval_type==1 || $eval_type=='') echo "checked";   ?>> <? echo $EVAL_TEACHER?>
      <input name="eval_type" type="radio" value="2" <? if($eval_type==2) echo "checked";   ?>> <? echo $EVAL_Perceptual?>
	  </td>
    </tr>
    <tr align="center"  class="tdbackground_white">
      <td align="right"><?=$EVAL_SHOW_STD?> : </td>
      <td align="left">
	  <input name="std_show" type="radio" value="1" <? if($show_rs==1 || $show_rs=='') echo "checked";   ?>> <?=$strYes ?> 
      <input name="std_show" type="radio" value="0" <? if($show_rs==0) echo "checked";   ?>><?=$strNo?>
	   </td>
    </tr>
    <tr align="center"  class="tdbackground_white"> 
      <td align="right"><? echo $SHOW_Finish ?>  :  </td>
      <td align="left">&nbsp; <input name="show_std" type="checkbox" id="show_std" value="1" checked <? if($show_std==1){ echo " checked"; } ?>></td>
    </tr>
    <tr valign="middle"  class="tdbackground3"> 
      <td height="30" align="center">&nbsp;</td>
      <td height="30" align="left">
	<?   if($have ==0){    ?>
	   <input type="submit" name="create" value="<? echo $strCreate ?>" class="button" >	  
	  <? }else{ ?>
			  <input type="submit" name="update" class="button"  value="<? echo $strUpdate?>">  
      <? } ?>			
	    <input type="submit"  class="button" name="delete" value=" <? echo $strDelete?> " onClick="return iconfirmdel('<? echo $md_name; ?>')">  
	  <input type="button" class="button"  value="<? echo $strCancel?>" name="cancel" onClick="javascript: window.location='t_index.php';"></td></tr>
</form>
</table>	
<br>&nbsp;
</body>
</html>