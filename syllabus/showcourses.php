<?   
		require("../include/global.php");
		require("../include/getsize.php");		
?>
<html>
<head>
<title>Course Syllabus</title>
<link href="../main2.css" rel="stylesheet" type="text/css">
<head>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<script language="JavaScript">
		function MM_openBrWindow(theURL,winName,features) { //v2.0
		  window.open(theURL,winName,features);
		}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>
<body bgcolor="#FFFFFF">
<?
  	$resDept=mysql_query("SELECT fac.FAC_NAME, dept.NAME_THAI  
													 FROM  ku_department as dept, ku_faculty as fac 
													 WHERE  dept.FAC_ID=fac.id AND  dept.id=$dept 
													 GROUP BY fac.FAC_NAME, dept.NAME_THAI;");
?>
<table width="95%" border="0" cellspacing="0" cellpadding="5"  align="center" bordercolor="#CCCCCC">
	<tr>
		<!--<td class="info"><?  echo  "<b>คณะ : <font class=\"info\">".mysql_result($resDept,0,"FAC_NAME")."</font>  ภาควิชา : <font class=\"info\">".mysql_result($resDept,0,"NAME_THAI")."</font></b>"; ?>&nbsp;</td>-->
		<td class="h5"><?  echo  "<b>คณะ : <font color=\"black\">".mysql_result($resDept,0,"FAC_NAME")."</font> &nbsp; &nbsp; &nbsp;   ภาควิชา :  <font color=\"black\">".mysql_result($resDept,0,"NAME_THAI")."</font></b>"; ?>&nbsp;</td>
	</tr>
</table><font class="info"></font>
<table width="95%" border="1" cellspacing="0" cellpadding="5"  align="center" bordercolor="#CCCCCC">
  <tr  bgcolor="#EAEAF4">
    <td width="5%" align="center" bgcolor="#EAEAF4" class="res"><b>No.</b></td>
    <td width="10%" align="center" bgcolor="#EAEAF4" class="res"><b>รหัสวิชา</b></td>
    <td width="5%" align="center" class="res"><b>หมู่เรียน</b></td>
    <td width="30%" align="center" class="res"><b>ชื่อรายวิชา</b></td>
    <td width="30%" align="center" class="res"><b>ชื่ออาจารย์ผู้สอน</b></td>
    <td width="15%" align="center" class="res"><b>Syllabus</b></td>
  </tr>
  <? 
//$resCourses=mysql_query("SELECT fac.FAC_NAME, dept.NAME_THAI, c.*, u.title, u.firstname, u.surname, s.syllabus_upload FROM ku_department as dept,courses as c,ku_faculty as fac, users as u, syllabus as s WHERE dept.FAC_ID=fac.id AND s.courses=c.id  AND c.users=u.id AND c.active=1 AND u.fac_id=fac.id AND u.dept_id=dept.id  AND dept.id=$dept ORDER BY  fac.FAC_NAME, dept.NAME_THAI, c.name;");
  $resCourses=mysql_query("SELECT c.*, u.title, u.firstname, u.surname, u.dept_id, s.syllabus_upload, s.newuploadfilename 
														  FROM courses as c,users as u, syllabus as s 
														  WHERE s.courses=c.id AND c.users=u.id AND c.active=1 AND u.dept_id=$dept 
														  ORDER BY c.name ;");
   $count=0;
    while( $row=mysql_fetch_array($resCourses) )
     {	 $count++;?>
  <tr>
    <td class="info" align="center"><? echo $count; ?>&nbsp;</td>
    <td class="info" align="center"><? echo $row["name"]."&nbsp;"; ?>&nbsp;</td>
    <td class="info" align="center">
      <? 
	  if ($row["section"]!= "" && $row["section"]!=null){ 
					echo $row["section"]; 	} ?>
      &nbsp;</td>
    <td class="info" align="left"><? echo $row["fullname_eng"]."<br>".$row["fullname"]."&nbsp;"; ?>&nbsp;</td>
    <? 
		 $result=mysql_query("SELECT su.* FROM  syllabus_userdef as su, courses as c  WHERE su.courses=c.id AND c.id=".$row["id"].";"); 
		 $c_userdef=mysql_num_rows($result);
	 ?>
    <td class="info" align="left">
      <? echo $row["title"].$row["firstname"]." &nbsp; ".$row["surname"]; ?>
	  [<a onClick="MM_openBrWindow('../personal/public_personal_detail.php?id=<? echo $row["users"]; ?>','','scrollbars=yes,width=700, height=500, resizable=yes')" style="cursor:hand" class="AS">More Detail.</a>]</td>
    <!-- syllabus link here -->
    <td class="info" align="center"><!--<a onClick="MM_openBrWindow('showsyllabus.php?courses=<? echo $row["id"]; ?>','','scrollbars=yes,width=screen.availWidth, height=screen.availHeight, resizable=yes')" style="cursor:hand" class="AS"><u>--><? 
			/*
						if($row["syllabus_upload"]!=null && $row["syllabus_upload"]!=""){    
										 echo  "file : ".$row["syllabus_upload"];  
						}else{     echo "Only details";    
								   }  echo "</u></a> &nbsp; &nbsp;  &nbsp; ";
			*/					   
				
			/*  if($c_userdef==0 && $row["syllabus_upload"]!=null && $row["syllabus_upload"]!="" ){ 
							//echo "<br><br><a href=\"../files/syllabus/".$row["id"]."/".$row["newuploadfilename"]."\" target=\"_blank\">view</a>"; 	 		
							?><a href="../files/syllabus/<? echo $row["id"]."/".$row["newuploadfilename"]; ?>" target="_blank" class="AS">view file</a><?
					}
				   if($c_userdef>=1){  
							?><br><br><a onClick="MM_openBrWindow('showsyllabus.php?courses=<? echo $row["id"]; ?>','','scrollbars=yes,width=screen.availWidth, height=screen.availHeight, resizable=yes')" style="cursor:hand" class="AS"><u>view</u></a><?  
					} 
			*/
			
			  if( $c_userdef==0 && $row["syllabus_upload"]!="" && $row["syllabus_upload"]!=none  ) 
				{    	$filepiz="";
						?><a onClick="MM_openBrWindow('../files/syllabus/<? echo $row["id"]."/".$row["newuploadfilename"];?>','','scrollbars=yes,width=screen.availWidth, height=screen.availHeight, resizable=yes')" style="cursor:hand">[ <u>view</u> ] 
						<?
						  $syllabus_filetype = strtolower(substr($row["newuploadfilename"], strrpos($row["newuploadfilename"],".")+1 ) );  
						  $syllabus_filesize = @filesize("../files/syllabus/".$row["id"]."/".$row["newuploadfilename"]."");
						  $syllabus_file = "../files/syllabus/".$row["id"]."/".$row["newuploadfilename"]."";
							/* if(strtolower($syllabus_filetype)=="pdf") 
						 {  		$filepiz="<img src=\"pdf.gif\" width=\"18\" height=\"18\" border=\"0\">";	 
									
						 }else if(strtolower($syllabus_filetype)=="doc")
						 			{   
											 $filepiz="<img src=\"msword.gif\" width=\"20\" height=\"20\" border=\"0\">";  
									  }  			  
						echo $filepiz."<u>".$row["syllabus_upload"]."</u>";  
						*/
					    //  url="http://www.experts-exchange.com/Web/Web_Languages/HTML/Q_20664416.html"   
					  //  รูปแบบ :  bSuccess = object.execCommand(sCommand [, bUserInterface] [, vValue]) ,     
					//   ตัวอย่าง : <a href="#" onClick="document.execCommand('SaveAs');return false;">Save me</a> 
				  ?></a>  &nbsp;&nbsp; [ <a href="AutoDW_file.php?filename=<?echo $syllabus_file;?>"><u>save</u></a> ] 
				  
				  <!--<br><br><a id="f" href="../files/syllabus/<? echo $row["id"]."/".$row["newuploadfilename"]; ?>" onClick="f.execCommand('SaveAs');return false;">Save me</a>--><? 
			 }else if($c_userdef>=1)
						   { 	?><br><br><a onClick="MM_openBrWindow('showsyllabus.php?courses=<? echo $row["id"]; ?>','','scrollbars=yes,width=screen.availWidth, height=screen.availHeight, resizable=yes')" style="cursor:hand" class="AS">[ <u>view</u> ]</a>  &nbsp;&nbsp; [ save ]<?  
							} 	 ?></td>
  </tr>
  <?	
		//	$cnt++;
	}		///  END SHOW SYLLABUS
//	$cntDept++;
?>
  <tr> 
    <td colspan="6" class="res"><b>หมายเหตุ : ช่อง syllabus บอกให้ทราบว่ามีเนื้อหาอย่างเดียว( 
      Only details ) หรือ มีไฟล์ด้วย( file :)</b></td>
  </tr>
</table>
<br><div align="center" class="res"><!--<b>หมายเหตุ : ช่อง syllabus บอกให้ทราบว่ามีเนื้อหาอย่างเดียว(Only details, no file)หรือมีไฟล์ด้วย(Details & file : )</b><br><br>--><input type="button" onClick="javascript:window.close();" value="c l o s e"></div>
</body>
</html>