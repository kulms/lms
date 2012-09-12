<?   
		require("../include/global.php");
		require("../include/getsize.php");
		require("syllabus.inc.php");

		$sel=mysql_query("SELECT * FROM syllabus WHERE courses=$courses;");
		$selc=mysql_query("SELECT * FROM courses WHERE id=$courses;");
		$row=mysql_fetch_array($sel);
		$rowc=mysql_fetch_array($selc);
		$pat=":";		
		$arr=split($pat,$row["grading"]);					
?>
<html>
<head>
<title>Course Syllabus</title>
<head>
<link rel="STYLESHEET" type="text/css" href="../main.css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>
<body bgcolor="#FFFFFF">
<table align="center" width="70%" border="0" cellspacing="0" cellpadding="0" >
  <tr> 
    <td colspan="2" align="right">&nbsp;<!--<input type="button" onClick="javascript: window.close();" value="c l o s e">--></td>
  </tr>
  <tr> 
    <td colspan="2" align="center"> <img src="syllabus.gif" width="325" height="30"><br>
        <b>Course : <? echo $rowc["fullname"];?></b></td>
  </tr>
  <tr><td><table width="100%" border="0" cellspacing="1" cellpadding="1"><tr> 
    <td height="35" class="mini" width="70%">
<?php
  if(  $row["syllabus_upload"]!="" && $row["syllabus_upload"]!=none  ) 
	{    ?><a href="<? echo "../files/syllabus/$courses/".$row["newuploadfilename"]; ?>" 
		target="<? if($row["new_window"]==0) 
									echo "_self";
							else 
									echo "_blank"; 	?>"><?php 
          $syllabus_filetype = strtolower(substr($row["newuploadfilename"], strrpos($row["newuploadfilename"],".")+1 ) );  
		  $syllabus_filesize = filesize("../files/syllabus/$courses/".$row["newuploadfilename"]);

		 if(strtolower($syllabus_filetype)=="pdf") 
		 {		?></a><a href="<? echo 	"../files/syllabus/$courses/".$row["newuploadfilename"];?>" 
		target="<? if($row["new_window"]==0) 
									echo "_self";
							else 
									echo "_blank"; ?>"><img src="pdf.gif" width="18" height="18" border="0"><? 
         }else if(strtolower($syllabus_filetype)=="doc")
							 {   
							 		  ?><img src="msword.gif" width="20" height="20" border="0"><?  
            	  		      }  echo $row["syllabus_upload"];  
      ?></a> (size : <? echo GetSize($syllabus_filesize); ?>&nbsp;  ; &nbsp; <? echo $syllabus_filesize; ?> bytes ) 
<?  }else{  ?>&nbsp;&nbsp;&nbsp; <? }   ?></td>
   </tr></table></td></tr>
  
  
  
  <? $userdef = mysql_query("select su.* from syllabus_userdef su where courses = $courses order by id;" );

		while($userrow = mysql_fetch_array($userdef))
		{		?>
  <tr> 
    <td height="34" colspan="2"><table width="700" border="0" cellspacing="5" cellpadding="3">
        <tr><td id="topic" background="bg2.jpg" class="blue"><img src="../images/bullet.gif" width="11" height="11"> 
            &nbsp;&nbsp;&nbsp; <b><? echo $userrow["topic_name"]; ?></b>
		</td></tr>
      </table></td>
  </tr>  
  <? 
  	if ($userrow["topic_name"] != $t[12]) {
  ?>
  <tr> 
    <td colspan="2"><table width="100%" border="0" cellspacing="5" cellpadding="3">
        <tr> 
          <td class="info"><? echo nl2br($userrow["details"]); ?></td>
        </tr>
      </table></td>
  </tr>
  <?
  } else { ?>
   <tr> 
    <td colspan="2">
	<table border="1" width="90%" align="left">
          <tr bgcolor="#CCCCCC"> 
            <td align="center" class="res"><strong>สัปดาห์ที่</strong></td>
            <td align="center"  class="res"><strong>วันที่สอน</strong></td>
            <td  align="center"  class="res"><strong>เวลา</strong></td>
            <td align="center"  class="res"><strong>หัวข้อ</strong></td>
            <td align="center"  class="res"><strong>การสอน</strong></td>
          </tr>
          <?
		  		$activity = mysql_query("SELECT * FROM syllabus_activity WHERE courses=$courses ORDER BY id;");
				$i = 0;
				while ($row_activity = mysql_fetch_array($activity))
				{ 				
				?>
          <tr> 
            <td class="blue" align="center"><b><? echo $i+1;?></b>&nbsp;</td>			
            <td class="blue"><? echo date("Y-m-d",$row_activity["date"]);?>&nbsp;</td>
            <td class="blue"><? echo $row_activity["time"];?>&nbsp;</td>
            <td class="blue"><? echo $row_activity["topic"];?>&nbsp;</td>
            <td  class="blue"> 
                <? if ($row_activity["method"] == 0) { echo "--";}?>
                <? if ($row_activity["method"] == 1) { echo "บรรยาย";}?>
                <? if ($row_activity["method"] == 2) { echo "ปฏิบัติ";}?>
                <? if ($row_activity["method"] == 3) { echo "บรรยาย/ปฏิบัติ";}?>
				<? if ($row_activity["method"] == 4) { echo "สอบ";}?>&nbsp;
               </td>
          </tr>
          <? 
		  	$i++;
			}
			?>
        </table>
	 </td>
  </tr>

  <?    }  
  
  
  }
  
  			$ddot	=":::::::";					
			if(trim($row["grading"])!=":::::::" && trim($row["grading"])!=$ddot && trim($row["grading"])!=""  && trim($row["grading"])!=none)
			{			
			?>						
    
  <tr> 
    <td colspan="2">
	  <table width="700" border="0" cellspacing="5" cellpadding="3">
        <tr><td background="bg2.jpg" class="blue">
		    <img src="../images/bullet.gif" width="11" height="11">&nbsp;&nbsp;&nbsp; <b><? echo "Grading Policy"; ?></b> 
		 </td></tr>
       </table>
	  </td>	 
  </tr> 
  
  <tr> 
    <td colspan="2">	
	 <table width="100%" height="89" border="0" cellpadding="15">
        <tr> 
          <td height="22"><table width="80%" border="0" cellspacing="0" cellpadding="3" >
              <tr> 
                <td bgcolor="#339900" class="small" width="20" align="center"> 
                  <div align="center">A</div></td>
                <td bgcolor="#66CC00" class="small" width="20" align="center"> 
                  <div align="center">B+</div></td>
                <td bgcolor="#CCFF33" class="small" width="20" align="center"> 
                  <div align="center">B</div></td>
                <td bgcolor="#FFFF66" class="small" width="20" align="center"> 
                  <div align="center">C+</div></td>
                <td bgcolor="#FFCC66" class="small" width="20" align="center"> 
                  <div align="center">C</div></td>
                <td bgcolor="#FF9999" class="small" width="20" align="center"> 
                  <div align="center">D+</div></td>
                <td bgcolor="#FF6666" class="small" width="20" align="center"> 
                  <div align="center">D</div></td>
                <td bgcolor="#CC0033" class="small" width="20" align="center">F</td>
              </tr>
              <tr> 
                <td bgcolor="#339900"> <div align="center" class="small"><? echo $arr[0]; ?></div></td>
                <td bgcolor="#66CC00"> <div align="center" class="small"><? echo $arr[1]; ?></div></td>
                <td bgcolor="#CCFF33"> <div align="center" class="small"><? echo $arr[2]; ?></div></td>
                <td bgcolor="#FFFF66"> <div align="center" class="small"><? echo $arr[3]; ?></div></td>
                <td bgcolor="#FFCC66"> <div align="center" class="small"><? echo $arr[4]; ?></div></td>
                <td bgcolor="#FF9999"> <div align="center" class="small"><? echo $arr[5]; ?></div></td>
                <td bgcolor="#FF6666"> <div align="center" class="small"><? echo $arr[6]; ?></div></td>
                <td bgcolor="#CC0033"> <div align="center" class="small"><? echo $arr[7]; ?></div></td>
              </tr>
             </table>
			
		   </td>
         </tr>
       </table>
	 </td>	 
   </tr>
<?  }  ?>
	<tr>
		<td align="left"><br><table width="80%" cellpadding="0" cellspacing="0" border="0">
														 <tr>
														    <td align="center"><input type="button" onClick="javascript: window.close();" value="c l o s e"> &nbsp;&nbsp; <input type="button" onClick="javascript: window.print();" value="p r i n t"></td>
														</tr>
													</table>
		</td>
	</tr>
</table>
</body>
</html>