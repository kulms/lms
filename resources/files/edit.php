<? //get Modules id & Resources id
require("../include/global_login.php");
require("../include/getsize.php");

$check=mysql_query("SELECT name FROM modules WHERE id=$modules;");

$get_course=mysql_query("SELECT courses FROM wp WHERE modules=$modules;");
$getc=mysql_fetch_array($get_course);

//$check_cadmin=mysql_query("SELECT id FROM wp WHERE courses=".mysql_result($get_course,0,"courses")." AND admin=1 AND users=".$person["id"].";");

$check_cadmin=mysql_query("SELECT m.id, m.users FROM modules m, wp WHERE m.id=$id and m.id=wp.modules AND wp.users=".$person["id"].";");

if(mysql_num_rows($check_cadmin)!=0){
        $cadmin=1;
}else{
        $cadmin=0;
}
$folder=mysql_query("SELECT r.* FROM resources r WHERE modules=$modules AND r.folder=1 AND r.id<>$id order by r.name;");
//**************************** GET QUOTA  **************************** 
if ($getc["courses"] != 0) {
	$get_filesize = mysql_query("SELECT id, file from resources WHERE courses=".$getc["courses"]." AND LENGTH(file) != 0 AND users=".$person["id"].";");	
} else {
	$get_filesize = mysql_query("SELECT id, file from resources WHERE courses=0 AND LENGTH(file) != 0 AND users=".$person["id"].";");
}
$sum_filesize = 0;
while ($row_filesize=mysql_fetch_array($get_filesize)){
	$sum_filesize = (filesize("../files/resources_files/".$row_filesize["id"]."/".$row_filesize["file"])) + $sum_filesize;	
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
<title>Edit resources</title>
<script language="javascript">
<!--

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<SCRIPT LANGUAGE="JavaScript">

<!-- Begin

var mikExp = /[$\@#%\^\&\*\(\)\[\]\+\{\}\'\~\=¡¢¤¦§¨©ª«¬­®¯°³±²´µ¶·¸º¼»¾¿ËÃ¹ÂÅÊÈÇÉÌÍÎÄÆ]/;

function checkFields(val) {

	missinginfo = "";
	if (form.file.value == "") {
		missinginfo += "\n     -  File Upload";
	}
	
	if (missinginfo != "") {
		missinginfo ="_____________________________\n" +
		"You failed to correctly fill in your:\n" +
		missinginfo + "\n_____________________________" +
		"\nPlease re-enter and submit again!";
		alert(missinginfo);
		return false;
	}
	else {
		//return true;
		if(form.file.value.search(mikExp) == -1) {
			//alert("Correct Input");
			return true;
		}
		else {
			alert("Sorry, but the following characters\n\r\n\r@ $ % ^ & * # ( ) [ ]  { + } ` ~ =  | \n\r\n\rFilename ·ÕèÁÕÍÑ¡ÉÃÀÒÉÒä·Â\n\r\n\rare not allowed!\n");
			return false;
		}
	}
}

//  End -->
</script>
<script language="javascript">
<!--

function chk_lstFolder(val) { 
	msg = "";
	if (val.value == -1) {
		msg ="_____________________________\n\n" +
		"Please Select Folder from List ...\n" +
		"_____________________________" ;		
		alert(msg);
		return false;
	}
	else {
		return true;
	}
}
//-->
</script>

<link rel="STYLESHEET" type="text/css" href="../main.css">
<link rel="STYLESHEET" type="text/css" href="../themes/blue/style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=tis-620"></head>
<body>
<div align="center"><br>
  <table width="500" align="center" bgcolor="#739FC4"  style="border-bottom: dotted #000000 1px; border-top: dotted #000000 1px; border-left: dotted #000000 1px; border-right: dotted #000000 1px;">
    <tr> 
      <td class="h3White" align="center"> Resource 
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
  <table width="500" align="center" bgcolor="#739FC4" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
    <tr> 
      <td> <div align="center"><font color="#333399" size="5"><strong>..:: EDIT 
          ::..</strong></font></div></td>
    </tr>
  </table>
  <table width="500" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td  colspan="4" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;"> 
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr> 
            <td width="13%">
			<?
                 if($r["folder"]==0 && strlen($r["url"])>0){
    		?>
				<img src="../images/weblink.gif"  border="0" align="top">
			<? } else { 
					 if($r["folder"]==0 && strlen($r["url"])==0){
			?>
				<img src="../images/file2.gif"  border="0" align="top">
			<? 		} else {  ?>
			<img src="../images/folder3.gif"  border="0" align="top">
			<?
						}
					}
			?>				
			</td>
            <td width="87%" valign="top"> 
			<form action="rename.php" method="post">
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
                    <td width="78%"><input type="text" name="name" size="40" value="<? echo $r[name];?>"></td>
                    <input type="hidden" name="modules" value="<? echo $modules?>">
                    <input type="hidden" name="id" value="<? echo $id?>">
                  </tr>
                  <tr> 
                    <td>
					<?
                	 if($r["folder"]==0 && strlen($r["url"])>0){ ?>
						<input type="submit" name="Rename" value="<? echo $strResource_BtnEditUrl;?>">
					 <? } else { 
							 if($r["folder"]==0 && strlen($r["url"])==0){	?>
								<input type="submit" name="Rename" value="<? echo $strResource_BtnEditFile;?>">
							<? } else {  ?>
									<input type="submit" name="Rename" value="<? echo $strResource_BtnEditFolder;?>">
								<? }
							}
					?>						
					</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
              </form></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td bgcolor="#d4e2ed">&nbsp;</td>
    </tr>
    <?
                 if($r["folder"]==0 && strlen($r["url"])>0){
    ?>
    <tr> 
      <td colspan="4" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
	  <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr> 
            <td width="13%" valign="top"><img src="../images/weblink.gif"  border="0" align="top"></td>
            <td width="87%"> <form action="url.php" method="post">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="22%" ><? echo $strResource_LabUrl;?></td>
                    <td width="78%"><input type="text" name="url" size="40" value="<? echo $r["url"]?>"></td>
                  </tr>
                  <tr> 
                    <td valign="top"><? echo $strResource_LabShowType;?></td>
                    <td><table width="200">
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
                      </table></td>
                  </tr>
                  <tr> 
                    <input type="hidden" name="modules" value="<? echo $modules?>">
                    <input type="hidden" name="id" value="<? echo $id?>">
                    <td><input name="submit" type="submit" value="Update URL">
                    </td>
                    <td ><input type="button" name="Submit2" value="Cancel" onClick="{location='index.php?id=<?echo $modules?>';}"> 
                    </td>
                  </tr>
                </table>
              </form></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td bgcolor="#d4e2ed">&nbsp;</td>
    </tr>
    <?
                 }
                if($r["folder"]==0 && strlen($r["url"])==0){
     ?>
    <tr> 
      <td  colspan="4" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
	  <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr> 
            <td width="13%" valign="top"><img src="../images/file2.gif"  border="0" align="top"></td>
            <td width="87%"> <form  name="form" action="file.php" method="post" enctype="multipart/form-data" onSubmit="return checkFields(this.file);">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="22%"><? echo $strResource_LabFileUpload;?></td>
                    <td width="78%"><input type="file" name="file" size="40"></td>
                  </tr>
                  <tr> 
                    <td valign="top"><? echo $strResource_LabShowType;?></td>
                    <td> <table width="200">
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
                      </table></td>
                  </tr>
                  <tr>
                    <td valign="bottom">&nbsp;</td>
                    <td valign="bottom"><b>Old file: <? echo $r["file"]?></b> 
                      <br> <br> <strong><font color="#FF0000">English file name 
                      ONLY!!! </font></strong></td>
                  </tr>
                  <tr> 
                    <input type="hidden" name="modules" value="<? echo $modules?>">
                    <input type="hidden" name="id" value="<? echo $id?>">
                    <input type="hidden" name="courses" value="<? echo $getc["courses"];?>">
                    <td valign="bottom"><input name="submit3" type="submit" value="Upload new file">
                    </td>
                    <td valign="bottom"><input type="button" name="Submit22" value="Cancel" onClick="{location='index.php?id=<?echo $modules?>';}"> 
                    </td>
                  </tr>
                </table>
              </form></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td bgcolor="#d4e2ed">&nbsp;</td>
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
                <br>
                <input type="submit" name="Submit" value="<? echo $strResource_BtnMove;?>">
              </form></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td bgcolor="#d4e2ed">&nbsp;</td>
    </tr>
    <tr> 
      <td  colspan="4"  style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
	  <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td width="17%" valign="top"><? echo $strResource_LabDelete;?></td>
            <td width="83%"><form>
          <input name="button" type="button" onClick="if(confirm('Realy delete?')){location='delete.php?modules=<? echo $modules?>&id=<? echo $r["id"]?>';}" value="<? echo $strResource_BtnDelete;?>">
        </form></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td bgcolor="#d4e2ed">&nbsp;</td>
    </tr>
    <tr>
      <td  colspan="4"  style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
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
        </table></td>
    </tr>
    <tr> 
      <td bgcolor="#d4e2ed">&nbsp;</td>
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
                <input name="getFile4" type="submit" id="getFile42" onClick="MM_openBrWindow('index_rc.php?user=<? echo $person["id"];?>&modules=<? echo $modules;?>&res_id=<? echo $id;?>&isedit=1&folders=yes&courses=<? echo $getc["courses"];?>','getResCenter','status=yes,scrollbars=yes,width=620,height=600')" value="Get Files"> 
                <? } else { ?>
                <input name="getFile4" type="submit" id="getFile42" onClick="MM_openBrWindow('index_rc.php?user=<? echo $person["id"];?>&modules=<? echo $modules;?>&res_id=<? echo $id;?>&isedit=1&courses=<? echo $getc["courses"];?>','getResCenter','status=yes,scrollbars=yes,width=620,height=600')" value="Get Files"> 
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
		
        ?>
        <hr noshade size="4" width="400">
  <table width="500" align="center" bgcolor="#739FC4" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;">
    <tr> 
      <td> <div align="center"><font color="#333399" size="5"><strong>..:: 
          ADD ::..</strong></font></div></td>
    </tr>
  </table>  
  <table width="500" border="0" cellpadding="2" cellspacing="0">
    <tr bgcolor="#FFFFFF"> 
      <td colspan="4" align="center" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;"> 
        <table width="100%" align="left">
          <tr> 
            <td width="13%" valign="top"><img src="../images/folder3.gif"  border="0" align="top"></td>
            <td width="87%" valign="top"> <form action="folder.php" method="post">
                <input type="hidden" name="modules" value="<? echo $modules?>">
                <input type="hidden" name="id" value="0">
                <input type="hidden" name="refid" value="<? echo $id?>">
                <input type="hidden" name="courses" value="<? echo $getc["courses"];?>">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="22%"><? echo $strResource_LabFolderName;?></td>
                    <td width="78%" class="res"><input type="text" name="name" size="40"> 
                    </td>
                  </tr>
                  <tr> 
                    <td><input name="submit" type="submit" value="<? echo $strResource_BtnAddFolder;?>"></td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
              </form></td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#d4e2ed"> 
      <td colspan="2" align="center">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="2" align="center" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;"> 
        <table width="100%" align="left">
          <tr> 
            <td width="13%" valign="top"><img src="../images/weblink.gif"  border="0" align="top"></td>
            <td width="87%"> <form action="url.php" method="post">
                <input type="hidden" name="modules" value="<? echo $modules?>">
                <input type="hidden" name="id" value="0">
                <input type="hidden" name="refid" value="<? echo $id?>">
                <input type="hidden" name="courses" value="<? echo $getc["courses"];?>">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="22%"><? echo $strResource_LabUrlName;?></td>
                    <td width="78%"><input type="text" name="name" size="40"></td>
                  </tr>
                  <tr> 
                    <td><? echo $strResource_LabUrl;?></td>
                    <td><input type="text" name="url" value="http://" size="40"></td>
                  </tr>
                  <tr> 
                    <td valign="top"><? echo $strResource_LabShowType;?></td>
                    <td><table width="200">
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
                      </table></td>
                  </tr>
                  <tr> 
                    <td><input name="submit" type="submit" value="New URL"></td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
              </form></td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#d4e2ed"> 
      <td colspan="2" align="center">&nbsp;</td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="2" align="center" style="border-bottom: solid #000000 1px; border-top: solid #000000 1px; border-left: solid #000000 1px; border-right: solid #000000 1px;"> 
        <table width="100%" align="left">
          <tr> 
            <td width="13%" valign="top"><img src="../images/file2.gif"  border="0" align="top"></td>
            <td width="87%"> <form  name="form" action="file.php" method="post" enctype="multipart/form-data" onSubmit="return checkFields(this.file);">
                <input type="hidden" name="modules" value="<? echo $modules?>">
                <input type="hidden" name="id" value="0">
                <input type="hidden" name="refid" value="<? echo $id?>">
                <input type="hidden" name="courses" value="<? echo $getc["courses"];?>">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="22%"><? echo $strResource_LabFileName;?></td>
                    <td width="78%"><input type="text" name="name" size="40"></td>
                  </tr>
                  <tr> 
                    <td><? echo $strResource_LabFileUpload;?></td>
                    <td><input type="file" name="file" size="40"></td>
                  </tr>
                  <tr> 
                    <td valign="top"><? echo $strResource_LabShowType;?></td>
                    <td><table width="200">
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
                      </table></td>
                  </tr>
                  <tr> 
                    <td>&nbsp;</td>
                    <td><font color="red"><b> (English file name ONLY!!!) </b></font></td>
                  </tr>
                  <tr> 
                    <td><font color="red"><b> 
                      <input name="submit" type="submit" value="<? echo $strResource_BtnUploadFile;?>">
                      </b></font></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr> 
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr> 
                    <td valign="top"><? echo $strResource_LabDiskUsage;?></td>
                    <td><table width="99%">
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
                </table>
              </form></td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#d4e2ed"> 
      <td colspan="2" align="center" style="border-bottom: solid #000000 1px;">&nbsp;</td>
    </tr>
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
        <td width="35%" style="border-left: solid #000000 1px; border-bottom: solid #000000 1px;"><font size="2"><? echo $strResource_LabGetFileCenter;?></font></td>
        <td width="65%" style="border-right: solid #000000 1px; border-bottom: solid #000000 1px;"><font size="2"> 
          <input name="getFile3" type="submit" id="getFile3" onClick="MM_openBrWindow('index_rc.php?user=<? echo $person["id"];?>&modules=<? echo $modules;?>&res_id=<? echo $id;?>&isedit=1&courses=<? echo $getc["courses"];?>','getResCenter','status=yes,scrollbars=yes,width=620,height=600')" value="Get Files">
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