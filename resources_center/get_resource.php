<? 
require("../include/global_login.php");
$get_person = mysql_query("SELECT * FROM users WHERE id=$user;");
$row_person = mysql_fetch_array($get_person);
$name = $row_person["firstname"];
//echo "Modules o insert : ".$modules."<br>";
$get_course = mysql_query("SELECT * FROM modules WHERE id=$modules;");
$courses = mysql_fetch_array($get_course);
//echo "Courses o insert : ".$courses["courses"]."<br>";
/*if ($submit) {
	echo $chk_folder."<br>";
	echo $chk_url."<br>";
	echo $chk_file."<br>";
}*/
//echo $res_id;
?>
<html>
<head>
<title>Get Resource From Personal</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">

<SCRIPT LANGUAGE="javascript">
var ie;

if (document.all)
	ie = true;
else
	ie = false;
	
function _ca(obj)
  {
  var Count = 100; // number of checkboxes
  
  for(var ii=1;ii<=Count;ii++)
    {
	if (ie)
	  {
	  box = document.all["folder"];
	  box.checked = obj.checked;
	  }
	else
	  {
	  box = document.getElementsByName("folder");
	  box[0].checked = obj.checked;
	  }
	}
  }	
</SCRIPT>

<SCRIPT LANGUAGE="JavaScript">

function checkChoice(field, i) {
if (i == 0) { // "All" checkbox selected.
	if (field[0].checked == true) {		
		//for (i = 1; i < field.length; i++)
			//field[i].checked = true;
   		//}
	//else {
		//for (i = 1; i < field.length; i++)
			//field[i].checked = false;		
	}	
}
else  {  // A checkbox other than "Any" selected.
	if (field[i].checked == true) {
		field[0].checked = false;
      }
   	}
	
}
</script>

</head>

<body>
<? 
	$get_modules = mysql_query("SELECT * FROM modules WHERE users=$user AND active = 0 ORDER BY id;");
//	echo mysql_num_rows($get_modules)."<br>";
	/*while ($row_modules=mysql_fetch_array($get_modules)) {
		echo $row_modules["name"]."<br>";
	}*/
