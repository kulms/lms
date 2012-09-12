<?php   
		require("../include/global_login.php");
		require_once ("./classes/User.php");
		require_once ("./classes/UserStorage.php");
		require_once( "./includes/main_functions.php" );
		
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

require "./style/$uistyle/header.php";
require "./style/$uistyle/footer.php";

		$check=mysql_query("SELECT name from modules WHERE id='$modules';");
		$get_course=mysql_query("SELECT courses FROM wp WHERE modules='$modules';");
		$check_cadmin=mysql_query("SELECT id FROM wp WHERE courses=".mysql_result($get_course,0,"courses")." AND admin=1 AND users=".$person["id"].";");
		if(mysql_num_rows($check_cadmin)!=0)
		{            
			$cadmin=1;
		}else{
             $cadmin=0;
        }     
		?>
<html>
<head>
        <title>Edit resources</title>
<SCRIPT LANGUAGE="Javascript" SRC="form.js"></SCRIPT>
<script language="javascript">
<!--
        function upload_check(val)
		{
                if(val.value=="")
				{           alert("Empty File Name!!");
                            return false;
                }else{
                            return true;
                         }
        }
        function delete_check()
		{         if(confirm("Do you really want to delete "+document.renameform.resourcesname.value+" and all its content?"))
			      {
							if(confirm("Are you really...REALLY sure?\nThis action can't be undone."))
							{             return true;
							}else{    return false;
									 }
                   }else{              return false;
                            }
        }       
		
		
		//-->
