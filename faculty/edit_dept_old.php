<?     require("include/connectdb.inc");
		  session_start();
  	       $table_dept = "demo_dept";
		  $field_thai = "name_thai";
		  $field_eng = "name_eng";
		  $field_fac_id = "fac_id";
		  $field_dep_id = "id";

		  $result=mysql_query("SELECT * FROM  ass a WHERE  a.id=$id");
?>
<html>
<head>
<title>.:: Edit Department ::.</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
</head>

<body bgcolor="#EFEFDE">
<table width="600" border="0" align="center">
  <tr> 
    <td height="33" bgcolor="#000000"><div align="center"><b><font color="#FFFFFF">.:: 
        Assign Task to Student Program ::.</font></b></div></td>
  </tr>
  <tr> 
    <td><div align="center">( โปรแกรมมอบหมายงานแก่นิสิตตามลำดับการเลือกของนิสิต 
        )</div></td>
  </tr>
</table>
<br>

<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr> 
    <td colspan="6"><div align="right"><font color="#666600"><b>[ <a href="file:///D|/MOO/ITforOrg/ITweb/exam/main_mm.php" target="_self"> 
        Main Management</a> ][ <a href="file:///D|/MOO/ITforOrg/ITweb/admin/logout.php?cgiPage=TaskMatching" target="_self">logout</a> 
        ]</b></font></div></td>
  </tr>
</table>
<? $row=mysql_fetch_array($result); ?>
<form name="edit_taskset" method="post" action="file:///D|/MOO/ITforOrg/ITweb/exam/update_taskset.php">
<input type="hidden" name="id" value="<? echo $id; ?>">
<input type="hidden" name="old_tsname" value="<? echo $row["name"]; ?>">
<input type="hidden" name="old_tsdes" value="<? echo $row["description"]; ?>">
		
  <table width="600" border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="#DBDBB7" bgcolor="#DBDBB7">
    <tr> 
      <td height="32" colspan="2" bgcolor="#666600"><div align="center"><b><font color="#FFFFFF">Edit 
          task set</font></b></div></td>
    </tr>
    <tr> 
      <td colspan="2" bgcolor="#FFFFFF"><div align="right">[ <a href="file:///D|/MOO/ITforOrg/ITweb/exam/insert_taskset.php" target="_self">Task 
          set Management </a>][ <a href="file:///D|/MOO/ITforOrg/ITweb/exam/insert_task.php" target="_self">add task</a> 
          ][ <a href="file:///D|/MOO/ITforOrg/ITweb/exam/insert_project.php" target="_self">add project</a> ]</div></td>
    </tr>
    <tr> 
      <td width="22%" bgcolor="#DBDBB7"><b><font color="#666600">Project name : </font></b> </td>
      <td bgcolor="#DBDBB7"> <select name="p_id" id="p_id">
          <option value="-99">------------------- Avaliable Project ------------------- 
          </option>
          <?  $result1=mysql_query("SELECT * FROM   project p ORDER BY p.id ;");
												while($row1=mysql_fetch_array($result1))  
												{
	  											 if ($row["p_id"]!=$row1["id"])
									  				 echo "<option value=\"".$row1["id"]."\"	>". $row1["name"]."</option>";
												else
													echo "<option value=\"".$row1["id"]."\"	selected>". $row1["name"]."</option>";
														
												 } ?>
        </select> </td>
    </tr>
    <tr> 
      <td bgcolor="#FFFFFF"><b><font color="#666600">Task set : </font></b></td>
      <td bgcolor="#FFFFFF"> <input name="taskset" type="text"  size="55" maxlength="50" value="<? echo $row["name"]; ?>"></td>
    </tr>
    <tr> 
      <td colspan="2"><b><font color="#666600">Taskset description 
        :</font></b> </td>
    </tr>
    <tr> 
      <td bgcolor="#FFFFFF"><b></b></td>
      <td bgcolor="#FFFFFF"><textarea name="tasksetdescr" cols="70" rows="9 " id="tasksetdescr"><? echo $row["description"]; ?></textarea></td>
    </tr>
    <tr> 
      <td>&nbsp; </td>
      <td> <input name="insert_taskset" type="submit" id="insert_taskset3" value="S a v e"> 
        <input name="reset" type="reset" id="reset" value="R e s e t"> </td>
    </tr>
  </table>
</form>
<p align="right">&nbsp;</p>
</body>
</html>
