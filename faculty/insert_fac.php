<?php		 require("../include/global_login.php");				
					  session_start();
if($save_fac)
	{
		if(  ($fac_thai=="" || $fac_thai==none)  ||  ($fac_eng=="" || $fac_eng==none) )
			{
				print("<script language='javascript'> alert('Please complete detail !'); </script>");
				
			}else {
							$result=mysql_query("SELECT * FROM ku_faculty  kf WHERE (kf.FAC_NAME='$fac_thai' OR kf.NAME_ENG='$fac_eng') and kf.CAMPUS_ID = '$campus_id' ;");
							if($row=mysql_fetch_array($result))
								{
									print("<script language='javascript'> alert('There is same Faculty in database ready ! '); </script>");	
								 } // end while
							else
								{
									$fac_thai=trim($fac_thai);
									$fac_eng=trim($fac_eng);
									// debug here
									$url=trim($url);
									$pid=$person["id"];
								//	echo  $fac_thai." ".$fac_eng." ".$url." ".$time." ".$pid,"<br>"; exit();
									mysql_query("INSERT INTO ku_faculty(id,FAC_NAME,NAME_ENG,CAMPUS_ID,URL ,edit_by,post_datetime) VALUES ('','$fac_thai', '$fac_eng','$campus_id','$url','$pid',now());");
									print("<script language='javascript'>document.location='insert_fac.php';</script>"); 	
								} //end else
						} //end else
		} // if save
	  $icname="";					
      $fac_query=mysql_query("SELECT kf.*,kc.NAME_THAI as CNAME_THAI FROM ku_faculty kf, ku_campus kc WHERE kc.CAMPUS_ID = kf.CAMPUS_ID ORDER BY kf.CAMPUS_ID,kf.FAC_NAME,kf.id;");		
?>
<html>
<head>
<title>.:: Faculty ::.</title>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>

<body bgcolor="#EFEFDE">
<table width="600" border="0" align="center">
  <tr> 
    <td height="33" bgcolor="#000000" class="headfac"><div align="center">
	<b><font color="#FFFFFF">.:: Faculty - Department - Major of Maxlearn ::.</font></b></div></td>
  </tr>
  <tr> 
    <td height="26"><div align="center">( รายละเอียดข้อมูล คณะ ภาควิชา และสาขาวิชา มหาวิทยาลัยเกษตรศาสตร์ )</div></td>
  </tr>
</table>

<font color="#EFEFDE">top</font><a name="top"></a> <br>
<table width="90%" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr> 
    <td colspan="5"><div align="center"><font color="#666600"><b><font color="#FF0000">***</font>Click 
        item <font color="#B3B300">Faculty name(Thai)</font> to see its Department <font color="#FF0000">***</font></b></font></div></td>
  </tr>
  <tr> 
    <td height="35" colspan="5"><div align="right"><font color="#666600"><b> [ 
        <a href="#Faculty">Add Faculty</a> ]</b></font></div></td>
  </tr>
  
