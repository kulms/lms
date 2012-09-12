<?php 
require "../include/global_login.php";
require("../include/getsize.php");
?>
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body>
<?php
$get_course=mysql_query("SELECT wp.modules,m.name AS modulename, mt.tablename,c.name AS coursename FROM wp,modules m,courses c,modules_type mt WHERE wp.courses=$courses AND m.id=wp.modules AND c.id=$courses AND mt.id=m.modules_type ORDER BY m.name ASC;");
if(mysql_num_rows($get_course)!=0){?>
	<div class="h3" align="center"><b>Manage Resource in Course <?php echo @mysql_result($get_course,0,"coursename")?></b></div>	
<?php } else { ?>
		<div class="h3" align="center"><b>Manage Resource in Personal <?php echo $person["firstname"];?></b></div>	
<?php }

		$modules=mysql_query("SELECT Distinct mt.picture,m.id,m.users,m.active,m.name
							  FROM modules m,wp,modules_type mt 
							  WHERE (wp.courses=$courses AND wp.modules=m.id AND m.modules_type=mt.id AND wp.cases=0 AND wp.groups=0 AND wp.folders=0 AND mt.id=3) order by m.name;");		
		if ($courses!=0) {
			$q = mysql_query("SELECT quota FROM courses WHERE id=$courses;");
			$row_q = mysql_fetch_array($q);
			$quota = $row_q["quota"]*1024*1024;
		} else {	
			$quota = $person["quota"]*1024*1024;
		}
												  
?>	
<table width="100%">
  <tr> 
    <td width="60%" valign="top"><table width="100%">
        <tr> 
          <td bgcolor="#000066"><table width="100%">
              <tr> 
                <td width="33%" class="main"><strong><font color="#FFFFFF">Resource 
                  Name</font></strong></td>
                <td width="67%" class="main"><strong><font color="#FFFFFF">File 
                  Detail</font></strong></td>
              </tr>
            </table></td>
        </tr>
      </table>
      <table width="100%">
        <tr> 
          <td bgcolor="#CCCCCC">		   
            <?php 
			$sum_all = 0;
			$count_all = 0;
			while($row_m=mysql_fetch_array($modules)) { 
				$rs = mysql_query("SELECT id, name, file from resources WHERE courses=$courses AND LENGTH(file) != 0 AND users=".$person["id"]." AND modules=".$row_m["id"].";");
				if (mysql_num_rows($rs)!=0) {
			?>
            <table width="100%">             
              <tr> 
                <td width="33%" height="21" valign="top" class="main"><img src="../images/resources.gif" width=20 height=16 alt="" border="0" align="top"><?php echo $row_m["name"]; ?></td>
                <td width="67%" bgcolor="#9999FF" class="main"><table width="100%">
                    <tr bgcolor="#999999" class="main"> 
                      <td width="41%" class="main"><strong>Filename</strong></td>
                      <td width="40%" class="main"><strong>FileSize</strong></td>
                      <td width="19%" class="main"><strong>Action</strong></td>
                    </tr>
                    <?php 
					$sum_filesize = 0;
					$count_file = 0;										
					while ($row_rs=mysql_fetch_array($rs)) {						
						//while ($row_filesize=mysql_fetch_array($get_filesize)){
						$sum_filesize = (filesize("../files/resources_files/".$row_rs["id"]."/".$row_rs["file"])) + $sum_filesize;							
						$count_file++;					
						//}
						?>
						<tr bgcolor="#CCCCCC" class="main"> 
						  <td><a href="../files/resources_files/<?php echo $row_rs["id"]."/".$row_rs["file"]?>" target="_blank">
								  <?php echo $row_rs["name"]?></a>
						  </td>
						  
                      <td><?php
					  		if ((filesize("../files/resources_files/".$row_rs["id"]."/".$row_rs["file"]))!=0) { 
					  			echo (filesize("../files/resources_files/".$row_rs["id"]."/".$row_rs["file"]))." bytes";
							} else echo "--";
						   ?>
						</td>
						  <td>Delete</td>
						</tr>
                    <?php } ?>
                  </table></td>
              </tr>
			   <tr> 
                <td height="21" valign="top" class="main"><strong><font color="#000066">Total 
                  each resource : </font></strong></td>
                <td bgcolor="#9999FF" class="main">
					<table width="100%" dwcopytype="CopyTableRow">
                    <tr bgcolor="#CCCCCC" class="main"> 
                      <td width="41%"><strong><font color="#000066"><?php echo $count_file." Files";?></font></strong></td>
                      <td width="40%"><strong><font color="#000066"><?php echo GetSize($sum_filesize);?></font></strong></td>
                      <td width="19%"><strong><font color="#000066">&nbsp;</font></strong></td>
                    </tr>
                  </table></td>
              </tr>
            </table>			
            <?php		
				$count_all = $count_file + $count_all;
				$sum_all = $sum_filesize + $sum_all;		
				} //End if (mysql_num_rows($get_course)!=0) 
				//$count_all = $count_file + $count_all;
				//$sum_all = $sum_filesize + $sum_all;
			} //End While($row_m=mysql_fetch_array($modules))
			?>
			
			<table width="100%" dwcopytype="CopyTableRow">
			   <tr> 
                <td width="33%" height="21" valign="top" class="main"><strong><font color="#FF0000">Total 
                  all resources : </font></strong></td>
                <td width="67%" bgcolor="#9999FF" class="main">
					<table width="100%" dwcopytype="CopyTableRow">
                    <tr bgcolor="#FFFFFF" class="main"> 
                      <td width="41%"><font color="#FF0000"><strong><?php echo $count_all." Files";?></strong></font></td>
                      <td width="40%"><font color="#FF0000"><strong><?php echo GetSize($sum_all)?></strong></font></td>
                      <td width="19%"><font color="#FF0000">&nbsp;</font></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
        </tr>
      </table></td>
    <td width="1%">&nbsp;</td>
    <td width="39%" valign="top"><table width="100%">
        <tr> 
          <td bgcolor="#CCCCCC"><table width="100%">
              <tr> 
                <td bgcolor="#000066" class="main"><font color="#FFFFFF"><strong>Storage 
                  Usage</strong></font></td>
              </tr>
              <tr> 
                <td bgcolor="#FFFFFF" class="main">
					<table width="100%">
                    <tr> 
                      <td bgcolor="#CCCCCC" class="main"><table width="100%">
                          <tr> 
                            <td width="34" align="center"><div align="center"><img src="../images/info_blue.gif" width=24 height=24 alt="" border="0" align="top"></div></td>
                            <td width="80"><font color="#000066" size="1">Used 
                              Space :</font></td>
                            <td width="130"><font color="#000066" size="1"><?php echo $sum_all." ";?>bytes</font></td>
                            <td width="84"><font color="#000066" size="1"><?php echo GetSize ($sum_all);?></font></td>
                          </tr>
                          <tr> 
                            <td align="center"><div align="center"><img src="../images/info_blue.gif" width=24 height=24 alt="" border="0" align="top"></div></td>
                            <td><font color="#000066" size="1">Free Space :</font></td>
                            <td><font color="#000066" size="1"><?php echo $quota-$sum_all." ";?>bytes</font></td>
                            <td><font color="#000066" size="1"><?php echo GetSize ($quota-$sum_all);?></font></td>
                          </tr>
                          <tr> 
                            <td align="center"><div align="center"><img src="../images/info_red.gif" width=24 height=24 alt="" border="0" align="top"></div></td>
                            <td><strong><font color="#FF0000" size="1">Your Quota:</font></strong></td>
                            <td><strong><font color="#FF0000" size="1"><?php echo $quota." ";?>bytes</font></strong></td>
                            <td><strong><font color="#FF0000" size="1"><?php echo GetSize ($quota);?></font></strong></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>

	
</body>
</html>