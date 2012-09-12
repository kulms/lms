<?php 	
	require("../include/global_login.php");
?>
<html>
<head>
<title>Classroom Support</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
</head>

<body bgcolor="White">
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center"
	    height="53" class="bg1">
          <tr> 
            <td class="menu" align="center"> <b>&nbsp;<?php echo "คู่มือการใช้งาน (Manual)";?></b> 
            </td>
          </tr>
        </table>
<br>
<table align="center" width="81%">
    <td bgcolor="#FFFFFF" class="main">             
		 <?php 
		if ($person["category"] == 2)   // Teacher
		{			
		?><br>
      <table width="100%" height="240"  border="0" cellpadding="0" cellspacing="0"  class="tdborder1">
        <tr class="boxcolor">
          <td height="20" ><span class="Bcolor">M@xLearn Manual</span></td>
        </tr>
        <tr>
          <td valign="top"> <br>
            <table width="90%" height="96"  border="0" align="center" cellpadding="3" cellspacing="0">
                <tr class="boxcolor">
                  
                <td height="20" ><strong><font color="#FFFFFF">For Instructor</font></strong></td>
                </tr>
                <tr>
                  <td bgcolor="#FFFFFF" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="20%" align="center" class="news" valign="top"><img src="../images/_tools.gif" width="48" height="47"><br>
                          <?php echo $strStart_LabManual;?></td>
                      <td width="1%">&nbsp;</td>
                      <td width="79%" class="news" valign="top"> 
					  <table width="100%" border="0" cellspacing="0" cellpadding="3" class="tdborder1">
                          <tr class="boxcolor"> 
                            <td class="main_white"><strong>No.</strong></td>
                            <td class="main_white"><strong>Topic</strong></td>
                            <td colspan="2" class="main_white"><strong>Type</strong></td>
                          </tr>
                          <tr > 
                            <td bgcolor="#FFFFFF">1.</td>
                            <td bgcolor="#FFFFFF" >คู่มือทั้งหมด </td>
                            <td bgcolor="#FFFFFF" ><img src="../images/www.gif" width="16" height="16"> 
                              <a href="html/all/index.htm">html</a></td>
                            <td bgcolor="#FFFFFF" ><img src="../images/pdf.gif" width="18" height="18"> 
                              <a href="pdf/all/manual.pdf">pdf</a></td>
                          </tr>
                          <tr> 
                            <td bgcolor="#FFFFFF">2.</td>
                            <td bgcolor="#FFFFFF">คู่มือการใช้งาน Course </td>
                            <td bgcolor="#FFFFFF"><img src="../images/www.gif" width="16" height="16"> 
                              <a href="html/course/index.htm">html</a></td>
                            <td bgcolor="#FFFFFF"><img src="../images/pdf.gif" width="18" height="18"> 
                              <a href="pdf/course/manual.pdf">pdf</a></td>
                          </tr>
                          <tr> 
                            <td bgcolor="#FFFFFF">3.</td>
                            <td bgcolor="#FFFFFF">การใช้งานเครื่องมือ</td>
                            <td bgcolor="#FFFFFF">&nbsp;</td>
                            <td bgcolor="#FFFFFF">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td bgcolor="#FFFFFF"><img src="../images/spacer.gif" width="20" height="1">3.1</td>
                            <td bgcolor="#FFFFFF">กระดานอภิปราย (Forum)</td>
                            <td bgcolor="#FFFFFF"><img src="../images/www.gif" width="16" height="16"> 
                              <a href="html/forum/index.htm">html</a></td>
                            <td bgcolor="#FFFFFF"><img src="../images/pdf.gif" width="18" height="18"> 
                              <a href="pdf/forum/manual.pdf">pdf</a></td>
                          </tr>
                          <tr> 
                            <td bgcolor="#FFFFFF"><img src="../images/spacer.gif" width="20" height="1">3.2</td>
                            <td bgcolor="#FFFFFF">กลุ่มสมาชิกและแฟ้มเอกสาร (Group 
                              &amp; Folder)</td>
                            <td bgcolor="#FFFFFF"><img src="../images/www.gif" width="16" height="16"> 
                              <a href="html/group/index.htm">html</a></td>
                            <td bgcolor="#FFFFFF"><img src="../images/pdf.gif" width="18" height="18"> 
                              <a href="pdf/group/manual.pdf">pdf</a></td>
                          </tr>
                          <tr> 
                            <td bgcolor="#FFFFFF"><img src="../images/spacer.gif" width="20" height="1">3.3</td>
                            <td bgcolor="#FFFFFF"> ระบบการส่งงาน (Homework)</td>
                            <td bgcolor="#FFFFFF"><img src="../images/www.gif" width="16" height="16"> 
                              <a href="html/homework/index.htm">html</a></td>
                            <td bgcolor="#FFFFFF"><img src="../images/pdf.gif" width="18" height="18"> 
                              <a href="pdf/homework/manual.pdf">pdf</a></td>
                          </tr>
                          <tr> 
                            <td bgcolor="#FFFFFF"><img src="../images/spacer.gif" width="20" height="1">3.4</td>
                            <td bgcolor="#FFFFFF">แบบทดสอบ (Quiz)</td>
                            <td bgcolor="#FFFFFF"><img src="../images/www.gif" width="16" height="16"> 
                              <a href="html/quiz/index.htm">html</a></td>
                            <td bgcolor="#FFFFFF"><img src="../images/pdf.gif" width="18" height="18"> 
                              <a href="pdf/quiz/manual.pdf">pdf</a></td>
                          </tr>
                          <tr> 
                            <td bgcolor="#FFFFFF"><img src="../images/spacer.gif" width="20" height="1">3.5</td>
                            <td bgcolor="#FFFFFF">ระบบการประเมินการสอนโดยนิสิต 
                              (Evaluation)</td>
                            <td bgcolor="#FFFFFF"><img src="../images/www.gif" width="16" height="16"> 
                              <a href="html/evaluate/index.htm">html</a></td>
                            <td bgcolor="#FFFFFF"><img src="../images/pdf.gif" width="18" height="18"> 
                              <a href="pdf/evaluate/manual.pdf">pdf</a></td>
                          </tr>
                          <tr> 
                            <td bgcolor="#FFFFFF"><img src="../images/spacer.gif" width="20" height="1">3.6</td>
                            <td bgcolor="#FFFFFF">แหล่งข้อมูล (Resources)</td>
                            <td bgcolor="#FFFFFF"><img src="../images/www.gif" width="16" height="16"> 
                              <a href="html/resources/index.htm">html</a></td>
                            <td bgcolor="#FFFFFF"><img src="../images/pdf.gif" width="18" height="18"> 
                              <a href="pdf/resources/manual.pdf">pdf</a></td>
                          </tr>
                          <tr> 
                            <td bgcolor="#FFFFFF"><img src="../images/spacer.gif" width="20" height="1">3.7</td>
                            <td bgcolor="#FFFFFF">กระดานข่าว (Webboard)</td>
                            <td bgcolor="#FFFFFF"><img src="../images/www.gif" width="16" height="16"> 
                              <a href="html/webboard/index.htm">html</a></td>
                            <td bgcolor="#FFFFFF"><img src="../images/pdf.gif" width="18" height="18"> 
                              <a href="pdf/webboard/manual.pdf">pdf</a></td>
                          </tr>
						  <tr> 
                            <td bgcolor="#FFFFFF"><img src="../images/spacer.gif" width="20" height="1">3.7</td>
                            <td bgcolor="#FFFFFF">ระบบคำนวณผลการเรียน (Grading 
                              System)</td>
                            <td bgcolor="#FFFFFF"><img src="../images/www.gif" width="16" height="16"> 
                              <a href="html/grade/index.htm">html</a></td>
                            <td bgcolor="#FFFFFF"><img src="../images/pdf.gif" width="18" height="18"> 
                              <a href="pdf/grade/manual.pdf">pdf</a></td>
                          </tr>
                          <tr>
                            <td bgcolor="#FFFFFF"><img src="../images/spacer.gif" width="20" height="1">3.8</td>
                            <td bgcolor="#FFFFFF">การสร้างบทเรียนประกอบการสอน 
                              (Content Creator)</td>
                            <td bgcolor="#FFFFFF"><img src="../images/www.gif" width="16" height="16"> 
                              <a href="html/content/index.htm">html</a></td>
                            <td bgcolor="#FFFFFF"><img src="../images/pdf.gif" width="18" height="18"> 
                              <a href="pdf/content/manual.pdf">pdf</a></td>
                          </tr>
                          <!--
                          <tr> 
                            <td bgcolor="#FFFFFF">11.</td>
                            <td bgcolor="#FFFFFF">แหล่งข้อมูล</td>
                            <td bgcolor="#FFFFFF"><img src="../images/www.gif" width="16" height="16"> 
                              html</td>
                            <td bgcolor="#FFFFFF"><img src="../images/pdf.gif" width="18" height="18"> 
                              pdf</td>
                          </tr>
						  -->
                        </table></td>
                    </tr>
                  </table></td>
                </tr>
				
              </table>
              
            <br>
          </td>
        </tr>
      </table>
	  
	  <? } ?>
</table>

</body>
</html>