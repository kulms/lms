<? 
require "../include/global_login.php";
require("../include/getsize.php");
require("../filemanager.inc.php");
?>
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
</head>
<body>
<?
$get_course=mysql_query("SELECT wp.modules,m.name AS modulename, mt.tablename,c.name AS coursename FROM wp,modules m,courses c,modules_type mt WHERE wp.courses=$courses AND m.id=wp.modules AND c.id=$courses AND mt.id=m.modules_type ORDER BY m.name ASC;");
if(mysql_num_rows($get_course)!=0){?>
	<div class="h3" align="center"><b><? echo $strResource_LabMang; ?> <? echo @mysql_result($get_course,0,"coursename")?></b></div>	
<? } 

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
    <td width="60%" valign="top" class="tdborder2"><table width="100%">
        <tr  class="boxcolor"> 
          <td ><table width="100%">
              <tr> 
                <td width="33%" class="Bcolor"><? echo $strResource_LabResourceName;?></td>
                <td width="67%" class="Bcolor"><? echo $strResource_LabFileDetail; ?></td>
              </tr>
            </table></td>
        </tr>
      </table>
      <table width="100%" >
        <tr> 
          <td>		   
            <? 
			$sum_all = 0;
			$count_all = 0;
			while($row_m=mysql_fetch_array($modules)) { 
				$rs = mysql_query("SELECT id, name, file,index_name from resources WHERE courses=$courses AND LENGTH(file) != 0 AND users=".$person["id"]." AND modules=".$row_m["id"].";");
				if (mysql_num_rows($rs)!=0) {
			?>
            <table width="100%">             
              <tr> 
                <td width="33%" height="21" valign="top" class="main"><img src="../images/resources.gif" width=20 height=16 alt="" border="0" align="top"><? echo $row_m["name"]; ?></td>
                <td width="67%"   class="tdborder2"><table width="100%">
                    <tr  class="boxcolor1"> 
                      <td width="41%" class="Bcolor"><? echo $strResource_LabFileName;?></td>
                      <td class="Bcolor"><? echo $strResource_LabFileSize;?></td>
                    </tr>
                    <? 
					$sum_filesize = 0;
					$count_file = 0;										
					while ($row_rs=mysql_fetch_array($rs)) {						
						//while ($row_filesize=mysql_fetch_array($get_filesize)){
						if($row_rs["index_name"] == "")
							$sum_filesize = (filesize("../files/resources_files/".$row_rs["id"]."/".$row_rs["file"])) + $sum_filesize;							
						else{
							  $allpath = "../files/resources_files/".$row_rs["id"] ;	
							  $sum_filesize=dirsize($allpath) + $sum_filesize;
						   }
						$count_file++;					
						//}
						?>
						<tr bgcolor="#FFFFFF" class="main"> 
						<? 
							if($row_rs["index_name"]==""){
								 $href="../files/resources_files/".$row_rs["id"]."/".$row_rs["file"];
							}else{
								 $href="../files/resources_files/".$row_rs["id"]."/".$row_rs["index_name"];
							}
					   ?>
						  <td><a href=<? echo $href ?> target="_blank">
								  <? echo $row_rs["name"]?></a>						  </td>
						  
                      <td><?
					  if($row_rs["index_name"]==""){
					  		if ((filesize("../files/resources_files/".$row_rs["id"]."/".$row_rs["file"])) !=0) { 
					  			$doc_filesize=(filesize("../files/resources_files/".$row_rs["id"]."/".$row_rs["file"]))." bytes";
							} else echo "--";
						}else{
							$allpath="../files/resources_files/".$row_rs["id"];
							$doc_filesize=dirsize($allpath);
						}
						
						if ($doc_filesize != 0) {
								echo GetSize ($doc_filesize);
						} else echo "0 B";
						   ?>
						</td>
					    </tr>
                    <? } ?>
                  </table></td>
              </tr>
			   <tr> 
                <td height="21" valign="top" class="main"><strong><font color="#000066"><? echo $strResource_LabEachResour;?></font></strong></td>
                <td  >
					<table width="100%" dwcopytype="CopyTableRow">
                    <tr  bgcolor="#FFFFFF"> 
                      <td width="41%"><strong><font color="#000066"><? echo $count_file." Files";?></font></strong></td>
                      <td><strong><font color="#000066"><? echo GetSize($sum_filesize);?></font></strong><strong><font color="#000066">&nbsp;</font></strong></td>
                      </tr>
                  </table></td>
              </tr>
            </table>			
            <?		
				$count_all = $count_file + $count_all;
				$sum_all = $sum_filesize + $sum_all;		
				} //End if (mysql_num_rows($get_course)!=0) 
				//$count_all = $count_file + $count_all;
				//$sum_all = $sum_filesize + $sum_all;
			} //End While($row_m=mysql_fetch_array($modules))
			?>
			
			<table width="100%" dwcopytype="CopyTableRow">
			   <tr> 
                <td width="33%" height="21" valign="top" class="main"><strong><font color="#FF0000"><? echo $strResource_LabAllResour;?></font></strong></td>
                <td width="67%"   >
					<table width="100%" dwcopytype="CopyTableRow">
                    <tr bgcolor="#FFFFFF" class="main"> 
                      <td width="41%"><font color="#FF0000"><strong><? echo $count_all." Files";?></strong></font></td>
                      <td><font color="#FF0000"><strong><? echo GetSize($sum_all)?></strong></font><font color="#FF0000">&nbsp;</font></td>
                      </tr>
                  </table></td>
              </tr>
            </table>
          </td>
        </tr>
      </table></td>
    <td width="1%">&nbsp;</td>
    <td width="39%" valign="top"><table width="100%" class="tdborder2" >
        <tr> 
          <td ><table width="100%">
              <tr class="boxcolor"> 
                <td class="Bcolor"><? echo $strResource_LabStorage;?></td>
              </tr>
              <tr> 
                <td >
					<table width="100%">
                    <tr> 
                      <td   bgcolor="#FFFFFF"><table width="100%">
                          <tr> 
                            <td width="34" align="center"><div align="center"><img src="../images/info_blue.gif" width=24 height=24 alt="" border="0" align="top"></div></td>
                            <td width="80"><font color="#000066" size="1"><? echo $strResource_LabUsedSpace;?></font></td>
                            <td width="130"><font color="#000066" size="1"><? echo $sum_all." ";?>bytes</font></td>
                            <td width="84"><font color="#000066" size="1"><? echo GetSize ($sum_all);?></font></td>
                          </tr>
                          <tr> 
                            <td align="center"><div align="center"><img src="../images/info_blue.gif" width=24 height=24 alt="" border="0" align="top"></div></td>
                            <td><font color="#000066" size="1"><? echo $strResource_LabFreeSpace;?></font></td>
                            <td><font color="#000066" size="1"><? echo $quota-$sum_all." ";?>bytes</font></td>
                            <td><font color="#000066" size="1"><? echo GetSize ($quota-$sum_all);?></font></td>
                          </tr>
                          <tr> 
                            <td align="center"><div align="center"><img src="../images/info_red.gif" width=24 height=24 alt="" border="0" align="top"></div></td>
                            <td><strong><font color="#FF0000" size="1"><? echo $strResource_LabQuota;?></font></strong></td>
                            <td><strong><font color="#FF0000" size="1"><? echo $quota." ";?>bytes</font></strong></td>
                            <td><strong><font color="#FF0000" size="1"><? echo GetSize ($quota);?></font></strong></td>
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