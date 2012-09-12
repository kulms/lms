<? //get Modules id & Resources id
require("../include/global_login.php");
require("../include/getsize.php");
require("../filemanager.inc.php");

$check=mysql_query("SELECT name FROM modules WHERE id=$modules;");

$get_course=mysql_query("SELECT courses FROM wp WHERE modules=$modules;");
$getc=mysql_fetch_array($get_course);
$courses=$getc['courses'];

$check_cadmin=mysql_query("SELECT m.id, m.users FROM modules m, wp WHERE m.id=$id and m.id=wp.modules AND wp.users=".$person["id"].";");

//echo "SELECT m.id, m.users FROM modules m, wp WHERE m.id=$id and m.id=wp.modules AND wp.users=".$person["id"].";";
if(mysql_num_rows($check_cadmin)!=0){
        $cadmin=1;
}else{
        $cadmin=0;
}
$sql_folder=mysql_query("SELECT r.* FROM resources r WHERE modules=$modules AND r.folder=1 AND r.id<>$id order by r.name;");
//**************************** GET QUOTA  **************************** 
if ($getc["courses"] != 0) {
	$get_filesize = mysql_query("SELECT id, file,index_name from resources WHERE courses=".$getc["courses"]." AND LENGTH(file) != 0 AND users=".$person["id"].";");	
} else {
	$get_filesize = mysql_query("SELECT id, file,index_name from resources WHERE courses=0 AND LENGTH(file) != 0 AND users=".$person["id"].";");
}
$sum_filesize = 0;
while ($row_filesize=mysql_fetch_array($get_filesize)){
	if($row_filesize["index_name"] == ""){
		//$sum_filesize = (filesize("../files/resources_files/".$row_filesize["id"]."/".$row_filesize["file"])) + $sum_filesize;	
	}else{
		//$sum_filesize = (filesize("../files/resources_files/".$row_filesize["id"])) + $sum_filesize;	
	}
}
if ($getc["courses"]!=0) {
	$q = mysql_query("SELECT quota FROM courses WHERE id=".$getc["courses"].";");
	$row_q = mysql_fetch_array($q);
	$quota = ($row_q["quota"])*1024*1024;
	if ($quota >= $sum_filesize) {
		$check_q = true;
	} else {
		$check_q = false;
		$check_after = false;
	}	
} else {	
	$quota = ($person["quota"])*1024*1024;
	if ($quota >= $sum_filesize) {
		$check_q = true;
	} else {
		$check_q = false;
		$check_after = false;
	}
}
//**************************** END GET QUOTA  **************************** 
?>
<html>
<head>
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
<title>Edit resources</title>
<script language="javascript">
<!--

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<SCRIPT LANGUAGE="JavaScript" src="form.js"></SCRIPT>

<link rel="STYLESHEET" type="text/css" href="../main.css">
<!--<link rel="STYLESHEET" type="text/css" href="../themes/blue/style/style.css">-->
<link href="style.css" rel="stylesheet" type="text/css">
<LINK href="main.css" type=text/css rel=stylesheet>
<meta http-equiv="Content-Type" content="text/html; charset=tis-620"></head>
<body>
<div align="center"><br>
  <table width="500" align="center" class="tdborder4">
    <tr> 
      <td class="Bcolor" align="center"> Resource 
          : <? echo mysql_result($check,0,"name");?></td>
    </tr>
  </table>  
  <?
