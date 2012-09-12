<? 
session_start();
$session_id = session_id();

require("../include/global_login.php");
require("../include/getsize.php");
require("../include/online.php");
require("../filemanager.inc.php");

online_courses($session_id,$person["id"],$courses,time(),1);
if($java=="yes"){
	$allpath=$realpath."/files/resources_files/".$folderid;
	rmdir($allpath);
	print( "<script language=javascript> alert(\"Can't find indexname in zip file. Please check your zip file and tryagin\"); </script>");
}
mysql_query("INSERT INTO login_modules(users,modules,time) VALUES(".$person["id"].",$id,".time().");");
$check_name=mysql_query("SELECT name,info from modules WHERE id=$id;");
$check=mysql_query("SELECT m.* FROM modules m, wp WHERE m.id=$id and m.id=wp.modules AND wp.users=".$person["id"].";");
if(mysql_num_rows($check)) {
	$cadmin = 1;
}

//**************************** GET QUOTA  **************************** 
if ($courses != 0) {
	$get_filesize = mysql_query("SELECT id, file,index_name, users from resources WHERE courses=".$courses." AND LENGTH(file) != 0 AND users=".$person["id"].";");	
} else {
	$get_filesize = mysql_query("SELECT id, file,index_name, users from resources WHERE courses=0 AND LENGTH(file) != 0 AND users=".$person["id"].";");
}
$sum_filesize = 0;
while ($row_filesize=mysql_fetch_array($get_filesize)){
	if($row_filesize["index_name"] == ""){
		//$sum_filesize = (filesize("../files/resources_files/".$row_filesize["users"]."/".$row_filesize["id"]."/".$row_filesize["file"])) + $sum_filesize;	
	}else{
		//$sum_filesize = (filesize("../files/resources_files/".$row_filesize["id"])) + $sum_filesize;	
	  $allpath = "../files/resources_files/".$row_filesize["users"]."/".$row_file["id"] ;	
	  //$sum_filesize=dirsize($allpath);
	   }
}
if ($courses!=0) {
	$q = mysql_query("SELECT quota FROM courses WHERE id=".$courses.";");
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
<title>Resources</title>
<script language="javascript">
<!--

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
<!--
function newWindowsResize(url)
 {
   var options = "width=" + screen.width + ",height=" + screen.height + ",";
   options += "resizable=yes,scrollbars=yes,status=yes,menubar=no,toolbar=no,location=no,directories=no,";
   options += "left=0,top=0";
 
   newWin = window.open(url, "wName", options);
   newWin.focus();
 }
//-->

</script>
<script language="JavaScript">
<!--
/*
function mouseOverRow(gId, onOver){	
	if(document.getElementById){
		if(onOver==1)
			//eval("document.getElementById('trE" + gId + "')").bgColor="#FFF5E8";
			//eval("document.getElementById('trE" + gId + "')").bgColor="#B3F2EF";
			eval("document.getElementById('trE" + gId + "')").bgColor="#E0E1FE";					
		else
			eval("document.getElementById('trE" + gId + "')").bgColor="";		
	}//end if

}//end function
*/


var plusImg = new Image();
var minusImg = new Image();
plusImg.src = "../images/rootPlus.gif";
minusImg.src = "../images/rootMinus.gif";

function tree(curObj, id){
	//if(isExpand==1){
		if(curObj.src == plusImg.src){
			curObj.src = minusImg.src;
			eval("document.getElementById('"+id+"')").style.display='';
		}else{
			curObj.src = plusImg.src;	
			eval("document.getElementById('"+id+"')").style.display='none';
		}//end if
//	}//end if

}//end function

//-->
</script>
<SCRIPT LANGUAGE=JAVASCRIPT>
function Highlight($objId,$id)
{
   	//unselect other checkbox's
    for(i=0;i<(document.form1.rad_id.length);i++)
    {
		//alert(document.form1.rad_id[i].value);
			
		if(document.form1.rad_id[i].id!=$objId)
		{
			document.form1.rad_id[i].checked=false;
			//document.form1.rad_id[i].disable=disable;
			//var row_id = "row"+(document.form1.rad_id[i].value);
			//document.getElementById(row_id).style.background="transparent";
		}
		
    }            	
		
	//When checkbox is checked(TRUE) change background to blue
	if(document.getElementById($objId).checked==true)
	{
		//document.getElementById($id).style.background="skyblue";
		//eval("document.getElementById('"+$id+"')").style.background="skyblue";
		//document.getElementById.style.background="skyblue";
	}
	//When checkbox is UNchecked(FALSE) Restore Defaults
	else if(document.getElementById($objId).checked==false)
		{
			//document.getElementById($id).style.background="transparent";
		}

}
</SCRIPT>
<script language="JavaScript">
	/**************
	 * This is only a sample.
	 *
	 * You may use this code as you see fit,
	 * as long as I (Thomas Raben) are
	 * given credit for this code upon
	 * release.
	 *
	 * If you like this code, then please vote
	 * for it.
	 * 
	 * Thank you.
	 *
	 * Best regards and happy coding
	 *
	 * Thomas Raben
	 */

	var HighLight="#ffffff";
	var Shadow="#3f3f3f";
	var Face="#d1d1d1";
	var DownFace="#e1e1e1";

	function add(url,type){
	 var el = document.form1.elements;
	 var modules= document.form1.modules.value;
	 var courses= document.form1.courses.value;
	 var msg;
	 var checkError = "";
	 var ii=0;
	 for(var i=0;i<el.length;i++){
		 if(el[i].type == "checkbox") {
			  		var idx=el[i].value;
					if (eval("document.form1.obj" + idx + ".checked") == true) {
							checkBoxvalue=idx;
							ii++;
							if (eval("document.form1.type" + idx + ".value") != "folder") {
								checkError += "\n-You didn't add folder because item type not type folder ...";
							}
					}
		 }
	 }
	if(ii==0){
			checkError += "\n-Please select item...";
		}

	 if (!checkError) {
	 		window.location="edit.php?modules=" + modules+"&courses="+courses+"&id="+checkBoxvalue+"&folder=true&action=add&m="+type;
	 }else{
    msg  = "______________________________________________________\n\n";
    msg += "The form wasn't processed since it contained some errors. \n";
    msg += "         Please correct the following errors and try again.\n";
    msg += "______________________________________________________\n\n";
    
    msg += checkError;
    alert(msg);
	}
	}
	
	function edit(url){
		 var el = document.form1.elements;
		 var modules= document.form1.modules.value;
		var courses= document.form1.courses.value;
		 var msg;
		 var checkError = "";
		 var ii=0;
		  //var itemchecked = false;
		 for(var i=0;i<el.length;i++){
			 if(el[i].type == "checkbox") {
						var idx=el[i].value;
						if (eval("document.form1.obj" + idx + ".checked") == true) {
								checkBoxvalue=idx;
								ii++;
						}
			 }
		 }
	
		if(ii==0){
			checkError += "\n-Please select item...";
		}

		 if (!checkError) {
				window.location=url+"?modules="+modules+"&courses="+courses+"&id="+checkBoxvalue+"&folder=true&action=edit";
		 }else{
		msg  = "______________________________________________________\n\n";
		msg += "The form wasn't processed since it contained some errors. \n";
		msg += "         Please correct the following errors and try again.\n";
		msg += "______________________________________________________\n\n";
		
		msg += checkError;
		alert(msg);
		}
	}
	
	function CreateMenus()
	{
		var ButtonName = new Array;
		var ButtonImage = new Array;
		var ButtonUrl = new Array;
		var ButtonTooltip = new Array;
		
		
		var ToolBar='<table border="0" cellpadding="0" cellspacing="0"><tr>';

		var i=0;
		var ii=0;
		
		
		//Set up the buttons
		//If ButtonImage is left blank, no image will be shown.
		//Note: if you need a ' in either the ButtonName or ButtonUrl remeber to type
		//it like this: \' (this will make the javascript understand it as a ', and not as
		//a end of string char.
		ButtonName[0]='add folder';
		ButtonImage[0]='../images/icon_folder_open_topic.gif';
		//ButtonUrl[0]='javascript:alert(\'You have pressed button 1\');';
		ButtonUrl[0]='javascript:add(\'edit.php\',\'folder\');';
		ButtonTooltip[0]='This button is for <nothing>';
		
		ButtonName[1]='';
		ButtonImage[1]='';
		ButtonUrl[1]='';							
		ButtonTooltip[1]='';
		
		ButtonName[2]='add file';
		ButtonImage[2]='../images/file_plus.gif';
		ButtonUrl[2]='javascript:add(\'edit.php\',\'file\');';	
		ButtonTooltip[2]='This button is for <nothing>';		
		
		//Leaving all blank the button will become a spacer/splitter
		ButtonName[3]='';
		ButtonImage[3]='';
		ButtonUrl[3]='';							
		ButtonTooltip[3]='';
		
		ButtonName[4]='add url';
		ButtonImage[4]='../images/www_plus.gif';
		ButtonUrl[4]='javascript:add(\'edit.php\',\'url\');';					
		ButtonTooltip[4]='This button is for <nothing>';
		
		ButtonName[5]='';
		ButtonImage[5]='';
		ButtonUrl[5]='';							
		ButtonTooltip[5]='';		
		
		ButtonName[6]='add zipfile';
		ButtonImage[6]='../images/zip_plus.gif';
		ButtonUrl[6]='javascript:add(\'edit.php\',\'zip\');';							
		ButtonTooltip[6]='This button is for <nothing>';		
		
		ButtonName[7]='';
		ButtonImage[7]='';
		ButtonUrl[7]='';							
		ButtonTooltip[7]='';		
		
		ButtonName[8]='edit';
		ButtonImage[8]='../images/_edit2.gif';
		ButtonUrl[8]='javascript:edit(\'edit.php\');';					
		ButtonTooltip[8]='Help from the author';
		
		ButtonName[9]='';
		ButtonImage[9]='';
		ButtonUrl[9]='';							
		ButtonTooltip[9]='';		
		
		ButtonName[10]='delete';
		ButtonImage[10]='../images/_delete.gif';
		ButtonUrl[10]='javascript:edit(\'delete.php\');';							
		ButtonTooltip[10]='Help from the author';		
		
		ButtonName[11]='';
		ButtonImage[11]='';
		ButtonUrl[11]='';							
		ButtonTooltip[11]='';		
		
		/*ButtonName[12]='Help';
		ButtonImage[12]='../images/atb_help.gif';
		ButtonUrl[12]='javascript:HelpMe();';					
		ButtonTooltip[12]='Help from the author';		*/		
		
		//Genereate the buttons...
		for(i=0;i<ButtonName.length;i++)
		{
			//This is actually pure HTML tags with some variables included.
			
			//if the button name isn't equal to nothing lets make a button
			if(ButtonName[i]!='')
			{
				ToolBar+='<td id="Button' + i + '" bgcolor="' + Face + '">';
				ToolBar+='<table border="0" cellpadding="0" cellspacing="0">';
				ToolBar+='<tr><td colspan="4" height="1"><img src="../images/dot.gif" width="1" height="1" border="0"></td></tr>';
				ToolBar+='<tr><td id="Button' + i + '1" colspan="4" height="1"><img src="../images/dot.gif" width="1" height="1" border="0"></td></tr>';
				ToolBar+='<tr>';
				ToolBar+='<td id="Button' + i + '2" width="1"><img src="../images/dot.gif" width="1" height="1" border="0"></td>';
				ToolBar+='<td nowrap height="16" >';
				
				//does the button have an image defined?
				if(ButtonImage[i]!='')
					ToolBar+='<a title="' + ButtonTooltip[i] + '" href="' + ButtonUrl[i] + '"  onmouseover="javascript:ShowOver(\'Button' + i + '\');" onmousedown="javascript:ShowDown(\'Button' + i + '\');" onmouseup="javascript:ShowOver(\'Button' + i + '\');" onmouseout="javascript:ShowNormal(\'Button' + i + '\');"><img src="' + ButtonImage[i] + '" border="0"></a>';
				else
					ToolBar+='<img src="dot.gif" width="1" height="1" border="0">';
			
			
				ToolBar+='</td>';
				ToolBar+='<td nowrap height="16" >';
				ToolBar+='<font style="font-family: Verdana; font-size:10px;">';
				ToolBar+='<a title="' + ButtonTooltip[i] + '" href="' + ButtonUrl[i] + '"  onmouseover="javascript:ShowOver(\'Button' + i + '\');" onmousedown="javascript:ShowDown(\'Button' + i + '\');" onmouseup="javascript:ShowOver(\'Button' + i + '\');" onmouseout="javascript:ShowNormal(\'Button' + i + '\');">&nbsp;' + ButtonName[i] + '&nbsp;</a>';
				ToolBar+='</font>';
				ToolBar+='</td>';
				ToolBar+='<td id="Button' + i + '3" width="1"><img src="../images/dot.gif" width="1" height="1" border="0"></td>';
				ToolBar+='</tr>';
				ToolBar+='<tr><td id="Button' + i + '4" colspan="4" height="1"><img src="../images/dot.gif" width="1" height="1" border="0"></td></tr>';
				ToolBar+='<tr><td colspan="4" height="1"><img src="../images/dot.gif" width="1" height="1" border="0"></td></tr>';
				ToolBar+='</table>';
				ToolBar+='</td>';			
				ToolBar+='<td width="2"><img src="../images/dot.gif" width="1" height="1" border="0"></td>';
			}
			//otherwise just make a seperator
			else
			{
				ToolBar+='<td width="2"><img src="../images/dot.gif" width="1" height="1" border="0"></td>';
				ToolBar+='<td bgcolor="' + Shadow + '" width="1"><img src="../images/dot.gif" width="1" height="1" border="0"></td>';
				ToolBar+='<td bgcolor="' + HighLight + '" width="1"><img src="../images/dot.gif" width="1" height="1" border="0"></td>';
				ToolBar+='<td width="2"><img src="../images/dot.gif" width="1" height="1" border="0"></td>';				
			}				
		}
		
		ToolBar+='</tr></table>';
		
		//write the toolbar to the table named Toolbar (look in the HTML for: id="Toolbar" ).
		document.getElementById('Toolbar').innerHTML=ToolBar;
	}
	
	//show the button normal
	function ShowNormal(object){
		document.all(object).bgColor=Face;
		document.all(object + '1').bgColor=Face;
		document.all(object + '2').bgColor=Face;
		document.all(object + '3').bgColor=Face;
		document.all(object + '4').bgColor=Face;
	}

	//show the button with the mouse over it
	function ShowOver(object){
		document.all(object).bgColor=Face;
		document.all(object + '1').bgColor=HighLight;
		document.all(object + '2').bgColor=HighLight;
		document.all(object + '3').bgColor=Shadow;
		document.all(object + '4').bgColor=Shadow;
	}	

	//show the button with the mouse is pressed
	function ShowDown(object){
		document.all(object).bgColor=DownFace;
		document.all(object + '1').bgColor=Shadow;
		document.all(object + '2').bgColor=Shadow;
		document.all(object + '3').bgColor=HighLight;
		document.all(object + '4').bgColor=HighLight;
	}		
	
	
	//Help function...
	//This functions displays a YES/CANCEL box,
	//and will send an email to the author, if 
	//chosen. (flrrrrr)
	function HelpMe()
	{
		if(confirm('Do you really need help with this code?'))
			this.document.location.href='mailto:tr@vupti.com';
	}	
</script>
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">

<style type="text/css">
	a.Button:hover {color: #ff0000; text-decoration: none}
	a.Button {color: #333333; text-decoration: none}
</style>

</head>
<body bgcolor="#ffffff" onLoad="javascript:CreateMenus();">
<div align="center">
<!--
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		  <tr valign="top"> 
			<td width="50%"> 
			  <h1><? //echo mysql_result($check,0,"name");?></h1></td>    
		  </tr>
		</table>
		<table border="0" cellpadding="4" cellspacing="0" width="100%">
			<tr> 			 
				  <? //if ($person["category"] == 2) { ?>
				  <td > 
					<table width="80%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td width="7%" valign="middle"><img src="../images/_edit-16.png" border="0">
							<a href="../common/module_admin.php?id=<? //echo $id;?>&courses=<? echo $courses;?>"> 
							<? //echo "edit";?></a> 
						</td>
						<td width="93%" valign="middle">						
							  <a href="javascript:delIt()"> <img src="../images/_trash_full-16.png" border="0"> </a>
							  <a href="javascript:delIt()"><? //echo "delete";?></a> 						  						
						</td>
					  </tr>
					</table>					
				  </td>
				 <? //} ?>
			</tr>
		</table>
-->					
<br>
  <table border="0" cellpadding="0" cellspacing="0">
        <tr>
                <td class="blue"><? echo nl2br(mysql_result($check_name,0,"info"))?></td>                
        </tr>
</table>
<!-- New Table -->

<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
	 <? if ($person["category"] == 2 || mysql_num_rows($check) != 0) { ?>
          <tr>
            <td align="right">
			<form name="frm_new" method=post action="./edit.php?modules=<? echo $id?>&id=0&folder=true&action=add">
                Add New Item to root : 
                <select name="m" style="font-size:10px" onChange="f=document.frm_new;mod=f.m.options[f.m.selectedIndex].value;if(mod) f.submit();">
                  <option value="" selected="selected">- New Item -</option>
                  <option value="folder">Folder</option>
                  <option value="url">Url</option>
                  <option value="file">File</option>
				  <option value="zip">Zip</option>
                </select>
                <input type="hidden" name="a" value="addedit" />
			</form>
			</td>
          </tr>
		<? } ?>
          <tr class="Boxcolor"> 
            <td align="center" ><b> </b><a href="../common/module_admin.php?id=<? echo $id?>&courses=<? echo $courses?>"> 
              </a> 
              <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                <tr>
                  <td width="94%" align="center"class="Bcolor"><b><? echo mysql_result($check_name,0,"name");?></b></td>
                  <td width="6%" class="Bcolor"><a href="../common/module_admin.php?id=<? echo $id?>&courses=<? echo $courses?>">edit 
                    <img src="../images/_edit2.gif" border="0" width="19" height="17"></a></td>
                </tr>
              </table></td>            
          </tr>
          <tr> 
            <td> 
			<form name="form1" method="post" action="">
			<input type="hidden" name="modules" value="<? echo $id?>">
			<input type="hidden" name="courses" value="<? echo $courses?>">
			<input type="hidden" name="a" value="addedit">
						<table width="100%" border="0" cellspacing="0" cellpadding="2" class="res">
                <tr id="trE<? echo $count;?>"> 
					<? if ($person["category"]==2 || $person["admin"] ==1) { ?>
                    <td width="630" style="BORDER-BOTTOM: solid #85C6E4 1px;BORDER-TOP: solid #85C6E4 1px;BORDER-LEFT: solid #85C6E4 1px;BORDER-RIGHT: solid #85C6E4 1px;" bgcolor="#d1d1d1"> 
                      <table bgcolor="#d1d1d1" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td id="Toolbar" height="24">&nbsp;</td>
						</tr>
					</table>
					</td>
					<? } ?>
                </tr>
            </table>
			<table width="100%" border="0" cellspacing="0" cellpadding="2" class="res">
                <tr id="trE<? echo $count;?>"> 
                  <td style="BORDER-BOTTOM: solid #85C6E4 1px;" width="19" align="center" valign="top"> 
                    <img src="../images/icon_folder_open_topic.gif" border="0"> 
                  </td>
                  <td width="630" style="BORDER-BOTTOM: solid #85C6E4 1px;"> <table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr> <? echo $space; ?> 
                        <td width="16" valign="top"><img src="../images/rootPlus.gif" border="0" ></td>
                        <td width="367" class="res">&nbsp;/ </td>                        
                        <td width="225" class="res" align="right">root directory</td>                        
                      </tr>
                    </table></td>
                </tr>
              </table>
                <!-- Start tree -->
                <?		   	
		    function rs($modules,$id,$cat,$count,$space, $admin,$cid,$ruid){
                $rs=mysql_query("SELECT r.name,r.id,r.folder,r.url,r.refid,r.file,r.new_window,r.modules,r.time,r.users,u.firstname,u.surname,r.index_name FROM resources  r,users u WHERE r.modules=$modules AND r.refid=$id AND r.users=u.id order by r.folder,r.name ASC;");
				
                while($row=mysql_fetch_array($rs)){	
					 $count++;
				?>
                <? if($row["folder"]==1) { ?>
                <table width="100%" border="0" cellspacing="0" cellpadding="2" class="res">
                <tr id="trE<? echo $count;?>"> 
                  <td style="BORDER-BOTTOM: solid #85C6E4 1px;" width="45" align="center" valign="top"> 
                    <img src="../images/icon_folder_open_topic.gif" border="0">
					<? if ($cat==2 || $admin ==1) { ?>
					<input type="checkbox" id="obj<? echo $row["id"];?>" onclick='Highlight("obj<? echo $row["id"];?>","row<? echo $row["id"];?>")' name="rad_id" value="<? echo $row["id"];?>"> 
					<input type="hidden" name="type<? echo $row["id"];?>" value="folder">
					<? }?>
                  </td>
                  <td width="593" style="BORDER-BOTTOM: solid #85C6E4 1px;"> <table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr> <? echo $space; ?> 
                        <td width="23" valign="top"><img src="../images/rootPlus.gif" border="0" onClick="tree(this, '<? echo $count;?>')" style="cursor:pointer;cursor:hand"></td>
                        <td width="360" class="res" style="cursor:pointer;cursor:hand" onClick="tree(this, '<? echo $count;?>')">&nbsp;<? echo $row["name"];?></td>
						
                        <? if ($cat==2 || $admin ==1) { ?>
						<!--
                        <td width="225" class="res" align="right"> add :
						  <a href="edit.php?modules=<? echo $modules?>&id=<? echo $row["id"]?>&action=add&m=folder"> 
                          [ <img src="../images/folder_plus.gif" alt="Add new Folder" width="16" height="16" border="0">] 
                          </a> 
						  <a href="edit.php?modules=<? echo $modules?>&id=<? echo $row["id"]?>&action=add&m=file"> 
                          [ <img src="../images/file_plus.gif" alt="Add new File" width="15" height="15" border="0">] 
                          </a> 
						  <a href="edit.php?modules=<? echo $modules?>&id=<? echo $row["id"]?>&action=add&m=url"> 
                          [ <img src="../images/www_plus.gif" alt="Add new Url" width="16" height="16" border="0">] 
                          </a> 
						  -->
						  <!--
						  <a href="edit.php?modules=<? echo $modules?>&id=<? echo $row["id"]?>&action=add&m=zip"> 
                          [ <img src="../images/zip_plus.gif" alt="Add new Zip" width="16" height="16" border="0">] 
                          </a>--> 
						  <!--
						  :: <a href="edit.php?modules=<? echo $modules?>&id=<? echo $row["id"]?>&action=edit"> 
                          edit <img src="../images/_edit2.gif" width=19 height=17 alt="Edit this Folder" border="0" align="top"></a> -->
                          <!--<img src="../images/_delete.gif" width=16 height=16 alt="Delete this Folder" border="0" align="top"> -->
						<!--  
                        </td>
						-->
                        <? } ?>
						
                      </tr>
                    </table></td>
                </tr>
              </table>
              <span id="<? echo $count;?>" style="display:'none';"> 
              <? } else { 
								 if(strlen($row["url"])!=0){ ?>
              <table width="100%" border="0" cellspacing="0" cellpadding="2" class="res">
                <tr id="trE<? echo $count;?>"> 
                  <td style="BORDER-BOTTOM: solid #85C6E4 1px;" width="42" align="center" valign="top"> 
                    <img src="../images/space.gif" width="16">
					<? if ($cat==2 || $admin ==1) { ?>
                      <input type="checkbox" id="obj<? echo $row["id"];?>" onclick='Highlight("obj<? echo $row["id"];?>","row<? echo $row["id"];?>")' name="rad_id" value="<? echo $row["id"];?>" >
					 <input type="hidden" name="type<? echo $row["id"];?>" value="url">
					  <? }?>
                    </td>
                  <td width="596" style="BORDER-BOTTOM: solid #85C6E4 1px;"> <table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr> 
                        <!--<td width="16"><img src="../images/space.gif" width="16"></td>-->
                        <? echo $space; ?> 
                          <td width="23" height="22" valign="top"> <img src="../images/space.gif" width="2"><img src="../images/rootMinus.gif" border="0" onClick="tree(this, '<? echo $count;?>')"></td>
                        <td width="29"><img src="../images/link.gif" border="0"></td>
                        <td width="411" class="res"> 
                          <? if(($row["new_window"]==0) || ($row["new_window"]==1)) {?>
                          <a href="<? echo $row["url"]?>" 
														target="<? if($row["new_window"]==0) 
															echo "_self";
															else
															echo "_blank"; 	
															?>"> <? echo $row["name"]?> 
                          </a> 
                          <? } else {?>
                          <a href="#" onClick="newWindowsResize('<? echo $row["url"]?>')"> 
                          <? echo $row["name"]?> </a> 
                          <? } ?>
                        </td>
                        <? if ($cat==2 || $admin==1) { ?>
                        <td width="141" class="res" align="right"><!-- <a href="edit.php?modules=<? echo $modules?>&id=<? echo $row["id"]?>&action=edit">edit 
                          <img src="../images/_edit2.gif" width=19 height=17 alt="Edit this WebSite" border="0" align="top"></a> -->
                          <!--<img src="../images/_delete.gif" width=16 height=16 alt="Delete this WebSite" border="0" align="top"> -->
                        </td>
                        <? } ?>
                      </tr>
                    </table></td>
                </tr>
              </table>
              <span id="<? echo $count;?>" style="display:'none';"> </span> 
              <? } else { ?>
              <table width="100%" border="0" cellspacing="0" cellpadding="2" class="res">
                <tr id="trE<? echo $count;?>"> 
                  <td style="BORDER-BOTTOM: solid #85C6E4 1px;" width="41" align="center" valign="top"> 
                    <img src="../images/space.gif" width="16">
					<? if ($cat==2 || $admin ==1) { ?>
                    <input type="checkbox" id="obj<? echo $row["id"];?>" onClick='Highlight("obj<? echo $row["id"];?>","row<? echo $row["id"];?>")' name="rad_id" value="<? echo $row["id"];?>">					  
                    <input type="hidden" name="type<? echo $row["id"];?>" value="file">
					<? }?>
                    </td>
                  <td width="597" style="BORDER-BOTTOM: solid #85C6E4 1px;"> <table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr> 
                        <!--<td width="16"><img src="../images/space.gif" width="16"></td> -->
                        <? echo $space; ?> 
                          <td width="23" valign="top"> <img src="../images/space.gif" width="2"><img src="../images/rootMinus.gif" border="0" onClick="tree(this, '<? echo $count;?>')"></td>
                        <td width="29"><img src="../images/file.gif" border="0"></td>
                        <td width="411" class="res"> 
						<? 
							if($row["index_name"]==""){
								 //$href="../files/resources_files/".$row["users"]."/".$row["id"]."/".$row["file"];
								 $href="../download.php?m=resources&userid=".$row["users"]."&id=".$row["id"]."&filename=".$row["file"]."&courses=".$cid."&req=".$ruid;
							}else{
								 //$href="../files/resources_files/".$row["users"]."/".$row["id"]."/".$row["index_name"];
								 $href="../download.php?m=resources&userid=".$row["users"]."&id=".$row["id"]."&filename=".$row["index_name"]."&courses=".$cid."&req=".$ruid;
							}
					   ?>
                          <? if(($row["new_window"]==0) || ($row["new_window"]==1)) {?>
                          <a href=<? echo $href ?>
														target="<? if($row["new_window"]==0) 
																	 echo "_self";
																	 else 
																	 echo "_blank"; 
																	 ?>"> <? echo $row["name"]?> 
                          </a> 
                          <? } else {?>
                          <!--<a href="#" onClick="newWindowsResize('http://<?php echo $_SERVER["HTTP_HOST"];?>/<?php echo $_SESSION['path'];?>/files/resources_files/<? echo  $row["users"]."/".$row["id"]."/".$row["file"]?>')">--> 
                          <a href="#" onClick="newWindowsResize('http://<?php echo $_SERVER["HTTP_HOST"];?>/<?php echo $_SESSION['path'];?>/download.php?m=resources&userid=<? echo $row["users"]."&id=".$row["id"]."&filename=".$row["file"]."&courses=".$cid."&req=".$ruid?>')">
                          <? echo $row["name"]?> </a> 
                          <? } ?>
						  
						  <?// } ?>
                          <!--
                          <? if(strlen($row["file"])!=0) {?>
                          (Size : 
                          <? 							if($row["index_name"]==""){
																//$doc_filesize = filesize("../files/resources_files/".$row["users"]."/".$row["id"]."/".$row["file"]);
						  								}else{
																//echo $doc_filesize = filesize("../files/resources_files/".$row["id"]."/6_47.xml");
																//echo "ff".$realpath;
																$allpath="../files/resources_files/".$row["users"]."/".$row["id"];
																//$doc_filesize=dirsize($allpath);
																}
															if ($doc_filesize != 0) {
																//echo GetSize ($doc_filesize);
															} else echo "0 B";
														?>
                          ) 
                          <? } else { ?>
                          (Size : 0 B) 
                          <? 	}?>
                          -->
                        </td>
                        <? if ($cat==2 || $admin ==1) { ?>
                        <td width="141" class="res" align="right"><!-- <a href="edit.php?modules=<? echo $modules?>&id=<? echo $row["id"]?>&action=edit"> 
                          edit <img src="../images/_edit2.gif" width=19 height=17 alt="Edit this File" border="0" align="top"></a> -->
                          <!--<img src="../images/_delete.gif" width=16 height=16 alt="Delete this File" border="0" align="top"> -->
                        </td>
                        <? } ?>
                      </tr>
                    </table></td>
                </tr>
              </table>
              <span id="<? echo $count;?>" style="display:'none';"> </span> 
              <? } 				
						?>
              <? }		
				 		if($row["folder"]==1){																					
							rs($modules,$row["id"],$cat,rand(),$space.'<td width="16"><img src="../images/space.gif" width="16"></td>',$admin,$cid,$ruid);						
							?>
              </span> 
              <? }
				}
			}						
			rs($id,0,$person["category"],0,'',$cadmin,$courses,$person["id"]);
			?>
              <!-- End Tree -->
			 <table width="100%" border="0" cellspacing="0" cellpadding="2" class="res">
                <tr id="trE<? echo $count;?>"> 
                  <td style="BORDER-BOTTOM: solid #85C6E4 1px;" width="19" align="center" valign="top">&nbsp; 
                  </td>
                  <td width="630" style="BORDER-BOTTOM: solid #85C6E4 1px;"> <table width="100%" border="0" cellspacing="0" cellpadding="2">
                  <!--
                      <tr> <? echo $space; ?> 
                        <td width="16" valign="top"><img src="../images/disk_space.gif" width="16" height="16" border="0"></td>
                        <td width="458" >&nbsp;<strong>Current Quota</strong>: 
                          <? echo GetSize ($quota);?>, <strong>Free</strong>: 
                          <? echo GetSize ($quota-$sum_filesize);?>, <strong>Used</strong>: 
                          <? echo GetSize ($sum_filesize);?></td>                        
                        <td width="134" class="res" align="right">&nbsp;</td>                        
                      </tr>
                   -->   
                    </table></td>
                </tr>
              </table> 
			  </form>
            </td>
          </tr>
        </table>
	</td>
   </tr>
</table>
<!-- End New Table -->

<? if (($person["category"] == 2) or ($person["category"] == 1)) { ?>
  <table width="40%">
    <tr>
      <td><!--<form name="form1" method="post" action="">
          <div align="center"><font color="#0000FF" size="2">Get File From Personal 
            :</font><font size="2"> 
            <input name="getFile" type="submit" id="getFile" onClick="MM_openBrWindow('get_resource.php?user=<? echo $person["id"];?>&modules=<? echo $id?>','getResource','status=yes,scrollbars=yes,width=350,height=400')" value="Get Files">            
            </font></div>
          </form>--></td>
    </tr>
  </table>
  <table width="80%">
    <tr>
		<td>
		<!--<form name="form2" method="post" action="">
          <div align="center"><font color="#0000FF" size="2">Get File From Resource 
            Center :</font><font size="2"> 
            <input name="getFile" type="submit" id="getFile" onClick="MM_openBrWindow('index_rc.php','getResCenter','status=yes,scrollbars=yes,width=600,height=600')" value="Get Files">            
            </font></div>
          </form>-->
		</td>
  	</tr>
  </table>
<? } ?>
</div></body>
</html>
<?
mysql_close();
?>