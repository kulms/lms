<? //get Modules id & Resources id
require("../include/global_login.php");
$check=mysql_query("SELECT name FROM modules WHERE id=$modules;");

$get_course=mysql_query("SELECT courses FROM wp WHERE modules=$modules;");
while ($getc=mysql_fetch_array($get_course)){
	echo $getc["course"];
}

$check_cadmin=mysql_query("SELECT id FROM wp WHERE courses=".mysql_result($get_course,0,"courses")." AND admin=1 AND users=".$person["id"].";");
if(mysql_num_rows($check_cadmin)!=0){
        $cadmin=1;
}else{
        $cadmin=0;
}
//echo "folders : ".$folders."<br>";
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

var mikExp = /[$\@#%\^\&\*\(\)\[\]\+\{\}\'\~\=\ก\ข\ค\ฆ\ง\จ\ฉ\ช\ซ\ฌ\ญ\ฎ\ฏ\ฐ\ณ\ฑ\ฒ\ด\ต\ถ\ท\ธ\บ\ป\พ\ฟ\ห\ร\น\ย\ล\ส\ศ\ว\ฬ\อ\ฮ\ฤ\ฦ|]/;

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
			alert("Sorry, but the following characters\n\r\n\r@ $ % ^ & * # ( ) [ ]  { + } ` ~ =  | \n\r\n\rFilename ที่มีอักษรภาษาไทย\n\r\n\rare not allowed!\n");
			return false;
		}
	}
}

//  End -->
</script>


<link rel="STYLESHEET" type="text/css" href="../main.css">
<meta http-equiv="Content-Type" content="text/html; charset=tis-620"></head>
<body bgcolor="#ffffff">
<div align="center"> 
  <table width="500" align="center" bgcolor="#0066FF">
    <tr> 
      <td bgcolor="#0000CC"> <div align="center"><font color="#FFFFFF" size="5"><strong>Resource 
          : <? echo mysql_result($check,0,"name");?></strong></font></div></td>
    </tr>
  </table>
  <?