</script>
<script language="javascript"> 
function displayCB() { 
	switch (document.getElementById("dropdown").selectedIndex) { 
	case 0: 		  
		  document.getElementById("area").innerHTML = "";
		 
		break; 
	case 1: 
		  //document.all.area.innerHTML = "<input type=\"checkbox\" name=\"cb1\" value=\"jpg\">jpg<br><input type=\"checkbox\" name=\"cb2\" value=\"gif\">gif<br><input type=\"checkbox\" name=\"cb3\" value=\"png\">png"; 		 
		  document.getElementById("area").innerHTML = "<input type=\"radio\" name=\"filetype\" value=\"1\" checked class=\"r-button\">image/gif"+
		  								"<input type=\"radio\" name=\"filetype\" value=\"2\" class=\"r-button\">image/jpg"+ 
										"<input type=\"radio\" name=\"filetype\" value=\"3\" class=\"r-button\">image/jpeg"+ 
										"<input type=\"radio\" name=\"filetype\" value=\"4\" class=\"r-button\">image/png"+
										"<input type=\"radio\" name=\"filetype\" value=\"5\" class=\"r-button\">All of 4";
										
		break; 
	case 2: 
		//document.all.area.innerHTML = "<input type=\"checkbox\" name=\"cb4\" value=\"doc\">doc<br><input type=\"checkbox\" name=\"cb5\" value=\"pdf\">pdf"; 
		document.getElementById("area").innerHTML = "<input type=\"radio\" name=\"filetype\" value=\"6\" checked class=\"r-button\">application/msword"+
		  							  "<input type=\"radio\" name=\"filetype\" value=\"7\" class=\"r-button\">application/pdf"+ 
									  "<input type=\"radio\" name=\"filetype\" value=\"8\" class=\"r-button\">All of 2";
									  
		break; 
	case 3: 
		//document.all.area.innerHTML = "<input type=\"checkbox\" name=\"cb4\" value=\"doc\">doc<br><input type=\"checkbox\" name=\"cb5\" value=\"pdf\">pdf"; 
		document.getElementById("area").innerHTML = "<input type=\"radio\" name=\"filetype\" value=\"9\" checked class=\"r-button\">Any type";		  
									  
		break; 	
		} 
} 
</script> 
<script language="javascript"> 
function displayAns(ans_type,text) {
	var text_text;
	var text_url;
	var text_file;
	if(ans_type==1)
		text_text=text;
	else 
		text_text="";
	
	if(ans_type==2)
		text_url=text;
	else 
		text_url="";
	
	if(ans_type==3)
		text_file=text;
	else 
		text_file="";
		
	switch (document.getElementById("ans_type").selectedIndex) { 
	case 0: 
		  //document.all.area.innerHTML = "<input type=\"checkbox\" name=\"cb1\" value=\"jpg\">jpg<br><input type=\"checkbox\" name=\"cb2\" value=\"gif\">gif<br><input type=\"checkbox\" name=\"cb3\" value=\"png\">png"; 		 
		  document.getElementById("area2").innerHTML = "";
		break; 
	case 1: 
		  //document.all.area.innerHTML = "<input type=\"checkbox\" name=\"cb1\" value=\"jpg\">jpg<br><input type=\"checkbox\" name=\"cb2\" value=\"gif\">gif<br><input type=\"checkbox\" name=\"cb3\" value=\"png\">png"; 		 
		  ddocument.getElementById("area2").innerHTML = "<textarea ROWS=\"10\" COLS=\"90\" name=\"answer\" wrap=\"virtual\" class=\"textarea\">"+text_text+"</textarea>";
		break; 
	case 2: 
		//document.all.area.innerHTML = "<input type=\"checkbox\" name=\"cb4\" value=\"doc\">doc<br><input type=\"checkbox\" name=\"cb5\" value=\"pdf\">pdf"; 
		document.getElementById("area2").innerHTML = "<input type=\"text\" name=\"answer\" size=\"70\" value=\"http:\/\/"+text_url+"\" class=\"text\">";
		break; 
	case 3: 
		//document.all.area.innerHTML = "<input type=\"checkbox\" name=\"cb4\" value=\"doc\">doc<br><input type=\"checkbox\" name=\"cb5\" value=\"pdf\">pdf"; 
		//document.all.area2.innerHTML = "<input type=\"file\" size=\"49\" name=\"answer\" class=\"button\">";
		if(text_file ==""){
			document.getElementById("area2").innerHTML = "<input type=\"file\" size=\"49\" name=\"answer\" class=\"button\">";
		}else{
			document.getElementById("area2").innerHTML = "<input type=\"file\" size=\"49\" name=\"answer\" class=\"button\">"+
																			"<br><b>Old file:  "+text_file+"</b>";
		}
		break; 	
		}		 
} 
</script> 
<script language="javascript"> 
function displayQuestion() { 
//alert(text);
	//if(text==null)
		//text="";
	switch (document.getElementById("q_type").selectedIndex) { 
	case 0: 
		  //document.all.area.innerHTML = "<input type=\"checkbox\" name=\"cb1\" value=\"jpg\">jpg<br><input type=\"checkbox\" name=\"cb2\" value=\"gif\">gif<br><input type=\"checkbox\" name=\"cb3\" value=\"png\">png"; 		 
		  //document.all.area3.innerHTML = "<textarea ROWS=\"10\" COLS=\"90\" name=\"answer\" wrap=\"virtual\" class=\"textarea\"></textarea>";
		  document.getElementById("area3").innerHTML = "";
		break; 
	case 1: 
		  //document.all.area.innerHTML = "<input type=\"checkbox\" name=\"cb1\" value=\"jpg\">jpg<br><input type=\"checkbox\" name=\"cb2\" value=\"gif\">gif<br><input type=\"checkbox\" name=\"cb3\" value=\"png\">png"; 		 
		  //document.all.area3.innerHTML = "<textarea ROWS=\"10\" COLS=\"90\" name=\"answer\" wrap=\"virtual\" class=\"textarea\"></textarea>";
		  document.getElementById("area3").innerHTML = "<input type=\"hidden\" name=\"question_type\" value=\"text\">"+
		  								 "<input type=\"hidden\" name=\"text\" value=\"1\">";
		break; 
	case 2: 
		//document.all.area.innerHTML = "<input type=\"checkbox\" name=\"cb4\" value=\"doc\">doc<br><input type=\"checkbox\" name=\"cb5\" value=\"pdf\">pdf"; 
		document.getElementById("area3").innerHTML = "<input type=\"text\" name=\"url\" size=\"70\" value=\"http:\/\/\" class=\"text\">"+
										"<input type=\"hidden\" name=\"question_type\" value=\"url\">";
		break; 
	case 3: 
		//document.all.area.innerHTML = "<input type=\"checkbox\" name=\"cb4\" value=\"doc\">doc<br><input type=\"checkbox\" name=\"cb5\" value=\"pdf\">pdf"; 
		document.getElementById("area3").innerHTML = "<input type=\"file\" size=\"49\" name=\"file\" class=\"button\">"+
									   "<input type=\"hidden\" name=\"question_type\" value=\"file\">";
		break; 	
		}		 
} 
</script>
<script language="javascript"> 
function displaySendType() { 
//alert("fFFFF");
//alert(document.getElementById("sendtype").selectedIndex);
	switch (document.getElementById("sendtype").selectedIndex) { 
	case 0: 
		  document.getElementById("area4").innerHTML = "";
		
		break; 
	case 1: 
		  document.getElementById("area4").innerHTML
		break; 
	case 2: 
		document.getElementById("area4").innerHTML = "";
		
		break; 
	case 3: 
	document.getElementById("area4").innerHTML = "<br>File Type:&nbsp;&nbsp;<select name=\"dropdown\" id=\"dropdown\"  onchange=\"displayCB();\" class=\"text\">"+
								       "<option value=\"0\">-Select File Type-</option>"+
							           "<option value=\"1\">image</option>"+
							           "<option value=\"2\">document</option>"+
									   "<option value=\"3\">Any Type</option>"+
							           "</select><div id=\"area\">"+
							   		   "</div>"+
									   "<br>File Size:&nbsp;&nbsp;&nbsp;<select name=\"filesize\" id=\"filesize\" class=\"text\">"+
									   "<option value=\"0\">-Select File Size-</option>"+
									   "<option value=\"1\" >100 KB</option>"+
								       "<option value=\"2\" >500 KB</option>"+
									   "<option value=\"3\" >1 MB</option>"+
									   "<option value=\"4\" >1.5 MB</option>"+
									   "<option value=\"5\" >2 MB</option>"+
									   "<option value=\"6\" >10 MB</option>"+
									   "</select>";
											   
		break; 	
		}
	/*	switch (document.all.sendtype3.selectedIndex) { 
		case 0: 
			  document.all.area4.innerHTML = "";
			
			break; 
		case 1: 
			  document.all.area4.innerHTML = "";
			
			break; 
		case 2: 
			document.all.area4.innerHTML = "";
			
			break; 
		case 3: 
			document.all.area4.innerHTML = "<br>File Type:&nbsp;&nbsp;<select name=\"dropdown\" onchange=\"displayCB();\" class=\"text\">"+
										   "<option value=\"0\">-Select File Type-</option>"+
										   "<option value=\"1\">image</option>"+
										   "<option value=\"2\">document</option>"+
										   "</select><div id=\"area\">"+
										   "</div>"+
										   "<br>File Size:&nbsp;&nbsp;&nbsp;<select name=\"filesize\" id=\"filesize\" class=\"text\">"+
										   "<option value=\"0\">-Select File Size-</option>"+
										   "<option value=\"1\" >100 KB</option>"+
										   "<option value=\"2\" >500 KB</option>"+
										   "<option value=\"3\" >1 MB</option>"+
										   "<option value=\"4\" >1.5 MB</option>"+
										   "<option value=\"5\" >2 MB</option>"+
										   "</select>";
												   
			break; 	
			}		 	*/	 
} 
</script>
<script language="javascript"> 
function displaySendType2() { 
//alert("EEE");
	switch (document.getElementById("sendtype2").selectedIndex) { 
	case 0: 
		  document.getElementById("area4").innerHTML = "";
		break; 
	case 1: 

		 document.getElementById("area4").innerHTML = "";
		break; 
	case 2: 
		document.getElementById("area4").innerHTML = "";
		break; 
	case 3: 	
		document.getElementById("area4").innerHTML = "<br>File Type:&nbsp;&nbsp;<select name=\"dropdown\" id=\"dropdown\"  onchange=\"displayCB();\" class=\"text\">"+
								       "<option value=\"0\">-Select File Type-</option>"+
							           "<option value=\"1\">image</option>"+
							           "<option value=\"2\">document</option>"+
							           "</select><div id=\"area\">"+
							   		   "</div>"+
									   "<br>File Size:&nbsp;&nbsp;&nbsp;<select name=\"filesize\" id=\"filesize\" class=\"text\">"+
									   "<option value=\"0\">-Select File Size-</option>"+
									   "<option value=\"1\" >100 KB</option>"+
								       "<option value=\"2\" >500 KB</option>"+
									   "<option value=\"3\" >1 MB</option>"+
									   "<option value=\"4\" >1.5 MB</option>"+
									   "<option value=\"5\" >2 MB</option>"+
									   "<option value=\"6\" >10 MB</option>"+
									   "</select>";									   
		break; 	
		}		 
} 
</script>
<link rel="STYLESHEET" type="text/css" href="../themes/<?php echo $theme;?>/style/main.css">
<!--<link rel="stylesheet" type="text/css" href="./style/<?php //echo $uistyle;?>/faq.css" media="all" />!-->
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<body bgcolor="#ffffff">
<div align="center" class="info">
<?     
//echo "ADD:".$add;
//echo "modules:".$modules;
//echo @mysql_result($check,0,"name"); 
if($id!="0")
{  $rs=mysql_query("SELECT * FROM homework WHERE id=$id;");
   $r=mysql_fetch_array($rs);
 
   if($r["users"]==$person["id"] || $person["admin"]==1)
   {        ?>  
 <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="50%"> 
      <h1><? echo $user->_($strHome_LabEditQues);?></h1>
	 </td>    
  </tr>
</table>
  <table border="0" cellpadding="2" cellspacing="0" width="100%" class="tdborder2">
    <?
	  if ($r["text"]==1)
	   { 
	   ?>
    <form action="rename.php" method="post" name="form" onSubmit="return CheckEmpty(this,'')" enctype="multipart/form-data">
      <!-- FORM -->
      <tr>
        <td colspan="2" class="hilite"><input name="submit8" type="submit" class="button" value="<? echo $user->_($strSubmit);?>">
            <input class="button" type="button" name="cancel7" value="<? echo $user->_($strCancel);?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = 'index.php?id=<? echo $modules;?>&courses=<? echo $courses;?>';}" /></td>
      </tr>
      <tr>
        <td align="right" valign="top"><span class="hilite"><? echo $user->_($strHome_LabQuestionType); ?></span></td>
        <td><select name="q_type"  id="q_type" onChange="displayQuestion();" class="text">
          <option value="0">-Select Question Type-</option>
          <option value="1" <? if ($r["text"] == 1 ){ echo "selected"; } ?> >text</option>
          <option value="2" <? //if($q_type == 2){ echo "selected";} ?>>url</option>
          <option value="3" <? //if($r["text"] == 0 && strlen($r["url"])==0){ echo "selected"; } ?>>file</option>
        </select>
        <div id="area3"></div>
		</td>
      </tr>
      <tr>
        <input type="hidden" name="modules" value="<? echo $modules; ?>">
        <input type="hidden" name="id" value="<? echo $id; ?>">
        <input type="hidden" name="courses" value="<? echo $courses; ?>">
        <td width="20%" align="right" class="hilite"><? echo $user->_($strHome_LabAssignment);?>:</td>
        <td width="80%"><textarea rows="10" cols="90" name="name" wrap="virtual" class="pn-text"><? echo $r["name"];  ?></textarea></td>
      </tr>
      <tr>
        <td align="right" valign="top" class="hilite">Participation :</td>
        <td class="hilite" > Student will take this assignment by ssssss<br>
          <select name="sendtype" id="sendtype" onChange="displaySendType();" class="text">
            <option value="0">-Select Sending-</option>
            <option value="1" <? if ($r["sendtype"] == 1){ echo "selected"; } ?>>Typing the answer in textbox</option>
            <option value="2" <? if ($r["sendtype"] == 2){ echo "selected"; } ?>>Sending URL</option>
            <option value="3" <? if ($r["sendtype"] == 3){ echo "selected"; } ?>>Sending File</option>
          </select>            
          <div id="area4"> <br>
                <? if($r["filetype"] != 0) { ?>
          File Type:
          <select name="dropdown" id="dropdown" onChange="displayCB();" class="text">
            <option value="0">-Select File Type-</option>
            <option value="1" <? if ($r["filetype"] == 1 || $r["filetype"] == 2 ||$r["filetype"] == 3 ||$r["filetype"] == 4 ||$r["filetype"] == 5 ){ echo "selected"; } ?>>image</option>
            <option value="2" <? if ($r["filetype"] == 6 || $r["filetype"] == 7 ||$r["filetype"] == 8 ){ echo "selected"; } ?>>document</option>
            <option value="3" <? if ($r["filetype"] == 9 ){ echo "selected"; } ?>>Any type</option>
          </select>
          <div id="area">
            <? if($r["filetype"] != 0) {
			   if ($r["filetype"] == 1 || $r["filetype"] == 2 ||$r["filetype"] == 3 ||$r["filetype"] == 4 ||$r["filetype"] == 5 ){
			?>
            <input type="radio" name="filetype" value="1" <? if ($r["filetype"] == 1){ echo "checked"; } ?> class="r-button">
            image/gif
            <input type="radio" name="filetype" value="2" <? if ($r["filetype"] == 2){ echo "checked"; } ?> class="r-button">
            image/jpg
            <input type="radio" name="filetype" value="3" <? if ($r["filetype"] == 3){ echo "checked"; } ?> class="r-button">
            image/jpeg
            <input type="radio" name="filetype" value="4" <? if ($r["filetype"] == 4){ echo "checked"; } ?> class="r-button">
            image/png
            <input type="radio" name="filetype" value="5" <? if ($r["filetype"] == 5){ echo "checked"; } ?> class="r-button">
            All of 4
            <? 
				} else {
					if ($r["filetype"] == 6 || $r["filetype"] == 7 ||$r["filetype"] == 8 ) {
			?>
            <input type="radio" name="filetype" value="6" <? if ($r["filetype"] == 6){ echo "checked"; } ?> class="r-button">
            application/msword
            <input type="radio" name="filetype" value="7" <? if ($r["filetype"] == 7){ echo "checked"; } ?> class="r-button">
            application/pdf
            <input type="radio" name="filetype" value="8" <? if ($r["filetype"] == 8){ echo "checked"; } ?> class="r-button">
            All of 2
            <?
			  		} else {
			  ?>
            <input type="radio" name="filetype" value="9" <? if ($r["filetype"] == 9){ echo "checked"; } ?> class="r-button">
            Any type
            <?			
					}						
				}
			  }
			}
			?>
          </div>
          <?
			if($r["filesize"] != 0) {
			?>
          <br>
          File Size :
          <select name="filesize" id="select" class="text">
            <option value="0">-Select File Size-</option>
            <option value="1" <? if ($r["filesize"] == 1){ echo "selected"; } ?>>100 KB</option>
            <option value="2" <? if ($r["filesize"] == 2){ echo "selected"; } ?>>500 KB</option>
            <option value="3" <? if ($r["filesize"] == 3){ echo "selected"; } ?>>1 MB</option>
            <option value="4" <? if ($r["filesize"] == 4){ echo "selected"; } ?>>1.5 MB</option>
            <option value="5" <? if ($r["filesize"] == 5){ echo "selected"; } ?>>2 MB</option>
			<option value="6" <? if ($r["filesize"] == 6){ echo "selected"; } ?>>10 MB</option>
          </select>
          <?
		  }
		  ?>
          </div></td>
      </tr>
      <tr>
        <td align="right" class="hilite"><? echo $user->_($strHome_LabMaxScores);?> : </td>
        <td ><input type="text" name="score" value="<? echo $r["points"]; ?>" class="text" onKeyUp="javascript: return CheckNum();">
          <span class="style1">*</span></td>
      </tr>
      <tr>
        <td>&nbsp; </td>
        <td align="left">&nbsp; </td>
      </tr>
    </form>
    <!-- END FORM -->
    <?   
	        } // END TEXT

           if($r["text"]==0 && strlen($r["url"])>0)
		   {    $type_url=1; 
		   		$textURL=explode("//",$r['url']);
		   		$text_url=$textURL[1];
		    ?>
    <form action="rename.php" method="post" name="form" onSubmit="return CheckEmptyEdit(this)" enctype="multipart/form-data">
      <!-- FORM -->
      <tr>
        <td colspan="2" class="hilite"><input name="submit7" type="submit" class="button" value="<? echo $user->_($strSubmit);?>">
            <input class="button" type="button" name="cancel62" value="<? echo $user->_($strCancel);?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = 'index.php?id=<? echo $modules;?>&courses=<? echo $courses;?>';}" /></td>
      </tr>
      <tr>
        <td align="right" valign="top"><span class="hilite"><? echo $user->_($strHome_LabQuestionType); ?></span></td>
        <td ><select name="q_type" id="q_type" onChange="displayQuestion1('<? echo $text_url ?>','');" class="text">
          <option value="0">-Select Question Type-</option>
          <option value="1" <? //if ($r["text"] == 1 ){ echo "selected"; } ?> >text</option>
          <option value="2" <? if($type_url == 1){ echo "selected";} ?>>url</option>
          <option value="3" <? //if($r["text"] == 0 && strlen($r["url"])==0){ echo "selected"; } ?>>file</option>
        </select>
		<div id="area3"><input type="text" name="url" size="49" value="<? echo $r["url"]; ?>" class="text"></div>		</td>
      </tr>
      <tr>
        <input type="hidden" name="modules" value="<? echo $modules; ?>">
        <input type="hidden" name="id" value="<? echo $id; ?>">
        <input type="hidden" name="courses" value="<? echo $courses; ?>">
        <input type="hidden" name="sendtype" id="sendtype" value="<? echo $r["sendtype"]; ?>">
        <td align="right" class="hilite"><? echo $user->_($strHome_LabAssignment);?>:</td>
        <td ><textarea rows="10" cols="90" name="name" wrap="virtual" class="pn-text"><? echo $r["name"]; ?></textarea>
        </td>
      </tr>
      <tr>
        <td align="right" valign="top" class="hilite">Participation :</td>
        <td  class="hilite"> Student will take this assignment byURL<br>
            <select name="sendtype2" id="sendtype2" onChange="displaySendType2();" class="text">
              <option value="0">-Select Sending-</option>
              <option value="1" <? if ($r["sendtype"] == 1){ echo "selected"; } ?>>Typing the answer in textbox</option>
              <option value="2" <? if ($r["sendtype"] == 2){ echo "selected"; } ?>>Sending URL</option>
              <option value="3" <? if ($r["sendtype"] == 3){ echo "selected"; } ?>>Sending File</option>
            </select>
          gg
            <div id="area4"> <br>
                <? if($r["filetype"] != 0) { ?>
          File Type:
          <select name="dropdown" id="dropdown" onChange="displayCB();" class="text">
            <option value="0">-Select File Type-</option>
            <option value="1" <? if ($r["filetype"] == 1 || $r["filetype"] == 2 ||$r["filetype"] == 3 ||$r["filetype"] == 4 ||$r["filetype"] == 5 ){ echo "selected"; } ?>>image</option>
            <option value="2" <? if ($r["filetype"] == 6 || $r["filetype"] == 7 ||$r["filetype"] == 8 ){ echo "selected"; } ?>>document</option>
            <option value="3" <? if ($r["filetype"] == 9 ){ echo "selected"; } ?>>Any Type</option>
          </select>
          <div id="area">
            <? if($r["filetype"] != 0) {
			   if ($r["filetype"] == 1 || $r["filetype"] == 2 ||$r["filetype"] == 3 ||$r["filetype"] == 4 ||$r["filetype"] == 5 ){
			?>
            <input type="radio" name="filetype" value="1" <? if ($r["filetype"] == 1){ echo "checked"; } ?> class="r-button">
            image/gif
            <input type="radio" name="filetype" value="2" <? if ($r["filetype"] == 2){ echo "checked"; } ?> class="r-button">
            image/jpg
            <input type="radio" name="filetype" value="3" <? if ($r["filetype"] == 3){ echo "checked"; } ?> class="r-button">
            image/jpeg
            <input type="radio" name="filetype" value="4" <? if ($r["filetype"] == 4){ echo "checked"; } ?> class="r-button">
            image/png
            <input type="radio" name="filetype" value="5" <? if ($r["filetype"] == 5){ echo "checked"; } ?> class="r-button">
            All of 4
            <? 
				} else {
					if ($r["filetype"] == 6 || $r["filetype"] == 7 ||$r["filetype"] == 8 ) {				
			?>
            <input type="radio" name="filetype" value="6" <? if ($r["filetype"] == 6){ echo "checked"; } ?> class="r-button">
            application/msword
            <input type="radio" name="filetype" value="7" <? if ($r["filetype"] == 7){ echo "checked"; } ?> class="r-button">
            application/pdf
            <input type="radio" name="filetype" value="8" <? if ($r["filetype"] == 8){ echo "checked"; } ?> class="r-button">
            All of 2
            <?
					} else {
			  ?>
            <input type="radio" name="filetype" value="9" <? if ($r["filetype"] == 9){ echo "checked"; } ?> class="r-button">
            Any Type
            <?		
					}	
				}
			}
			}
			?>
          </div>
          <?
			if($r["filesize"] != 0) {
			?>
          <br>
          File Size :
          <select name="filesize" id="select" class="text">
            <option value="0">-Select File Size-</option>
            <option value="1" <? if ($r["filesize"] == 1){ echo "selected"; } ?>>100 KB</option>
            <option value="2" <? if ($r["filesize"] == 2){ echo "selected"; } ?>>500 KB</option>
            <option value="3" <? if ($r["filesize"] == 3){ echo "selected"; } ?>>1 MB</option>
            <option value="4" <? if ($r["filesize"] == 4){ echo "selected"; } ?>>1.5 MB</option>
            <option value="5" <? if ($r["filesize"] == 5){ echo "selected"; } ?>>2 MB</option>
			<option value="6" <? if ($r["filesize"] == 6){ echo "selected"; } ?>>10 MB</option>
          </select>
          <?
		  }
		  ?>
          </div></td>
      </tr>
      <tr>
        <td align="right" class="hilite"><? echo $user->_($strHome_LabMaxScores);?> : </td>
        <td ><input type="text" name="score" value="<? echo $r["points"]; ?>" class="text" onKeyUp="javascript: return CheckNum();">
        <span class="style1">*</span></td>
      </tr>
      <tr>
        <td ><? echo " "; ?> </td>
        <td align="left" >&nbsp;</td>
      </tr>
    </form>
    <form action="url.php" method="post">
      <!-- FORM -->
      <!--<tr>
        <td colspan="2" class="hilite"><input name="submit6" type="submit" class="button" value="<? echo $user->_($strSave);?>">
            <input class="button" type="button" name="cancel6" value="<? echo $user->_($strCancel);?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = 'index.php?id=<? echo $modules;?>&courses=<? echo $courses;?>';}" /></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td >&nbsp;</td>
      </tr>-->      <tr>
        <td>&nbsp; </td>
        <td align="left">&nbsp; </td>
      </tr>
    </form>
    <?
             } // END URL

          if($r["text"]==0 && strlen($r["url"])==0)
			 {                      ?>
    <form action="rename.php" method="post" enctype="multipart/form-data" onSubmit="return CheckEmpty(this,'<? echo $r["file"] ?>')" name="form">
      <!-- FORM -->
      <tr>
        <td colspan="2" class="hilite"><input name="submit4" type="submit" class="button" value="<? echo $user->_($strSave);?>">
            <input class="button" type="button" name="cancel4" value="<? echo $user->_($strCancel);?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = 'index.php?id=<? echo $modules;?>&courses=<? echo $courses;?>';}" />
        </td>
      </tr>
      <tr>
        <td align="right" valign="top"><? echo $user->_($strHome_LabQuestionType); ?></td>
        <td ><select name="q_type" id="q_type" onChange="displayQuestion1('','<? echo $r["file"] ?>');" class="text">
          <option value="0">-Select Question Type-</option>
          <option value="1" <? //if ($r["text"] == 1 ){ echo "selected"; } ?> >text</option>
          <option value="2" <? //if($type_url == 1){ echo "selected";} ?>>url</option>
          <option value="3" <? if($r["file"] != ""){ echo "selected"; } ?>>file</option>
        </select><div id="area3"><input type="file" size="49" name="file" style="width:270px" class="button">
          <b>Old file:<? echo $r["file"]; ?></b></div></td>
      </tr>
      <tr>
        <input type="hidden" name="modules" value="<? echo $modules; ?>">
        <input type="hidden" name="id" value="<? echo $id; ?>">
        <input type="hidden" name="courses" value="<? echo $courses; ?>">
        <input type="hidden" name="sendtype2" value="<? echo $r["sendtype"]; ?>">
		<input type="hidden" name="old_file" value="<? echo $r["file"]; ?>">
        <td align="right" class="hilite"><? echo $user->_($strHome_LabAssignment);?>:</td>
        <td ><textarea rows="10" cols="90" name="name" wrap="virtual" class="pn-text"><? echo $r["name"]; ?></textarea>
            <br></td>
      </tr>
      <tr>
        <td align="right" valign="top" class="hilite">Participation :</td>
        <td  class="hilite">Students will reply this question by <br>
            <select name="sendtype" id="sendtype" onChange="displaySendType();" class="text">
              <option value="0">-Select Sending-</option>
              <option value="1" <? if ($r["sendtype"] == 1){ echo "selected"; } ?>>Typing the answer in textbox</option>
              <option value="2" <? if ($r["sendtype"] == 2){ echo "selected"; } ?>>Sending URL</option>
              <option value="3" <? if ($r["sendtype"] == 3){ echo "selected"; } ?>>Sending File</option>
            </select>
            <div id="area4"> <br>
                <? if($r["filetype"] != 0) { ?>
          File Type:
          <select name="dropdown" id="dropdown"onChange="displayCB();" class="text">
            <option value="0">-Select File Type-</option>
            <option value="1" <? if ($r["filetype"] == 1 || $r["filetype"] == 2 ||$r["filetype"] == 3 ||$r["filetype"] == 4 ||$r["filetype"] == 5 ){ echo "selected"; } ?>>image</option>
            <option value="2" <? if ($r["filetype"] == 6 || $r["filetype"] == 7 ||$r["filetype"] == 8 ){ echo "selected"; } ?>>document</option>
            <option value="2" <? if ($r["filetype"] == 9 ){ echo "selected"; } ?>>Any Type</option>
          </select>
          <div id="area">
            <? if($r["filetype"] != 0) {
			   if ($r["filetype"] == 1 || $r["filetype"] == 2 ||$r["filetype"] == 3 ||$r["filetype"] == 4 ||$r["filetype"] == 5 ){
			?>
            <input type="radio" name="filetype" value="1" <? if ($r["filetype"] == 1){ echo "checked"; } ?> class="r-button">
            image/gif
            <input type="radio" name="filetype" value="2" <? if ($r["filetype"] == 2){ echo "checked"; } ?> class="r-button">
            image/jpg
            <input type="radio" name="filetype" value="3" <? if ($r["filetype"] == 3){ echo "checked"; } ?> class="r-button">
            image/jpeg
            <input type="radio" name="filetype" value="4" <? if ($r["filetype"] == 4){ echo "checked"; } ?> class="r-button">
            image/png
            <input type="radio" name="filetype" value="5" <? if ($r["filetype"] == 5){ echo "checked"; } ?> class="r-button">
            All of 4
            <? 
				} else {
				if ($r["filetype"] == 6 || $r["filetype"] == 7 ||$r["filetype"] == 8 ) {
			?>
            <input type="radio" name="filetype" value="6" <? if ($r["filetype"] == 6){ echo "checked"; } ?> class="r-button">
            application/msword
            <input type="radio" name="filetype" value="7" <? if ($r["filetype"] == 7){ echo "checked"; } ?> class="r-button">
            application/pdf
            <input type="radio" name="filetype" value="8" <? if ($r["filetype"] == 8){ echo "checked"; } ?> class="r-button">
            All of 2
            <?
					} else {
			  ?>
            <input type="radio" name="filetype" value="9" <? if ($r["filetype"] == 9){ echo "checked"; } ?> class="r-button">
            Any Type
            <?		
					}	
				}
			}
			}
			?>
          </div>
          <?
			if($r["filesize"] != 0) {
			?>
          <br>
          File Size:
          <select name="filesize" id="select" class="text">
            <option value="0">-Select File Size-</option>
            <option value="1" <? if ($r["filesize"] == 1){ echo "selected"; } ?>>100 KB</option>
            <option value="2" <? if ($r["filesize"] == 2){ echo "selected"; } ?>>500 KB</option>
            <option value="3" <? if ($r["filesize"] == 3){ echo "selected"; } ?>>1 MB</option>
            <option value="4" <? if ($r["filesize"] == 4){ echo "selected"; } ?>>1.5 MB</option>
            <option value="5" <? if ($r["filesize"] == 5){ echo "selected"; } ?>>2 MB</option>
			<option value="6" <? if ($r["filesize"] == 6){ echo "selected"; } ?>>10 MB</option>
          </select>
          <?
		  }
		  ?>
          </div></td>
      </tr>
      <tr>
        <td align="right" class="hilite"><? echo $user->_($strHome_LabMaxScores);?> : </td>
        <td><input type="text" name="score" value="<? echo $r["points"]; ?>" class="text" onKeyUp="javascript: return CheckNum();">
        <span class="style1">*</span></td>
      </tr>
    </form>
    <form action="file.php" method="post" enctype="multipart/form-data" onSubmit="return upload_check(this.file);" name="uploadform">
      <!-- FORM -->
      <tr>
        <input type="hidden" name="modules" value="<? echo $modules; ?>">
        <input type="hidden" name="id" value="<? echo $id; ?>">
        <input type="hidden" name="courses" value="<? echo $courses; ?>">
        <td align="right" class="hilite">&nbsp;</td>
        <td class="hilite"></td>
      </tr>
      <tr>
        <td>&nbsp; </td>
        <td align="left">&nbsp; </td>
      </tr>
    </form>
    <!-- END FORM FILE -->
    <? 
			  }     //END FILE			
 }                   //   END CHECK USER  
 ?>
  </table>
  <? 
	  	if($r["answer_type"]==3)
		   	$oldfile=$r["answer"];
	  ?>
  <form action="answer.php" method="post" enctype="multipart/form-data" onSubmit="return CheckEmptyAns(this,'<? echo $oldfile ?>')">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="12%"> 
      <h1><? echo $user->_('Add Answer');?></h1>
	    </td> 
	    <td width="88%">&nbsp; </td>     
  </tr>
</table>

    <table border="0" cellpadding="2" cellspacing="0" width="100%" class="tdborder2">
      <!-- FORM -->
      <input type="hidden" name="modules" value="<? echo $modules; ?>">
      <input type="hidden" name="id" value="<? echo $id; ?>">
      <input type="hidden" name="courses" value="<? echo $courses; ?>">
      <tr> 
        <td colspan="2"  valign="top" class="hilite"><input name="submit32" type="submit" class="button" value="<? echo $user->_($strSave);?>"> 
          <input class="button" type="button" name="cancel43" value="<? echo $user->_($strCancel);?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = 'index.php?id=<? echo $modules;?>&courses=<? echo $courses;?>';}" /></td>
      </tr>
      <tr>
        <td align="right" valign="top">&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr> <? 
	  	if($r["answer_type"]==2){
		   	$text_ans=explode("//",$r['answer']);
		   	$textAns=$text_ans[1];
		}else{
			$textAns=$r["answer"];
		}
	  ?>
        <td width="19%" align="right" valign="top" class="hilite">Answer File:</td>
        <td width="81%"  class="hilite"> <select name="ans_type" onChange="displayAns('<? echo $r["answer_type"] ?>','<? echo $textAns ?>');" class="text">
            <option value="0">-Select Type-</option>
            <option value="1" <? if ($r["answer_type"] == 1 ){ echo "selected"; } ?>>text</option>
            <option value="2" <? if ($r["answer_type"] == 2 ){ echo "selected"; } ?>>url</option>
            <option value="3" <? if ($r["answer_type"] == 3 ){ echo "selected"; } ?>>file</option>
          </select> <div id="area2"> 
            <? if($r["answer_type"] != 0) {
		  		if($r["answer_type"] == 1) {
				?>
            <textarea ROWS="10" COLS="90" name="answer" wrap="virtual" class="pn-text"><? echo $r["answer"]; ?></textarea>
            <?
				}
				if($r["answer_type"] == 2) {
				?>
            <input type="text" name="url" size="70" value="<? echo $r["answer"]; ?>" class="text">
            <?
				}
				if($r["answer_type"] == 3) {
				?>
            <input type="file" size="49" name="answer"  class="button" style="width:270px">
            <br>
            <b>Old file : <? echo $r["answer"]; ?><input type="hidden" name="old_file" value="<? echo $oldfile; ?>"> </b>
            <?
				}		
		  }
		  ?>
          </div></td>
      </tr>
	  <tr>
        <td align="right" valign="top">&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
    </table>
  </form>
<?  }else{   //   $id==0  ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top"> 
    <td width="50%"> 
      <h1><? echo $user->_('Add New Assignment');?></h1></td>    
  </tr>
</table>
<table border="0" cellpadding="2" cellspacing="0" width="100%" class="tdborder2">
    <?
			switch ($add) {
			case 1: 
			?>
    <form action="new_question.php" method="post" enctype="multipart/form-data" name="form">
      <!-- FORM -->
      <tr> 
        <td colspan="2" class="hilite"><input name="submit" type="submit" class="button" value="<? echo $user->_($strSave);?>"> 
          <input class="button" type="button" name="cancel3" value="<? echo $user->_($strCancel);?>" onClick="javascript:if(confirm('Are you sure you want to cancel.')){location.href = 'index.php?id=<? echo $modules;?>&courses=<? echo $courses;?>';}" /></td>
      </tr>
      <tr> 
        <td align="right" valign="top">&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr> 
        <td align="right" valign="top" class="hilite"><? echo $user->_($strHome_LabQuestionType); ?>:</td>
        <td ><select name="q_type" id="q_type" onChange="displayQuestion();" class="text">
          <option value="0">-Select Question Type-</option>
          <option value="1" <? //if ($r["text"] == 1 ){ echo "selected"; } ?> >text</option>
          <option value="2" <? //if($q_type == 2){ echo "selected";} ?>>url</option>
          <option value="3" <? //if($r["text"] == 0 && strlen($r["url"])==0){ echo "selected"; } ?>>file</option>
        </select>        
        <div id="area3"></div></td>
      </tr>
      <tr> 
        <input type="hidden" name="modules" value="<? echo $modules; ?>">      
        <input type="hidden" name="courses" value="<? echo $courses; ?>">
        <td width="20%" align="right" class="hilite"><? echo $user->_($strHome_LabAssignment);?>:</td>
        <td width="80%" ><textarea ROWS="10" COLS="90" name="name" wrap="virtualy"  class="pn-text"></textarea></td>
      </tr>
      <tr> 
        <td  align="right" valign="top" class="hilite">Participation :</td>
        <td  class="hilite">Students will reply this question by <br>          
          <select name="sendtype" id="sendtype" onChange="displaySendType();" class="text">
            <option value="0">-Select Sending-</option>
            <option value="1" >Typing the answer in textbox</option>
            <option value="2">Sending URL</option>
            <option value="3">Sending File</option>
          </select> <div id="area4"> </div></td>
      </tr>     
      <tr> 
        <td align="right" class="hilite"><? echo $user->_($strHome_LabMaxScores);?> : </td>
        <td ><input type="text" name="score" value="<? echo $r["points"]; ?>" class="text" onKeyUp="javascript: return CheckNum();">          <span class="style1">*</span></td>
      </tr>
      <tr> 
        <td >&nbsp; </td>
        <td align="left">&nbsp; </td>
      </tr>
    </form>
    <!-- END FORM -->
    <?
				break;
			case 2:
				break;
			case 3:			
				break;			
			}
	?>
  </table>
<?  }     ?>
</div>
</body>
</html>