<?  		 require("../include/global.php");  
			 include("../include/page_update.js");
?>
<html>
<head>
<title>แสดง syllabus ตามคณะ ภาควิชา ของผู้สอน</title>
<!--<link rel="STYLESHEET" type="text/css" href="../main.css">-->
<link rel="STYLESHEET" type="text/css" href="../main2.css">
<script language="JavaScript">
		var plusImg = new Image();
		var minusImg = new Image();
		plusImg.src = "../images/rootPlus.gif";
		minusImg.src = "../images/rootMinus.gif";
		
		function tree(curObj, id){
			//if(isExpand==1){
				//alert(id + '    ' + curObj.src + '     ' + plusImg.src );
				if(curObj.src == plusImg.src){
									curObj.src = minusImg.src;
									eval("document.getElementById('"+id+"')").style.display='';
				}else{
									curObj.src = plusImg.src;	
									eval("document.getElementById('"+id+"')").style.display='none';
							}//end if
		//	}//end if
		}//end function
		
		function MM_openBrWindow(theURL,winName,features) { //v2.0
			  window.open(theURL,winName,features);
		}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874"></head>

<body bgcolor="#d0d0d0">
<script src="../help_syllabus/Javascript/JUMPTOP.JS"></script>

<DIV align=center>
<CENTER>
    <TABLE cellSpacing=0 cellPadding=0 border=0>
      <TBODY>
        <TR> 
          <TD><IMG height=15 
            src="../images/line7_2.gif" width=760></TD>
        </TR>
        <tr> 
          <td align="right" bgcolor="#FFFFFF"><a href="../login/ilogins.php" target="_self"><strong><font color="#0000FF" size="2">M<font color="#990000">@</font>X 
            LEARN</font><font color="#0000FF" size="5"></font><font color="#0000FF" size="5"></font></strong></a></td>
        </tr>
        <tr> 
          <td align="right" bgcolor="#FFFFFF"><a href="../login/ilogins.php" target="_self"><strong><font color="#0000FF" size="5"><font color="#999999" size="1"> 
            KU-LMS / Kasetsart University Learning Management System</font> </font></strong></a></td>
        </tr>
        <TR> 
          <TD width="100%"><IMG height=13 src="../images/line3_1.gif" width=760></TD>
        </TR>
        <TR> 
          <TD width="100%"> <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
              <TBODY>
                <TR> 
                  <TD width="50%" bgColor=#9edce6>&nbsp;</TD>
                  <TD width="50%" bgColor=#9edce6>&nbsp;</TD>
                </TR>
                <TR> 
                  <TD colspan="2" bgColor=#9edce6> </TD>
                </TR>
              </TBODY>
            </TABLE></TD>
        </TR>
        <TR> 
          <TD width="100%" bgcolor="#9edce6"><table width="100%">
              <tr> 
                <td colspan="2"><div align="left"> 
                    <table align="center" width="90%" bgcolor="#666666">
                      <tr> 
                        <td width="7%" height="28" bgcolor="#FFFFFF">&nbsp;</td>
                        <td width="86%" rowspan="3" valign="top"><div align="center"><img src="../images/MainPic.gif" width="400" height="154"></div></td>
                        <td width="7%" bgcolor="#FFFF00">&nbsp;</td>
                      </tr>
                      <tr> 
                        <td height="99" bgcolor="#FFFFFF">&nbsp;</td>
                        <td bgcolor="#FFFFFF">&nbsp;</td>
                      </tr>
                      <tr> 
                        <td bgcolor="#FFCC00">&nbsp;</td>
                        <td bgcolor="#FFFFFF">&nbsp;</td>
                      </tr>
                    </table>
                    <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                      <tr>
                        <td align="right"><br>
                          <font color="#4D9999" face="MS Sans Serif, Microsoft Sans Serif" size="1"><b>|</b> 
                          &nbsp;<a href="../login/ilogins.php" target="_self"><b>Home</b></a> 
                          &nbsp; <b>|</b> &nbsp;<a href="../help.html" target="_blank"><b>Help</b></a>&nbsp; 
                          <b>|</b></font>&nbsp; </td>
                      </tr>
                    </table>
                    <table width="90%" border="1"  align="center" cellpadding="5" cellspacing="0" bordercolor="#CCCCCC" bgcolor="#FFFFFF">
                      <tr> 
                        <td colspan="6" align="center"><font color="#993300" face="MS Sans Serif, Microsoft Sans Serif" size="1"><b>Syllabus 
                          Online</b></font></td>
                      </tr>
                      <tr> 
                        <td colspan="6"><b><font color="navy">Tips : </font> Double 
                          Click ที่คณะเพื่อแสดงภาควิชา<font color="navy"> >> </font>รายวิชา<font color="navy"> 
                          >> </font>syllabus ไฟล์ของแต่ละรายวิชา<br>
                          &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </font><font color="red">***</font> 
                          &nbsp; <font color="navy">คู่มือการใช้งานเพิ่มเติม( 
                          Help )เปิดดูได้ที่เมนูด้านบนขวา</font>&nbsp; <font color="red">***</font></b></td>
                      </tr>
                      <?
     /// นับรายวิชาตามคณะ
	// 	 $resFac=mysql_query("SELECT fac.FAC_NAME, count(*) as CNO FROM courses as c, ku_faculty as fac, users as u, syllabus as s WHERE s.courses=c.id AND s.newuploadfilename!=\"\"  AND c.users=u.id AND c.active=1 AND u.fac_id=fac.id GROUP BY fac.CAMPUS_ID, fac.FAC_NAME DESC;");
    	 $resFac=mysql_query("SELECT fac.FAC_NAME, count(*) as CNO FROM courses as c, ku_faculty as fac, users as u, syllabus as s WHERE s.courses=c.id AND s.newuploadfilename!=\"\"  AND c.users=u.id AND c.active=1 AND u.fac_id=fac.id GROUP BY fac.CAMPUS_ID, fac.FAC_NAME;");
  //    $resFac=mysql_query("SELECT fac.FAC_NAME, count(*) as CNO FROM courses as c, ku_faculty as fac, users as u, syllabus as s WHERE s.courses=c.id AND s.newuploadfilename!=\"\"  AND c.users=u.id AND c.active=1 AND u.fac_id=fac.id GROUP BY fac.FAC_NAME;");
