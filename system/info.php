<? require("../include/global_login.php"); ?>
<html>
<head><link rel="STYLESHEET" type="text/css" href="../main.css">
<style type="text/css">
<!--
body {  margin: 0px  0px; padding: 0px  0px}
a:link { color: #000099; text-decoration: none}
a:visited { color: #000099; text-decoration: none}
a:active { color: #000099; text-decoration: underline}
a:hover { color: #000099; text-decoration: underline}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620">
</head>
<body bgcolor="#ffffff" topmargin="0" leftmargin="0">
<table width="482" border="0" cellspacing="0" cellpadding="0" align="center" background="../images/headerbg.gif" height="53">
  <tr>
    <td class="menu" align="center"><b>System Area</b></td>
  </tr>
</table>
<br>
    <table align="center" width="85%"> 
    <td bgcolor="#FFFFFF" class="main"> <div align="center"> 
        <?  
		if ($person["category"] == 2) 
		{			?>
        <table width="100%"  style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
          <tr> 
            <td width="19%" class="news"><div align="center"><a href="upload_form_1.php"><img src="../images/_user.gif" width="48" height="47" border="0"></a><br>
                <a href="upload_form_1.php"> User</a>s</div></td>
            <td width="79%"  class="news"><p><br>
                </p></td>
          </tr>
        </table>
        <br>
        <table width="100%"  style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
          <tr> 
            <td width="19%" class="news"><div align="center"><a href="create_course_select.php"><img src="../images/_faculty.gif" width="48" height="51" border="0"><br>
                Modules</a><br>
              </div></td>
            <td width="79%" class="news"> <div align="left"> 
                    <p>&nbsp;</p>
              </div></td>
          </tr>
        </table>
          </div>
		  <?
		  }
		  ?>
		  
		  </td>
    
</table>
  </body>
</html>