if($id!="0"){
        $rs=mysql_query("SELECT * from resources WHERE id=$id;");
        $r=mysql_fetch_array($rs);
		if ($action == "edit") {
        if($r["users"]==$person["id"] || $person["admin"]==1 || $cadmin==1){
        ?>
  <br>
  <table width="500" align="center" class="tdborder4">
    <tr> 
      <td class="Bcolor"> <div align="center"><font  size="5"><strong>..:: <?php echo $strEdit;?> 
          ::..</strong></font></div></td>
    </tr>
  </table>
  <br>
  <table width="500" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td  colspan="4" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;"> 
        <table width="100%" border="0" cellspacing="2" cellpadding="2" >
          <tr> 
            <td width="13%">
			<?
                 if($r["folder"]==0 && strlen($r["url"])>0){
    		?>
				<img src="../images/weblink.gif"  border="0" align="top">
			<? } else { 
					 if($r["folder"]==0 && strlen($r["url"])==0){
					 	if($r["index_name"]==""){
					 		echo "<img src=\"../images/file2.gif\"  border=\"0\" align=\"top\">";
						}
						else
							echo "<img src=\"../images/zip1.gif\"  border=\"0\" align=\"top\">";
			?>
				<!--<img src="../images/file2.gif"  border="0" align="top">-->
			<? 		} else {  ?>
			<img src="../images/folder3.gif"  border="0" align="top">
			<?
						}
					}
			?>				
			</td>
            <td width="87%" valign="top"> 
			<form action="rename.php" method="post"  name="rename">
			<input type="hidden" name="courses" value="<? echo $courses?>">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="22%">
					<?
                	 if($r["folder"]==0 && strlen($r["url"])>0){										
						echo $strResource_LabUrlName;
					 } else { 
							 if($r["folder"]==0 && strlen($r["url"])==0){					
								echo $strResource_LabFileName;
							} else {  
									echo $strResource_LabFolderName;
								}
							}
					?>	
					</td>
                    <td width="78%"><input type="text" name="name" size="40" value="<? echo $r[name];?>" class="text"></td>
                    <input type="hidden" name="modules" value="<? echo $modules?>">
                    <input type="hidden" name="id" value="<? echo $id?>">
                  </tr>
				  <? if($r["index_name"] !=""){?>
				<tr> 
                    <td width="22%">Index Name</td>
                    <td width="78%"><input type="text" name="index" size="40" value="<? echo $r["index_name"];?>" class="text">                      
                      <input type="hidden" name="zip" value="1">
				    <input  type="hidden" name="index_name" value="<? echo $r["index_name"];?>">
					<? 
						$sql=mysql_query("SELECT index_name FROM resources WHERE id=$id");
						$index_name=mysql_result($sql,0,'index_name');
						$allpath=$realpath."/files/resources_files/".$id;
						$dir=opendir($allpath);
						$i=0;
						while(($data=readdir($dir)) != false){
							if ($data != "." && $data != "..") { 
								if(is_file($allpath."/".$index_name))
									$i++;
							}
						}
					?>
					<input  type="hidden" name="error" value="<? echo $i?>">
					</td></tr>
				  <? }?>
				  <tr> 
                    <td height="23" colspan="2">&nbsp;</td>
				  </tr>
                  <tr> 
                    <td colspan="2">
					<?
                	 if($r["folder"]==0 && strlen($r["url"])>0){ ?>
						<input type="submit" name="Rename" value="<? echo $strResource_BtnEditUrl;?>" class="button" onClick="return checkEmptyEdit()">
					 <? } else { 
							 if($r["folder"]==0 && strlen($r["url"])==0){	?>
							 	<? if($r["index_name"] ==""){ ?>
										<input type="submit" name="Rename" value="<? echo $strResource_BtnEditFile;?>" class="button" onClick="return checkEmptyEdit()">
								<? }else{?>
										<input  type="submit" name="Rename" value="<? echo $strResource_BtnEditZip;?>" class="button" onClick="return checkEmptyEdit()">
								<? }?>
							<? } else {  ?>
									<input type="submit" name="Rename" value="<? echo $strResource_BtnEditFolder;?>" class="button" onClick="return checkEmptyEdit()">
								<? }
							}
					?>						
					</td>
                  </tr>
                </table>
              </form></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td class="tdbackground1">&nbsp;</td>
    </tr>
    <?
                 if($r["folder"]==0 && strlen($r["url"])>0){
    ?>
    <tr> 
      <td colspan="4" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
	  <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr> 
            <td width="13%" valign="top"><img src="../images/weblink.gif"  border="0" align="top"></td>
            <td width="87%"> <form action="url.php" method="post" >
			<input type="hidden" name="courses" value="<? echo $courses?>">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="22%" ><? echo $strResource_LabUrl;?></td>
                    <td width="78%"><input type="text" name="url" size="40" value="<? echo $r["url"]?>" class="text"></td>
                  </tr>
                  <tr> 
                    <td valign="top"><? echo $strResource_LabShowType;?></td>
                    <td><input name="file_target" type="hidden" value="0">
                    <!--
                    <table width="200">
                        <tr> 
                          <td class="res"><label> 
                            <input name="file_target" type="radio" value="0" <? if($r["new_window"]==0) echo "Checked"; else echo "Unchecked";?> class="r-button">
                            Show URL in same window</label></td>
                        </tr>
                        <tr> 
                          <td class="res"><label> 
                            <input name="file_target" type="radio" value="1" <? if($r["new_window"]==1) echo "Checked"; else echo "Unchecked";?> class="r-button">
                            Show URL in new window</label></td>
                        </tr>
                        <tr> 
                          <td class="res"><label> 
                            <input name="file_target" type="radio" value="2" <? if($r["new_window"]==2) echo "Checked"; else echo "Unchecked";?> class="r-button">
                            Show URL in full screen window</label></td>
                        </tr>
                      </table>
                      -->
                      </td>
                  </tr>
                  <tr> 
                    <input type="hidden" name="modules" value="<? echo $modules?>">
                    <input type="hidden" name="id" value="<? echo $id?>">
                    <td><input name="submit" type="submit" value="Update URL" class="button">&nbsp;
                    </td>
                    <td ><input type="button" name="Submit2" value="Cancel" onClick="{location='index.php?id=<?echo $modules?>';}" class="button"> 
                    </td>
                  </tr>
                </table>
              </form></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td  class="tdbackground1">&nbsp;</td>
    </tr>
    <?
                 }
                if($r["folder"]==0 && strlen($r["url"])==0){
     ?>
    <tr> 
      <td  colspan="4" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
	<? if($r["index_name"] =="") {?>
	  <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr> 
            <td width="13%" valign="top"><img src="../images/file2.gif"  border="0" align="top"></td>
            <td width="87%"> <form  name="form" action="file.php" method="post" enctype="multipart/form-data" onSubmit="return checkFields(this.file,'file');">
			<input type="hidden" name="courses" value="<? echo $courses?>">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="22%"><? echo $strResource_LabFileUpload;?></td>
                    <td width="78%"><input type="file" name="file" size="40" class="text"></td>
                  </tr>
                  <tr> 
                    <td valign="top"><? echo $strResource_LabShowType;?></td>
                    <td><input name="file_target" type="hidden" value="0">
                    <!-- 
                    <table width="200">
                        <tr> 
                          <td class="res"><label> 
                            <input name="file_target" type="radio" value="0" <? if($r["new_window"]==0) echo "Checked"; else echo "Unchecked";?> class="r-button">
                            Show file in same window</label></td>
                        </tr>
                        <tr> 
                          <td class="res"><label> 
                            <input name="file_target" type="radio" value="1" <? if($r["new_window"]==1) echo "Checked"; else echo "Unchecked";?> class="r-button">
                            Show file in new window</label></td>
                        </tr>
                        <tr> 
                          <td class="res"><label> 
                            <input name="file_target" type="radio" value="2" <? if($r["new_window"]==2) echo "Checked"; else echo "Unchecked";?> class="r-button">
                            Show URL in full screen window</label></td>
                        </tr>
                      </table>
                      -->
                      </td>
                  </tr>
                  <tr>
                    <td valign="bottom">&nbsp;</td>
                    <td valign="bottom"><b>Old file: <? echo $r["file"]?></b><input type="hidden" name="file_old" value="<? echo $r["file"]?>">
                      <br> 
                      <br> <strong><font color="#FF0000">English file name 
                    ONLY!!! </font></strong></td>
                  </tr>
                  <tr> 
                    <input type="hidden" name="modules" value="<? echo $modules?>">
                    <input type="hidden" name="id" value="<? echo $id?>">
                    <input type="hidden" name="courses" value="<? echo $getc["courses"];?>">
                    <td valign="bottom"><input name="submit3" type="submit" value="Upload new file" class="button">&nbsp;
                    </td>
                    <td valign="bottom"><input type="button" name="Submit22" value="Cancel" onClick="{location='index.php?id=<?echo $modules?>';}" class="button"> 
                    </td>
                  </tr>
                </table>
              </form></td>
          </tr>
        </table>
		<? }else{?>
		<table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr> 
            <td width="13%" valign="top"><img src="../images/zip1.gif"  border="0" align="top"></td>
            <td width="87%"> <form  name="form" action="unzip.php" method="post" enctype="multipart/form-data" onSubmit="return checkFieldsEdit(this.file);">
			<input type="hidden" name="courses" value="<? echo $courses?>">
			<input  type="hidden" name="rename" value="1">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="22%"><? echo $strResource_LabFileUpload;?></td>
                    <td width="78%"><input type="file" name="file" size="40" class="text"></td>
                  </tr>
                  <tr> 
                    <td valign="top"><? echo "Index Name";?></td>
                    <td>
                    <input name="file_target" type="hidden" value="0"> 
                    <!--
                    <table width="200">
                        <tr> 
                          <td class="res"><label> 
                            <input name="file_target" type="radio" value="0" <? if($r["new_window"]==0) echo "Checked"; else echo "Unchecked";?> class="r-button">
                            Show file in same window</label></td>
                        </tr>
                        <tr> 
                          <td class="res"><label> 
                            <input name="file_target" type="radio" value="1" <? if($r["new_window"]==1) echo "Checked"; else echo "Unchecked";?> class="r-button">
                            Show file in new window</label></td>
                        </tr>
                        <tr> 
                          <td class="res"><label> 
                            <input name="file_target" type="radio" value="2" <? if($r["new_window"]==2) echo "Checked"; else echo "Unchecked";?> class="r-button">
                            Show URL in full screen window</label></td>
                        </tr>
                      </table>
                      -->
                      </td>
                  </tr>
                  <tr>
                    <td valign="bottom">&nbsp;</td>
                    <td valign="bottom"><b>Old file: <? echo $r["file"]?></b><input type="hidden" name="file_old" value="<? echo $r["file"]?>">
                      <br> 
                      <br> <strong><font color="#FF0000">English file name 
                    ONLY!!! </font></strong></td>
                  </tr>
                  <tr> 
                    <input type="hidden" name="modules" value="<? echo $modules?>">
                    <input type="hidden" name="id" value="<? echo $id?>">
                    <input type="hidden" name="courses" value="<? echo $getc["courses"];?>">
                    <td valign="bottom"><input name="submit3" type="submit" value="Upload new file" class="button">&nbsp;&nbsp;
                    </td>
                    <td valign="bottom"><input type="button" name="Submit22" value="Cancel" onClick="{location='index.php?id=<?echo $modules?>';}" class="button"> 
                    </td>
                  </tr>
                </table>
              </form></td>
          </tr>
        </table>
		<? }?>
		</td>
    </tr>
    <tr> 
      <td  class="tdbackground1">&nbsp;</td>
    </tr>
    <?
                } 
	?>
    <tr> 
      <td  colspan="4"  style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
	  <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr> 
            <td width="17%" valign="top"><? echo $strResource_LabMove;?></td>
            <td width="83%"> <form name="form3" method="post" action="move.php" onSubmit="return chk_lstFolder(this.lstFolder);">
			<input type="hidden" name="courses" value="<? echo $courses?>">
                <select name="lstFolder" class="pn-text">
                  <option value="-1"><? echo "--------- Select Folder ----------";?></option>
                  <option value="0"><? echo "== Up To Root Folder ==";?></option>
                  <? while($row_folder=mysql_fetch_array($folder)) { 
				if ($r["refid"]!=$row_folder["id"]) {
			?>
                  <option value="<? echo $row_folder["id"]; ?>"><? echo $row_folder["name"];?></option>
                  <? } ?>
                  <? } ?>
                </select>
                <input type="hidden" name="modules" value="<? echo $modules?>">
                <input type="hidden" name="id" value="<? echo $id?>">
                <input type="submit" name="Submit" value="<? echo $strResource_BtnMove;?>" class="button">
                <br>
              </form></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td  class="tdbackground1">&nbsp;</td>
    </tr>
    <tr> 
      <td  colspan="4"  style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
	  <!--
	  <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td width="17%" valign="top"><? //echo $strResource_LabDelete;?></td>
            <td width="83%"><form>
          <input name="button" type="button" onClick="if(confirm('Realy delete?')){location='delete.php?modules=<? //echo $modules?>&id=<? //echo $r["id"]?>';}" value="<? //echo $strResource_BtnDelete;?>">
        </form></td>
          </tr>
        </table>
		-->
		</td>
    </tr>
    <tr> 
      <td  class="tdbackground1">&nbsp;</td>
    </tr>
    <tr>
      <td  colspan="4"  style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
	  <!--
      <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td width="17%" valign="top">&nbsp;</td>
            <td width="83%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>				
                  <td width="22%" valign="top"><? echo $strResource_LabDiskUsage;?></td>
                  <td width="78%"><table width="99%">
                      <tr> 
                        <td width="24" align="center"><div align="center"><img src="../images/info_blue.gif" width=24 height=24 alt="" border="0" align="top"></div></td>
                        <td width="69"><font color="#0066FF" size="1">Used Space:</font></td>
                        <td width="92"><font color="#0066FF" size="1"><? echo $sum_filesize." ";?>bytes</font></td>
                        <td width="63"><font color="#0066FF" size="1"><? echo GetSize ($sum_filesize);?></font></td>
                      </tr>
                      <tr> 
                        <td align="center"><div align="center"><img src="../images/info_blue.gif" width=24 height=24 alt="" border="0" align="top"></div></td>
                        <td><font color="#0066FF" size="1">Free Space :</font></td>
                        <td><font color="#0066FF" size="1"><? echo $quota-$sum_filesize." ";?>bytes</font></td>
                        <td><font color="#0066FF" size="1"><? echo GetSize ($quota-$sum_filesize);?></font></td>
                      </tr>
                      <tr> 
                        <td align="center"><div align="center"><img src="../images/info_red.gif" width=24 height=24 alt="" border="0" align="top"></div></td>
                        <td><strong><font color="#FF0000" size="1">Your Quota:</font></strong></td>
                        <td><strong><font color="#FF0000" size="1"><? echo $quota." ";?>bytes</font></strong></td>
                        <td><strong><font color="#FF0000" size="1"><? echo GetSize ($quota);?></font></strong></td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
        </table>
        --></td>
    </tr>
    <tr> 
      <td  class="tdbackground1">&nbsp;</td>
    </tr>
    <tr> 
      <? if($r["users"]==$person["id"] || $person["admin"]==1 || $cadmin==1){
				?>
      <? if($r["folder"]==1) { ?>
      <td   style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;"> 
        <form name="form4" method="post" action="">
          <table width="100%" border="0" cellspacing="0" cellpadding="2">
		  <!--
            <tr valign="top"> 
              <td width="35%"><? echo $strResource_LabGetFilePer;?></td>
              <td width="65%"> 
                <? if ($folders=="yes") { ?>
                <input name="getFile" type="submit" id="getFile5" onClick="MM_openBrWindow('get_resource.php?user=<? echo $person["id"];?>&modules=<? echo $modules;?>&res_id=<? echo $id;?>&isedit=1&folders=yes','getResource','status=yes,scrollbars=yes,width=390,height=400')" value="Get Files"> 
                <? } else { ?>
                <input name="getFile" type="submit" id="getFile5" onClick="MM_openBrWindow('get_resource.php?user=<? echo $person["id"];?>&modules=<? echo $modules;?>&res_id=<? echo $id;?>&isedit=1','getResource','status=yes,scrollbars=yes,width=390,height=400')" value="Get Files"> 
                <? } ?>
              </td>
            </tr>
			-->
            <tr valign="top"> 
              <td><? echo $strResource_LabGetFileCenter;?></td>
              <td> 
                <? if ($folders=="yes") { ?>
                <input name="getFile4" type="submit" id="getFile42" onClick="MM_openBrWindow('index_rc.php?user=<? echo $person["id"];?>&modules=<? echo $modules;?>&res_id=<? echo $id;?>&isedit=1&folders=yes&courses=<? echo $getc["courses"];?>','getResCenter','status=yes,scrollbars=yes,width=620,height=600')" value="Get Files" class="button"> 
                <? } else { ?>
                <input name="getFile4" type="submit" id="getFile42" onClick="MM_openBrWindow('index_rc.php?user=<? echo $person["id"];?>&modules=<? echo $modules;?>&res_id=<? echo $id;?>&isedit=1&courses=<? echo $getc["courses"];?>','getResCenter','status=yes,scrollbars=yes,width=620,height=600')" value="Get Files" class="button"> 
                <? } ?>
              </td>
            </tr>
          </table>
        </form> 		
	  </td>
	  <? }
	 }?>
    </tr>
  </table>
 
<?
        }else{
        $getuser=mysql_query("SELECT u.firstname, u.surname FROM users u, resources r WHERE r.id=$id AND u.id=r.users");
        $creator=mysql_result($getuser,0,"firstname")."&nbsp;".mysql_result($getuser,0,"surname");
        ?>
        <p>
        <div class="h5" align="center">Sorry, you can't edit this item. It can only be edited by it's creator (<i><? echo $creator ?></i>)</div>
        </p>
        <? }
		}
}
if ($action == "add") {
		if (($folder=="true") or ($r["folder"]==1) or ($id==0)){
		//if($folder=="true"){
        ?>
        <hr noshade size="4" width="400">
  <table width="500" align="center"  class="tdborder4">
    <tr> 
      <td  class="Bcolor"> <div align="center"><font  size="5"><strong>..:: 
          <?php echo $strAdd." ".$m;?> ::..</strong></font></div></td>
    </tr>
  </table>  
  <br>
  <table width="500" border="0" cellspacing="0" cellpadding="2" >
	  <tr> <? echo $space; ?> 
		<td width="17" valign="top">
		<? if($m=="folder") {?>
		<img src="../images/folder_plus.gif" width="16" height="16" border="0">
		<?php }?>
		<? if($m=="file") {?>
		<img src="../images/file_plus.gif" width="16" height="16" border="0">
		<?php }?>
		<? if($m=="url") {?>
		<img src="../images/www_plus.gif" width="16" height="16" border="0">
		<?php }?>
		<? if($m=="zip") {?>
		<img src="../images/zip_plus.gif" width="16" height="16" border="0">
		<?php }?>
		</td>
		
		  
      <td width="167" >&nbsp;<strong>Add new <?php echo $m?> to directory :</strong></td>                        							
		  <td width="304"  align="left">
		  <?php
		  if($id == 0){
		  	echo "/";
		  } else {
		   //echo $id;
		  	function rs($modules,$id,$str){
					$rs=mysql_query("SELECT r.name,r.folder,r.id, r.refid
														FROM resources r,users u 
														WHERE r.modules=$modules AND r.id=$id 
														AND r.users=u.id order by r.name;");
					while($row=mysql_fetch_array($rs)){						 
						 if($row["folder"]==1) {						  	
							 //echo "/".$row["name"];
							 //$str = $row["name"]."/".$str;
							 //$str = "/".$row["name"].rs($modules,$row["refid"],$str);														
							 //$str = $row["name"]."/".rs($modules,$row["refid"],$str);
							 $str = rs($modules,$row["refid"],$str)."/".$row["name"];														
						 }
					}
					return $str;								
			}
			$strDir = rs($modules,$id,"");
			echo $strDir;
			/*				
			$len = strlen($strDir); 
			$j==0;
			for($i==0;$i<$len;$i++){
				$rest = substr($strDir, $i, 1);
				//echo $rest;
				if($rest=="/") {
					$strNew = substr($strDir, $j,$i).$strNew;					
					$j=$i;
				}				
			}			
			echo $strNew;
			*/
		  }
		  ?>
		  </td>                        
	</tr>
  </table>
  <br>
  <table width="500" border="0" cellpadding="2" cellspacing="0">
  <?php 
  if($m=="folder") {?>
  <!-- Add Folder -->
    <tr bgcolor="#FFFFFF"> 
      <td colspan="4" align="center" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;"> 
        <table width="100%" align="left">
          <tr> 
            <td width="13%" valign="top"><img src="../images/folder3.gif"  border="0" align="top"></td>
            <td width="87%" valign="top"> <form action="folder.php" method="post" onSubmit="return checkEmptyAdd(this.name,'folder')" name="add_folder">
                <input type="hidden" name="modules" value="<? echo $modules?>">
                <input type="hidden" name="id" value="0">
                <input type="hidden" name="refid" value="<? echo $id?>">
                <input type="hidden" name="courses" value="<? echo $getc["courses"];?>">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="22%"><? echo $strResource_LabFolderName;?></td>
                    <td width="78%" class="res"><input type="text" name="name" size="40" class="text"> 
                    </td>
                  </tr>
                  <tr> 
                    <td colspan="2"><input name="submit" type="submit" value="<? echo $strResource_BtnAddFolder;?>" class="button"> 
                      <input name="Cancel" type="button"  value="<?php echo $strCancel;?>" onClick="history.back();" class="button"></td>
                  </tr>
                </table>
              </form></td>
          </tr>
        </table></td>
    </tr>	
    <tr  class="tdbackground1"> 
      <td colspan="2" align="center" style="border-bottom: solid #000000 1px;">&nbsp;</td>
    </tr>
	<?php 
	}
	if($m=="url") {
	?>
	<!-- Add Web Link -->
    <tr> 
      <td colspan="2" align="center" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;"> 
        <table width="100%" align="left">
          <tr> 
            <td width="13%" valign="top"><img src="../images/weblink.gif"  border="0" align="top"></td>
            <td width="87%"> <form action="url.php" method="post" onSubmit="return checkEmptyAdd(this.name,'url')" name="add_url">
                <input type="hidden" name="modules" value="<? echo $modules?>">
                <input type="hidden" name="id" value="0">
                <input type="hidden" name="refid" value="<? echo $id?>">
                <input type="hidden" name="courses" value="<? echo $getc["courses"];?>">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="22%"><? echo $strResource_LabUrlName;?></td>
                    <td width="78%"><input type="text" name="name" size="40" class="text"></td>
                  </tr>
                  <tr> 
                    <td><? echo $strResource_LabUrl;?></td>
                    <td><input type="text" name="url" value="http://" size="40" class="text"></td>
                  </tr>
                  <tr> 
                    <td valign="top"><? echo $strResource_LabShowType;?></td>
                    <td><input name="file_target" type="hidden" value="0">
                    <!--
                    <table width="200">
                        <tr> 
                          <td class="res"><label> 
                            <input name="file_target" type="radio" value="0" <? if($r["new_window"]==0) echo "Checked"; else echo "Unchecked";?> class="r-button">
                            Show URL in same window</label></td>
                        </tr>
                        <tr> 
                          <td class="res"><label> 
                            <input name="file_target" type="radio" value="1" <? if($r["new_window"]==1) echo "Checked"; else echo "Unchecked";?> class="r-button">
                            Show URL in new window</label></td>
                        </tr>
                        <tr> 
                          <td class="res"><label> 
                            <input name="file_target" type="radio" value="2" <? if($r["new_window"]==2) echo "Checked"; else echo "Unchecked";?> class="r-button">
                            Show URL in full screen window</label></td>
                        </tr>
                      </table>
                      -->
                      </td>
                  </tr>
                  <tr> 
                    <td colspan="2"><input name="submit" type="submit" value="<? echo $strResource_BtnAddUrl;?>" class="button">
                      <input name="Cancel2" type="button"  value="<?php echo $strCancel;?>" onClick="history.back();" class="button"></td>
                  </tr>
                </table>
              </form></td>
          </tr>
        </table></td>
    </tr>
    <tr  class="tdbackground1"> 
      <td colspan="2" align="center" style="border-bottom: solid #000000 1px;">&nbsp;</td>
    </tr>
	<?php
	}
	if($m=="file"){
	?>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="2" align="center" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;"> 
        <table width="100%" align="left">
          <tr> 
            <td width="13%" valign="top"><img src="../images/file2.gif"  border="0" align="top"></td>
            <td width="87%"> <form  name="form" action="file.php" method="post" enctype="multipart/form-data" onSubmit="return checkFields(this.file,'file');">
                <input type="hidden" name="modules" value="<? echo $modules?>">
                <input type="hidden" name="id" value="0">
                <input type="hidden" name="refid" value="<? echo $id?>">
                <input type="hidden" name="courses" value="<? echo $getc["courses"];?>">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="22%"><? echo $strResource_LabFileName;?></td>
                    <td width="78%"><input type="text" name="name" size="40" class="text"></td>
                  </tr>
                  <tr> 
                    <td><? echo $strResource_LabFileUpload;?></td>
                    <td><input type="file" name="file" size="40" class="text"></td>
                  </tr>
                  <tr> 
                    <td valign="top"><? echo $strResource_LabShowType;?></td>
                    <td><input name="file_target" type="hidden" value="0">
                    <!--
                    <table width="200">
                        <tr> 
                          <td class="res"><label> 
                            <input name="file_target" type="radio" value="0" <? if($r["new_window"]==0) echo "Checked"; else echo "Unchecked";?> class="r-button">
                            Show file in same window</label></td>
                        </tr>
                        <tr> 
                          <td class="res"><label> 
                            <input name="file_target" type="radio" value="1" <? if($r["new_window"]==1) echo "Checked"; else echo "Unchecked";?> class="r-button">
                            Show file in new window</label></td>
                        </tr>
                        <tr> 
                          <td class="res"><label> 
                            <input name="file_target" type="radio" value="2" <? if($r["new_window"]==2) echo "Checked"; else echo "Unchecked";?> class="r-button">
                            Show URL in full screen window</label></td>
                        </tr>
                      </table>
                      -->
                      </td>
                  </tr>
                  <tr> 
                    <td>&nbsp;</td>
                    <td><font color="red"><b> (English file name ONLY!!!) </b></font></td>
                  </tr>
                  <tr> 
                    <td colspan="2"><font color="red"><b> 
                      <input name="submit" type="submit" value="<? echo $strResource_BtnUploadFile;?>" class="button">
                      <input name="Cancel3" type="button"  value="<?php echo $strCancel;?>" onClick="history.back();" class="button">
                      </b></font></td>
                  </tr>
                  <tr> 
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr> 
                    <td valign="top"><? echo $strResource_LabDiskUsage;?></td>
                    <td>
                    <!--
                    <table width="99%">
                        <tr> 
                          <td width="24" align="center"><div align="center"><img src="../images/info_blue.gif" width=24 height=24 alt="" border="0" align="top"></div></td>
                          <td width="69"><font color="#0066FF" size="1">Used Space:</font></td>
                          <td width="92"><font color="#0066FF" size="1"><? echo $sum_filesize." ";?>bytes</font></td>
                          <td width="63"><font color="#0066FF" size="1"><? echo GetSize ($sum_filesize);?></font></td>
                        </tr>
                        <tr> 
                          <td align="center"><div align="center"><img src="../images/info_blue.gif" width=24 height=24 alt="" border="0" align="top"></div></td>
                          <td><font color="#0066FF" size="1">Free Space :</font></td>
                          <td><font color="#0066FF" size="1"><? echo $quota-$sum_filesize." ";?>bytes</font></td>
                          <td><font color="#0066FF" size="1"><? echo GetSize ($quota-$sum_filesize);?></font></td>
                        </tr>
                        <tr> 
                          <td align="center"><div align="center"><img src="../images/info_red.gif" width=24 height=24 alt="" border="0" align="top"></div></td>
                          <td><strong><font color="#FF0000" size="1">Your Quota:</font></strong></td>
                          <td><strong><font color="#FF0000" size="1"><? echo $quota." ";?>bytes</font></strong></td>
                          <td><strong><font color="#FF0000" size="1"><? echo GetSize ($quota);?></font></strong></td>
                        </tr>
                      </table>--></td>
                  </tr>
                </table>
              </form></td>
          </tr>
        </table></td>
    </tr>
    <tr  class="tdbackground1"> 
      <td colspan="2" align="center" style="border-bottom: solid #000000 1px;">&nbsp;</td>
    </tr>
	<?php
	}if($m=="zip"){
	?>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="2" align="center" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;"> 
        <table width="100%" align="left">
          <tr> 
            <td width="13%" valign="top"><img src="../images/zip1.gif"  border="0" align="top"></td>
            <td width="87%"> <form  name="form" action="unzip.php" method="post" enctype="multipart/form-data" onSubmit="return checkFields(this.file,'zip');">
                <input type="hidden" name="modules" value="<? echo $modules?>">
                <input type="hidden" name="id" value="0">
                <input type="hidden" name="refid" value="<? echo $id?>">
                <input type="hidden" name="courses" value="<? echo $getc["courses"];?>">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="22%"><? echo $strResource_LabFileName;?></td>
                    <td width="78%"><input type="text" name="name" size="40" class="text"></td>
                  </tr>
				  <tr> 
                    <td width="22%"><? echo "Indexname";?></td>
                    <td width="78%"><input type="text" name="index" size="40" class="text"></td>
                  </tr>
                  <tr> 
                    <td><? echo $strResource_LabFileUpload;?></td>
                    <td><input type="file" name="file" size="40" class="text"></td>
                  </tr>
                  <tr> 
                    <td valign="top"><? echo $strResource_LabShowType;?></td>
                    <td><input name="file_target" type="hidden" value="0">
                    <!--
                    <table width="200">
                        <tr> 
                          <td class="res"><label> 
                            <input name="file_target" type="radio" value="0" <? if($r["new_window"]==0) echo "Checked"; else echo "Unchecked";?> class="r-button">
                            Show file in same window</label></td>
                        </tr>
                        <tr> 
                          <td class="res"><label> 
                            <input name="file_target" type="radio" value="1" <? if($r["new_window"]==1) echo "Checked"; else echo "Unchecked";?> class="r-button">
                            Show file in new window</label></td>
                        </tr>
                        <tr> 
                          <td class="res"><label> 
                            <input name="file_target" type="radio" value="2" <? if($r["new_window"]==2) echo "Checked"; else echo "Unchecked";?> class="r-button">
                            Show URL in full screen window</label></td>
                        </tr>
                      </table>
                      -->
                      </td>
                  </tr>
                  <tr> 
                    <td>&nbsp;</td>
                    <td><font color="red"><b> (English file name ONLY!!!) </b></font></td>
                  </tr>
                  <tr> 
                    <td colspan="2"><font color="red"><b> 
                      <input name="submit" type="submit" value="<? echo $strResource_BtnUploadFile;?>" class="button">
                      <input name="Cancel3" type="button"  value="<?php echo $strCancel;?>" onClick="history.back();" class="button">
                      </b></font></td>
                  </tr>
                  <tr> 
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr> 
                    <td valign="top"><? echo $strResource_LabDiskUsage;?></td>
                    <td>
                    <!--
                    <table width="99%">
                        <tr> 
                          <td width="24" align="center"><div align="center"><img src="../images/info_blue.gif" width=24 height=24 alt="" border="0" align="top"></div></td>
                          <td width="69"><font color="#0066FF" size="1">Used Space:</font></td>
                          <td width="92"><font color="#0066FF" size="1"><? echo $sum_filesize." ";?>bytes</font></td>
                          <td width="63"><font color="#0066FF" size="1"><? echo GetSize ($sum_filesize);?></font></td>
                        </tr>
                        <tr> 
                          <td align="center"><div align="center"><img src="../images/info_blue.gif" width=24 height=24 alt="" border="0" align="top"></div></td>
                          <td><font color="#0066FF" size="1">Free Space :</font></td>
                          <td><font color="#0066FF" size="1"><? echo $quota-$sum_filesize." ";?>bytes</font></td>
                          <td><font color="#0066FF" size="1"><? echo GetSize ($quota-$sum_filesize);?></font></td>
                        </tr>
                        <tr> 
                          <td align="center"><div align="center"><img src="../images/info_red.gif" width=24 height=24 alt="" border="0" align="top"></div></td>
                          <td><strong><font color="#FF0000" size="1">Your Quota:</font></strong></td>
                          <td><strong><font color="#FF0000" size="1"><? echo $quota." ";?>bytes</font></strong></td>
                          <td><strong><font color="#FF0000" size="1"><? echo GetSize ($quota);?></font></strong></td>
                        </tr>
                      </table>
                      -->
                      </td>
                  </tr>
                </table>
              </form></td>
          </tr>
        </table></td>
    </tr>
    <tr  class="tdbackground1"> 
      <td colspan="2" align="center" style="border-bottom: solid #000000 1px;">&nbsp;</td>
    </tr>
	<?php
	}
	?>
    <? if ($folders!="yes") { ?>
	<!--
    <form name="form1" method="post" action="">
      <tr > 
        <td width="35%" style="border-left: solid #000000 1px;"><? echo $strResource_LabGetFilePer;?></td>
        <td width="65%" style="border-right: solid #000000 1px;"><font size="2">           
          <input name="getFile2" type="submit" id="getFile2" onClick="MM_openBrWindow('get_resource.php?user=<? echo $person["id"];?>&modules=<? echo $modules?>','getResource','status=yes,scrollbars=yes,width=390,height=400')" value="Get Files">
          </font></td>
      </tr>
    </form>
	-->
    <form name="form2" method="post" action="">
      <tr> 
        <td width="46%" style="border-left: solid #000000 1px; border-bottom: solid #000000 1px;"><font size="2"><? echo $strResource_LabGetFileCenter;?></font></td>
        <td width="54%" style="border-right: solid #000000 1px; border-bottom: solid #000000 1px;"><font size="2"> 
          <input name="getFile3" type="submit" id="getFile3" onClick="MM_openBrWindow('index_rc.php?user=<? echo $person["id"];?>&modules=<? echo $modules;?>&res_id=<? echo $id;?>&isedit=1&courses=<? echo $getc["courses"];?>','getResCenter','status=yes,scrollbars=yes,width=620,height=600')" value="Get Files" class="button">
          </font></td>
      </tr>
    </form>
    <? } ?>
  </table>
<?
	}
}
?>
</div>
</body>
</html>