//  	 $resFac=mysql_query("SELECT fac.FAC_NAME, count(*) as CNO FROM courses as c, ku_faculty as fac, users as u, syllabus_userdef as su WHERE c.users=u.id AND su.courses=c.id AND c.active=1 AND u.fac_id=fac.id GROUP BY fac.FAC_NAME;");

	$resDept=mysql_query("SELECT fac.FAC_NAME, count(*) as CNO2, dept.id as deptID,  dept.NAME_THAI  FROM  ku_department as dept,courses as c,ku_faculty as fac, users as u, syllabus as s WHERE  dept.FAC_ID=fac.id AND s.courses=c.id AND s.newuploadfilename!=\"\"   AND c.users=u.id AND c.active=1 AND u.fac_id=fac.id AND u.dept_id=dept.id GROUP BY fac.FAC_NAME DESC, dept.NAME_THAI DESC;");

	 $resCourses=mysql_query("SELECT fac.FAC_NAME, dept.NAME_THAI, c.*, u.title, u.firstname, u.surname, u.email, u.email2, s.syllabus_upload FROM ku_department as dept,courses as c,ku_faculty as fac, users as u, syllabus as s WHERE  dept.FAC_ID=fac.id AND s.courses=c.id AND s.newuploadfilename!=\"\"   AND c.users=u.id AND c.active=1 AND u.fac_id=fac.id AND u.dept_id=dept.id  ORDER BY  fac.FAC_NAME, dept.NAME_THAI, c.name;");

	$numCourse=mysql_num_rows($resCourses);
	$numDept=mysql_num_rows($resDept);
	$row = array();
	$rowDept = array();
	
	while($row3=mysql_fetch_array($resDept))
		array_push($rowDept,$row3);
	
	$cnt = 0;
	$cntDept = 0;
  ?>
                      <tr> 
                        <td colspan="6" align="center">
                          <?
	
		  while($row1=mysql_fetch_array($resFac))
		  {		$count++;
	?>
                          <table background="../images/bg.gif" width="100%" border="0" cellspacing="0" cellpadding="0"  align="center" style="border-bottom: solid #999999 1px;">
                            <tr id="trE<? echo $count;?>"> 
                              <td colspan="6" style="cursor:pointer;cursor:hand"  onClick="tree(this, '<? echo $count; ?>')"><img src="../images/rootPlus.gif" border="0" onClick="tree(this, '<? echo $count;?>')" style="cursor:pointer;cursor:hand"> 
                                <?  echo  $row1["FAC_NAME"]."(".$row1["CNO"].")&nbsp;";  ?>
                                &nbsp; </td>
                            </tr>
                          </table>
                          <span id="<? echo $count; ?>" style="display:'none';"> 
                          <?
			while(($rowDept[$cntDept]["FAC_NAME"] == $row1["FAC_NAME"] ) && $cntDept < $numDept)	
			{    		
		?>
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr> 
                              <td> <table width="100%" bgcolor="#DDDDEE"  border="0" cellspacing="0" cellpadding="0"  align="center">
                                  <tr id="trEDept<? echo $cntDept; ?>"> 
                                    <td height="24" colspan="5" style="cursor:pointer;cursor:hand; border-bottom: solid #999999 1px;"  onClick="MM_openBrWindow('../syllabus/showcourses.php?dept=<? 
						echo $rowDept[$cntDept]["deptID"]; ?>','','scrollbars=yes,width=780,height=600, resizable=yes')">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/rootPlus.gif" border="0" onClick="tree(this, '2_<? echo $cntDept;?>')" style="cursor:pointer;cursor:hand">&nbsp; 
                                      <?  echo  $rowDept[$cntDept]["NAME_THAI"] ."(".$rowDept[$cntDept]["CNO2"].")";  ?>
                                    </td>
                                  </tr>
                                </table></td>
                            </tr>
                          </table>
                          <?   $cntDept++;  }  ?>
                          </span> 
                          <?
		}     ///  END while loop