if($id!="0"){
        $rs=mysql_query("SELECT * from resources WHERE id=$id;");
        $r=mysql_fetch_array($rs);
        if($r["users"]==$person["id"] || $person["admin"]==1 || $cadmin==1){
        ?>
  <br>
  <table width="500" align="center" bgcolor="#FFFFCC">
    <tr> 
      <td bgcolor="#FFCC66"> <div align="center"><font color="#333399" size="5"><strong>..:: 
          EDIT ::.. </strong></font></div></td>
    </tr>
  </table>
        
  <table width="500" border="0" cellpadding="2" cellspacing="0" bgcolor="#FFFFCC">
    <form action="rename.php" method="post">
      <tr> 
        <td bgcolor="#FFFFCC" class="res">Name:</td>
        <td bgcolor="#FFFFCC" class="res"><input type="text" name="name" size="40" value="<? echo $r[name];?>"></td>
        <input type="hidden" name="modules" value="<? echo $modules?>">
        <input type="hidden" name="id" value="<? echo $id?>">
      </tr>
      <tr> 
        <td bgcolor="#FFFFCC" class="res">&nbsp;</td>
        <td bgcolor="#FFFFCC" class="res"> <input type="submit" name="Rename" value="Rename"> </td>
    </form><tr bgcolor="#66FF66"></tr>
    <?
                 if($r["folder"]==0 && strlen($r["url"])>0){
                         ?>
		<form action="url.php" method="post">
    <tr> 
      <td bgcolor="#FFFFCC" class="res">URL:</td>
      <td bgcolor="#FFFFCC" class="res"><input type="text" name="url" size="40" value="<? echo $r["url"]?>"></td>
    </tr>
    <tr> 
      
        <input type="hidden" name="modules" value="<? echo $modules?>">
        <input type="hidden" name="id" value="<? echo $id?>">
        <td bgcolor="#FFFFCC" class="res">&nbsp;</td>
        <td bgcolor="#FFFFCC" class="res"> <input type="submit" value="Update URL"> </td>
      </form>
    <tr bgcolor="#66FF66"></tr>
    <?
                 }
                if($r["folder"]==0 && strlen($r["url"])==0){
                        ?>
	<form  name="form" action="file.php" method="post" enctype="multipart/form-data" onSubmit="return checkFields(this.file);">
    <tr> 
      <td bgcolor="#FFFFCC" class="res">File:</td>
      <td bgcolor="#FFFFCC" class="info"><input type="file" name="file" size="40"></td>
    </tr>
    <tr> 
      
        <input type="hidden" name="modules" value="<? echo $modules?>">
        <input type="hidden" name="id" value="<? echo $id?>">
        <td bgcolor="#FFFFCC" class="res">&nbsp;</td>
        <td bgcolor="#FFFFCC" class="info">
          English file name ONLY!!! <br> <input name="submit3" type="submit" value="Upload new document"> 
          <br>
          Old file: <? echo $r["file"]?> </td>
      </form>
    <tr bgcolor="#66FF66"></tr>
	
    
    <?
                } 
	?>
	<tr>
		<td bgcolor="#FFFFCC" class="res">&nbsp;</td>
		<td bgcolor="#FFFFCC" class="res">
       <form>
		<input type="button" value="Delete!" onClick="if(confirm('Realy delete?')){location='delete.php?modules=<? echo $modules?>&id=<? echo $r["id"]?>';}">
	   </form>
    	</td>
    </tr>
    <?                  if($r["users"]==$person["id"] || $person["admin"]==1 || $cadmin==1){
                        ?>
    <tr> 
      <td colspan="2" align="center"> 
        <? if($r["folder"]==1) { ?>
        <form name="form1" method="post" action="">
          <!--<table width="100%">-->
            <tr bgcolor="#66FF66"> 
              <td width="40%" bgcolor="#00CCFF"><font color="#0000FF" size="2">Get File From Personal : </font></td>
              <td width="60%" bgcolor="#00CCFF">
			  <? if ($folders=="yes") { ?>
			  <input name="getFile" type="submit" id="getFile" onClick="MM_openBrWindow('get_resource.php?user=<? echo $person["id"];?>&modules=<? echo $modules;?>&res_id=<? echo $id;?>&isedit=1&folders=yes','getResource','status=yes,scrollbars=yes,width=350,height=400')" value="Get Files"></td>
			  <? } else { ?>
			  		<input name="getFile" type="submit" id="getFile" onClick="MM_openBrWindow('get_resource.php?user=<? echo $person["id"];?>&modules=<? echo $modules;?>&res_id=<? echo $id;?>&isedit=1','getResource','status=yes,scrollbars=yes,width=350,height=400')" value="Get Files"></td>		
			  		 <? } ?>
            </tr>
          <!--</table>-->
        </form>
		
		<form name="form1" method="post" action="">
          <!--<table width="100%">-->
            <tr bgcolor="#66FF66"> 
              <td width="40%" bgcolor="#00CCFF"><font color="#0000FF" size="2">Get File From Resource Center : </font></td>
              <td width="60%" bgcolor="#00CCFF">
			  <? if ($folders=="yes") { ?>
			  <input name="getFile" type="submit" id="getFile" onClick="MM_openBrWindow('index_rc.php?user=<? echo $person["id"];?>&modules=<? echo $modules;?>&res_id=<? echo $id;?>&isedit=1&folders=yes','getResCenter','status=yes,scrollbars=yes,width=600,height=600')" value="Get Files"></td>
			  <? } else { ?>
			  <input name="getFile" type="submit" id="getFile" onClick="MM_openBrWindow('index_rc.php?user=<? echo $person["id"];?>&modules=<? echo $modules;?>&res_id=<? echo $id;?>&isedit=1','getResCenter','status=yes,scrollbars=yes,width=600,height=600')" value="Get Files"></td>		
			  		 <? } ?>
            </tr>
          <!--</table>-->
        </form>
        <? } ?>
      </td>
    </tr>
    <!--<tr> 
      <td colspan="2" align="center"> 
        <!--<form action="pub_course.php" method="post">
          <table width="100%">
            <tr> 
              <td width="10%" height="27">&nbsp;</td>
              <td width="90%"><input name="public" type="submit" id="public" value="Public Course">
              </td>
            </tr>
          </table>
          <input type="hidden" name="modules" value="<? echo $modules?>">
          <input type="hidden" name="id" value="<? echo $id?>">
        </form>
      </td>
    </tr>-->
    <? }?>
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
if(($folder=="true") or ($r["folder"]==1)){
        ?>
        <hr noshade size="4" width="400">
  <table width="500" align="center" bgcolor="#FFFFCC">
    <tr> 
      <td bgcolor="#FFCC66"> <div align="center"><font color="#333399" size="5"><strong>..:: 
          ADD ::..</strong></font></div></td>
    </tr>
  </table>  
  <table width="500" border="0" cellpadding="2" cellspacing="0" bgcolor="#99FF99">
    <tr bgcolor="#FFFFFF"> 
      <td colspan="4" align="center"> <table width="300" align="left" bgcolor="#006633">
          <tr> 
            <td bgcolor="#339999"> <div align="center"><font color="#333399" size="3"><strong>:: 
                FOLDER ::</strong></font></div></td>
          </tr>
        </table></td>
    </tr>
    <tr bgcolor="#99FF99"> 
    <tr> 
      <form action="folder.php" method="post">
        <input type="hidden" name="modules" value="<?echo $modules?>">
        <input type="hidden" name="id" value="0">
        <input type="hidden" name="refid" value="<?echo $id?>">
        <td class="res">Name:</td>
        <td class="res"><input type="text" name="name"> </td>
        <tr bgcolor="#99FF99"></tr>
        <tr bgcolor="#99FF99"> 
          <td colspan="2" align="center" class="res"><input name="submit" type="submit" value="New folder"></td>
        </tr>
      </form>
    <tr> 
      <td align="center" colspan="2"><hr noshade size="1" width="200"></td>
    </tr>
    <tr> 
      <td colspan="2" align="center" bgcolor="#FFFFFF"> <table width="300" align="left" bgcolor="#006633">
          <tr> 
            <td bgcolor="#339999"> <div align="center"><font color="#333399" size="3"><strong>:: 
                URL ::</strong></font></div></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <form action="url.php" method="post">
        <input type="hidden" name="modules" value="<? echo $modules?>">
        <input type="hidden" name="id" value="0">
        <input type="hidden" name="refid" value="<? echo $id?>">
        <td class="res">Name:</td>
        <td class="res"><input type="text" name="name" size="40"> </td>
        <tr bgcolor="#99FF99"></tr>
        <tr bgcolor="#99FF99"> 
          <td class="res">URL:</td>
          <td class="res"><input type="text" name="url" value="http://" size="40"> 
          </td>
        </tr>
        <tr bgcolor="#99FF99"> 
          <td colspan="2" align="center" class="res"><input name="submit" type="submit" value="New URL"></td>
        </tr>
      </form>
    <tr> 
      <td align="center" colspan="2"><hr noshade size="1" width="200"></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td colspan="2" align="center"> <table width="300" align="left" bgcolor="#006633">
          <tr> 
            <td bgcolor="#339999"> <div align="center"><font color="#333399" size="3"><strong>:: 
                FILE ::</strong></font></div></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <form  name="form" action="file.php" method="post" enctype="multipart/form-data" onSubmit="return checkFields(this.file);">
        <input type="hidden" name="modules" value="<? echo $modules?>">
        <input type="hidden" name="id" value="0">
        <input type="hidden" name="refid" value="<? echo $id?>">
        <td class="res">Name:</td>
        <td class="res"><input type="text" name="name" size="40"> </td>
        <tr bgcolor="#99FF99"></tr>
        <tr bgcolor="#99FF99"> 
            <td class="res">File:</td>
          <td class="info"><input type="file" name="file" size="50"></td>
        </tr>
        <tr bgcolor="#99FF99"> 
            <td class="res">&nbsp;</td>
            <td class="info"> <font color="red"><b> 
            (English file name ONLY!!!)<br>
            <input name="submit2" type="submit" value="Upload file">
            </b></font></td>
        </tr>
        <tr> 
          <td align="center" class="res" colspan="2"><hr noshade size="1" width="200"></td>
        </tr>
        
      </form>
      <? if ($folders!="yes") { ?>
      <form name="form1" method="post" action="">
        <tr> 
          <td width="40%" bgcolor="#00CCFF"></td>
          <td width="60%" bgcolor="#00CCFF"><font size="2"> <font color="#0000FF" size="2">Get 
            File From Personal : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font> 
            <input name="getFile2" type="submit" id="getFile2" onClick="MM_openBrWindow('get_resource.php?user=<? echo $person["id"];?>&modules=<? echo $modules?>','getResource','status=yes,scrollbars=yes,width=350,height=400')" value="Get Files">
            </font></td>
        </tr>
      </form>
      <form name="form2" method="post" action="">
        <tr> 
          <td width="40%" bgcolor="#00CCFF"><font size="2">&nbsp; </font></td>
          <td width="60%" bgcolor="#00CCFF"><font size="2"> <font color="#0000FF" size="2">Get 
            File From Resource Center :</font> 
            <input name="getFile3" type="submit" id="getFile3" onClick="MM_openBrWindow('index_rc.php?user=<? echo $person["id"];?>&modules=<? echo $modules?>','getResCenter','status=yes,scrollbars=yes,width=600,height=600')" value="Get Files">
            </font></td>
        </tr>
      </form>
      <? } ?>
  </table>
  <?
}
?>
</div>
</body>
</html>