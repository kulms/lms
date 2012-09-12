<?  	
		session_start();
		$session_id = session_id();		

		require ("../include/global_login.php");
		
		$g_sql = "SELECT * FROM g_grade WHERE g_courses = $g_courses;";
		$g_query = mysql_query($g_sql);
		$g_result = mysql_fetch_array($g_query);
		print_progress("2");
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
</head>
<body>
<form name="select_type" method="post" action="?a=select_level">	
  <table width="603" border="0" align="center" cellpadding="2" cellspacing="0" class="tdborder1">
    <tr class="boxcolor"> 
      <th colspan="2"  class="Bcolor">Select your Type</th>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td  align="left" class="hilite"> <input name="type" type="submit"  value="Save" class="button"> 
        <input name="reset" type="reset" id="reset" value="Reset" class="button">	
      </td>
      <td align="right">&nbsp;</td>
    </tr>
    <tr> 
      <td width="187" align="right">Type : </td>
      <td width="404"> 
        <?
	$sql = "SELECT g_eval_type_id, g_eval_type_name FROM g_eval_type;";
    
	$result = mysql_query($sql);
  
					echo "<select name=\"g_eval_type\" >";
		            echo "<option value=\"\">Select Type</option>";
                  while ($row = mysql_fetch_array($result)) {
                     
					 echo "<option value=\"$row[0]\" >$row[1]</option>";
	
		     
                              }
		echo "</select>";
                  
			?>
      </td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>