?>
                        </td>
                      </tr>
                      <tr> 
                        <td colspan="6"  bordercolor="#CCCCCC" bgcolor="#F1F1F8">&nbsp; 
                          <b><font color="navy"><? echo "รวม &nbsp;".$numCourse."&nbsp; รายวิชา "; ?></font> 
                          <br>
                          <br>
                          <font color="red">***</font> &nbsp;Syllabus Online แสดงแยกตามคณะและภาควิชา 
                          กรณีมีคณะแต่ไม่มีภาควิชาจะไม่นำมาแสดง &nbsp;<font color="red">***</font></b></td>
                      </tr>
                    </table>
                  </div></td>
              </tr>
            </table></TD>
        </TR>
        <TR> 
          <TD width="100%"> <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
              <TBODY>
                <TR> 
                  <TD bgColor=#76cca3>&nbsp;</TD>
                  <TD bgColor=#76cca3>&nbsp;</TD>
                  <TD bgColor=#76cca3>&nbsp;</TD>
                </TR>
              </TBODY>
            </TABLE></TD>
        </TR>
        <TR> 
          <TD width="100%"><IMG height=12 src="../images/line5_1.gif" 
      width=760></TD>
        </TR>
        <TR> 
          <TD> <TABLE cellSpacing=0 cellPadding=0 border=0>
              <TBODY>
                <TR> 
                  <TD bgColor=#a5db6a>&nbsp;</TD>
                  <TD bgColor=#a5db6a>&nbsp;</TD>
                  <TD bgColor=#a5db6a> <TABLE cellSpacing=0 cellPadding=0 border=0>
                      <TBODY>
                        <TR> 
                          <TD>&nbsp;</TD>
                        </TR>
                        <TR> 
                          <TD>&nbsp;</TD>
                        </TR>
                      </TBODY>
                    </TABLE></TD>
                </TR>
                <TR> 
                  <TD bgColor=#a5db6a colSpan=3><IMG height=15 
            src="../images/line7_1.gif" 
  width=760></TD>
                </TR>
              </TBODY>
            </TABLE></TD>
        </TR>
        <TR> 
          <TD width="100%"></TD>
        </TR>
        <TR> 
          <TD width="100%"></TD>
        </TR>
      </TBODY>
    </TABLE>
  </CENTER>
  </DIV>
</body>
</html>