<? if($icname!=@mysql_result($fac_query,0,"CNAME_THAI"))
		{   $icname=@mysql_result($fac_query,0,"CNAME_THAI") ;   ?>
  <tr> 
    <td colspan="5"><b><font color="#666600">วิทยาเขต<? echo @mysql_result($fac_query,0,"CNAME_THAI");  ?></font></b></td>
  </tr>
  <tr> 
    <td width="5%" bgcolor="#666600"><div align="center"><font color="#FFFFFF"><b>No.</b></font></div></td>
    <td width="25%" bgcolor="#666600"><div align="center"><font color="#FFFFFF"><b> 
        Faculty name(Thai)</b></font></div></td>
    <td width="25%" bgcolor="#666600"><div align="center"><font color="#FFFFFF"><b> 
        Faculty name(English)</b></font></div></td>
    <td width="20%" bgcolor="#666600"><div align="center"><font color="#FFFFFF"><b> 
        Faculty URL</b></font></div></td>
    <td width="5%" bgcolor="#666600"><div align="center"><font color="#FFFFFF"><b>command</b></font></div></td>
  </tr>
  <tr> 
    <td bgcolor="#DBDBB7"><div align="center"><font color="#666600"><? echo "1"; ?></font></div></td>
    <td bgcolor="#DBDBB7"><font color="#666600"><a href="insert_dept.php?id=<? echo  @mysql_result($fac_query,0,"id"); ?>" title="View more detail!"> 
      <?
      if(  ( @mysql_result($fac_query,0,"FAC_NAME")!="")  &&  (@mysql_result($fac_query,0,"FAC_NAME")!=none) && (@mysql_result($fac_query,0,"id")!=72 )   ){ echo "คณะ".@mysql_result($fac_query,0,"FAC_NAME"); }else {  echo @mysql_result($fac_query,0,"FAC_NAME"); } ?>
      </a></font></td>
    <td bgcolor="#DBDBB7"><font color="#666600"> 
      <?
       if(  (@mysql_result($fac_query,0,"NAME_ENG")!="")  &&  (@mysql_result($fac_query,0,"NAME_ENG")!=none) && (@mysql_result($fac_query,0,"id")!=72 )  ){ echo "Faculty of  ".@mysql_result($fac_query,0,"NAME_ENG"); }else {  echo @mysql_result($fac_query,0,"NAME_ENG"); } ?>
      </font></td>
    <td bgcolor="#DBDBB7"> 
      <?  if(@mysql_result($fac_query,0,"URL")!=""  &&  @mysql_result($fac_query,0,"URL")!=none ){ echo "<a href='http://".@mysql_result($fac_query,0,"URL")."'>http://".@mysql_result($fac_query,0,"URL")."</a>"; }else {  echo ""; } ?>
    </td>
    <td bgcolor="#DBDBB7"> <div align="center"><font color="#666600">[ <a href="edit_fac.php?id=<? echo   @mysql_result($fac_query,0,"id"); ?>" target="_self">edit</a> ]</font></div></td>
  </tr>   
<? 	} 	  $num=2;
			   while( $row=mysql_fetch_array($fac_query))
				 {     $name_thai=$row["FAC_NAME"];
						$name_eng=$row["NAME_ENG"];
						$cname = $row["CNAME_THAI"];
						$url=$row["URL"];
						//$url=str_replace("http://",$url);
						$url=trim($url);
						$id=$row["id"];
						
 if($icname!=$cname )
		{	  ?>
  <tr> 
    <td colspan="5"><strong><font color="#666600">วิทยาเขต<? echo $cname; ?></font></strong></td>
  </tr>
  <tr> 
    <td width="5%" bgcolor="#666600"><div align="center"><font color="#FFFFFF"><b>No.</b></font></div></td>
    <td width="25%" bgcolor="#666600"><div align="center"><font color="#FFFFFF"><b> 
        Faculty name(Thai)</b></font></div></td>
    <td width="25%" bgcolor="#666600"><div align="center"><font color="#FFFFFF"><b> 
        Faculty name(English)</b></font></div></td>
    <td width="20%" bgcolor="#666600"><div align="center"><font color="#FFFFFF"><b> 
        Faculty URL</b></font></div></td>
    <td width="5%" bgcolor="#666600"><div align="center"><font color="#FFFFFF"><b>command</b></font></div></td>
  </tr>
<? 			$icname=$cname;	   
		} 	  ?>
  <tr> 
    <td bgcolor="#DBDBB7"><div align="center"><font color="#666600"><? echo $num++; ?></font></div></td>
    <td bgcolor="#DBDBB7"><font color="#666600"><a href="insert_dept.php?id=<? echo $id; ?>" title="View more detail!"> 
      <?
      if(  ($name_thai!="")  &&  ($name_thai!=none) && ($id!=72 )   ){ echo "คณะ".$name_thai; }else {  echo $name_thai; } ?>
      </a></font></td>
    <td bgcolor="#DBDBB7"><font color="#666600"> 
      <?
       if(  ($name_eng!="")  &&  ($name_eng!=none) && ($id!=72 )  ){ echo "Faculty of  ".$name_eng; }else {  echo $name_eng; } ?>
      </font></td>
    <td bgcolor="#DBDBB7"> 
      <?  if($url!=""  &&  $url!=none ){ echo "<a href='http://".$url."'>http://".$url."</a>"; }else {  echo ""; } ?>
    <td bgcolor="#DBDBB7"> <div align="center"><font color="#666600">[ <a href="edit_fac.php?id=<? echo $id; ?>" target="_self">edit</a> ]</font></div></td>
  </tr>
<? 		} 		?>
</table>
<br>
<div align="right"><a href="#top">Go to top</a>
</div>

<form name="insert_fac" method="post" action="insert_fac.php">

  <table width="600" border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="#804000" bgcolor="#DBDBB7">
    <tr> 
      <td height="32" colspan="2" bgcolor="#666600"><div align="center"><b><a name="Faculty"></a><font color="#FFFFFF">:-: 
          Add Faculty :-:</font></b></div></td>
    </tr>
    <tr> 
      <td colspan="2" bgcolor="#FFFFFF"><div align="right"> </div></td>
    </tr>
    <tr> 
      <td width="190"><div align="right"><b><font color="#666600">วิทยาเขต</font></b></div></td>
      <td width="404"> 
        <? $resCmp = mysql_query("select * from ku_campus order by id");
			  if($rowCmp = mysql_fetch_array($resCmp))
			  {				?>
        <select name="campus_id">
          <option value="<? echo $rowCmp["CAMPUS_ID"]; ?>" selected><? echo $rowCmp["NAME_THAI"]; ?></option>
			  <?
				while($rowCmp = mysql_fetch_array($resCmp))
					  {			?>
          <option value="<? echo $rowCmp["CAMPUS_ID"]; ?>"><? echo $rowCmp["NAME_THAI"]; ?></option>
			  <?   }		?>
        </select> 
        <?   }            ?>
      </td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td><div align="right"><b><font color="#666600">คณะ&nbsp; </font></b></div></td>
      <td><input name="fac_thai" type="text" id="fac_thai" size="55" maxlength="200"></td>
    </tr>
    <tr> 
      <td width="190" bgcolor="#FFFFFF"><div align="right"><b><font color="#666600">Faculty 
          of&nbsp; </font></b></div></td>
      <td width="404" bgcolor="#FFFFFF"><input name="fac_eng" type="text" id="fac_eng" size="55" maxlength="200"></td>
    </tr>
    <tr> 
      <td><div align="right"><b><font color="#666600">URL : &nbsp; </font></b></div></td>
      <td><font color="#666600"><b>http://</b></font> <input name="url" type="text" id="url" size="55" maxlength="100"> 
      </td>
    </tr>
    <tr> 
      <td bgcolor="#FFFFFF"><font color="#666600">&nbsp;</font></td>
      <td bgcolor="#FFFFFF">&nbsp; </td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td><input name="save_fac" type="submit" id="save_fac" value="S a v e"> 
        &nbsp;&nbsp;&nbsp; <input name="resetfac" type="reset" id="resetfac" value="R e s e t"></td>
    </tr>
  </table>
</form><br>
</body>
</html>