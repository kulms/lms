<?php 
require("../include/global_login.php");
//$check=mysql_query("SELECT name from modules WHERE id=$modules;");
//$get_course=mysql_query("SELECT courses FROM wp WHERE modules=$modules;");
//$check_cadmin=mysql_query("SELECT id FROM wp WHERE courses=".mysql_result($get_course,0,"courses")." AND admin=1 AND users=".$person["id"].";");
if (($person["category"] == 2) || ($person["category"] == 0)) {
        $cadmin=1;
}else{
        $cadmin=0;
}
//echo $chk."<br>";
//echo $m."  id:   ".$id."<br>";
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
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
</head>
<body bgcolor="#ffffff">
<div align="center">
<h1 class="h1"><? //echo mysql_result($check,0,"name");?></h1>
<?
if($id!="0"){
        $rs=mysql_query("SELECT * from resources_center WHERE id=$id;");
        $r=mysql_fetch_array($rs);
        if($r["users"]==$person["id"] || $person["admin"]==1 || $cadmin==1){
?>
        <h1>Edit</h1>
        <table border="0" cellpadding="2" cellspacing="0" class="tdborder2">
                 <tr>
                         <form action="rename.php" method="post">                         
                         <input type="hidden" name="id" value="<? echo $id?>">
						 <input type="hidden" name="fac" value="<? echo $fac?>">
						 <input type="hidden" name="dept" value="<? echo $dept?>">
						 <input type="hidden" name="major" value="<? echo $major?>">
						 <input type="hidden" name="chk" value="<? echo $chk?>">
                         <td class="hilite">Name:</td>
                         <td class="hilite">
						 	<input type="text" name="name" size="40" value="<? echo $r[name];?>" class="text">
						 	<input type="submit" class="button" value="Rename">
 						 </td>
                         </form>
                 </tr>
                 <?
                 if($r["folder"]==0 && strlen($r["url"])>0){
                         ?>
						 
                         <tr>
                                 <form action="url.php" method="post">
                                 <input type="hidden" name="id" value="<? echo $id?>">
								 <input type="hidden" name="fac" value="<? echo $fac?>">
								 <input type="hidden" name="dept" value="<? echo $dept?>">
								 <input type="hidden" name="major" value="<? echo $major?>">
								 <input type="hidden" name="chk" value="<? echo $chk?>">
                                 <td class="hilite">URL:</td>
                                 <td class="hilite">
						 		 	<input type="text" name="url" size="40" value="<? echo $r["url"]?>" class="text">
						 		 	<input type="submit" class="button" value="Update URL">
						 		 </td>
                                 </form>
                         </tr>
                         <?
                 }
                if($r["folder"]==0 && strlen($r["url"])==0){
                        ?>
						<?
						if($r["index_name"]!= "" && $r["index_name"] != "null") {
						?>
						<tr>
                                <form action="unzip.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<? echo $id?>">
								<input type="hidden" name="fac" value="<? echo $fac?>">
								<input type="hidden" name="dept" value="<? echo $dept?>">
								<input type="hidden" name="major" value="<? echo $major?>">
								<input type="hidden" name="chk" value="<? echo $chk?>">
								<input type="hidden" name="file" value="<? echo $r["file"];?>">
								<input type="hidden" name="rename" value="1">
																																
                                <td class="hilite">Index Name:</td>
                                <td class="info">
                                	<input type="text" name="index" size="40" value="<? echo $r["index_name"];?>" class="text">
						 			<input type="submit" value="Rename" class="button">
                                </td>
                                </form>
                        </tr>
                        <tr>
                                <form action="unzip.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<? echo $id?>">
								<input type="hidden" name="fac" value="<? echo $fac?>">
								<input type="hidden" name="dept" value="<? echo $dept?>">
								<input type="hidden" name="major" value="<? echo $major?>">
								<input type="hidden" name="chk" value="<? echo $chk?>">																
                                <td class="hilite">File:</td>
                                <td class="info">
                                        <input type="file" name="file" size="40" class="text"><br>
                                        English file name ONLY!!!<br>
                                        <input type="submit" value="Upload new document">
                                        <br>Old file: <? echo $r["file"]?>
                                </td>
                                </form>
                        </tr>
						<?
						} else {						
						?>
						<tr>
                                <form action="file.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<? echo $id?>">
								<input type="hidden" name="fac" value="<? echo $fac?>">
								<input type="hidden" name="dept" value="<? echo $dept?>">
								<input type="hidden" name="major" value="<? echo $major?>">
								<input type="hidden" name="chk" value="<? echo $chk?>">
                                <td class="hilite">File:</td>
                                <td class="info">
                                        <input type="file" name="file" size="40" class="text"><br>
                                        English file name ONLY!!!<br>
                                        <input type="submit" value="Upload new document">
                                        <br>Old file: <? echo $r["file"]?>
                                </td>
                                </form>
                        </tr>
						<?
						}
						?>
                        <?
                }
                        if($r["users"]==$person["id"] || $person["admin"]==1 || $cadmin==1){
                        ?>
                        <tr>
                                <td colspan="2" align="center">
                                        <form>
										<input type="hidden" name="fac" value="<? echo $fac?>">
										<input type="hidden" name="dept" value="<? echo $dept?>">
										<input type="hidden" name="major" value="<? echo $major?>">
										<input type="hidden" name="chk" value="<? echo $chk?>">
										<input type="button" value="Delete!" onClick="if(confirm('Realy delete?')){location='delete.php?id=<? echo $r["id"]?>';}" class="button">
        								</form>
                                </td>
                        </tr>
                        <? }?>
						<tr> 
						  <td colspan="2" align="center"> 
							<? if($r["folder"]==1) { ?>
							<form name="form1" method="post" action="">
          <table width="100%">
            <tr> 
             <!-- <td><div align="center">
                  <input name="getFile" type="submit" class="button" id="getFile" onClick="MM_openBrWindow('get_resource.php?user=<? echo $person["id"];?>&isedit=1','getResource','status=yes,scrollbars=yes,width=350,height=400')" value="Get Files">
                </div></td>
				-->
            </tr>
          </table>
        </form>
							<? } ?>
						  </td>
						</tr>
        </table>
<?
        }else{
        $getuser=mysql_query("SELECT u.firstname, u.surname FROM users u, resources_center r WHERE r.id=$id AND u.id=r.users");
        $creator=mysql_result($getuser,0,"firstname")."&nbsp;".mysql_result($getuser,0,"surname");
        ?>
        <p>
        <div class="h5" align="center">Sorry, you can't edit this item. It can only be edited by it's creator (<i><? echo $creator ?></i>)</div>
        </p>
        <? }
}
if($folder=="true"){
        ?>
  
        <h1 >Add</h1>
        
  <table border="0" cellpadding="2" cellspacing="0" class="tdborder2">
    <tr> 
      <td align="center" colspan="2"><h1>Folder</h1></td>
    </tr>
    <form action="folder.php" method="post">
      <tr> 
        <input type="hidden" name="id" value="0">
        <input type="hidden" name="refid" value="<? echo $id?>">
        <input type="hidden" name="fac" value="<? echo $fac?>">
        <input type="hidden" name="dept" value="<? echo $dept?>">
        <input type="hidden" name="major" value="<? echo $major?>">
        <input type="hidden" name="chk" value="<? echo $chk?>">
        <td class="hilite">Name:</td>
        <td class="hilite"><input type="text" name="name" class="text"></td>
      </tr>
      <tr> 
        <td align="center" class="hilite" colspan="2"><input type="submit" value="New folder" class="button"></td>
      </tr>
    </form>
    <tr> 
      <td align="center" colspan="2"><hr noshade size="1" width="200"><h1>
        URL</h1></td>
    </tr>
    <form action="url.php" method="post">
      <tr> 
        <input type="hidden" name="id" value="0">
        <input type="hidden" name="refid" value="<? echo $id?>">
        <input type="hidden" name="fac" value="<? echo $fac?>">
        <input type="hidden" name="dept" value="<? echo $dept?>">
        <input type="hidden" name="major" value="<? echo $major?>">
        <input type="hidden" name="chk" value="<? echo $chk?>">
        <?
							//echo $id."<br>";
							//echo $fac."<br>";
							//echo $dept."<br>";
							//echo $major."<br>";
						?>
        <td class="hilite">Name:</td>
        <td class="hilite"><input name="name" type="text" class="text" size="40"></td>
      </tr>
      <tr> 
        <td class="hilite">URL:</td>
        <td class="hilite"><input name="url" type="text" class="text" value="http://" size="40"></td>
      </tr>
      <tr> 
        <td align="center" class="hilite" colspan="2"><input type="submit" class="button" value="New URL"></td>
    </form></tr>
    <tr> 
      <td align="center" colspan="2"><hr noshade size="1" width="200"><h1>
        File</h1></td>
    </tr>
    <form action="file.php" method="post" enctype="multipart/form-data">
      <tr> 
        <input type="hidden" name="id" value="0">
        <input type="hidden" name="refid" value="<? echo $id?>">
        <input type="hidden" name="fac" value="<? echo $fac?>">
        <input type="hidden" name="dept" value="<? echo $dept?>">
        <input type="hidden" name="major" value="<? echo $major?>">
        <input type="hidden" name="chk" value="<? echo $chk?>">
        <td class="hilite">Name:</td>
        <td class="hilite"><input name="name" type="text" class="text" size="40"></td>
      </tr>
      <tr> 
        <td class="hilite">File:</td>
        <td ><input name="file" type="file" class="button" size="50">
          <br> <font color="red"><b>(English file name ONLY!!!)</b></font></td>
      </tr>
      <tr> 
        <td align="center" class="hilite" colspan="2"><input type="submit" class="button" value="Upload file"> 
        </td>
    </form></tr>
    <tr> 
      <td align="center" colspan="2"><hr noshade size="1" width="200"><h1>
        Zip File</h1></td>
    </tr>
    <form action="unzip.php" method="post" enctype="multipart/form-data">
      <tr> 
        <input type="hidden" name="id" value="0">
        <input type="hidden" name="refid" value="<? echo $id?>">
        <input type="hidden" name="fac" value="<? echo $fac?>">
        <input type="hidden" name="dept" value="<? echo $dept?>">
        <input type="hidden" name="major" value="<? echo $major?>">
        <input type="hidden" name="chk" value="<? echo $chk?>">
		<input type="hidden" name="rename" value="0">
        <td class="hilite">Name:</td>
        <td class="hilite"><input name="name" type="text" class="text" size="40"></td>
      </tr>
      <tr>
        <td class="hilite">Index Name :</td>
        <td class="hilite"><input name="index" type="text" class="text" size="40"></td>
      </tr>
      <tr> 
        <td class="hilite">File:</td>
        <td class="info"><input name="file" type="file" class="button" size="50">
          <br> <font color="red"><b>(English file name ONLY!!!)</b></font></td>
      </tr>
      <tr> 
        <td align="center" class="hilite" colspan="2"><input type="submit" value="Upload file" class="button"> 
        </td>
    </form></tr>
  </table>
        <?
}
?>
</div>
</body>
</html>