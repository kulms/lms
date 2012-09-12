<? require("../include/global_login.php");
//echo $person["firstname"];
//echo "(";
//echo $person["login"];
//echo ")";
//echo "( Category : ";
//echo $person["category"];
//echo ")";

$check=mysql_query("SELECT name from modules WHERE id=$modules;");
//$checkrs = mysql_fetch_array($check);
//echo $checkrs["name"]."<br>";
//echo $modules."<br>";

$get_course=mysql_query("SELECT courses FROM wp WHERE modules=$modules;");
//$getrs = mysql_fetch_array($get_course);
//echo $getrs["courses"]."<br>";

$check_cadmin=mysql_query("SELECT id FROM wp WHERE courses=".mysql_result($get_course,0,"courses")." AND admin=1 AND users=".$person["id"].";");

if(mysql_num_rows($check_cadmin)!=0){
        $cadmin=1;
}else{
        $cadmin=0;
}
?>
<html>
<head>
        <title>Edit resources</title>
<script language="javascript">
</script>
<link rel="STYLESHEET" type="text/css" href="../main.css">
</head>
<body bgcolor="#ffffff">
<div align="center">
<h1 class="h1"><? echo mysql_result($check,0,"name");?></h1>
<?
if($id!="0"){
        $rs=mysql_query("SELECT * from resources WHERE id=$id;");
        $r=mysql_fetch_array($rs);
		//echo $r["users"];
		//echo $r["name"];
        if($r["users"]==$person["id"] || $person["admin"]==1 || $cadmin==1){
        ?>
        
  <h3 class="h3">Edit Student</h3>
        <table border="0" cellpadding="2" cellspacing="0">
                 <tr>
                         <form action="rename.php" method="post">
                         <input type="hidden" name="modules" value="<? echo $modules?>">
                         <input type="hidden" name="id" value="<? echo $id?>">
                         <td class="res">Name:</td>
                         <td class="res"><input type="text" name="name" size="40" value="<? echo $r[name];?>"><input type="submit" value="Rename">
        </td>
                         </form>
                 </tr>
                 <?
				 //folder == 1 It is folder .Can,t Click into. 
				 // if condition there.Edit url .
                 if($r["folder"]==0 && strlen($r["url"])>0){
                         ?>
                         <tr>
                                 <form action="url.php" method="post">
                                 <input type="hidden" name="modules" value="<?echo $modules?>">
                                 <input type="hidden" name="id" value="<?echo $id?>">
                                 <td class="res">URL:</td>
                                 <td class="res"><input type="text" name="url" size="40" value="<? echo $r["url"]?>"><input type="submit" value="Update URL">
        </td>
                                 </form>
                                </tr>
                         <?
                 }
				 //if ondition there .Edit File
                if($r["folder"]==0 && strlen($r["url"])==0){
                        ?>
                        <tr>
                                <form action="file.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="modules" value="<? echo $modules?>">
                                <input type="hidden" name="id" value="<? echo $id?>">
                                <td class="res">File:</td>
                                <td class="info">
                                        <input type="file" name="file" size="40"><br>
								          English file name ONLY!!! <br>
                                        <input type="submit" value="Upload new document">
                                        <br>Old file: <? echo $r["file"]?>
                                </td>
                                </form>
                        </tr>
                        <?
                }
                        if($r["users"]==$person["id"] || $person["admin"]==1 || $cadmin==1){
                        ?>
                        <tr>
                                <td colspan="2" align="center">
                                        <form><input type="button" value="Delete!" onClick="if(confirm('Realy delete?')){location='delete.php?modules=<? echo $modules?>&id=<? echo $r["id"]?>';}"></form>
                                </td>
                        </tr>
                        <?}?>
        </table>
<? //  user use these resource are not creator ?
        }else{
        $getuser=mysql_query("SELECT u.firstname, u.surname FROM users u, resources r WHERE r.id=$id AND u.id=r.users");
        $creator=mysql_result($getuser,0,"firstname")."&nbsp;".mysql_result($getuser,0,"surname");
        ?>
        <p>
        <div class="h5" align="center">Sorry, you can't edit this item. It can only be edited by it's creator (<i><? echo $creator ?></i>)</div>
        </p>
        <? }
}
//When no object in these resource or you click on head of resource $folder will equal true.
if (($folder=="true") or ($r["folder"]==1)) {
        ?>
        <hr noshade size="4" width="400">
    
  <h1 class="h1">Add Student</h1>
  <table border="0" cellpadding="2" cellspacing="0">
    <tr> 
      <td align="center" colspan="2"><h4 class="h4">Folder</h4></td>
    </tr>
    <tr> 
      <form action="folder.php" method="post">
        <input type="hidden" name="modules" value="<?echo $modules?>">
        <input type="hidden" name="id" value="0">
        <input type="hidden" name="refid" value="<?echo $id?>">
        <td class="res">Name:</td>
        <td class="res"><input type="text" name="name">
        </td>
    </tr>
    <tr> 
      <td align="center" class="res" colspan="2"><input name="submit" type="submit" value="New folder"></td>
    </tr>
	</form>
    <tr> 
      <td align="center" colspan="2"><hr noshade size="1" width="200">
        <h4 class="h4">URL</h4></td>
    </tr>
    <tr> 
      <form action="url.php" method="post">
        <input type="hidden" name="modules" value="<? echo $modules?>">
        <input type="hidden" name="id" value="0">
        <input type="hidden" name="refid" value="<? echo $id?>">
        <td class="res">Name:</td>
        <td class="res"><input type="text" name="name" size="40">
        </td>
      
    </tr>
    <tr> 
      <td class="res">URL:</td>
      <td class="res"><input type="text" name="url" value="http://" size="40">
      </td>
    </tr>
    <tr> 
      <td align="center" class="res" colspan="2"><input name="submit" type="submit" value="New URL"></td>
    </tr>
	</form>
    <tr> 
      <td align="center" colspan="2"><hr noshade size="1" width="200">
        <h4 class="h4">File</h4></td>
    </tr>
    <tr> 
      <form action="file.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="modules" value="<? echo $modules?>">
        <input type="hidden" name="id" value="0">
        <input type="hidden" name="refid" value="<? echo $id?>">
        <td class="res">Name:</td>
        <td class="res"><input type="text" name="name" size="40">
        </td>
      
    </tr>
    <tr> 
      <td class="res">File:</td>
      <td class="info"><input type="file" name="file" size="50">
        <br> <font color="red"><b>ชื่อไฟล์เป็นภาษาอังกฤษเท่านั้น (English file 
        name ONLY!!!)</b></font></td>
    </tr>
    <tr> 
      <td align="center" class="res" colspan="2"><input name="submit" type="submit" value="Upload file"></td>
    </tr>
	</form>
  </table>
  <?
}
?>
</div>
</body>
</html>