?>
<br>
<form name="form1" method="post" action="resource_up.php">
<table width="100%" align="center">
  <tr> 
    <td colspan="5"><div align="center"><font color="#0066FF" size="2" face="Microsoft Sans Serif, MS Sans Serif, sans-serif"><strong>Resources 
          in Personal ของ <? echo $name; ?></strong></font></div></td>
  </tr>
  <tr>
    <td colspan="5"><div align="center">
          <table border="0" align="center" cellpadding="0" cellspacing="0">
            <? while ($row_modules=mysql_fetch_array($get_modules)) { ?>
            <tr>
              <td width="243" class="res"><font size="2" face="Microsoft Sans Serif, MS Sans Serif, sans-serif"><img src="../images/resources.gif" width=20 height=16 alt="" border="0" align="top"><? echo $row_modules["name"];?>&nbsp;&nbsp;</font></td>
            </tr>
            <tr>
              <td class="res" colspan="2"><font size="2" face="Microsoft Sans Serif, MS Sans Serif, sans-serif"><img src="../images/l_down.gif" width=20 height=20 alt="" border="0" align="top"></font></td>
            </tr>
            <? //=======================================================================          
                $rs=mysql_query("SELECT r.name,r.id,r.folder,r.url,r.refid,r.file,r.modules,r.time,r.users,u.firstname,u.firstname,u.surname 
				FROM resources r,users u WHERE r.users=$user AND r.public=0 AND r.users = u.id AND r.modules = ".$row_modules["id"]." AND r.folder = 1 
				ORDER BY r.name;");
			?>
			<tr>
		              
              <td class="res" nowrap><font size="2" face="Microsoft Sans Serif, MS Sans Serif, sans-serif">	
                <? 	
			    $test  = 'a';
				if (mysql_num_rows($rs) != 0) {
            	while($row=mysql_fetch_array($rs)) {
					if ($test != 'a') {						
						//echo $test."<br>";
						$test++;
					} else {
						//echo $test."<br>";
						$test++;
					}
					
               ?>
                <img src="../images/l_out.gif" width=20 height=20 alt="" border="0" align="top"> 
                <input name="folder[ ]" type="checkbox" value="<? echo $row["id"];?>">
                <img src="../images/folder.gif" width=20 height=15 alt="" border="0" align="top"> 
                <?
              		echo $row["name"]; 
					?>
                <!--<input name="folder[ ]" type="checkbox" value="<? echo $row["id"];?>" onClick="checkChoice(document.form1.folder, 0)">-->
                <!--<input name="folder[ ]" type="checkbox" value="<? echo $row["id"];?>" onClick="javascript: _ca(this);">-->
                <br>
                <? 
					//echo "folder"."<br>";
					
					$rs_file = mysql_query("SELECT r.name,r.id,r.folder,r.url,r.refid,r.file,r.modules,r.time,r.users,u.firstname,u.firstname,u.surname 
					FROM resources r,users u WHERE r.users=$user AND r.public=0 AND r.users = u.id AND r.modules = ".$row_modules["id"]." AND r.refid = ".$row["id"]."  
					ORDER BY r.name;"); 
					$count = 1;
					if (mysql_num_rows($rs_file) != 0) { 
						while($rs_file_row=mysql_fetch_array($rs_file)) { 
							
							if ($count != 1) {						
								//echo $count."<br>";
								$count++;
							} else {
								//echo $count."<br>";
								$count++;
							}
								
							if(strlen($rs_file_row["url"])!=0) { 
								
									?>
                <img src="../images/l_down.gif" width=20 height=20 alt="" border="0" align="top"> 
                <?
									?>
                &nbsp;<img src="../images/l_out.gif" width=20 height=20 alt="" border="0" align="top"> 
                <input name="url[ ]2" type="checkbox" value="<? echo $rs_file_row["id"];?>">
                <?
	  								?>
                &nbsp;<img src="../images/link.gif" width=20 height=16 alt="" border="0" align="top"> 
                <?
                					?>
                <!--<a href="<? echo $rs_file_row["url"]?>">-->
                <? echo $rs_file_row["name"]?> 
                <!--</a>-->
                <br>
                <?
									//echo "rs_file_row"."<br>";	 
                 			} else {
								
									?>
                <img src="../images/l_down.gif" width=20 height=20 alt="" border="0" align="top"> 
                <?
									?>
                &nbsp;<img src="../images/l_out.gif" width=20 height=20 alt="" border="0" align="top"> 
                <input name="file[ ]2" type="checkbox" value="<? echo $rs_file_row["id"];?>">
                <?
        	        				?>
                &nbsp;<img src="../images/file.gif" width=20 height=16 alt="" border="0" align="top"> 
                <?
            	    				?>
                <!--<a href="../files/resources_files/<? echo $rs_file_row["id"]."/".$rs_file_row["file"]?>">-->
                <? echo $rs_file_row["name"]?> 
                <!--</a>-->
                <br>
                <?
								 	//echo "rs_file_row"."<br>";
                    		}
							
						}//End While loop $rs_file_row 
					} // End if mysql_num_rows($rs_file) 
										
				
             	} // End While loop ของ $row
				//=======================================================================			
        		?>
                <?  } else {
					
					$rs2=mysql_query("SELECT r.name,r.id,r.folder,r.url,r.refid,r.file,r.modules,r.time,r.users,u.firstname,u.firstname,u.surname 
					FROM resources r,users u WHERE r.users=$user AND r.public=0 AND r.users = u.id AND r.modules = ".$row_modules["id"]." AND r.folder = 0 AND r.refid = 0   
					ORDER BY r.name;");
					
					while($row2=mysql_fetch_array($rs2)) {
					
						if(strlen($row2["url"])!=0) { 
							?>
                <img src="../images/l_out.gif" width=20 height=20 alt="" border="0" align="top"> 
                <input name="url[ ]" type="checkbox" value="<? echo $row2["id"];?>">
                <?
		  					?>
                <img src="../images/link.gif" width=20 height=16 alt="" border="0" align="top"> 
                <?
        	        		?>
                <!--<a href="<? echo $row2["url"]?>">-->
                <? echo $row2["name"]?> 
                <!--</a>-->
                <br>
                <?
							//echo "row2"."<br>";
						}
						else {
							?>
                <img src="../images/l_out.gif" width=20 height=20 alt="" border="0" align="top"> 
                <input name="file[ ]" type="checkbox" value="<? echo $row2["id"];?>">
                <?
	        	        	?>
                <img src="../images/file.gif" width=20 height=16 alt="" border="0" align="top"> 
                <?
    	        	    	?>
                <!--<a href="../files/resources_files/<? echo $row2["id"]."/".$row2["file"]?>">-->
                <? echo $row2["name"]?> 
                <!--</a>-->
                <br>
                <?
							//echo "row2"."<br>";
						}
					}
						
				}  // End if ของ mysql_num_rows($rs) != 0
				?>
                &nbsp;&nbsp;</font></td>
            </tr>
          <?
		  	} // End While loop ของ $row_modules
		  ?>		 
		  <tr>
		  	<td>
				<input name="submit" type="submit" value="submit">
              </td>
		  </tr> 		    
          </table>
		  <input name="user" type="hidden" value="<? echo $user;?>">
		  <input name="modules" type="hidden" value="<? echo $modules;?>">
		  <input name="courses" type="hidden" value="<? echo $courses["courses"];?>">
		  <input name="res_id" type="hidden" value="<? echo $res_id;?>">
		  <input name="isedit" type="hidden" value="<? echo $isedit;?>">
      
        </div></td>
  </tr>
</table>
  </form>
</body>
</html>