<?
//require("../include/global_login.php");
session_start();
$session_id = session_id();		

require ("../include/global_login.php");

require_once ("./classes/User.php");
require_once ("./classes/UserStorage.php");
require_once( "./includes/main_functions.php" );

require("../include/getsize.php");
require("../filemanager.inc.php");
	
$user = UserStorage::lookupById($person["login"]);

session_register( 'user' ); 		

switch ($user->getCategory()) {
	case 0:
		$uistyle = "admin";
		break;
	case 1:
		$uistyle = "admin";
		break;
	case 2:
		$uistyle = "teacher";
		break;
	case 3:
		$uistyle = "student";
		break;
	default:
		$uistyle = "guest";
	}


//echo "Faculty : ".$fac."<br>";
//echo "Department : ".$dept."<br>";
//echo "Major : ".$major."<br>";
if($fac == "" ||  empty($fac)){
	$fac =-1;
}
if($dept == ""  ||  empty($dept)){
	$dept =-1;
}
if($major == ""  ||  empty($major)){
	$major ="no";
}
if (($fac == -1) and ($dept == -1) and ($major == "no")){
	$chk = 0;	
} elseif (($fac != -1) and ($dept == -1) and ($major == "no")){
		$chk = 1;		
	} elseif (($fac != -1) and ($dept != -1) and ($major == "no")){
			$chk = 2;			
		} elseif (($fac != -1) and ($dept != -1) and ($major != "no")){
				$chk = 3;				
			}
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
</script>
<script language="javascript">
<!--
function newWindowsResize(url)
 {
   var options = "width=" + screen.width + ",height=" + screen.height + ",";
   options += "resizable=yes,scrollbars=no,status=yes,menubar=no,toolbar=no,location=no,directories=no,";
   options += "left=0,top=0";
 
   newWin = window.open(url, "wName", options);
   newWin.focus();
 }
//-->

<!--
function newWindowsResizeURL(url)
 {
   var options = "width=" + screen.width + ",height=" + screen.height + ",";
   options += "resizable=yes,scrollbars=no,status=yes,menubar=no,toolbar=yes,location=no,directories=no,";
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
	 //var modules= document.form1.modules.value;
	 //var courses= document.form1.courses.value;
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
	 		window.location="edit.php?id="+checkBoxvalue+"&folder=true&action=add&m="+type;
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
		 //var modules= document.form1.modules.value;
		 //var courses= document.form1.courses.value;
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
				window.location=url+"?&id="+checkBoxvalue+"&folder=true&action=edit";
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
<body bgcolor="#ffffff">
<div align="center">
  <table width="482" border="0" cellspacing="0" cellpadding="0" align="center"
	    height="53" class="bg1">
    <tr> 
      <td class="menu" align="center"> <b>E-Courseware Center</b> </td>
    </tr>
  </table>
  <br>
  <!-- new Structure  -->
  <table width="70%" border="0" cellspacing="0" cellpadding="2">
	 <? if ($cadmin == 1) { ?>
          <tr>
            <td align="right">			
	
			</td>
          </tr>
		<? } ?>
          <tr class="Boxcolor"> 
    
          </tr>
          <tr> 
            <td> 
			<form name="form1" method="post" action="">			

			<input type="hidden" name="a" value="addedit">
						<table width="100%" border="0" cellspacing="0" cellpadding="2" class="res">
                <tr id="trE<? echo $count;?>"> 
					<? if ($person["admin"] ==1) { ?>
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
		    function rs2($id,$space,$faculty,$department,$major,$check,$admin,$count){
				
				 if (($faculty != -1) and ($department != -1) and ($major != "no")){
				 	 //echo "1"."<br>";
					 $rs=mysql_query("SELECT r.*,u.firstname,u.surname,u.category, u.admin 
									  FROM resources_center r,users u 
									  WHERE r.refid=$id AND r.users=u.id AND 
									  (r.faculty=$faculty AND 
									  ((r.department=$department) OR (r.department=0)) AND ((r.major=$major) OR (r.major=0))) 
									  ORDER BY r.name;");
				 } elseif (($faculty != -1) and ($department != -1)){
				 			//echo "2"."<br>";
							//echo "id = ".$id."<br>";
							$rs=mysql_query("SELECT r.*,u.firstname,u.surname,u.category, u.admin  
										  	 FROM resources_center r,users u 
										  	 WHERE r.refid=$id AND r.users=u.id AND 
										  	 (r.faculty = $faculty AND ((r.department=$department) OR (r.department=0)))  											  
										  	 ORDER BY r.name;");
				 		} elseif ($faculty != -1) {
								//echo "3"."<br>";
								$rs=mysql_query("SELECT r.*,u.firstname,u.surname,u.category, u.admin  
									  			 FROM resources_center r,users u 
									  			 WHERE r.refid=$id AND r.users=u.id AND r.faculty=$faculty
									  			 ORDER BY r.name;");
							   } else {
							   			//echo "4"."<br>";
										$rs=mysql_query("SELECT r.*,u.firstname,u.surname,u.category, u.admin  
														 FROM resources_center r,users u 
														 WHERE r.refid=$id AND r.users=u.id 
														 ORDER BY r.name;");			
							   		  }

				
                while($row=mysql_fetch_array($rs)){	
					 $count++;
				?>
                <? if($row["folder"]==1) { ?>
                <table width="100%" border="0" cellspacing="0" cellpadding="2" class="res">
                <tr id="trE<? echo $count;?>"> 
                  <td style="BORDER-BOTTOM: solid #85C6E4 1px;" width="32" align="center" valign="top"> 
                    <img src="../images/icon_folder_open_topic.gif" border="0">
					<? if ($admin ==1) { ?>			
					<? }?>                  </td>
                  <td width="752" style="BORDER-BOTTOM: solid #85C6E4 1px;"> <table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr> <? echo $space; ?> 
                        <td width="23" valign="top"><img src="../images/rootPlus.gif" border="0" onClick="tree(this, '<? echo $count;?>')" style="cursor:pointer;cursor:hand"></td>
                        <td width="360" class="res" style="cursor:pointer;cursor:hand" onClick="tree(this, '<? echo $count;?>')">&nbsp;<? echo $row["name"];?></td>																								
                      </tr>
                  </table></td>
                  
				  
				  		<? 
                                      if($row["folder"]==0){?>
						                  <td width="20" style="BORDER-BOTTOM: solid #85C6E4 1px;">
										  	 <? if($admin == 1){?>
                                             <a href="edit.php?id=<? echo $row["id"]?>&fac=<? echo $row["faculty"]?>&dept=<? echo $row["department"]?>&major=<? echo $row["major"]?>&chk=<? echo $check?>">
                                             <img src="../images/tool.gif" width=18 height=16 alt="<? echo $row["firstname"]." ".$row["surname"]." ".date("Y-m-d H:i",$row["time"])?>" border="0" align="top"></a>
											 <? }?>                                   		  </td>
                                   <? } else {
								   			if (($row["is_major"]==1) OR (($row["is_fac"]==0) AND ($row["is_dept"]==0) AND ($row["is_major"]==0))) {
								   ?>
												<td width="20" style="BORDER-BOTTOM: solid #85C6E4 1px;">
													<? if($admin == 1){?>	
													<a href="edit.php?id=<? echo $row["id"]?>&folder=true&fac=<? echo $row["faculty"]?>&dept=<? echo $row["department"]?>&major=<? echo $row["major"]?>&chk=<? echo $check?>">
													<img src="../images/tool.gif" width=18 height=16 alt="<? echo $row["firstname"]." ".$row["surname"]." ".date("Y-m-d H:i",$row["time"])?>" border="0" align="top"></a>
													<? }?>												</td>
									<?	}
									}
									?>
				  
				  
				  
                </tr>
              </table>
              <span id="<? echo $count;?>" style="display:'none';"> 
              <? } else { 
								 if(strlen($row["url"])!=0){ ?>
              <table width="100%" border="0" cellspacing="0" cellpadding="2" class="res">
                <tr id="trE<? echo $count;?>"> 
                  <td style="BORDER-BOTTOM: solid #85C6E4 1px;" width="30" align="center" valign="top"> 
                    <img src="../images/space.gif" width="16">
					<? if ($admin ==1) { ?>
					  <? }?>                  </td>
                  <td width="754" style="BORDER-BOTTOM: solid #85C6E4 1px;"> <table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr>                         
                        <? echo $space; ?> 
                          <td width="23" height="22" valign="top"> <img src="../images/space.gif" width="2"><img src="../images/rootMinus.gif" border="0" onClick="tree(this, '<? echo $count;?>')"></td>
                        <td width="23"><img src="../images/link.gif" border="0"></td>
                        <td width="313" class="res"> 
						<a href="#" onClick="newWindowsResizeURL('main_url.php?id=<? echo $row["id"]?>&index_name=<? echo $row["url"];?>')"><? echo $row["name"]?></a>
						</td>
                        <? if ($admin==1) { ?>
                        
                        <? } ?>
                      </tr>
                  </table></td>
                   		<? 
                                      if($row["folder"]==0){?>
						                  <td width="20" style="BORDER-BOTTOM: solid #85C6E4 1px;">
										  	 <? if($admin == 1){?>
                                             <a href="edit.php?id=<? echo $row["id"]?>&fac=<? echo $row["faculty"]?>&dept=<? echo $row["department"]?>&major=<? echo $row["major"]?>&chk=<? echo $check?>">
                                             <img src="../images/tool.gif" width=18 height=16 alt="<? echo $row["firstname"]." ".$row["surname"]." ".date("Y-m-d H:i",$row["time"])?>" border="0" align="top"></a>
											 <? }?>                                   		  </td>
                                   <? } else {
								   			if (($row["is_major"]==1) OR (($row["is_fac"]==0) AND ($row["is_dept"]==0) AND ($row["is_major"]==0))) {
								   ?>
												<td width="20" style="BORDER-BOTTOM: solid #85C6E4 1px;">
													<? if($admin == 1){?>	
													<a href="edit.php?id=<? echo $row["id"]?>&folder=true&fac=<? echo $row["faculty"]?>&dept=<? echo $row["department"]?>&major=<? echo $row["major"]?>&chk=<? echo $check?>">
													<img src="../images/tool.gif" width=18 height=16 alt="<? echo $row["firstname"]." ".$row["surname"]." ".date("Y-m-d H:i",$row["time"])?>" border="0" align="top"></a>
													<? }?>												</td>
									<?	}
									}
									?>
                </tr>
              </table>
              <span id="<? echo $count;?>" style="display:'none';"> </span> 
              <? } else { ?>
              <table width="100%" border="0" cellspacing="0" cellpadding="2" class="res">
                <tr id="trE<? echo $count;?>"> 
                  <td style="BORDER-BOTTOM: solid #85C6E4 1px;" width="30" align="center" valign="top"> 
                    <img src="../images/space.gif" width="16">
					<? if ($admin ==1) { ?>
					<? }?>                  </td>
                  <td width="754" style="BORDER-BOTTOM: solid #85C6E4 1px;"> <table width="100%" border="0" cellspacing="0" cellpadding="2">
                      <tr>                         
                        <? echo $space; ?> 
                          <td width="23" valign="top"> <img src="../images/space.gif" width="2"><img src="../images/rootMinus.gif" border="0" onClick="tree(this, '<? echo $count;?>')"></td>
                        <td width="23"><img src="../images/file.gif" border="0"></td>
                        <td width="411" class="res"> 
						<? 
							if($row["index_name"]!= "" && $row["index_name"] != "null") {
							?>
							 <!--<a href="#" onClick="newWindowsResize('main.php?id=<? echo $row["id"]?>&index_name=<? echo $row["index_name"]."&action=content&user=".$person["login"]?>;?>')">-->
							 <!--<a href="#" onClick="newWindowsResize('../files/resources_center_files/<? echo $row["id"]."/".$row["index_name"]."?action=content&user=".$person["login"]?>')">-->
							 <a href="#" onClick="newWindowsResize('main.php?id=<? echo $row["id"]?>&index_name=<? echo $row["index_name"];?>')">
							<? echo $row["name"]?> </a>
							<!--<a href="../files/resources_center_files/<? echo $row["id"]."/".$row["index_name"]?>" target="_blank"><? echo $row["name"]?></a>-->
							<?
						} else {
							?>
							<!--<a href="../files/resources_center_files/<? echo $row["id"]."/".$row["file"]?>"><? echo $row["name"]?></a>-->
							<a href="#" onClick="newWindowsResize('main_file.php?id=<? echo $row["id"]?>&index_name=<? echo $row["file"];?>')"><? echo $row["name"]?></a>
							<?
						}
					   ?>                        </td>
                        <? if ($admin ==1) { ?>
                       
                        <? } ?>
                      </tr>
                  </table></td>
                   		<? 
                                      if($row["folder"]==0){?>
						                  <td width="20" style="BORDER-BOTTOM: solid #85C6E4 1px;">
										  	 <? if($admin == 1){?>
                                             <a href="edit.php?id=<? echo $row["id"]?>&fac=<? echo $row["faculty"]?>&dept=<? echo $row["department"]?>&major=<? echo $row["major"]?>&chk=<? echo $check?>">
                                             <img src="../images/tool.gif" width=18 height=16 alt="<? echo $row["firstname"]." ".$row["surname"]." ".date("Y-m-d H:i",$row["time"])?>" border="0" align="top"></a>
											 <? }?>                                   		  </td>
                                   <? } else {
								   			if (($row["is_major"]==1) OR (($row["is_fac"]==0) AND ($row["is_dept"]==0) AND ($row["is_major"]==0))) {
								   ?>
												<td width="20" style="BORDER-BOTTOM: solid #85C6E4 1px;">
													<? if($admin == 1){?>	
													<a href="edit.php?id=<? echo $row["id"]?>&folder=true&fac=<? echo $row["faculty"]?>&dept=<? echo $row["department"]?>&major=<? echo $row["major"]?>&chk=<? echo $check?>">
													<img src="../images/tool.gif" width=18 height=16 alt="<? echo $row["firstname"]." ".$row["surname"]." ".date("Y-m-d H:i",$row["time"])?>" border="0" align="top"></a>
													<? }?>												</td>
									<?	}
									}
									?>
                </tr>
              </table>
              <span id="<? echo $count;?>" style="display:'none';"> </span> 
              <? } 				
						?>
              <? }		
				 		if($row["folder"]==1){																					
							 rs2($row["id"],$space.'<td width="16"><img src="../images/space.gif" width="16"></td>',$faculty,$department,$major,$check,$admin,rand()); 
							?>
              </span> 
              <? }
				}
			}						
			rs2(0,'',$fac,$dept,$major,$chk,$person["admin"],0);
			?>
              <!-- End Tree -->			 
			  </form>
            </td>
          </tr>
  </table>
  
  <!-- End new Structure-->
  
  
  
                <? if (($person["category"] == 2) or ($person["category"] == 1)) { ?>
             
                <? } ?>
<table width="40%">
    <tr>
      <td>
          <div align="center">
            <input name="Back" type="button" id="Back" value="Back" onClick="location.href('index.php')" class="button">            
            </font></div>
      </td>
    </tr>
  </table> 
  
</div></body>
</html>
